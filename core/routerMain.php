<?php

namespace Core;

use Exception;

class RouterMain
{

    private static $groupStack = [];
    protected static $routers = [];
    protected static $wheres = [];
    public static $names = [];

    protected static function GetName()
    {
        throw new Exception("Error");
    }

    private static function AddResource($method, $args, $name)
    {
        $method = strtolower($method);

        $event = [
            "groupStack" => [
                "add" => function (string $name) {
                    static::$groupStack[] = $name;
                },

                "pop" => function () {
                    array_shift(static::$groupStack);
                },

                "get" => function () {
                    return static::$groupStack;
                }
            ],
            "name" => [
                "set" => function (string $name, string $path) {
                    static::$names[$name] = $path;
                }
            ],
            "where" => [
                "set" => function (string $method, string $name, array $array) {
                    static::$wheres[$method][$name] = $array;
                }
            ]
        ];

        $routerRegister = new RouterRegister($method, $args, $event);
        if (count($routerRegister->GetRouters()))
            foreach ($routerRegister->GetRouters() as $method => $args) {
                foreach ($args as $path => $function) {
                    static::$routers[$method][$path] = $function;
                }
            }
        return $routerRegister;
    }

    private static function HandlePath(string $method, string $url): array
    {
        $endpoint = null;
        $endmethod = null;
        $parameters = [];
        
        if (isset(static::$routers[$method])) {
            foreach (static::$routers[$method] as $route => $_) {
                if ($endpoint == null) {

                    $path = $route;
                    $path_array = explode("/", $path);
                    $regex_array = preg_grep("/\{(.*?)\??\}/", $path_array);

                    if (array_key_exists($method, static::$wheres) and array_key_exists($route, static::$wheres[$method])) {
                        // var_dump(static::$wheres[$method][$route]);

                        foreach (static::$wheres[$method][$route] as $key => $regex) {
                            foreach ($regex_array as $index => $__) {

                                // var_dump([$url, $route, $key, $regex, $index, $__]);

                                $regex_path = $path_array[$index];

                                if (preg_match("/\{" . $key . "\?\}/", $regex_path)) {
                                    // echo ">>>>>>>>>>>>>>";
                                    $regex_path = str_replace("{" . $key . "?}", "((?:" . $regex . ")?)",  $regex_path);
                                } else if (preg_match("/\{" . $key . "\}/", $regex_path)) {
                                    $regex_path = str_replace("{" . $key . "}", "(" . $regex . ")", $regex_path);
                                }
                                $path_array[$index] = $regex_path;
                            }
                        }
                    }
                    foreach ($regex_array as $index => $__) {
                        $regex_path = $path_array[$index];
                        if (preg_match("/\{(.+?)\?\}/",  $regex_path)) {
                            //echo ">>>>>>>>>>>>>>";
                            $regex_path = preg_replace("/\{(.+?)\?\}/", "((?:.+?)?)",  $regex_path);
                        } else if (preg_match("/\{(.+?)\}/",  $regex_path)) {
                            $regex_path = preg_replace("/\{(.+?)\}/", "(.+?)", $regex_path);
                        }
                        $path_array[$index] = $regex_path;
                    }

                    $path = join("\/", $path_array);

                    if (count($path_array) > 2) {

                        for ($i = 2; $i < count($path_array); $i++) {
                            $path_array[$i] = str_replace("\/((?:", "((?:\/", $path_array[$i]);
                        }
                        $path = join("\/", $path_array);
                    }

                    preg_match_all("/^" . $path . "$/", $url, $matches);
                    if (count($matches[0]) > 0) {
                        $endpoint = $route;
                        $endmethod = $method;
                        if (count($matches) > 1) {
                            for ($i = 1; $i < count($matches); $i++) {
                                $parameters[] = $matches[$i][0];
                            }
                        }
                    }
                }
            }
        }

        return [$endpoint, $endmethod, $parameters];
    }

    protected static function UrlToParamter()
    {
        $method = strtolower(Request::RequestMethod());
        $url = Request::RequestUri();
        $endpoint = null;
        $endmethod = null;
        $parameters = [];

        list($endpoint, $endmethod, $parameters) = static::HandlePath("any", $url);
        if(!$endpoint)
        list($endpoint, $endmethod, $parameters) = static::HandlePath($method, $url);

        return [$endmethod, $endpoint, $parameters];
    }

    protected static function Name($name, $parameters){
        $path_array = explode("/", static::$names[$name]);
        $regex_array = preg_grep("/\{(.*?)\??\}/", $path_array);

        foreach($regex_array as $key => $regex){
            $value = "";
            if(count($parameters)){
                $value = str_replace("$","\$", array_shift($parameters));
            }
            $path_array[$key] = preg_replace("/\{(.+?)\??\}/", $value,  $regex);
        }

        return join("/",$path_array);
    }

    public static function __callStatic($name, $args = null)
    {
        try {
            return static::AddResource($name, $args, static::GetName());
        } catch (\Exception $ex) {
            echo ("Error: <strong>" . $ex->getMessage() . "</strong> in line <strong>" . $ex->getTrace()[1]["line"] . "</strong> of file <strong>route.php</strong> in folder <strong>app</strong><br>");
        }
    }
};
