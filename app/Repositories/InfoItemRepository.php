<?php

namespace App\Repositories;

use App\Models\InfoItem;
use App\Models\InfoItemPivot;

class InfoItemRepository
{
    protected $infoItem;
    protected $infoItemPivot;

    /**
     * ItemRepository constructor.
     * @param App\Models\InfoItem $info_item
     * @param App\Models\InfoItemPivot $info_item_pivot
     */
    public function __construct(
        InfoItem $info_item,
        InfoItemPivot $info_item_pivot
    ) {
        $this->infoItem = $info_item;
        $this->infoItemPivot = $info_item_pivot;
    }

    /**
     * 全件取得処理
     *
     * @return object
     */
    public function fetchIndex($searchKeyword)
    {
        return $this->infoItem
            ->where('info_item_name', 'LIKE', "%$searchKeyword%")
            ->paginate(20);
    }

    /**
     * 1件取得処理
     *
     * @param int $id
     * @return object
     */
    public function fetchShow($id)
    {
        return $this->infoItem->findOrFail($id);
    }

    /**
     * 新規登録処理
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    public function createRecord($request)
    {
        $record = $this->infoItem->register($request);
        return response($record, 201);
    }

    /**
     * 更新処理
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return object
     */
    public function updateRecord($request, $id)
    {
        return $this->infoItem->updateData($request, $id);
    }

    /**
     * 削除処理
     *
     * @param int $id
     * @return object
     */
    public function deleteRecord($id)
    {
        return $this->infoItem->deleteData($id);
    }

    /**
     * レコードの最後のID取得
     *
     * @return int
     */
    public function fetchLastId()
    {
        return $this->infoItem->orderBy('id', 'desc')->value('id');
    }

    /**
     * リスト取得
     *
     * @return array
     */
    public function fetchList()
    {
        return $this->infoItem->get(['id', 'info_item_name', 'image']);
    }
}
