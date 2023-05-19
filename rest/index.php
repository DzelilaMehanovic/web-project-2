<?php
require "../vendor/autoload.php";
require "services/StudentService.php";
require "services/CourseService.php";
require "dao/UserDao.php";

Flight::register('student_service', "StudentService");
Flight::register('course_service', "CourseService");
Flight::register('userDao', "UserDao");

require_once 'routes/StudentRoutes.php';
require_once 'routes/CourseRoutes.php';
require_once 'routes/UserRoutes.php';

Flight::start();
?>
