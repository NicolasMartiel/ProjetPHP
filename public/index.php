<?php
require "../vendor/autoload.php";

use App\Router;

define('DEBUG_TIME',microtime(true));

$routes = [
    "index" => "/",
    "blog" => "/blog", 
    "categories" => "/blog/categories", 
    "post" => "/blog/[*:slug]-[i:id]", 
    "admin" => "/admin",
    "login" => "/login",
    "logout" => "/logout",
    "edit" => "/admin/edit-[i:id]"
];

$router = new Router(dirname(__DIR__) . '/views');

$router->get($routes["index"], 'home', 'Home');

$router->get($routes["blog"], 'blog', 'Blog');

$router->get($routes["categories"], 'categories', 'Categories');

$router->get($routes["post"], 'post', 'Post');

$router->get($routes["admin"], 'admin', 'Admin', 'admin');

$router->post($routes["admin"], 'admin', 'AdminDelete', 'admin');

$router->get($routes["login"], 'login', 'LoginGet',"admin");

$router->post($routes["login"],'login', "LoginPost","admin");

$router->get($routes["logout"],'logout', "Logout","admin");

$router->get($routes["edit"],"edit","EditGet","admin");

$router->post($routes["edit"],"edit","EditPost","admin");

$router->run();


?>

