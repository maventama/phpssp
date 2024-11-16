<?php
// app/helper.php

require_once __DIR__ . '/Library/CSRF.php';
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function csrf_token() {
    return CSRF::generateToken();
}