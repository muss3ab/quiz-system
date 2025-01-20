<?php

namespace App\Http\Service;

use Exception;
use App\Models\Tenant;
use Illuminate\Validation\ValidationException;
use Symfony\Component\CssSelector\Exception\ParseException;

class TenantService
{

    private static $tenant;
    private static $domain;
    private static $database;

    public static function switchToTenant(Tenant $tenant)
    {
        if(!$tenant instanceof Tenant){
            // throw error or tenant class 
            throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);
        }
        \DB::purge('laravel');
        \DB::purge('tenant');
     
        \Config::set('database.connections.tenant.database' , $tenant->id.'_tenant');
        \Config::set('database.connections.tenant.driver' , 'mysql');
        Self::$tenant = $tenant;
        Self::$domain = $tenant->domain;
        Self::$database = $tenant->id.'_tenant';
        $databaseName = $tenant->id.'_tenant';
        
        \DB::connection('tenant')->reconnect();
        \DB::setDefaultConnection('tenant');
    }

    public static function switchToDefault()
    {
        \DB::purge('laravel');
        \DB::purge('tenant');
        \DB::connection('laravel')->reconnect();
        \DB::setDefaultConnection('laravel');
    }


    public static function getTenant(){
        return Self::$tenant;
    }

}