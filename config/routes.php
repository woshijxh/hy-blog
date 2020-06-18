<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::post('/login', 'App\Controller\AuthController@login');

Router::addGroup('/v1', function () {
    Router::get('/info', 'App\Controller\AuthController@info');
    Router::get('/article/index', 'App\Controller\ArticlesController@index');
    Router::post('/article/store', 'App\Controller\ArticlesController@store');
    Router::post('/article/update', 'App\Controller\ArticlesController@update');
    Router::post('/article/delete', 'App\Controller\ArticlesController@delete');

    Router::post('/upload', 'App\Controller\FileController@upload');
}, ['middleware' => [Phper666\JwtAuth\Middleware\JwtAuthMiddleware::class, \App\Middleware\UserInfoMiddleware::class]]);
