<?php
// routes.php

require_once 'app/controllers/UserController.php';

$controller = new UserController();
$url = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($url == '/user/dashboard' || $url == '/') {
    $controller->dashboard();
} elseif ($url == '/user/index' && $requestMethod == 'GET') {
    $controller->index();
} elseif ($url == '/user/create' && $requestMethod == 'GET') {
    $controller->create();
} elseif ($url == '/user/store' && $requestMethod == 'POST') {
    $controller->store();
} elseif (preg_match('/\/user\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_user = $matches[1];
    $controller->edit($id_user);
} elseif (preg_match('/\/user\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $id_user = $matches[1];
    $controller->update($id_user, $_POST);
} elseif (preg_match('/\/user\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_user = $matches[1];
    $controller->deleteUser($id_user);
} else {
    http_response_code(404);
    echo "404 Not Found";
}