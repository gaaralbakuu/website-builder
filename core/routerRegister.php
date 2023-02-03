<?php

namespace Core;

/**
 * @method void Group(\Closure $callback)
 */

class RouterRegister
{
    private $allowMethod = ["get", "post", "any"];
    private $withoutMethod = ["prefix"];
    private static ?array $event = [];
    private static ?string $method;
    private static ?string $name;

    private static $_instance = null;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self(static::$method);
        }

        return self::$_instance;
    }

    private $routers = [];

    function __construct($method, $args = NULL, $event = [])
    {
        static::$event = $event;

        if (in_array($method, $this->allowMethod)) {
            static::$method = $method;
            return $this->AddRoute($method, $args);
        } else if (in_array($method, $this->withoutMethod)) {
            $this->AddGroupStack($args);
        }
    }

    /**
     * Create a route group with shared attributes.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    function Group($callback)
    {
        if (array_key_exists("pop", static::$event["groupStack"])) {
            $callback();
            static::$event["groupStack"]["pop"]();
        }
    }

    function GetRouters()
    {
        return $this->routers;
    }

    private function AddGroupStack($args)
    {
        $name = isset($args[0]) ? $args[0] : NULL;

        static::$event["groupStack"]["add"]($name);
    }

    private function AddRoute($method, $args)
    {

        $prefix = "";
        $event = static::$event;
        $eventName = [];

        if (static::$event and array_key_exists("get", static::$event["groupStack"])) {
            $eventName = static::$event["name"];
            $eventGroup = static::$event["groupStack"];
            $stack = $eventGroup["get"]();

            $lengthGroupStack = count($stack);

            if ($lengthGroupStack) {
                $prefix = join("", $stack);
            }
        }

        $name = isset($args[0]) ? $prefix . $args[0] : NULL;
        $function = isset($args[1]) ? $args[1] : NULL;

        static::$name = $name;

        $this->routers[$method][$name] = $function;
        return $this;
    }


    /**
     *
     *
     * @param  string  $name
     * @return RouterRegister
     */

    public function Name(string $name)
    {
        static::$event["name"]["set"]($name, static::$name);
        return $this;
    }

    /**
     * 
     *
     * @param  array  $array
     * @return RouterRegister
     */
    public function Where(array $array)
    {
        static::$event["where"]["set"](static::$method, static::$name, $array);
        return $this;
    }
}