<?php

namespace App\GraphQL;

class Connection
{
    private static $conn;

    public static function get()
    {
        if (!self::$conn) {
            self::$conn = new \PDO(
                'mysql:host=localhost;dbname=graphql_php',
                'root',
                null,
                [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}