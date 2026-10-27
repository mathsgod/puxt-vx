<?php

namespace VX\Tests;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PUXT\Config;
use Ramsey\Uuid\Uuid;
use VX;
use VX\User;

final class JwtUser extends User
{
    public $user_id = 42;

    public function __construct()
    {
        // JWT generation only needs the user ID, not a database connection.
    }
}

final class JwtTest extends TestCase
{
    private const SECRET = 'jwt-regression-test-key-0123456789abcdefghijklmnopqrstuvwxyz-012345';
    private VX $vx;
    private array $cookies;
    private int $leeway;
    private ?int $timestamp;

    protected function setUp(): void
    {
        $this->cookies = $_COOKIE;
        $this->leeway = JWT::$leeway;
        $this->timestamp = JWT::$timestamp;
        JWT::$leeway = 0;
        JWT::$timestamp = null;
        $this->vx = (new \ReflectionClass(VX::class))->newInstanceWithoutConstructor();
        $this->vx->config = new Config(['VX' => ['jwt' => ['secret' => self::SECRET]]], true);
        $this->vx->base_path = '/api/';
    }

    protected function tearDown(): void
    {
        $_COOKIE = $this->cookies;
        JWT::$leeway = $this->leeway;
        JWT::$timestamp = $this->timestamp;
    }

    private function decode(string $token): \stdClass
    {
        $headers = new \stdClass();
        $payload = JWT::decode($token, new Key(self::SECRET, 'HS256'), $headers);
        self::assertSame('HS256', $headers->alg);
        self::assertSame(42, $payload->user_id);
        self::assertTrue(Uuid::isValid($payload->jti));
        return $payload;
    }

    public function testGeneralTokenKeepsDataAndOneHourLifetime(): void
    {
        $payload = $this->decode($this->vx->generateToken(new JwtUser(), ['name' => '客戶', 'roles' => ['admin']]));
        self::assertSame(['name' => '客戶', 'roles' => ['admin']], (array) $payload->data);
        self::assertEqualsWithDelta(3600, $payload->exp - $payload->iat, 1);
        self::assertFalse(isset($payload->type));
    }

    public function testAccessAndRefreshClaimsAndDefaultLifetimes(): void
    {
        $access = $this->decode($this->vx->generateAccessToken(new JwtUser()));
        $refresh = $this->decode($this->vx->generateRefreshToken(new JwtUser()));
        self::assertSame('access_token', $access->type);
        self::assertSame('refresh_token', $refresh->type);
        self::assertEqualsWithDelta(3600, $access->exp - $access->iat, 1);
        self::assertEqualsWithDelta(86400, $refresh->exp - $refresh->iat, 1);
        self::assertNotSame($access->jti, $refresh->jti);
    }

    public function testConfiguredLifetimesArePreserved(): void
    {
        $this->vx->config['VX']['jwt']['access_token_expire'] = 120;
        $this->vx->config['VX']['jwt']['refresh_token_expire'] = 600;
        $access = $this->decode($this->vx->generateAccessToken(new JwtUser()));
        $refresh = $this->decode($this->vx->generateRefreshToken(new JwtUser()));
        self::assertEqualsWithDelta(120, $access->exp - $access->iat, 1);
        self::assertEqualsWithDelta(600, $refresh->exp - $refresh->iat, 1);
    }

    public function testExistingHs256TokensRemainReadable(): void
    {
        // Construct the existing wire format independently of JWT 7's encoder.
        $base64url = static fn ($value) => rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
        $header = $base64url('{"typ":"JWT","alg":"HS256"}');
        $payload = ['user_id' => 42, 'exp' => time() + 600, 'data' => ['name' => '客戶']];
        $body = $base64url(json_encode($payload));
        $signature = $base64url(hash_hmac('sha256', $header . '.' . $body, self::SECRET, true));
        $token = $header . '.' . $body . '.' . $signature;
        self::assertSame(42, $this->vx->getUserIdByToken($token));
        self::assertSame('客戶', $this->vx->decodeJWT($token)->data->name);
        self::assertSame($payload, $this->vx->jwtDecode($token));
    }

    public static function invalidTokens(): array
    {
        return [['malformed'], ['expired'], ['future'], ['wrong-signature'], ['wrong-algorithm'], ['tampered']];
    }

    private function invalidToken(string $kind): string
    {
        $payload = ['user_id' => 42, 'iat' => time() - 60, 'exp' => time() + 600, 'type' => 'refresh_token'];
        if ($kind === 'malformed') {
            return 'invalid-token';
        }
        if ($kind === 'expired') {
            $payload['exp'] = time() - 30;
        }
        if ($kind === 'future') {
            $payload['nbf'] = time() + 300;
        }
        $token = JWT::encode($payload, $kind === 'wrong-signature' ? str_repeat('different', 8) : self::SECRET, $kind === 'wrong-algorithm' ? 'HS512' : 'HS256');
        if ($kind === 'tampered') {
            $parts = explode('.', $token);
            $payload['user_id'] = 999;
            $parts[1] = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');
            $token = implode('.', $parts);
        }
        return $token;
    }

    #[DataProvider('invalidTokens')]
    public function testInvalidTokensRetainNullResults(string $kind): void
    {
        $token = $this->invalidToken($kind);
        self::assertNull($this->vx->decodeJWT($token));
        self::assertNull($this->vx->getUserIdByToken($token));
    }

    public function testStrictDecodeStillThrowsForInvalidSignature(): void
    {
        $this->expectException(SignatureInvalidException::class);
        $this->vx->jwtDecode($this->invalidToken('wrong-signature'));
    }

    #[DataProvider('invalidTokens')]
    public function testRefreshPageClearsAccessCookieForInvalidToken(string $kind): void
    {
        $_COOKIE['refresh_token'] = $this->invalidToken($kind);
        $page = require dirname(__DIR__) . '/pages/auth/renew-token.php';
        $response = $page->post($this->vx);
        self::assertSame(200, $response->getStatusCode());
        self::assertSame('access_token=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/api/; SameSite=Strict; HttpOnly', $response->getHeaderLine('Set-Cookie'));
    }

    public function testRefreshPageStillRejectsAccessTokens(): void
    {
        $_COOKIE['refresh_token'] = $this->vx->generateAccessToken(new JwtUser());
        $page = require dirname(__DIR__) . '/pages/auth/renew-token.php';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('error when renew access token');
        $page->post($this->vx);
    }

    public function testPasswordResetRejectsInvalidTokenBeforeDatabaseAccess(): void
    {
        $this->expectException(SignatureInvalidException::class);
        $this->vx->resetPassword('unused', $this->invalidToken('wrong-signature'));
    }

    public function testShortSecretsAreRejectedWithoutSilentlyChangingTheKey(): void
    {
        $this->vx->config['VX']['jwt']['secret'] = 'short';
        $this->expectException(\DomainException::class);
        $this->vx->generateAccessToken(new JwtUser());
    }
}
