<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Facades\OriginAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginController extends Controller
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function hello()
    {
        return 'HelloLogin';
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // ユーザー一覧を取得
        $users = $this->admin->get(['id', 'email', 'password']);
        $userId = OriginAuth::existsLoginUser($credentials, 'email', $users);

        if (!$userId) {
            $data = [
                'errors' => [
                    'message' => [config('util.ERROR_MESSAGE.UNPROCESSABLE_ENTITY')],
                ],
            ];
            throw new HttpResponseException(response()->json($data, config('util.HTTP_STATUS.UNPROCESSABLE_ENTITY')));
        }
        $user = $this->admin->find($userId);

        return OriginAuth::login($request, $credentials, $user, 'admin');
    }

    public function logout(Request $request)
    {
        $user = \Auth::user();

        return OriginAuth::logout($request, $user, 'admin');
    }
}
