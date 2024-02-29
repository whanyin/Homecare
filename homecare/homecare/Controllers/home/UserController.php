<?php

class UserController extends BaseController
{
    function Login()
    {
        $model = new UserModel();
        $data1 = $model->GetData1();
        include VIEW_PATH.'login.html';
    }

    function Check()
    {
        $name   = $_POST['user_name'];
        $pass   = $_POST['user_pass'];
        $model  = new UserModel();
        $result = $model->Check($name, $pass,2);
        if ($result == 1) {//In fact, it can be written directly as：if($result){...}
            //echo 'login successful';
            $msg = 'login successful';
            //include VIEW_PATH . '_msg.html';
            $_SESSION['login'] = 'ok';
            $_SESSION['user']  = $name;

            if ($_SESSION['flag'] == 1) {
                header("location:?p=back&c=Index&a=Index");
            } else {
                header("location:?");
            }

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
        header('location:?c=User&a=Login');
    }

    function Register()
    {

        include VIEW_PATH . 'register.html';
        //In fact, all these statements for loading views can be packaged like this：
        //$this->display('login.html');
    }

    function RegSave()
    {
        $name   = $_POST['user_name'];
        $pass   = $_POST['user_pass'];
        $mail   = $_POST['user_mail'];
        $phone   = $_POST['phone'];
        $model  = new UserModel();
        $result = $model->InsertUser($name, $pass, $mail, $phone);

//        //Complete email verification below
//        require_once LIB_PATH . 'mail.class.php';
//        $mail    = new mail();
//        $server  = $_SERVER['SERVER_NAME'];
//        $script  = $_SERVER['SCRIPT_NAME'];
//        $url     = "http://" . $server . $script . "?c=User&a=Validate";
//        $url     .= "&name=" . md5($name);
//        $title   = 'Blog website registration verification email';
//        $content = 'Please click the link below to complete registration：';
//        $content .= "<br /><a href='$url'>点击验证</a>";
//        $mail->postmail('ldh@itcast.cn', $title, $content);
//
        $msg = 'Register information submitted successfully, please check your mailbox for verification。';
        include VIEW_PATH . '_msg.html';
        header('refresh:3; url=?c=User&a=Login');
    }

    function Validate()
    {
        $name   = $_GET['name'];
        $model  = new UserModel();
        $result = $model->Validate($name);
        if ($result == true) {
            $msg = 'Thank you for registering. Please log in.';
            include VIEW_PATH . '_msg.html';
            header('refresh:3; url=?c=User&a=Login');
        } else {
            $msg = 'Verification failed, please register again.';
            include VIEW_PATH . '_msg.html';
            header('refresh:3; url=?c=User&a=Register');
        }
    }
}