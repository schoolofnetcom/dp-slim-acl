<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    return 'home';
})->setName('home');

$app->get('/login', function (Request $request, Response $response, array $args) {
    return 'login';
})->setName('login');

$app->get('/register', function (Request $request, Response $response, array $args) {
    return 'register';
})->setName('register');

$app->get('/logout', function (Request $request, Response $response, array $args) {
    return 'logout';
})->setName('logout');

$app->get('/profile', function (Request $request, Response $response, array $args) {
    return 'my_profile';
})->setName('my_profile');

$app->get('/admin', function (Request $request, Response $response, array $args) {
    return 'dashboard';
})->setName('admin_dashboard');

$app->get('/articles/{id}', function (Request $request, Response $response, array $args) {
    return 'artigos';
});

$app->get('/articles/{id}/update', function (Request $request, Response $response, array $args) {
    return 'artigos';
})->add(function ($req, $res, $next) {
    $user_id = 1;
    $user_role = 'admin';

    $route = $req->getAttribute('route');
    $article_user_id = (int)$route->getArgument('id');

    if ($user_id !== $article_user_id and $user_role != 'admin') {
        $res = $res->withStatus(401);
        return $res->write('Você não pode fazer isso');
    }

    return $next($req, $res);
});
