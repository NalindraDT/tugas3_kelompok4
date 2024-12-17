<?php
// routes.php

require_once 'app/controllers/LoansController.php';

$loancontroller = new LoansController();
$url = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($url == '/loans/dashboard' || $url == '/') {
    $loancontroller->dashboard();
} elseif ($url == '/loans/index' && $requestMethod == 'GET') {
    $loancontroller->index();
} elseif ($url == '/loans/create' && $requestMethod == 'GET') {
    $loancontroller->create();
} elseif ($url == '/loans/store' && $requestMethod == 'POST') {
    $loancontroller->store();
} elseif (preg_match('/\/loans\/edit\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $loansId = $matches[1];
    $loancontroller->edit($loansId);
} elseif (preg_match('/\/loans\/update\/(\d+)/', $url, $matches) && $requestMethod == 'POST') {
    $loansId = $matches[1];
    $loancontroller->update($loansId, $_POST);
} elseif (preg_match('/\/loans\/delete\/(\d+)/', $url, $matches) && $requestMethod == 'GET') {
    $loansId = $matches[1];
    $loancontroller->delete($loansId);
} else {
    http_response_code(404);
    echo "404 Not Found";
}