<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InfoItemRequest;
use App\Http\Controllers\Controller;
use App\Repositories\InfoItemRepository;

class InfoItemController extends Controller
{
    protected $infoItemRepository;

    /**
     * __construct
     *
     * @param App\Repositories\InfoItemRepository $info_item_repository
     */
    public function __construct(InfoItemRepository $info_item_repository)
    {
        $this->infoItemRepository = $info_item_repository;
    }

    /**
     * 全件取得
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function index(Request $request)
    {
        $searchKeyword = '';
        if ($request->has('keyword')) {
            $searchKeyword = $request->keyword;
        }

        return $this->infoItemRepository->fetchIndex($searchKeyword);
    }

    /**
     * 1件取得処理
     *
     * @param int $id
     * @return object
     */
    public function show($id)
    {
        return $this->infoItemRepository->fetchShow($id);
    }

    /**
     * 新規登録
     *
     * @param App\Http\Requests\InfoItemRequest $request
     * @return object
     */
    public function shop(InfoItemRequest $request)
    {
        $result = $this->infoItemRepository->createRecord($request, $request->shop_id);

        return $result;
    }

    /**
     * 更新
     *
     * @param App\Http\Requests\InfoItemRequest $request
     * @param int $id
     * @return object
     */
    public function update(InfoItemRequest $request, $id)
    {
        $result = $this->infoItemRepository->updateRecord($request, $id);

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
        return $this->infoItemRepository->deleteRecord($id);
    }

    /**
     * レコードの最後のIDを取得
     *
     * @return int
     */
    public function lastId()
    {
        return $this->infoItemRepository->fetchLastId();
    }

    /**
     * リスト取得
     *
     * @return array
     */
    public function list()
    {
        return $this->infoItemRepository->fetchList();
    }
}
