<?php
// routes/web.php

require_once __DIR__ . '/../app/library/Router.php';

$router = new Router();

$router->add('GET', '/', 'HomeController@index', ['RateLimiter', 'InputSanitizer']);
$router->add('GET', '/about', 'HomeController@about', ['RateLimiter', 'InputSanitizer']);
$router->add('POST', '/submit-form', 'FormController@submit', ['RateLimiter', 'InputSanitizer']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
