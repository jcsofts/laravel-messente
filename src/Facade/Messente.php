<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 15/11/2017
 * Time: 1:26 PM
 */

namespace Jcsofts\LaravelMessente\Facade;


use Illuminate\Support\Facades\Facade;

class Messente extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jcsofts\LaravelMessente\Lib\Messente::class;
    }
}