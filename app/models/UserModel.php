<?php
// app/models/UserModel.php

require_once __DIR__ . '/../Library/Database.php';
require_once __DIR__ . '/../models/Model.php';

class UserModel extends Model {
    public function getAll()
    {
        $users = $this->db->query("SELECT * FROM users");
    }
}
