<?php
// app/models/UserModel.php

require_once __DIR__ . '/../Database.php';

class UserModel {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $config = require __DIR__ . '/../config.php';
        $this->db = new Database($config);
    }
    public function getAll()
    {
        // Query data dari database dengan nama tabel 'gauge'
        $gauges = $this->db->query("SELECT * FROM gauge");
        $gaugesWithPercents = [];
        foreach ($gauges as $gauge) {
            $gauge['percent'] = round($gauge['real_kontrak'] / $gauge['pagu'] * 100, 2);
            $gaugesWithPercents[] = $gauge;
        }

        return $gaugesWithPercents;
    }
}
