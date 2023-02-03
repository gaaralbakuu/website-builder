<?php

namespace Src;

use Core\RouterMain;
use Core\Request;
use Core\Response;
use Core\Route;
use Core\Session;

require_once(__DIR__ . "\\..\\core\\autoload.php");
require_once(__DIR__ . "\\router\\index.php");

class Api extends RouterMain
{
    public static $config = [];

    public function __construct()
    {
        $this->init();
    }


    /**
     * It loads the config file, creates a new session, request and response object.
     */
    private function init()
    {
        static::$config = require_once __DIR__ . '\\..\\config\\api.php';

        new Session();
        new Request();
        new Response();
    }

    private function render()
    {
        list($method, $endpoint, $paramters) = Route::UrlToParamter();
        if (!isset($endpoint)) {
            header(Request::ServerProtocol() . " 404 Not Found");
            exit();
        }

        echo call_user_func_array(static::$routers[$method][$endpoint], $paramters);
    }

    public function __destruct()
    {
        $this->render();
    }
}

new Api();