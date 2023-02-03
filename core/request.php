<?php

namespace Core;

class Request
{
    private static $arguments = [];

    function __construct()
    {
        static::BootStrapSelf();
    }

    /**
     * bootstrapSelf là hàm lấy tất cả param của $_SERVER đổ vào cho đối tượng gốc.
     * sau này việc sử dụng 1 router sẽ không cần sử dụng biến global của PHP
     * thay vào đó chúng ta sẽ truyền đối tượng request vào
     * các key của biến $_SERVER sẽ được format theo dạng CamelCase 
     * đây là cú pháp lạc đà
     *
     * @return void
     */
    private static function BootStrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            static::$arguments[static::ToPascalCase($key)] = $value;
        }
    }

    static function Get(string $key): ?string
    {
        return isset($_GET[$key]) ? $_GET[$key] : NULL;
    }

    static function Post(string $key): ?string
    {
        return isset($_POST[$key]) ? $_POST[$key] : NULL;
    }

    private static function ToPascalCase($string)
    {
        $result = strtolower($string);

        $result = explode("_", $result);

        foreach ($result as $index => $item) {
            $result[$index] = strtoupper(substr($item, 0, 1)).substr($item, 1);
        }

        return join("",$result);
    }

    static function __callStatic($name, $_)
    {
        return static::$arguments[$name];
    }
}
