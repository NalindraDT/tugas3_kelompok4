<?php
// routes.php

require_once 'app/controllers/Books.php';

$controller = new BooksController();
$url = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($url == '/books/dashboard' || $url == '/') {
    $controller->dashboard();
} elseif ($url == '/books/index' && $requestMethod == 'GET') {
    $controller->index();
} elseif ($url == '/books/create' && $requestMethod == 'GET') {
    $controller->create();
} elseif ($url == '/books/store' && $requestMethod == 'POST') {
    $controller->store();
} elseif (preg_match('/\/books\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_buku = $matches[1];
    $controller->edit($id_buku);
} elseif (preg_match('/\/books\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $id_buku = $matches[1];
    $controller->update($id_buku, $_POST);
} elseif (preg_match('/\/books\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_buku = $matches[1];
    $controller->delete($id_buku);
} else {
    http_response_code(404);
    echo "404 Not Found";
}