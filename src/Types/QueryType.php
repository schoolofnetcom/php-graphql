<?php

namespace App\GraphQL\Types;

use App\GraphQL\Database\User;
use App\GraphQL\Database\Post;
use App\GraphQL\AppType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = $this->config();
        parent::__construct($config);
    }

    private function config()
    {
        return [
            'name' => 'Query',
            'description' => 'Tipo raiz da api',
            'fields' => [
                'user' => [
                    'name' => 'User',
                    'type' => AppType::user(),
                    'description' => 'Exibe usuário por id',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
                'posts' => [
                    'name' => 'Posts',
                    'type' => Type::listOf(AppType::post()),
                    'description' => 'Exibe uma lista de artigos',
                    'args' => [
                        'page' => Type::int(),
                        'limit' => Type::int(),
                    ]
                ]
            ],
            'resolveField' => function ($val, $args, $context, $info) {
                $field = strtolower($info->fieldName);
                return $this->{$field}($val, $args, $context, $info);
            }
        ];
    }

    public function user($val, $args, $context, $info)
    {
        return User::first($args['id'], $info);
    }
    
    public function posts($val, $args, $context, $info)
    {
        if (!isset($args['page'])) {
            return Post::all($info);
        }
        $limit = $args['limit'] ?? 10;
        $post = Post::paginate($args['page'], $limit, $info);
        return $post;
    }
}
