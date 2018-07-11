<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';
require_once __DIR__.'/src/Facebook/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


$user_id = NULL;


function authenticate(\Slim\Route $route)
{
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();

        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $db->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}


$app->post('/updateloc', function() use ($app)  {

	$Latitude = $_GET['lat'];
  $Longitude = $_GET['lng'];
  $Bike_No = $_GET['bk'];


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

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



  echoRespnse(201,$posts);


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
