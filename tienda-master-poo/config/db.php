<?php

class Database
{
    public static function conectar()
    {
        $db = new mysqli('localhost', 'user', 'password123', 'tienda_master');
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}
