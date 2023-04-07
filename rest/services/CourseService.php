<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/CoursesDao.class.php";

class CourseService extends BaseService{
    public function __construct(){
        parent::__construct(new CoursesDao);
    } 
}
?>