<?php


class IndexController extends BaseController
{
    function index()
    {
        $c_model     = new ConsultationModel();
        $r_model     = new ReservationModel();
        $c_count     = $c_model->GetTotalCount();
        $r_count     = $r_model->GetTotalCount();
        $total_count = $c_count + $r_count;
        include VIEW_PATH . 'index.html';
    }

    public function consultationDetail()
    {
        $id    = $_GET['id'];
        $model = new ConsultationModel();
        $data  = $model->GetConsultationById($id);
        include VIEW_PATH . 'consultation_detail.html';
    }

    public function getDoctor()
    {
        $model = new UserModel();
        $data  = $model->getDoctor();
        include VIEW_PATH . 'doctor.html';
    }

    public function editUser()
    {
        $model = new UserModel();
        $id =$_GET['id'];

        $model->getDoctor($id);
        include VIEW_PATH . 'd_edit.html';
    }

    public function update()
    {
        $model = new UserModel();
        $sql = "update user set status='$_POST[status]',capacity='$_POST[capacity]' where  user_id='$_POST[id]'";
        $model->save($sql);
        header("location:?p=back&c=index&a=getDoctor");
    }
    public function addPatientFiles()
    {
        $u_model = new UserModel();
        $disease = $u_model->getAll('select user_id,user_name from user where flag=2;');
        $doctor = $u_model->getAll('select user_id,user_name from user where flag=3;');
        include VIEW_PATH. 'add_patient_files.html';
    }

    public function getPatientFiles()
    {
        $model = new PatientFilesModel();
        $data  = $model->getAllNoSql();
        $u_model = new UserModel();
        $disease = $u_model->getAll('select user_id,user_name from user where flag=2;');
        $doctor = $u_model->getAll('select user_id,user_name from user where flag=3;');
        $disease = array_column($disease , 'user_name', 'user_id');
        $doctor = array_column($doctor , 'user_name', 'user_id');
        include VIEW_PATH. 'patient_files.html';
    }
    public function savePatientFiles()
    {
        $type = $_POST['type'];
        $doctor_content = $_POST['doctor_content'];
        $user_id = $_POST['user_id'];
        $doctor_id = $_POST['doctor_id'];
        $model = new UserModel();
        $sql = "insert into patient_files (type,doctor_content,user_id,doctor_id) values('$type','$doctor_content','$user_id','$doctor_id')";
        $model->save($sql);
        header("location:?p=back&c=index&a=addPatientFiles");
    }
    public function pDel()
    {
        $model = new PatientFilesModel();
        $sql = 'Delete from patient_files where id='.$_GET['id'];
        $model->save($sql);
        header("location:?p=back&c=index&a=getPatientFiles");
    }

    public function editPatientFiles()
    {
        $u_model = new UserModel();
        $disease = $u_model->getAll('select user_id,user_name from user where flag=2;');
        $doctor = $u_model->getAll('select user_id,user_name from user where flag=3;');

        $model = new PatientFilesModel();
        $id = $_GET['id'];
        $data = $model->getAll("select * from  patient_files where id=$id;");
        $data = $data[0]??[];

        include VIEW_PATH.'p_edit.html';

    }
    public function editSave()
    {
        $type = $_POST['type'];
        $id = $_POST['id'];
        $doctor_content = $_POST['doctor_content'];
        $user_id = $_POST['user_id'];
        $doctor_id = $_POST['doctor_id'];
        $model = new PatientFilesModel();
        $sql     = "update patient_files set doctor_id=$doctor_id ,doctor_content='$doctor_content',user_id=$user_id where id=$id";
        $model->save($sql);
        header("location:?p=back&c=index&a=getPatientFiles");
    }
}