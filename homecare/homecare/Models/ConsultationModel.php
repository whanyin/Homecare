<?php

class ConsultationModel extends BaseModel
{
    const TYPE = [
        1 => 'Regular health assessment',
        2 => 'Drug management',
        3 => 'Rehabilitation services',
        4 => 'Home care',
        5 => 'Others'
    ];

    function Insert($insert)
    {
        //Build sql statement
        $sql = "insert into consultation (type, user_id, consultation_content,cate_id,amount)values";
        $sql .= "('{$insert['type']}','{$insert['user_id']}','{$insert['consultation_content']}','{$insert['cate_id']}','{$insert['amount']}');";
        //Execute sql statement and get the result
        $result = $this->db->exec($sql);
        //Return results
        return $result;
    }
    public function getAllConsultation($startLine = 0, $pageSize = 100,$where='')
    {
        if (empty($where)) $where = ' 1=1 ';
        $sql = "select c.*,u.user_name as doctor from consultation c left join user u on u.user_id=c.doctor_id where $where limit $startLine, $pageSize;";
        //Execute sql statement and get the result
        return $this->db->GetAllRow($sql);
    }
    function getTotalCount(){
        $sql = "select count(*) as c from consultation;";
        return $this->db->GetOneData($sql);
    }

    public function getDataById($id)
    {
        $sql = 'select *  from consultation where id='.$id.';';
        return $this->db->GetOneRow($sql);
    }
    public function save($sql)
    {
        return $this->db->exec($sql);
    }
}