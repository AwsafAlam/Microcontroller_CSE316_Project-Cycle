<?php 

require_once '/include/DbHandler.php';
require_once '/include/PassHash.php';
require '/libs/Slim/Slim.php';
// require_once __DIR__.'/src/Facebook/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();



$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");	

 $strings ="INSERT INTO Bicycle (bicycle_id, phone_number, imei, ride_count) VALUES (NULL, '0198324839', 'kkkkbfs', '0');";
      
       $result = $conn->prepare($strings);
    $result->execute();
       
       $result->close();


// $connect = mysqli_connect("198.211.96.87", "root", "aquarium201", "Cycle");


// if (mysqli_connect_errno())
//   {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   }

// echo $string = "INSERT INTO Bicycle (bicycle_id, phone_number, imei, ride_count) VALUES (NULL, '0198324839', 'kkkkbfs', '0');";

// $rslt = mysqli_query($connect, $query);
//             if (!$rslt) {
//                 echo "Failure on inserting data";
//             }



 ?>