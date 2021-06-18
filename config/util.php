<?php

return [
    'HTTP_STATUS' => [
        'OK' => 200,
        'CREATED' => 201,
        'NO_CONTENT' => 204,
        'BAD_REQUEST' => 400,
        'UNAUTHORIZED' => 401,
        'FORBIDDEN' => 403,
        'NOT_FOUND' => 404,
        'CONFLICT' => 409,
        'UNPROCESSABLE_ENTITY' => 422,
        'INTERNAL_SERVER_ERROR' => 500,
    ],

    'ERROR_MESSAGE' => [
        'BAD_REQUEST' => '不正なリクエストです。',
        'FORBIDDEN' => 'アクセス権限がありません。',
        'UNPROCESSABLE_ENTITY' => '入力情報が正しくありません。',
        'NOT_EXIST' => '登録されていません。',
        'NOT_LOGIN' => 'ログインしてください。',
        'EXIST' => '既に登録されています。',
        'EXIST_ACCOUNT_ID' => '既に登録されているアカウントIDです',
        'EXIST_LOGIN' => '既に別の端末でログイン済みです',
        'NOT_POINTS' => 'ポイントがありません。',
        'NOT_ENOUGH_POINT' => 'ポイントが足りません',
        'FAIL_AWS_SETTING' => 'AWSの登録に失敗しました。',
        'FAIL_STORE' => '登録に失敗しました',
        'NEED_VERIFICATION' => "2段階認証が必要です。\\nご登録のメールアドレスにメールを送信しましたので、認証を完了させてから再度ログインしてください。",
        'OUT_OF_STOCK' => '在庫切れです。',
        'INVALID_TOKEN' => '無効なトークンです。',
    ],

    'PAGINATE' => 20,
    'LIMIT_TEN' => 10,
];
