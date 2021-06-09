<?php


$origin = $_SERVER["HTTP_ORIGIN"];
header("Access-Control-Allow-Origin: $origin");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Authorization, vx-view-as');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE");

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    header("HTTP/1.1 200 OK");
    exit();
}

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once("vendor/autoload.php");
$app = new PUXT\App(__DIR__);
$app->run();
