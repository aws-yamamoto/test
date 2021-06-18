<?php
namespace App\Http\Components;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class OriginAuth
{
    // TODO: existsUser とやってること同じ
    /**
     * ログインユーザーの存在チェック
     *
     * @param array $credentials
     * @param string $key
     * @param array $users
     * @return integer
     */
    public function existsLoginUser($credentials, $key, $users)
    {
        $userId = null;

        // ユーザー存在チェック
        foreach ($users as $user) {
            if ($user[$key] === $credentials[$key]) {
                $userId = $user['id'];
            }
        }

        return $userId;
    }

    /**
     * ログイン処理
     *
     * @param Request $request
     * @param array $credentials
     * @param object $user
     * @param string $guard
     * @return object
     */
    public function login($request, $credentials, $user, $guard)
    {
        // パスワードチェック
        if (Hash::check($credentials['password'], $user['password'])) {
            // セッションを再生成する
            $request->session()->regenerate();
            $user->update(['api_token' => Str::random(60)]);
            \Auth::guard($guard)->login($user);

            return $user;
        } else {
            $data = [
                'errors' => [
                    'message' => [config('util.ERROR_MESSAGE.UNPROCESSABLE_ENTITY')],
                ],
            ];
            throw new HttpResponseException(response()->json($data, config('util.HTTP_STATUS.UNPROCESSABLE_ENTITY')));
        }
    }

    /**
     * ログアウト処理
     *
     * @param Request $request
     * @param object $user
     * @param string $guard
     * @return void
     */
    public function logout($request, $user, $guard)
    {
        \Auth::guard($guard)->logout();

        $request->session()->invalidate();

        $user->api_token = null;
        $user->save();

        // セッションを再生成する
        $request->session()->regenerate();

        return response()->json();
    }

    /**
     * 認証が必要なユーザーが既に登録されているかチェック
     *
     * @param array $request
     * @param integer $id
     * @param array $list
     * @param string $key
     * @return boolean
     */
    public function existsUser($request, $id, $list, $key)
    {
        $exists = false;

        if (count($list) < 1) {
            return $exists;
        }

        foreach ($list as $item) {
            // カラムはnullableなので空は除外する
            if (!$item[$key]) {
                continue;
            }

            if ($item['id'] != $id && $request[$key] === $item[$key]) {
                $exists = true;
            }
        }

        return $exists;
    }
}
