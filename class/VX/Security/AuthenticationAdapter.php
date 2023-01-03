<?php

namespace VX\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Google\Authenticator\GoogleAuthenticator;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Config\Config;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use VX\User;
use VX\UserLog;

class AuthenticationAdapter implements AdapterInterface
{
    protected $request;
    protected $config;
    public function __construct(ServerRequestInterface $request, Config $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function authenticate()
    {
        //get the request body

        $body = [];
        $content = $this->request->getBody()->getContents();
        if ($this->request->getHeaderLine('Content-Type') == 'application/json') {
            $body = json_decode($content, true);
        }


        if ($token = $body["token"]) {
            //token is jwt
            try {
                JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
                return new Result(Result::SUCCESS, $token);
            } catch (\Exception $e) {
                return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ["User not found or incorrect password"]);
            }
        }

        //get the username and password and code
        $username = $body['username'];
        $password = $body['password'];
        $code = $body['code'];

        //check if the username and password are correct

        //if correct return new Result(Result::SUCCESS, $user);
        $ul = UserLog::Create();
        $ul->login_dt = date("Y-m-d H:i:s");
        $ul->ip = $_SERVER['REMOTE_ADDR'];
        $ul->user_agent = $_SERVER["HTTP_USER_AGENT"];

        $user = User::Get([
            "username" => $username,
            "status" => 0
        ]);
        if (!$user) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ["User not found or incorrect password"]);
        }

        $ul->user_id = $user->user_id;

        //check password

        if (!password_verify($password, $user->password)) {
            $ul->result = "FAIL";
            $ul->save();

            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["User not found or incorrect password"]);
        }

        //check expiry date
        if ($user->expiry_date && strtotime($user->expiry_date) < time()) {
            $ul->result = "FAIL";
            $ul->save();
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["User account expired"]);
        }

        if (count($user->getRoles()) == 0) {
            $ul->result = "FAIL";
            $ul->save();
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["User has no user group"]);
        }


        //check code
        if ($user->need2Step($_SERVER['REMOTE_ADDR'])) {
            if (!$code) {
                $ul->result = "FAIL";
                $ul->save();
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["code required"]);
            }

            if (!(new GoogleAuthenticator())->checkCode($user->secret, $code)) {
                $ul->result = "FAIL";
                $ul->save();
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["code invalid"]);
            }
        }

        $ul->result = "SUCCESS";
        $ul->save();


        //create Token

        $access_token_time = $this->config->VX->access_token_time ?? 3600 * 8;

        $identity = JWT::encode([
            "jti" => Uuid::uuid4()->toString(),
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + $access_token_time,
            "id" => $user->getIdentity()
        ], $_ENV["JWT_SECRET"], "HS256");


        return new Result(Result::SUCCESS, $identity);
    }
}
