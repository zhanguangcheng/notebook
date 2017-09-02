<?php

namespace singleton;

class Singleton
{
    protected static $instance;

    public static function getInstance()
    {
        if (!static::$instance instanceof static) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    protected function __construct()
    {
        
    }

    protected function __clone()
    {
        
    }
}
