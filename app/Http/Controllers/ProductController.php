<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\ShopRepository;
use App\Repositories\VersionManagementRepository;
use App\Libs\Common;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productRepository;
    protected $shopRepository;
    protected $versionManagementRepository;

    /**
     * __construct
     *
     * @param App\Repositories\ProductRepository $product_repository
     * @param App\Repositories\ShopRepository $shop_repository
     * @param App\Repositories\VersionManagementRepository $version_management_repository
     */
    public function __construct(
        ProductRepository $product_repository,
        ShopRepository $shop_repository,
        VersionManagementRepository $version_management_repository
    ) {
        $this->productRepository = $product_repository;
        $this->shopRepository = $shop_repository;
        $this->versionManagementRepository = $version_management_repository;
    }

    /**
     * 全件取得
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function index(Request $request)
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

        $topProductCategoryId = '';
        if ($request->has('top_product_category_id')) {
            $topProductCategoryId = $request->top_product_category_id;
        }

        $productCategoryId = '';
        if ($request->has('product_category_id')) {
            $productCategoryId = $request->product_category_id;
        }

        return $this->productRepository->fetchIndex($shopId, $searchKeyword, $topProductCategoryId, $productCategoryId, $searchValidPeriodFrom, $searchValidPeriodTo);
    }

    /**
     * 1件取得
     *
     * @param int $id
     * @return object
     */
    public function show($id)
    {
        return $this->productRepository->fetchShow($id);
    }

    /**
     * リスト取得
     *
     * @return array
     */
    public function list()
    {
        return $this->productRepository->fetchList();
    }

    /**
     * 新規登録
     *
     * @param App\Http\Requests\ProductRequest $request
     * @return object
     */
    public function shop(ProductRequest $request)
    {
        $result = $this->productRepository->createRecord($request);
        $this->versionManagementRepository->versionUpdate($request->shop_id);

        return $result;
    }

    /**
     * 更新
     *
     * @param App\Http\Requests\ProductRequest $request
     * @param int $id
     * @return object
     */
    public function update(ProductRequest $request, $id)
    {
        $result = $this->productRepository->updateRecord($request, $id);
        $this->versionManagementRepository->versionUpdate($request->shop_id);

        return $result;
    }

    /**
     * 削除
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return object
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->productRepository->deleteRecord($id);
        $this->versionManagementRepository->versionUpdate($request->shop_id);

        return $result;
    }

    /**
     * レコードの最後のIDを取得
     *
     * @return int
     */
    public function lastId()
    {
        return $this->productRepository->fetchLastId();
    }

    public function storeCopy(Request $request)
    {
        $id = $request['id'];
        return $this->productRepository->createCopy($id);
    }
}
