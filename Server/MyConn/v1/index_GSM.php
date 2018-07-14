<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';
require_once __DIR__.'/src/Facebook/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/updateloc', function() use ($app)  {

	$Latitude = $_GET['lat'];
  $Longitude = $_GET['lng'];
  $Bike_No = $_GET['bk'];


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  // Queries for update etc.
  // Send the state

      $strings="SELECT * FROM bicycle where bicycle_id=". "'".$Bike_No."'"."";;
      $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($id,$phone,$ridecount,$lat,$lng,$state);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();
           $item = 20.8;

          $tmp["id"] = $id;
          $tmp["phone"] = $phone;
          $tmp["$ridecount"] = $ridecount;
          $tmp["lat"] = $lat;
          $tmp["lng"] = $lng;
          $tmp["state"] = $state;


          array_push($posts, $tmp);
       }
	   $result->close();


echo $state;
  //echoRespnse(201,$posts);


});

function echoRespnse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
?>
