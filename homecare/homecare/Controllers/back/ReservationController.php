<?php

class ReservationController extends BaseController
{
    public function ShowList()
    {
        $where = ' 1=1 ';
        if (!empty($_POST['s_type'])) {
            $where .= ' and c.type=' . $_POST['s_type'];
        }
        if (!empty($_POST['keywords'])) {
            $where .= ' and c.reservation_content like "%' . $_POST['keywords'] . '%"';
        }
        // if ($_SESSION['flag'] == 3) {
        //     $where .= 'and (c.doctor_id is null or c.doctor_id = ' . $_SESSION['user_id'] . ')';
        // }
        $c_model = new ReservationModel();
        $data    = $c_model->getAllReservation(0, 100, $where);
        include VIEW_PATH . 'reservation.html';
    }
    

    public function edit()
    {
        $c_model   = new ReservationModel();
        $id        = $_GET['id'];
        $data      = $c_model->getDataById($id);
        $doctor_id = 0;
        if ($_SESSION['flag'] == 3) $doctor_id = $_SESSION['user_id'];
        $doctor = (new UserModel())->getDoctor($doctor_id);
        $doctor = array_column($doctor, 'user_name', 'user_id');
        include VIEW_PATH . 'r_edit.html';
    }

    public function update()
    {
        $c_model = new ReservationModel();
        $id      = $_POST['id'];
        if ($_SESSION['flag'] == 3) {
             $status = ',status='.$_POST['status'];
             $doctor_id = $_SESSION['user_id'];
            } else {
            $status = ',status='.$_POST['status'];
            $doctor_id = $_POST['doctor_id'];
            }

        $sql = 'update reservation set doctor_id=' . $doctor_id . ',status='.$_POST['status'].',answer_time="' . date('Y-m-d H:i:s') . '" where id=' . $id;
        $c_model->save($sql);
        header("location:?p=back&c=reservation&a=ShowList");
    }

    public function withdrawal()
    {
        $where = 'c.doctor_id = ' . $_SESSION['user_id'];
        if (!empty($_POST['s_type'])) {
            $where .= ' and c.type=' . $_POST['s_type'];
        }
        if (!empty($_POST['keywords'])) {
            $where .= ' and c.reservation_content like "%' . $_POST['keywords'] . '%"';
        }

        if (empty($_SESSION['user_id'])) {
            $msg = 'Please log in first.';
            include VIEW_PATH . '_msg.html';
            header('refresh:3; url=?p=back&c=User&a=Login');
        }


        $c_model = new ReservationModel();
        $data    = $c_model->getAllReservation(0, 100, $where);
        $total_amount = $c_model->getAll('select sum(withdraw) as total_amount from reservation where doctor_id='. $_SESSION['user_id']);
        $total_amount = $total_amount[0]['total_amount'] ?? 0;
        include VIEW_PATH . 'withdrawal.html';
    }

    public function withdrawalAmount()
    {
        $c_model = new ReservationModel();
        $where   = 'c.id = ' . $_GET['id'];
        $data    = $c_model->getAllReservation(0, 100, $where);
        if (empty($data) || $data[0]['amount']-$data[0]['withdraw']==0) {
            $msg = 'No eligible withdrawal data available.';

        } else {
            $data   = $data[0];
            $amount = $data['amount'];
            $sql    = "update reservation set withdraw={$amount} where id=" . $_GET['id'];
            $c_model->save($sql);
            $msg = 'Withdrawal success. The amount is ' . $amount;
        }

        include VIEW_PATH . '_msg.html';
        header('refresh:3; url=?p=back&c=reservation&a=withdrawal');
    }


}
