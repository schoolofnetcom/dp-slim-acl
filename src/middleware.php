<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(function ($req, $res, $next) use ($app) {
    $acl = new App\Acl;
    $acl->createRoles();
    $acl->createResources();
    $acl->createPermissions();

    $route = $req->getAttribute('route');

    if (!$route) {
        return $next($req, $res);
    }

    // atenção neste ponto
    if (!$route->getName()) {
        return $next($req, $res);
    }

    // buscar no banco de dados
    $user = [
        'role' => 'member'
    ];

    $role = $user['role'];
    $resource = $route->getName();
    $method = $req->getMethod();

    $isAllowed = $acl->check($role, $resource, $method);

    if (!$isAllowed) {
        $url = $app->getContainer()->get('router')->pathFor('login');
        return $res->withRedirect($url, 302);
    }

    return $next($req, $res);
});
