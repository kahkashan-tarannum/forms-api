<?php

namespace App\Repositories;

use App\Models\Users;

class AuthRepository
{
    public function verifyAuth($username, $password)
    {
        $result = false;
        if(!is_null($username) && !is_null($password)) {
            if(Users::where('username', '=',$username)->count()) {
                $result = true;
            }
        }
        return $result;
    }
}