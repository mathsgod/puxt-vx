<?php

namespace VX\Authentication;

use Firebase\JWT\JWT;
use Google\Authenticator\GoogleAuthenticator;
use Laminas\Authentication\Adapter\AdapterInterface;
use VX\User;
use Laminas\Authentication\Result;
use Ramsey\Uuid\Uuid;
use VX\UserLog;

class Adapter implements AdapterInterface
{
    protected $identity;
    protected $password;
    protected $code;

    public function __construct(string $identity, ?string $password, ?string $code)
    {
        $this->identity = $identity;
        $this->password = $password;
        $this->code = $code;
    }


    public function authenticate()
    {

        $ul = UserLog::Create();
        $ul->login_dt = date("Y-m-d H:i:s");
        $ul->ip = $_SERVER['REMOTE_ADDR'];
        $ul->user_agent = $_SERVER["HTTP_USER_AGENT"];

        $user = User::Get([
            "username" => $this->identity,
            "status" => 0
        ]);

        if (!$user) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ["User not found or incorrect password"]);
        }
        $ul->user_id = $user->user_id;

        //check password

        if (!password_verify($this->password, $user->password)) {
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

        if ($user->UserList->count() == 0) {
            $ul->result = "FAIL";
            $ul->save();
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["User has no user group"]);
        }


        //check code
        if ($user->need2Step($_SERVER['REMOTE_ADDR'])) {
            if (!$this->code) {
                $ul->result = "FAIL";
                $ul->save();
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["code required"]);
            }

            if (!(new GoogleAuthenticator())->checkCode($user->secret, $this->code)) {
                $ul->result = "FAIL";
                $ul->save();
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ["code invalid"]);
            }
        }

        $ul->result = "SUCCESS";
        $ul->save();


        //create Token

        $identity = JWT::encode([
            "jti" => Uuid::uuid4()->toString(),
            "type" => "access_token",
            "iat" => time(),
            "exp" => time() + 3600 * 8,
            "id" => $user->getIdentity()
        ], $_ENV["JWT_SECRET"]);


        return new Result(Result::SUCCESS, $identity);
    }
}
