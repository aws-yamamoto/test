<?php

namespace App\Repositories;

use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopRepository
{
    protected $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    public function fetchIndex($searchKeyword)
    {
        return $this->shop
                ->where('shop_name', 'LIKE', "%$searchKeyword%")
                ->paginate(20);
    }

    public function fetchList()
    {
        return $this->shop->get(['id', 'shop_name']);
    }

    public function fetchShow($id)
    {
        return $this->shop->with('infoItems')->findOrFail($id);
    }

    public function createRecord($request)
    {
        DB::beginTransaction();
        try {
            $record = new $this->shop;
            $record->fill($request->all())->save();

            DB::commit();
            return $record;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    public function updateRecord($request, $id)
    {
        DB::beginTransaction();
        try {
            $record = $this->shop->findOrFail($id);
            $record->fill($request->all())->save();
            DB::commit();
            return $record;
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::info($e);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    public function deleteRecord($id)
    {
        return $this->shop->deleteData($id);
    }

    public function fetchIds()
    {
        return $this->shop->pluck('id');
    }

    public function checkIds($id)
    {
        if (!$id) {
            abort(400);
        }

        if (!$this->fetchIds()->contains($id)) {
            abort(400);
        }
    }
}
