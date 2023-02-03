<?php

namespace Core;

class Session
{

    function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    public static function Destroy()
    {
        session_destroy();
    }

    static function Set(string $name, string $value)
    {
        $_SESSION[$name] = $value;
    }

    static function Get(string $name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
    }
}
