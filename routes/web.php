<?php
// routes/web.php

require_once __DIR__ . '/../app/library/Router.php';

// Inisialisasi objek router
$router = new Router();

// Definisikan route dengan parameter dinamis menggunakan metode add
$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/about', 'HomeController@about');
// $router->add('GET', '/user/{id}', 'UserController@show');
// $router->add('GET', '/post/{slug}', 'PostController@detail');

// Fungsi untuk menjalankan routing berdasarkan URL saat ini
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
