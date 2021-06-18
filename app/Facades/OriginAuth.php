<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OriginAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'originAuth';
    }
}
