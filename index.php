<?php

require "vendor/autoload.php";

Flight::route("/", function(){
   echo "Hello from / route";
});

Flight::route("GET /test", function(){
    echo "Hello from test route";
 });

 Flight::route("GET /new", function(){
     echo "Hello from new route";
  });

Flight::start();
?>
