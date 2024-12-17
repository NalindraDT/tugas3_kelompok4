<?php
// routes.php

require_once 'app/controllers/PublishersController.php';

$controller = new PublishersController();
$url = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($url == '/publishers/dashboard' || $url == '/') {
    $controller->dashboard();
} elseif ($url == '/publishers/index' && $requestMethod == 'GET') {
    $controller->index();
} elseif ($url == '/publishers/create' && $requestMethod == 'GET') {
    $controller->create();
} elseif ($url == '/publishers/store' && $requestMethod == 'POST') {
    $controller->store();
} elseif (preg_match('/\/publishers\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $publishersId = $matches[1];
    $controller->edit($publishersId);
} elseif (preg_match('/\/publishers\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $publishersId = $matches[1];
    $controller->update($publishersId, $_POST);
} elseif (preg_match('/\/publishers\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $publishersId = $matches[1];
    $controller->delete($publishersId);
} else {
    http_response_code(404);
    echo "404 Not Found";
}