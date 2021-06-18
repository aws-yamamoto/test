<?php

namespace App\Repositories;

use App\Models\VersionManagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VersionManagementRepository
{
    protected $versionManagement;

    /**
     * VersionManagementRepository constructor.
     * @param App\Models\VersionManagement $version_management
     */
    public function __construct(VersionManagement $version_management)
    {
        $this->versionManagement = $version_management;
    }

    /**
     * バージョン情報取得
     *
     * @param int $storeId
     * @return object
     */
    public function fetchIndex($storeId)
    {
        return $this->versionManagement->where('store_id', $storeId)->first();
    }

    /**
     * 新規登録処理
     *
     * @param int $storeId
     * @return object
     */
    public function createRecord($storeId)
    {
        DB::beginTransaction();
        try {
            $record = new $this->versionManagement;
            $record->version = 1;
            $record->store_id = $storeId;
            $record->save();
            DB::commit();
            return $record;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }

        return $record;
    }

    /**
     * 更新処理
     *
     * @param int $id
     * @return object
     */
    public function updateRecord($id)
    {
        DB::beginTransaction();
        try {
            $record = $record = $this->versionManagement->findOrFail($id);
            $record = $record->increment('version');

            DB::commit();
            return $record;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }

        return $record;
    }

    /**
     * バージョン更新処理
     *
     * @param int $storeId
     * @return object
     */
    public function versionUpdate($storeId)
    {
        $record = $this->fetchIndex($storeId);
        if ($record) {
            $this->updateRecord($record->id);
        } else {
            $this->createRecord($storeId);
        }
    }
}
