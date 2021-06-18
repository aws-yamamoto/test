<?php

namespace App\Traits;

/**
 * データ操作の共通処理を定義するトレイト
 */
trait DataOperation
{
    /**
     * 全件取得
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->get();
    }

    /**
     * 1件取得
     *
     * @param integer $request
     * @return object
     */
    public function fetchFirst($id)
    {
        return $this->findOrFail($id);
    }

    /**
     * 新規登録
     *
     * @param Request $request
     * @return object
     */
    public function createData($request)
    {
        $record = new $this;
        $record->fill($request->all())->save();
        return $record;
    }

    /**
     * 更新処理
     *
     * @param array $request
     * @param integer $id
     * @return object
     */
    public function updateData($request, $id)
    {
        $record = $this->findOrFail($id);
        $record->fill($request->all())->save();
        return $record;
    }

    /**
     * 削除処理
     *
     * @param integer $id
     * @return null
     */
    public function deleteData($id)
    {
        $record = $this->findOrFail($id);
        $record->delete();

        return null;
    }

    /**
     * 基本設定更新処理
     *
     * @param array $request
     * @param integer $appFuncId
     * @return object
     */
    public function updateBasicSettingData($request, $appFuncId)
    {
        $record = $this->where('app_func_id', $appFuncId)->first();
        $request['version'] = $record->version + 1;
        $record->fill($request->all())->save();
        return $record;
    }
}
