<?php
// routes.php

require_once 'app/controllers/PublishersController.php';
require_once 'app/controllers/LoansController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/Books.php';

$controller = new BooksController();
$UserController = new UserController();
$LoansController = new LoansController();
$PublishersController = new PublishersController();
$url = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($url == '/publishers/dashboard' || $url == '/') {
    $PublishersController->dashboard();
} elseif ($url == '/publishers/index' && $requestMethod == 'GET') {
    $PublishersController->index();
} elseif ($url == '/publishers/create' && $requestMethod == 'GET') {
    $PublishersController->create();
} elseif ($url == '/publishers/store' && $requestMethod == 'POST') {
    $PublishersController->store();
} elseif (preg_match('/\/publishers\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $publishersId = $matches[1];
    $PublishersController->edit($publishersId);
} elseif (preg_match('/\/publishers\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $publishersId = $matches[1];
    $PublishersController->update($publishersId, $_POST);
} elseif (preg_match('/\/publishers\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $publishersId = $matches[1];
    $PublishersController->delete($publishersId);
} elseif ($url == '/loans/dashboard' || $url == '/') {
    $LoansController->dashboard();
} elseif ($url == '/loans/index' && $requestMethod == 'GET') {
    $LoansController->index();
} elseif ($url == '/loans/create' && $requestMethod == 'GET') {
    $LoansController->create();
} elseif ($url == '/loans/store' && $requestMethod == 'POST') {
    $LoansController->store();
} elseif (preg_match('/\/loans\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $loansId = $matches[1];
    $LoansController->edit($loansId);
} elseif (preg_match('/\/loans\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $loansId = $matches[1];
    $LoansController->update($loansId, $_POST);
} elseif (preg_match('/\/loans\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $loansId = $matches[1];
    $LoansController->delete($loansId);
} elseif ($url == '/user/dashboard' || $url == '/') {
    $UserController->dashboard();
} elseif ($url == '/user/index' && $requestMethod == 'GET') {
    $UserController->index();
} elseif ($url == '/user/create' && $requestMethod == 'GET') {
    $UserController->create();
} elseif ($url == '/user/store' && $requestMethod == 'POST') {
    $UserController->store();
} elseif (preg_match('/\/user\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_user = $matches[1];
    $UserController->edit($id_user);
} elseif (preg_match('/\/user\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $id_user = $matches[1];
    $UserController->update($id_user, $_POST);
} elseif (preg_match('/\/user\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $id_user = $matches[1];
    $UserController->deleteUser($id_user);
} elseif ($url == '/books/dashboard' || $url == '/') {
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