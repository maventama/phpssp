<?php
// app/CSRF.php

class CSRF {
    // Fungsi untuk menghasilkan token CSRF dan menyimpannya di sesi
    public static function generateToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Ciptakan token CSRF yang aman
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        
        return $token;
    }

    // Fungsi untuk memverifikasi token CSRF
    public static function verifyToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Periksa apakah token CSRF yang diberikan cocok dengan yang ada di sesi
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
