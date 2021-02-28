<?php

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

$containerBuilder=new ContainerBuilder;

$containerBuilder->addDefinitions([
   Engine::class=>function(){
    return new Engine('../app/views');
    },
    QueryFactory::class=>function(){
        return new QueryFactory('mysql');
    },
    PDO::class=>function(){
    return new PDO("mysql:host=localhost; dbname=finalproject; charset=utf8;","root","root");
    },
    Auth::class   =>  function($container){
        return new Auth($container->get('PDO'));
    }
]);

$container = $containerBuilder->build();
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
//Home(main page):
    $r->addRoute('GET', '/',['App\controllers\HomeController','index']);
    $r->addRoute('GET', '/home',['App\controllers\HomeController','index']);
//Register:
    $r->addRoute('GET', '/register',['App\controllers\RegisterController','showForm']);
    $r->addRoute('POST', '/register',['App\controllers\RegisterController','register']);
//Login and Logout:
    $r->addRoute('GET', '/login',['App\controllers\LoginController','showForm']);
    $r->addRoute('POST', '/login',['App\controllers\LoginController','login']);
    $r->addRoute('GET', '/logout',['App\controllers\LoginController','logout']);
//Create New User:
    $r->addRoute('GET', '/create',['App\controllers\UserController','createForm']);
    $r->addRoute('POST', '/create',['App\controllers\UserController','createUser']);
//Edit(change) User Information:
    $r->addRoute('GET', '/edit{id:\d+}',['App\controllers\UserController','showUserForm']);
    $r->addRoute('POST', '/edit{id:\d+}',['App\controllers\UserController','editUser']);
//Security change:
    $r->addRoute('GET', '/security{id:\d+}',['App\controllers\UserController','showSecurity']);
    $r->addRoute('POST', '/security{id:\d+}',['App\controllers\UserController','editSecurity']);
//Status change:
    $r->addRoute('GET', '/status{id:\d+}',['App\controllers\UserController','showStatus']);
    $r->addRoute('POST', '/status{id:\d+}',['App\controllers\UserController','editStatus']);
//Avatar Upload(avatar):
    $r->addRoute('GET', '/changeAvatar{id:\d+}',['App\controllers\UserController','showAvatar']);
    $r->addRoute('POST', '/changeAvatar{id:\d+}',['App\controllers\UserController','editAvatar']);
//Profile page:
    $r->addRoute('GET', '/profile{id:\d+}',['App\controllers\UserController','showProfile']);
    $r->addRoute('POST', '/profile{id:\d+}',['App\controllers\UserController','showProfile']);
//Delete User:
    $r->addRoute('GET', '/delete/{id:\d+}',['App\controllers\UserController','deleteUser']);



    /*$r->addRoute('GET', '/user/{id:\d+}', ['App\controllers\HomeController','index']);
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]',['App\controllers\HomeController','index']);*/
});

//// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

//// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 404;
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo 'Metod ne razreshon';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($handler,$vars);

        break;
}