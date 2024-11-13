<?php
// app/models/UserModel.php

require_once __DIR__ . '/../Library/Database.php';

class Model {
    protected $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $config = require __DIR__ . '/../config.php';
        $this->db = new Database($config);
    }
}
