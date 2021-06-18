<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/get-hello', 'HelloController@getHello');
Route::post('/post-hello', 'HelloController@postHello');
Route::post('/post-lbb', 'HelloController@postLbb');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * 未認証アクセス可能
 */
Route::group(['middleware' => 'guest:admin'], function () {
    // ログイン
    Route::post('/login', 'Auth\LoginController@login');

    // ログインユーザー
    Route::get('/user', 'Auth\UserController@authUser');

    // APIトークン削除
    Route::patch('/reset/api-token', 'Api\admin\users\AdminController@resetApiToken');

    // リスト取得
    Route::get('/shops/name/list', 'ShopController@list')->name('shop.list');
    // トークンリフレッシュ
    // Route::get('/reflesh-token', function (Request $request) {
    //     $request->session()->regenerateToken();

    //     return response()->json();
    // });
});

/**
 * 認証後アクセス可能
 */
Route::group(['middleware' => 'auth:admin'], function () {
    // ログインユーザー
    Route::get('/user', 'Auth\UserController@authUser');

    // ログアウト
    Route::post('/logout', 'Auth\LoginController@logout');

    // 店舗リスト取得
    Route::get('/shop-list', 'ShopController@list');
    Route::resource('/shops', 'ShopController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

    // 画像の管理等
    Route::get('/info-items-list', 'InfoItemController@list');

    Route::resource('/product-categories', 'ProductCategoryController', ['only' => ['show', 'store', 'update', 'destroy']]);
    // 商品カテゴリ全件取得
    Route::get('/product-categories/{id}/child-categories', 'ProductCategoryController@indexChildCategories');

    // 商品カテゴリのリスト取得
    Route::get('/product-categories/child-categories/list', 'ProductCategoryController@childCategoryList');

    //// 商品
    Route::resource('/products', 'ProductController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
});
