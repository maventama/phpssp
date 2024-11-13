<?php
// app/controllers/BaseController.php

class Controller {
    protected function view($view, $data = []) {
        extract($data); // Ekstrak data agar bisa diakses langsung di view
        require_once __DIR__ . "/../../views/{$view}.php";
    }

    // Tambahkan metode lain yang ingin digunakan di semua controller
}
