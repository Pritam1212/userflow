<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "registered_users";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if($conn->connect_error){
        die("Could not connect to the database!".$conn->connect_error);
    }
    $mongo;
    try{
        $mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    } catch (MongoDBDriverExceptionException $e) {
        echo 'Failed to connect to MongoDB';
        echo $e->getMessage();
        exit();
    }

    try {
        
    $redis = new Redis(); 
    $redis->connect('127.0.0.1', 6379); 

    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

?>