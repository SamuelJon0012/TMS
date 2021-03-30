<?php
namespace App\Traits;

trait Singleton
{

    protected static $_instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$_instance) static::$_instance = new static;
        return static::$_instance;
    }
}
