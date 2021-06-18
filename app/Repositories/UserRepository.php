<?php

namespace App\Repositories;

class UserRepository
{
    public function __construct()
    {
    }

    public function fetchAuthUser()
    {
        $user = \Auth::user()->find(\Auth::id());
        return $user;
    }
}
