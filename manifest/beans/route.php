<?php

return [

    // Api路由
    [
        // 名称
        'name'       => 'apiRoute',
        // 类路径
        'class'      => \App\Api\Route\Router::class,
        // 初始方法
        'initMethod' => 'parse',
        // 属性注入
        'properties' => [
            // 默认变量规则
            'defaultPattern' => '[\w-]+',
            // 路由变量规则
            'patterns'       => [
            ],
            // 全局中间件
            'middleware'     => [\App\Api\Middleware\GlobalMiddleware::class],
            // 路由规则
            'rules'          => [
                // 普通路由
                'POST /file/upload' => [[\App\Api\Controllers\FileController::class, 'upload'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                '/curl'             => [[\App\Api\Controllers\CurlController::class, 'index'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                // 分组路由
                '/v2'               => [
                    // 分组中间件
                    'middleware' => [\App\Api\Middleware\GroupMiddleware::class],
                    'middleware' => [\App\Api\Middleware\CorsMiddleware::class],
                    // 分组路由规则
                    'rules'      => [
                        // 分组路由
                        'POST /user/create' => [[\App\Api\Controllers\UserController::class, 'create'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                        'POST /goods/create' => [[\App\Api\Controllers\GoodsController::class, 'create'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                        'GET /goods/one/{id}' => [[\App\Api\Controllers\GoodsController::class, 'info'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                        'POST /idioms/create/{id}' => [[\App\Api\Controllers\GoodsController::class, 'createIdioms'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                        'POST /idioms/act/{gid}/{nick}' => [[\App\Api\Controllers\GoodsController::class, 'actlong'], 'middleware' => [\App\Api\Middleware\ActionMiddleware::class]],
                    ],
                ],
            ],
        ],
    ],

    // Web路由
    [
        // 名称
        'name'       => 'webRoute',
        // 类路径
        'class'      => \App\Web\Route\Router::class,
        // 初始方法
        'initMethod' => 'parse',
        // 属性注入
        'properties' => [
            // 默认变量规则
            'defaultPattern' => '[\w-]+',
            // 路由变量规则
            'patterns'       => [
                'id' => '\d+',
            ],
            // 全局中间件
            'middleware'     => [\App\Web\Middleware\GlobalMiddleware::class],
            // 路由规则
            'rules'          => [
                // 普通路由
                '/'             => [[\App\Web\Controllers\IndexController::class, 'index'], 'middleware' => [\App\Web\Middleware\ActionMiddleware::class]],
                '/profile/{id}' => [[\App\Web\Controllers\ProfileController::class, 'index'], 'middleware' => [\App\Web\Middleware\ActionMiddleware::class]],
            ],
        ],
    ],

];
