<?php

namespace App\GraphQL;

class AppType
{
    private static $appTypes = [];

    public static function user()
    {
        if (!isset(self::$appTypes['User'])) {
            self::$appTypes['User'] = new Types\UserType;
        }

        return self::$appTypes['User'];
    }

    public static function post()
    {
        if (!isset(self::$appTypes['Post'])) {
            self::$appTypes['Post'] = new Types\PostType;
        }

        return self::$appTypes['Post'];
    }
}
