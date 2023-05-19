<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/StudentsDao.class.php";

class StudentService extends BaseService{
    public function __construct(){
        parent::__construct(new StudentsDao);
    }

    public function update($student, $id, $id_column="id"){
        $student['password'] = md5($student['password']);
        if(isset($student['id_column'])  && !is_null($student['id_column'])){
            return parent::update($student, $id, $student['id_column']);
        }
        return parent::update($student, $id);
    }

    public function add($entity){
        unset($entity['phone']);
        $entity['password'] = md5($entity['password']);
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
