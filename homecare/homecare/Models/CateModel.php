<?php
class CateModel extends BaseModel{
    function Insert($cate){
        //Build sql statement
        $sql = "insert into category (cate_id, cate_name, cate_desc)values";
        $sql .= "(null,'{$cate['name']}','{$cate['desc']}');";
        //Execute sql statement and get the result
                $result = $this->db->exec($sql);
        //Return results
        return $result;
    }
    function GetAllCate($start=0, $pagesize=10){
        //Build sql statement
        $sql = "select * from category limit $start, $pagesize;";
        //Execute sql statement and get the result
        return $this->db->GetAllRow($sql);
    }
    function GetTotalCount(){
        $sql = "select count(*) as c from category;";
        return $this->db->GetOneData($sql);
    }
    function DeleteById($id){
        $sql = "delete from category where cate_id = $id";
        return $this->db->exec($sql);
    }
    function GetCateById($id){
        $sql = "select * from category where cate_id = $id";
        return $this->db->GetOneRow($sql);
    }
    function Update($id, $cate){
        $sql = "update category ";
        $sql .= " set cate_name = '{$cate['name']}'";
        $sql .= ", cate_desc='{$cate['desc']}' ";
        $sql .= " where cate_id = $id ";
        return $this->db->exec($sql);
    }
}