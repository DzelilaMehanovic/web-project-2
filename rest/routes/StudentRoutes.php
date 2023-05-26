<?php
/**
 * @OA\Get(path="/students", tags={"students"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all students from the API. ",
 *         @OA\Response( response=200, description="List of students.")
 * )
 */
Flight::route("GET /students", function(){
    $user = Flight::get('user');
    if($user['is_admin']){
        Flight::json(Flight::student_service()->get_all());
    } else {
        Flight::json(Flight::student_service()->get_user_students($user));
    }
 });

  /**
  * @OA\Get(path="/student_by_id", tags={"students"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="query", name="id", example=1, description="Student ID"),
  *     @OA\Response(response="200", description="Fetch individual student")
  * )
  */
 Flight::route("GET /student_by_id", function(){
     $user = Flight::get('user');
     if($user['is_admin']){
         Flight::json(Flight::student_service()->get_by_id(Flight::request()->query['id']));
     } else {
         Flight::json(Flight::student_service()->get_by_id_and_user($user, Flight::request()->query['id']));
     }
 });

 /**
  * @OA\Get(path="/students/{id}", tags={"students"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="path", name="id", example=1, description="Student ID"),
  *     @OA\Response(response="200", description="Fetch individual student")
  * )
  */
 Flight::route("GET /students/@id", function($id){
     $user = Flight::get('user');
     if($user['is_admin']){
         Flight::json(Flight::student_service()->get_by_id($id));
     } else {
         Flight::json(Flight::student_service()->get_by_id_and_user($user, $id));
     }
 });

 /**
 * @OA\Delete(
 *     path="/students/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Delete student",
 *     tags={"students"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Student ID"),
 *     @OA\Response(
 *         response=200,
 *         description="Note deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
 Flight::route("DELETE /students/@id", function($id){
    $user = Flight::get('user');
    if($user['is_admin']){
        Flight::student_service()->delete($id);
    } else {
        Flight::student_service()->delete_student($user, $id);
    }
    Flight::json(['message' => "Student deleted successfully"]);
 });

 /**
* @OA\Post(
*     path="/student", security={{"ApiKeyAuth": {}}},
*     description="Add student",
*     tags={"students"},
*     @OA\RequestBody(description="Add new student", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="first_name", type="string", example="Demo",	description="Student first name"),
*    				@OA\Property(property="last_name", type="string", example="Student",	description="Student last name" ),
*                   @OA\Property(property="email", type="string", example="demo@gmail.com",	description="Student email" ),
*                   @OA\Property(property="password", type="string", example="12345",	description="Password" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Student has been added"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
 Flight::route("POST /student", function(){
    $user = Flight::get('user');
    $request = Flight::request()->data->getData();
    Flight::json(['message' => "Student added successfully",
                  'data' => Flight::student_service()->add($request, $user)
                 ]);
 });


 /**
 * @OA\Put(
 *     path="/student/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Edit student",
 *     tags={"students"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Student ID"),
 *     @OA\RequestBody(description="Student info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="first_name", type="string", example="Demo",	description="Student first name"),
 *    				@OA\Property(property="last_name", type="string", example="Student",	description="Student last name" ),
 *                  @OA\Property(property="email", type="string", example="demo@gmail.com",	description="Student email" ),
 *                  @OA\Property(property="password", type="string", example="12345",	description="Password" ),
 *        )
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="Student has been edited"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
 Flight::route("PUT /student/@id", function($id){
    $user = Flight::get('user');
    $student = Flight::request()->data->getData();
    Flight::json(['message' => "Student edit successfully",
                  'data' => Flight::student_service()->update($student, $id, 'id', $user)
                 ]);
 });

 Flight::route("GET /students/@name", function($name){
    echo "Hello from /students route with name= ".$name;
 });

 Flight::route("GET /students/@name/@status", function($name, $status){
    echo "Hello from /students route with name = " . $name . " and status = " . $status;
 });

?>
