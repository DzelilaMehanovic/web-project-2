<?php
require_once "BaseDao.class.php";

class StudentsDao extends BaseDao {

    public function __construct(){
        parent::__construct("students");
    }
}
?>