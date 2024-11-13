<?php

class InputSanitizer {
    public function handle($request) {
        // Loop untuk menyaring semua input yang ada
        foreach ($_POST as $key => $value) {
            // Sanitasi input: Mencegah XSS dengan htmlspecialchars
            $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        foreach ($_GET as $key => $value) {
            // Sanitasi input: Mencegah XSS dengan htmlspecialchars
            $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }
}
