<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function hello()
    {
        return 'HelloUser';
    }

    public function authUser()
    {
        return $this->service->authUser();
    }
}
