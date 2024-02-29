<?php

class UserModel extends BaseModel
{
    const STATUS = [
        1 => 'Busy',
        0 => 'Not busy',
    ];
    const CAPACITY = [
        0 => 'Not capable',
        1 => 'Average ability',
        2 => 'Moderate ability',
        3 => 'Be capable',
    ];

    function GetData1()
    {
        return 'aaa';
    }

    function Check($name, $pass, $flag = 2)
    {

        //Build query statement：
        $sql = "select * from user ";
        $sql .= " where user_name='$name' and user_pass = md5('$pass') and flag=$flag; ";
        //Execute and return results
        $result  = $this->db->GetAllRow($sql);

        $count   = count($result);    //Rows、
        if ($count==0) return 0;
        $flag    = $result[0]['flag'];
        $user_id = $result[0]['user_id'];
        //When the flag is 0, it is not actually a valid user and cannot log in.
        if ($count == 1 && $flag != 0) {    //Indicates successful login
            $_SESSION['flag']        = $flag;
            $_SESSION['user_id']     = $user_id;
            $_SESSION['user_name']   = $result[0]['user_name'];
            $_SESSION['user_mail']   = $result[0]['user_mail'];
            $_SESSION['phone']       = $result[0]['phone'];
            $_SESSION['user_id']     = $result[0]['user_id'];
            $_SESSION['login_times'] = $result[0]['login_times'] + 1;
            $sql                     = "update user set login_times=login_times+1 where user_name='$name'";
            $this->db->exec($sql);
            return 1;
        }
        return 0;
    }

    function InsertUser($name, $pass, $mail, $phone)
    {
        //Set the flag item to 0 initially
        $sql = "insert into user (user_name, user_pass, user_mail,phone, login_times,flag)";
        $sql .= " values('$name',md5('$pass'),'$mail', $phone,0 , 2);";
        return $this->db->exec($sql);
    }

    function Validate($name)
    {    //This $name has actually been md5 encrypted.
        $sql   = "select count(*) as c  from user where md5(user_name) = '$name'";
        $count = $this->db->GetOneData($sql);
        if ($count == 1) {
            $sql = "update user set flag = 2 where md5(user_name) = '$name'";
            $this->db->exec($sql);
            return true;
        } else {
            return false;
        }
    }

    function GetLoginTimes($user_name)
    {
        $sql = "select login_times from user where user_name = '$user_name'";
        return $this->db->GetOneData($sql);
    }

    public function getDoctor($doctor_id = 0)
    {
        $where = 'flag=3';
        if (!empty($doctor_id)) $where .= ' and user_id = ' . $doctor_id;
        $sql = "select * from user where $where";
        //Execute and return results
        return $this->db->GetAllRow($sql);
    }
    public function getAll($sql)
    {
        return $this->db->GetAllRow($sql);
    }
    public function save($sql)
    {
        return $this->db->exec($sql);
    }
}