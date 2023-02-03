<?php

namespace Core;

use Src\Api;
use Exception;

require_once(__DIR__ . '\\..\\vendor\\autoload.php');
require_once(__DIR__ . '\\autoload.php');

class Response
{
    private static $twig;

    function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '\\..\\src\\pages');
        static::$twig = new \Twig\Environment($loader, [
            'debug' => Api::$config['debug'],
            'cache' => __DIR__ . '\\..\\tmp\\cache',
            'auto_loaded' => Api::$config['debug']
        ]);

        $assetFunction = new \Twig\TwigFunction('assets', function ($value) {
            return str_replace(Api::$config["public"], "", Api::$config["assets"]) . $value;
        });

        $nameFunction = new \Twig\TwigFunction('name', function ($name, ...$paramters) {
            $path = "";

            $path = Api::Name($name, $paramters);

            return $path;
        });

        static::$twig->addFunction($assetFunction);
        static::$twig->addFunction($nameFunction);
    }

    public static function Render(string $name, array $paramter = []): string
    {
        try{
            return static::$twig->render($name, $paramter);
        }
        catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function Json(array $object = []): string
    {
        header("Content-Type: application/json; charset=utf-8");
        return json_encode($object);
    }

    public static function Redirect(string $path): void
    {
        header("Location: $path");
    }

    public static function Controller(string $controller, array $paramter = [])
    {
        $controllerName = $controller;
        $controllerMethod = "Index";

        if(preg_match_all("/^((?!\d)[\w\d]+)@((?!\d)[\w\d]+)$/", $controller, $matches)){
            $controllerName = $matches[1][0];
            $controllerMethod = $matches[2][0];
        }

        $namespace = "\\src\\controllers\\{$controllerName}";
        return call_user_func_array([new $namespace(), $controllerMethod], $paramter);
    }
}
