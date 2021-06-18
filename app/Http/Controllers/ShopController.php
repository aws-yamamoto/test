<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;
use App\Http\Controllers\Controller;
use App\Repositories\ShopRepository;

class ShopController extends Controller
{
    protected $shopRepository;

    public function __construct(ShopRepository $shop_repository)
    {
        $this->shopRepository = $shop_repository;
    }

    public function index(Request $request)
    {
        $searchKeyword = '';
        if ($request->has('keyword')) {
            $searchKeyword = $request->keyword;
        }

        return $this->shopRepository->fetchIndex($searchKeyword);
    }

    public function list()
    {
        return $this->shopRepository->fetchList();
    }

    public function show($id)
    {
        return $this->shopRepository->fetchShow($id);
    }

    public function shop(ShopRequest $request)
    {
        return $this->shopRepository->createRecord($request);
    }

    public function update(ShopRequest $request, $id)
    {
        return $this->shopRepository->updateRecord($request, $id);
    }

    public function destroy($id)
    {
        return $this->shopRepository->deleteRecord($id);
    }
}
