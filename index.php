<?php
session_start();
require_once "./vendor/autoload.php";
require_once "./env.php";
require_once "./src/slimConfiguration.php";
require_once './src/constants.php';
require_once "./routes/index.php";

$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("resources/views");

$app->run();