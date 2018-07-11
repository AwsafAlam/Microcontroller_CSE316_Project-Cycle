<?php

require_once 'include/DbHandler.php';
require_once 'include/PassHash.php';
require '/libs/Slim/Slim.php';
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




$app->get('/updateloc', function() use ($app)  {

  echo "string";
  $Latitude = $_GET["Lat"];

  $conn = new mysqli("localhost", "root", "aquarium201", "Cycle");
  echo "Worked\n";

  // $strings="SELECT  *FROM answers where question_id=123 order by answer_id";
  // $result = $conn->prepare($strings);
  //
  //
  // $result->execute();
  // $result->bind_result($answer_id,$question_id,$userid,$username,$image,$string,$upvote,$downvote,$anonymous,$isright,$imglin);
  // $posts = array();
  //
  // while($result->fetch()) {
  //
  //          $tmp = array();
  //
  //     $tmp["answer_id"] = $answer_id;
  //     $tmp["question_id"] = $question_id;
  //     $tmp["userid"] = $userid;
  //     $tmp["username"] = $username;
  //     $tmp["string"] = $string;
	//     $tmp["anonymous"] = $anonymous;
  //
  //          array_push($posts, $tmp);
  // }
  // $result->close();
  //
  //
  // echoRespnse(201,$posts);
  //

});




function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}


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
