<?php namespace Octobro\Notify\Facades;

use October\Rain\Support\Facade;

class Notify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'octobro.notify.classes';
    }

    protected static function getFacadeInstance()
    {
        return new \Octobro\Notify\Classes\Notify;
    }
}
