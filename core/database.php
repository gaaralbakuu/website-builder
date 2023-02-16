<?php

namespace Core;

use Closure;
use Exception;

class Database
{
    private static $mysqli;
    private static $error;
    private static $config;


    function __construct()
    {
        static::$config = require_once __DIR__ . '\\..\\config\\database.php';

        static::$mysqli = new \mysqli(
            static::$config["host"],
            static::$config["user"],
            static::$config["pass"],
            static::$config["db"]
        );
        
        if (static::$mysqli->connect_errno) {
            static::$error = static::$mysqli->connect_error;
        }

        static::$mysqli->set_charset(static::$config["charset"]);
    }

    // static function Table(ObjectDB $table): ?Table
    // {
    //     $tableClass = null;
    //     try {
    //         $tableClass = new Table($table, static::$mysqli, static::$error);
    //     } catch (Exception $ex) {
    //         static::$error = $ex->getMessage();
    //     }
    //     return $tableClass;
    // }

    static function getConnection(){
        return static::$mysqli;
    }

    static function insertId(): int
    {
        return static::$mysqli->insert_id;
    }

    static function getError(): ?string
    {
        return static::$error;
    }

    static function disconnect(): void
    {
        static::$mysqli->close();
    }


    function __destruct()
    {
        static::$mysqli->close();
    }
}

// class Table
// {
//     private static $table;
//     private static $mysqli;
//     private static $error;
//     private static array $join = [];

//     private static $_instance = null;

//     public static function getInstance()
//     {
//         if (self::$_instance === null) {
//             self::$_instance = new self(static::$table, static::$mysqli, static::$error);
//         }

//         return self::$_instance;
//     }

//     function __construct(ObjectDB $table, \mysqli $mysqli, &$error)
//     {
//         static::$table = $table;
//         static::$mysqli = $mysqli;
//         static::$error = &$error;
//     }

//     function GetBy(array $columns = []): array
//     {
//         $result = [];

//         $query = static::$table->GetBy($columns);

//         $execute = static::$mysqli->query($query);
//         while ($row = $execute->fetch_assoc()) {
//             $result[] = $row;
//         }

//         return $result;
//     }

//     function GetAll(): array
//     {
//         $result = [];
//         $table = static::$table->GetTableName();
//         $query = "SELECT * FROM `{$table}`";
//         $execute = static::$mysqli->query($query);
//         while ($row = $execute->fetch_assoc()) {
//             $result[] = $row;
//         }
//         return $result;
//     }

//     function Insert(): int
//     {
//         $query = static::$table->Add();
//         if (static::$mysqli->query($query) === TRUE) {
//             return static::$mysqli->insert_id;
//         } else {
//             static::$error = static::$mysqli->error;
//             return 0;
//         }
//     }

//     function UpdateBy(array $columns = []): bool
//     {
//         if (count($columns) == 0)
//             return false;
//         $query = static::$table->UpdateBy($columns);

//         $execute = static::$mysqli->query($query);
//         if ($execute === TRUE) {
//             return true;
//         } else {
//             static::$error = static::$mysqli->error;
//             return false;
//         }
//     }

//     private function convertAddslashes($value)
//     {
//         if ($value instanceof \DateTime) {
//             $value = $value->format("Y/m/d H:i:s");
//         } else {
//             $value = addslashes($value);
//         }
//         return $value;
//     }

//     function Test(array $columns = [])
//     {
//         list($keys, $values) = static::$table->GetAll($columns);
//         $tableName = static::$table->GetTableName();

//         $from = "`$tableName`";
//         $where = "";

//         if (count(static::$join)) {
//             for ($i = 0; $i < count(static::$join); $i++) {
//                 $from .= " `" . static::$join[$i][0]->GetTableName() . "` ON (" . join(' and ', static::$join[$i][1]) . ")";
//             }
//         }

//         $wheres = [];
//         foreach ($keys as $index => $key) {
//             if (in_array($key, $columns)) {
//                 $value = $this->convertAddslashes($values[$index]);
//                 $wheres[] = "`$key` = '" . $value . "'";
//             }
//         }

//         if(count($wheres)){
//             $where = "WHERE ".join(" and ",$wheres);
//         }

//         $select = "SELECT * FROM ".$from." ".$where;
//     }

//     function Join(array $objects = [], array $bys = [])
//     {
//         static::$join = array_merge(static::$join, [$objects, $bys]);
//         return $this;
//     }
// }
