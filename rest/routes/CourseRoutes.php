<?php

Flight::route("GET /students", function(){
    Flight::json(Flight::course_dao()->get_all());
 });
 
 Flight::route("GET /student_by_id", function(){
    Flight::json(Flight::course_dao()->get_by_id(Flight::request()->query['id']));
 });
 
 Flight::route("GET /students/@id", function($id){
    Flight::json(Flight::course_dao()->get_by_id($id));
 });
 
 Flight::route("DELETE /students/@id", function($id){
    Flight::course_dao()->delete($id);
    Flight::json(['message' => "Student deleted successfully"]);
 });
 
 Flight::route("POST /course", function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => "Student added successfully",
                  'data' => Flight::course_dao()->add($request)
                 ]);
 });
 
 Flight::route("PUT /student/@id", function($id){
    $student = Flight::request()->data->getData();
    Flight::json(['message' => "Student edit successfully",
                  'data' => Flight::course_dao()->update($student, $id)
                 ]);
 });
 
 Flight::route("GET /students/@name", function($name){
    echo "Hello from /students route with name= ".$name;
 });
 
 Flight::route("GET /students/@name/@status", function($name, $status){
    echo "Hello from /students route with name = " . $name . " and status = " . $status;
 });

?>