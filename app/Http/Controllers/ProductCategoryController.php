<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Controllers\Controller;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ShopRepository;
use App\Repositories\VersionManagementRepository;
use App\Libs\Common;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    protected $productCategoryRepository;
    protected $shopRepository;
    protected $versionManagementRepository;

    /**
     * __construct
     *
     * @param App\Repositories\ProductCategoryRepository $product_category_repository
     * @param App\Repositories\ShopRepository $shop_repository
     * @param App\Repositories\VersionManagementRepository $version_management_repository
     */
    public function __construct(
        ProductCategoryRepository $product_category_repository,
        ShopRepository $shop_repository,
        VersionManagementRepository $version_management_repository
    ) {
        $this->productCategoryRepository = $product_category_repository;
        $this->shopRepository = $shop_repository;
        $this->versionManagementRepository = $version_management_repository;
    }

    /**
     * 1件取得
     *
     * @param int $id
     * @return object
     */
    public function show($id)
    {
        return $this->productCategoryRepository->fetchShow($id);
    }

    /**
     * トップカテゴリ取得
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function indexTopCategories(Request $request)
    {
        // クエリパラメーターから取得した店舗ID
        $shopId = $request->shop_id;
        // 登録されている店舗IDかチェック
        $this->shopRepository->checkIds($shopId);

        $searchKeyword = '';
        if ($request->has('keyword')) {
            $searchKeyword = $request->keyword;
        }

        $searchValidPeriodFrom = '';
        if ($request->has('valid_period_from')) {
            $searchValidPeriodFrom = $request->valid_period_from;
        }

        $searchValidPeriodTo = '';
        if ($request->has('valid_period_to')) {
            $searchValidPeriodTo = $request->valid_period_to;
        }

        return $this->productCategoryRepository->fetchTopCategories($shopId, $searchKeyword, $searchValidPeriodFrom, $searchValidPeriodTo);
    }

    /**
     * トップカテゴリに紐づく子カテゴリのみ取得
     *
     * @param int $id トップカテゴリID
     * @return object
     */
    public function indexChildCategories(Request $request, $id)
    {
        // クエリパラメーターから取得した店舗ID
        $shopId = $request->shop_id;
        // 登録されている店舗IDかチェック
        $this->shopRepository->checkIds($shopId);

        $searchKeyword = '';
        if ($request->has('keyword')) {
            $searchKeyword = $request->keyword;
        }

        $searchValidPeriodFrom = '';
        if ($request->has('valid_period_from')) {
            $searchValidPeriodFrom = $request->valid_period_from;
        }

        $searchValidPeriodTo = '';
        if ($request->has('valid_period_to')) {
            $searchValidPeriodTo = $request->valid_period_to;
        }

        return $this->productCategoryRepository->fetchChildCategory($shopId, $id, $searchKeyword, $searchValidPeriodFrom, $searchValidPeriodTo);
    }

    /**
     * トップ商品カテゴリ一覧取得
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function topCategoryList(Request $request)
    {
        // クエリパラメーターから取得した店舗ID
        $shopId = $request->shop_id;
        // 登録されている店舗IDかチェック
        $this->shopRepository->checkIds($shopId);

        return $this->productCategoryRepository->fetchTopCategoryList($shopId);
    }

    /**
     * 子商品カテゴリ一覧取得
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function childCategoryList(Request $request)
    {
        // クエリパラメーターから取得した店舗ID
        $shopId = $request->shop_id;
        // 登録されている店舗IDかチェック
        $this->shopRepository->checkIds($shopId);

        return $this->productCategoryRepository->fetchChildCategoryList($shopId);
    }

    /**
     * 新規登録
     *
     * @param App\Http\Requests\ProductCategoryRequest $request
     * @return object
     */
    public function shop(ProductCategoryRequest $request)
    {
        $result = $this->productCategoryRepository->createRecord($request, $request->shop_id);
        $this->versionManagementRepository->versionUpdate($request->shop_id);

        return $result;
    }

    /**
     * 更新
     *
     * @param App\Http\Requests\ProductCategoryRequest $request
     * @param int $id
     * @return object
     */
    public function update(ProductCategoryRequest $request, $id)
    {
        $result = $this->productCategoryRepository->updateRecord($request, $id);
        $this->versionManagementRepository->versionUpdate($request->shop_id);

        return $result;
    }

    /**
     * 優先順更新
     *
     * @param App\Http\Requests\ProductCategoryRequest $request
     * @return object
     */
    public function updatePriorityOrder(Request $request)
    {
        return $this->productCategoryRepository->updatePriorityOrder($request);
    }

    /**
     * 削除
     *
     * @param App\Http\Requests\ProductCategoryRequest $request
     * @param int $id
     * @return object
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->productCategoryRepository->deleteRecord($id);
        $this->versionManagementRepository->versionUpdate($request->shop_id);

        return $result;
    }
}
