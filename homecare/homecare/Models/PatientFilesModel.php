<?php

class PatientFilesModel extends BaseModel
{
    protected $table = 'patient_files';

    public function getAll($sql)
    {
        return $this->db->GetAllRow($sql);
    }
    public function getAllNoSql()
    {
        $sql = "select * from ".$this->table;
        return $this->db->GetAllRow($sql);
    }
    public function save($sql)
    {
        return $this->db->exec($sql);
    }
}