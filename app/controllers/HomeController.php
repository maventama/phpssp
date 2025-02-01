<?php
// app/controllers/HomeController.php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class HomeController extends Controller {
    private $db;

    public function __construct() {
        $config = require __DIR__ . '/../config.php';
        $this->db = new Database($config);
    }
    public function index() {
        $data = ['title' => 'Home Page', 'message' => 'Ini adalah halaman home.'];
        $this->view('home', $data);
    }

    public function about() {
        $data = ['title' => 'About Page', 'message' => 'Ini adalah halaman about.'];
        $this->view('home', $data);
    }
    public function test($var)
    {
        echo $var;
    }
    public function detail($var, $detail)
    {
        echo $var . ' - ' . $detail;
    }
}
