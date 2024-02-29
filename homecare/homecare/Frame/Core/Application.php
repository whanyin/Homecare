<?php

class Application
{
    static function run()
    {
        //Initialize three parameters p, c, and a and make them constants for subsequent use.
        Application::initPCA();
        //Initialize some common constants
        Application::initConst();

        //"Declare" (register) autoload functions (methods)；
        Application::initAutoload();

        //Load a few basic classes that are almost always needed：
        Application::loadBaseClass();

        //Request distribution: In fact, it is which method to execute "determine which control"；
        Application::dispatch();
    }

    private static function loadBaseClass()
    {
        require_once FRAME_PATH . 'DB' . DS . 'MySQLDB.php';
        require_once CORE_PATH . 'BaseModel.php';
        require_once CORE_PATH . 'BaseController.php';
    }

    //Initialize three parameters p, c, and a and make them constants for subsequent use.
    private static function initPCA()
    {
        $p = !empty($_GET['p']) ? $_GET['p'] : "home";    //Platform name
        $c = !empty($_GET['c']) ? $_GET['c'] : "Index";    //Controller name
        $a = !empty($_GET['a']) ? $_GET['a'] : "Index";//action name, method name
        define('PLAT', $p);
        define('CTRL', $c);
        define('ACTION', $a);
    }

    //Initialize some common constants
    private static function initConst()
    {
        //Continue to define some commonly used constants to facilitate subsequent use.：
        define("DS", DIRECTORY_SEPARATOR);
        define('ROOT', getcwd() . DS);    //It is the directory where index.php is currently located, and is also the root directory of mvc.
        define('FRAME_PATH', ROOT . 'Frame' . DS);
        define('CORE_PATH', FRAME_PATH . 'Core' . DS);
        define('APP_PATH', ROOT);
        define('CONFIG_PATH', APP_PATH . 'Config' . DS);
        define('MODEL_PATH', APP_PATH . 'Models' . DS);
        define('CTRL_PATH', APP_PATH . 'Controllers' . DS . PLAT . DS);
        define('VIEW_PATH', APP_PATH . 'Views' . DS . PLAT . DS);
        define('LIB_PATH', FRAME_PATH . 'Libs' . DS);
        define('SMARTY_PATH', FRAME_PATH . 'smarty' . DS . 'libs' . DS);
        define('COMPILE_PATH', VIEW_PATH . 'template_c' . DS);


    }
    //Here comes the "declaration" (registration) of the automatic loading function (method);
     //After the declaration, once a class is "required" during program execution, the autoloading function will be called    
     private static function initAutoload()
    {

        spl_autoload_register("self::autoload");

    }

    //Autoload function (method)；
    private static function autoload($className)
    {    //class name, such as'UserController','UserModel'
        //Load model class or controller class file
        //require_once 'App/Models/UserModel.php';
        //require_once 'App/Controllers/home/UserController.php';
        $model_file      = MODEL_PATH . $className . '.php';
        $controller_file = CTRL_PATH . $className . '.php';
        if (file_exists($model_file)) {
            require_once $model_file;
        } else if (file_exists($controller_file)) {
            require_once $controller_file;
        }
    }

    //Request distribution: In fact, it is which method to execute "determine which control"；
    private static function dispatch()
    {
        try {
            //Instantiate the controller and call the method
            $ctrl_name = ucfirst(CTRL) . "Controller";    //Controller class name
            $ctrl      = new $ctrl_name();
            $a         = ACTION;
            $ctrl->$a();
        }catch (\Exception $e){
            echo $e->getLine().'---'.$e->getMessage();
        }

    }
}