<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/StudentsDao.class.php";

class StudentService extends BaseService{
    public function __construct(){
        parent::__construct(new StudentsDao);
    }

    public function get_user_students($user){
        return $this->dao->get_user_students($user['id']);
    }

    public function get_by_id_and_user($user, $id){
        return $this->dao->get_by_id_and_user($user['id'], $id);
    }

    public function delete_student($user, $id){
        return $this->dao->delete_student($user['id'], $id);
    }

    public function update($student, $id, $id_column="id", $user = null){
        if($user){
            $student['user_id'] = $user['id'];
        }
        $student['password'] = md5($student['password']);
        if(isset($student['id_column'])  && !is_null($student['id_column'])){
            return parent::update($student, $id, $student['id_column']);
        }
        return parent::update($student, $id);
    }

    public function add($entity, $user = null){
        unset($entity['phone']);
        if($user){
            $entity['user_id'] = $user['id'];
        }
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
