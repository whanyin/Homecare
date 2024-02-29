<?php

class UserController extends BaseController
{
    function Login()
    {
        $model = new UserModel();
        $data1 = $model->GetData1();
        include VIEW_PATH.'admin_login.html';
    }
    function Check()
    {
        $name   = $_POST['user_name'];
        $pass   = $_POST['user_pass'];
        $flag   = $_POST['flag'];
        $model  = new UserModel();
        $result = $model->Check($name, $pass,$flag);

        if ($result == 1) {//In fact, it can be written directly as：if($result){...}
            //echo 'login successful';
            $msg = 'login successful';
            //include VIEW_PATH . '_msg.html';
            $_SESSION['login'] = 'ok';
            $_SESSION['user']  = $name;
            $_SESSION['user_name']  = $name;
            $_SESSION['user']  = $name;

            header("location:?p=back&c=Index&a=Index");

        } else {
            //echo 'Login failed: Incorrect username or password';
            $msg = 'Login failure: Incorrect username or password';
            include VIEW_PATH . '_msg.html';
        }
    }
    function Logout()
    {
        unset($_SESSION['login']);
        session_destroy();
        header('location:?p=back&c=User&a=Login');
    }
}