<?php

namespace Core;

/**
 * @method static \Core\RouterRegister Post(string $uri, array|string|callable|null $action = null)
 * @method static \Core\RouterRegister Get(string $uri, array|string|callable|null $action = null)
 * @method static \Core\RouterRegister Any(string $uri, string $destination)
 * @method static \Core\RouterRegister Prefix(string $uri)
*/

class Route extends RouterMain
{
    protected static function GetName(){
        return 'router';
    }
}
