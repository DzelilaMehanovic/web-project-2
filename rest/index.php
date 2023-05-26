<?php
require "../vendor/autoload.php";
require "services/StudentService.php";
require "services/CourseService.php";
require "dao/UserDao.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::register('student_service', "StudentService");
Flight::register('course_service', "CourseService");
Flight::register('userDao', "UserDao");

// middleware method for login
Flight::route('/*', function(){
  //perform JWT decode
  $path = Flight::request()->url;
  if ($path == '/login' || $path == '/docs.json') return TRUE; // exclude login route from middleware

  $headers = getallheaders();
  if (!$headers['Authorization']){
    Flight::json(["message" => "Authorization is missing"], 403);
    return FALSE;
  }else{
    try {
      $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
      Flight::set('user', $decoded);
      return TRUE;
    } catch (\Exception $e) {
      Flight::json(["message" => "Authorization token is not valid"], 403);
      return FALSE;
    }
  }
});


/* REST API documentation endpoint */
Flight::route('GET /docs.json', function(){
  $openapi = \OpenApi\scan('routes');
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

require_once 'routes/UserRoutes.php';
require_once 'routes/StudentRoutes.php';
require_once 'routes/CourseRoutes.php';


Flight::start();
?>
