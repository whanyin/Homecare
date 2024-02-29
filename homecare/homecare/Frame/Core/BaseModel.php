<?php

class BaseModel{
    protected $db = null;
    function __construct(){
        $config = include CONFIG_PATH . 'config.php';
        $this->db = MySQLDB::GetDB($config);
    }

}