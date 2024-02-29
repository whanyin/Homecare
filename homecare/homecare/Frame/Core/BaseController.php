<?php
class BaseController{
    function __construct(){
        header("content-type:text/html; charset=utf-8");

        session_start();
    }

    function GetSmarty(){
        require_once SMARTY_PATH . 'smarty.class.php';
        $smarty = new smarty();
        $smarty->template_dir = VIEW_PATH;
        $smarty->compile_dir = COMPILE_PATH;
        return $smarty;
    }
}