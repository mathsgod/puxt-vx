<?php

namespace VX\Auth;

use Google\Authenticator\GoogleAuthenticator;
use Laminas\Authentication\Adapter\AdapterInterface;
use VX\User;
use Laminas\Authentication\Result;
use VX\UserLog;

class Adapter implements AdapterInterface
{
    protected $username;
    protected $password;
    protected $code;

    public function __construct(string $username, string $password, ?string $code)
    {
        $this->username = $username;
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
            "username" => $this->username,
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

        return new Result(Result::SUCCESS, $user->user_id);
    }
}
