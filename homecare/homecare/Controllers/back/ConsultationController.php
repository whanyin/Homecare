<?php

class ConsultationController extends BaseController
{
    public function ShowList()
    {
        try {
            $where = ' 1=1 ';
            if (!empty($_POST['s_type'])) {
                $where .= ' and c.type='.$_POST['s_type'];
            }
            if (!empty($_POST['keywords'])) {
                $where .= ' and c.consultation_content like "%'.$_POST['keywords'].'%"';
            }
            // if ($_SESSION['flag']== 3) {
            //     $where.='and (c.doctor_id is null or c.doctor_id = '.$_SESSION['user_id']. ')';
            // }
            $c_model = new ConsultationModel();
            $data = $c_model->getAllConsultation(0,100,$where);
            include VIEW_PATH. 'consultation.html';
        }catch (\Exception $e) {
            echo $e->getLine().'---'.$e->getMessage();
        }

    }

    public function edit()
    {
        $c_model = new ConsultationModel();
        $id = $_GET['id'];
        $data = $c_model->getDataById($id);
        $doctor_id = 0;
        if ($_SESSION['flag']== 3) $doctor_id =$_SESSION['user_id'];
        $doctor = (new UserModel())->getDoctor($doctor_id);

        $doctor  = array_column($doctor,'user_name','user_id');
        include VIEW_PATH. 'c_edit.html';
    }
    public function refuse()
    {
        $c_model = new ConsultationModel();
        $id = $_GET['id'];
        $sql = 'update consultation set doctor_id=0,doctor_answer="" where id='.$id;
        $c_model->save($sql);
    }
    public function update()
    {
        $c_model = new ConsultationModel();
        $id = $_POST['id'];
        $sql = 'update consultation set doctor_id='.$_POST['doctor_id'].',doctor_answer="'.$_POST['doctor_answer'].'" where id='.$id;
        $c_model->save($sql);
        header("location:?p=back&c=consultation&a=ShowList");
    }

}