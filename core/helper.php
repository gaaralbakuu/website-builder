<?php

// namespace Core;

// use Core\ObjectDatabase\ObjectDB;
// use DateTime;

// class Helper
// {

//     public static function RequireAll(array $array): bool
//     {
//         foreach ($array as $item) {
//             if (is_null($item) || $item == "") {
//                 return false;
//             }
//         }
//         return true;
//     }

//     public static function Mapper(array $array, ObjectDB &$object): void
//     {
//         foreach ($array as $key => $value) {
//             if ($object->getType()[$key] == "DateTime") {
//                 $object->$key = (new DateTime())->setTimestamp(strtotime($value));
//             } else if ($object->getType()[$key] == "int") {
//                 $object->$key = (int)$value;
//             } else {
//                 $object->$key = $value ? $value : "";
//             }
//         }
//     }
// }
