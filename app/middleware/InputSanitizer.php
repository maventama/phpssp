<?php

class InputSanitizer {
    public function handle($request) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        foreach ($_GET as $key => $value) {
            $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }
}
