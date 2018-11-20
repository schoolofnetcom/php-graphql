<?php

namespace App\GraphQL\Database;

use App\GraphQL\Connection;

class Post
{
    public static function byAuthor($author_id, $info)
    {
        $pdo = Connection::get();

        $allowed_field = [
            'title',
            'body'
        ];
        $fields = $info->getFieldSelection();
        $sql = createSelectSql('posts', $fields, $allowed_field, 'WHERE author_id=?');

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $author_id
        ]);
        return $stmt->fetchAll();
    }

    public static function paginate($page, $limit, $info)
    {
        $pdo = Connection::get();

        $allowed_field = [
            'title',
            'body'
        ];

        $offset = $limit * ($page - 1);

        $fields = $info->getFieldSelection();
        $sql = createSelectSql('posts', $fields, $allowed_field, 'LIMIT ' . $offset . ', ' . $limit);

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function all($info)
    {
        $pdo = Connection::get();

        $allowed_field = [
            'title',
            'body'
        ];
        $fields = $info->getFieldSelection();
        $sql = createSelectSql('posts', $fields, $allowed_field);

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
