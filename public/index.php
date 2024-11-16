<?php
// public/index.php

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/Library/Database.php';
require_once __DIR__ . '/../app/helper.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once __DIR__ . '/../routes/web.php';
