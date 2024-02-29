<?php

class ReservationModel extends BaseModel
{
    const TYPE = [
        1 => 'Medical examination',
        2 => 'Catheter care',
        3 => 'Blood test',
        4 => 'COVID-19 detection',
        5 => 'Vaccination',
        6 => 'Feedback',
    ];
    const STATUS = [
        0 => 'Not seen',
        1 => 'On the doorstep',
        2 => 'Visited',
    ];
    function Insert($insert)
    {
        //Build sql statement
                $sql = "insert into reservation (reservation_content, user_id,cate_id,type,status,amount)values";
        $sql .= "('{$insert['reservation_content']}','{$insert['user_id']}','{$insert['cate_id']}','{$insert['type']}','{$insert['status']}','{$insert['amount']}');";
        //Execute sql statement and get the result
        $result = $this->db->exec($sql);
        //Return results
        return $result;
    }
    public function getAllReservation($startLine = 0, $pageSize = 100,$where='')
    {
        if (empty($where)) $where ='1=1 ';
        $sql = "select c.*,u.user_name as doctor from reservation c left join user u on u.user_id=c.doctor_id where $where limit $startLine, $pageSize;";
        //Execute sql statement and get the result
                return $this->db->GetAllRow($sql);
    }
    
    function getTotalCount(){
        $sql = "select count(*) as c from reservation;";
        return $this->db->GetOneData($sql);
    }
    public function getDataById($id)
    {
        $sql = 'select *  from reservation where id='.$id.';';
        return $this->db->GetOneRow($sql);
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