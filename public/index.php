<?php
// public/index.php

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/helper.php';

// Ambil URI dari request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Muat rute dan arahkan ke controller yang tepat
require_once __DIR__ . '/../routes/web.php';
route($uri, $routes);
