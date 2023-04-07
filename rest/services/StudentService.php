<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/StudentsDao.class.php";

class StudentService extends BaseService{
    public function __construct(){
        parent::__construct(new StudentsDao);
    }

    public function update($student, $id){
        if($student['id_column']){
            return parent::update($student, $id, $student['id_column']);
        }
        return parent::update($student, $id);
    }

    public function add($entity){
        return parent::add($entity);
        /*
        example
        send an email
        if(!validateField($entity['first_name'])){
            //error
        }
        */
    }
}
?>
