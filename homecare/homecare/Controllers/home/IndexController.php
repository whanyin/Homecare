<?php

class  IndexController extends HomeController
{
    function Index()
    {
        //Get a list of categories：
        $model = new CateModel();
        $cates = $model->GetAllCate(0, 8);
        $cates = $this->GetCates();

        $cid   = !empty($_GET['cid']) ? $_GET['cid'] : "0";

        if ($cid == 2) {
            $cates = array_column($cates, null, 'cate_id');

            include VIEW_PATH . 'consultation.html';
        } elseif ($cid == 3) {

            include VIEW_PATH . 'reservation.html';

        } elseif ($cid == 4) {
            $name  = 'Consultation';
            $model = new ConsultationModel;
            $res   = $model->getAllConsultation();
            foreach ($res as $v) {
                $tmp['time']    = $v['consultation_time'];
                $tmp['content'] = $v['consultation_content'];
                $tmp['type']    = ConsultationModel::TYPE[$v['type']] ?? '';
                $tmp['status']  = 'success';
                $data[]         = $tmp;
            }

            include VIEW_PATH . 'record.html';

        } else {
            include VIEW_PATH . 'index.html';
        }

    }


    function consultation()
    {
        $model                        = new ConsultationModel;
        $data['consultation_content'] = $_POST['consultation_content'];
        $data['type']                 = $_POST['type'];
        $data['pay_type']             = $_POST['pay_type'];
        $data['amount']               = $_POST['amount'];

        $data['cate_id'] = 2;
        $data['user_id'] = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $model->Insert($data);

        $msg = 'Thank you for your consultation！';
        include VIEW_PATH . '_msg.html';
        header('refresh:1; url=?a=Index');
    }

    function reservation()
    {

        $model = new ReservationModel;

        $data['type']                = $_POST['type'];
        $data['reservation_content'] = $_POST['reservation_content'];
        $data['cate_id']             = 3;
        $data['status']              = 0;
        $data['user_id']             = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $data['pay_type']            = $_POST['pay_type'];
        $data['amount']              = $_POST['amount'];

        $model->Insert($data);

        $msg = 'Thank you for your reservation！';
        include VIEW_PATH . '_msg.html';
        header('refresh:1; url=?a=Index');
    }

    function record()
    {
        $model = new CateModel();
        $cates = $model->GetAllCate(0, 8);
        $cates = $this->GetCates();
        if (empty($_GET['type'])) {
            $name = 'Unknown';
        } elseif ($_GET['type'] == 2) {
            $model = new ConsultationModel;
            $res   = $model->getAllConsultation();
            $name  = 'Consultation';
            foreach ($res as $v) {
                $tmp['time']    = $v['consultation_time'];
                $tmp['content'] = $v['consultation_content'];
                $tmp['status']  = 'success';
                $tmp['type']    = ConsultationModel::TYPE[$v['type']] ?? '';
                $data[] = $tmp;
            }

        } elseif ($_GET['type'] == 3) {
            $name   = 'Reservation';
            $model  = new ReservationModel;
            $res    = $model->getAllReservation();
            $status = [ 0 => 'Not seen', 1 => 'On the doorstep', 2 => 'Visited',];
            foreach ($res as $v) {
                $tmp['time']    = $v['reservation_time'];
                $tmp['content'] = $v['reservation_content'];
                $tmp['type']    = ConsultationModel::TYPE[$v['type']] ?? '';
                $tmp['status']  = $status[$v['status']] ?? 'Unknown';
                $data[]         = $tmp;
            }
        }
        include VIEW_PATH . 'record.html';
    }
}
