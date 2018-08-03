<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';
require_once __DIR__.'/src/Facebook/autoload.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/getBikeData', function() use ($app)  {

  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  $strings="SELECT * FROM bicycle";
  $result = $conn->prepare($strings);

  $result->execute();
  $result->bind_result($id,$phone,$ridecount,$lat,$lng,$state);
  $posts = array();

	$main = array();
	$main["nearby"] = 1;
	$posts = array();

  	while($result->fetch()) {
			if($state == "lock"){
					$tmp = array();
					for ($i = 0; $i <= 6; $i++) {
						if ($i==0) {
							$locationProperties = array();
							array_push($locationProperties, $lat);
							array_push($locationProperties, $lng);
							array_push($tmp, $locationProperties);

						} else if($i==1) {
							$tmp["occupied"] = 1;
						} else if($i==2){
							$tmp["overview"] = "overview";
						} else if($i==3){
							$item = "06 July 2018";
							$tmp["release_date"] = $item;
						} else if($i==4) {
							$tmp["bike_id"] = 44;
						} else if($i==5) {
							$tmp["rating"] = $item;
						}

					}
					array_push($posts, $tmp);

				}
	 		}
	   	$result->close();

     array_push($main, $posts);

     $main["totalResults"] = 2;
     $main["total_bikes"] = 20;

		echoRespnse(201,$main);

});

$app->get('/updateloc', function() use ($app)  {

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

     echo $state;

    //echoRespnse(201,$posts);

});

$app->post('/locstate', function() use ($app)  {

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
     echo $state;
    //echoRespnse(201,$posts);
});

$app->post('/gpsloc', function() use ($app)  {

  $Latitude = $_GET['lat'];
  $Longitude = $_GET['lng'];
  $Bike_No = $_GET['bk'];

  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  $strings="UPDATE bicycle SET latitude = "."'".$Latitude."'"." , longitude = "."'".$Longitude."'"." WHERE bicycle_id=". "'".$Bike_No."'"."";

  $result = $conn->prepare($strings);

  $result->execute();

	echo "unlock";
});

$app->get('/startRide', function() use ($app)  {

	//$Latitude = $_GET['lat'];
  //$Longitude = $_GET['lng'];
  $Bike_No = $_GET['id'];


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  $strings="UPDATE bicycle SET state = 'unlock' WHERE bicycle_id=". "'".$Bike_No."'"."";

  $result = $conn->prepare($strings);

  $result->execute();
  // $result->bind_result($id,$phone,$ridecount,$lat,$lng,$state);
  // $posts = array();
  //
  // while($result->fetch()) {
  //
  //          $tmp = array();
  //          $item = 20.8;
  //
  //         $tmp["id"] = $id;
  //         $tmp["phone"] = $phone;
  //         $tmp["$ridecount"] = $ridecount;
  //         $tmp["lat"] = $lat;
  //         $tmp["lng"] = $lng;
  //         $tmp["state"] = $state;
  //
  //
  //         array_push($posts, $tmp);
  //      }
	//    $result->close();


   $main = array();
   $main["nearby"] = 1;

   $posts = array();


   for ($j = 0; $j <2 ; $j++) {
      $tmp = array();
      for ($i = 0; $i <= 6; $i++) {

          if ($i==0) {
  	    $locationProperties = array();
  	   $item = 46.74;
  	   array_push($locationProperties, $item);
  	   array_push($locationProperties, $item);
  	   array_push($tmp, $locationProperties);

          } else if($i==1) {
      		$tmp["occupied"] = 1;
          } else if($i==2){
  		$item = "Overview of the bicycle";
  		$tmp["overview"] = $item;
          } else if($i==3){
  		$item = "06 July 2018";
                  $tmp["release_date"] = $item;
  	} else if($i==4) {
      		$tmp["bike_id"] = 44;
          } else if($i==5) {
      		$tmp["rating"] = $item;
          }
      }

         array_push($posts, $tmp);

         }
     array_push($main, $posts);

    $main["totalResults"] = 2;
    $main["total_bikes"] = 20;



  //   $main->close();
    // echo json_encode($main);


  echoRespnse(201,$main);


});

$app->get('/startRideTable', function() use ($app)  {


  $Bike_No = $_GET['id'];
  $Username = $_GET['user'];
  $pass = $_GET['pass'];

  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  $strings="UPDATE bicycle SET state = 'unlock' WHERE bicycle_id=". "'".$Bike_No."'"."";

  $result = $conn->prepare($strings);

  $result->execute();
  $result->close();

  $strings="SELECT * FROM user";

  $result = $conn->prepare($strings);

  $result->execute();

  $result->bind_result($id,$phone,$email,$name,$Password,$ridecount,$promo,$wallet);
  $posts = array();

  $main = array();
  $USER_ID ="";
  while($result->fetch()) {
      if($Username == $name && $pass == $Password){
       $tmp = array();
        $main["nearby"] = $id;

       $tmp["id"] = $id;
       $tmp["phone"] = $phone;
       $tmp["ridecount"] = $ridecount;
       $tmp["lat"] = $promo;
       $tmp["lng"] = $wallet;
       $tmp["state"] = $email;
       array_push($posts, $tmp);

      }
   }
    $result->close();
    // echoRespnse(201,$posts);


     $strings="INSERT INTO ride (bicycle_id, user_id) VALUES ('".$Bike_No."', '".$main["nearby"]."')";
     $result = $conn->prepare($strings);
     $result->execute();
     $result->close();

     $strings="SELECT * FROM ride";
     $result = $conn->prepare($strings);

     $result->execute();

     $result->bind_result($ride_id,$bike_id,$dstlat,$dstlng,$srclat,$srclng,$UserId);


     while($result->fetch()) {
         if($bike_id == $Bike_No && $UserId == $main["nearby"] && $srclat == NULL && $srclng == NULL && $dstlat == NULL && $dstlng == NULL){
           $tmp = array();
          $main["totalResults"] = $ride_id;

          $tmp["rideID"] = $ride_id;
          $tmp["bikeID"] = $bike_id;
          $tmp["dlat"] = $dstlat;
          $tmp["dlng"] = $dstlng;
          $tmp["UserID"] = $UserId;
          $tmp["slat"] = $srclat;
          array_push($posts, $tmp);

         }
      }
       $result->close();

       echoRespnse(201,$posts);


    $main["total_bikes"] = 20;



  //   $main->close();
    // echo json_encode($main);


 // echoRespnse(201,$main);


});

$app->get('/userInfo', function() use ($app)  {

  $Username = $_GET['user'];
  $pass = $_GET['pass'];


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  $strings="SELECT * FROM user";

  $result = $conn->prepare($strings);

  $result->execute();

$result->bind_result($id,$phone,$email,$name,$Password,$ridecount,$promo,$wallet);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();
           $item = 20.8;
          $tmp["id"] = $id;
          $tmp["phone"] = $phone;
          $tmp["ridecount"] = $ridecount;
          $tmp["lat"] = $promo;
          $tmp["lng"] = $wallet;
          $tmp["state"] = $email;


          array_push($posts, $tmp);
       }
    $result->close();
   //
   // $main = array();
   // $main["nearby"] = 1;
   //
   // $posts = array();
   //
   //
   // for ($j = 0; $j <2 ; $j++) {
   //    $tmp = array();
   //    for ($i = 0; $i <= 6; $i++) {
   //
   //        if ($i==0) {
  	//     $locationProperties = array();
  	//    $item = 46.74;
  	//    array_push($locationProperties, $item);
  	//    array_push($locationProperties, $item);
  	//    array_push($tmp, $locationProperties);
   //
   //        } else if($i==1) {
   //    		$tmp["occupied"] = 1;
   //        } else if($i==2){
  	// 	$item = "Overview of the bicycle";
  	// 	$tmp["overview"] = $item;
   //        } else if($i==3){
  	// 	$item = "06 July 2018";
   //                $tmp["release_date"] = $item;
  	// } else if($i==4) {
   //    		$tmp["bike_id"] = 44;
   //        } else if($i==5) {
   //    		$tmp["rating"] = $item;
   //        }
   //    }
   //
   //       array_push($posts, $tmp);
   //
   //       }
   //   array_push($main, $posts);
   //
   //  $main["totalResults"] = 2;
   //  $main["total_bikes"] = 20;
   //
   //  //$main->close();
    // echo json_encode($main);

  echoRespnse(201,$posts);


});


$app->get('/endRide', function() use ($app)  {

	//$Latitude = $_GET['lat'];
  //$Longitude = $_GET['lng'];
  $Bike_No = $_GET['id'];


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  $strings="UPDATE bicycle SET state = 'lock' WHERE bicycle_id=". "'".$Bike_No."'"."";

  $result = $conn->prepare($strings);

  $result->execute();


   $main = array();
   $main["nearby"] = 1;
   $posts = array();

   for ($j = 0; $j <2 ; $j++) {
      $tmp = array();
      for ($i = 0; $i <= 6; $i++) {

        if ($i==0) {
    	    $locationProperties = array();
    	    $item = 46.74;
      	   array_push($locationProperties, $item);
      	   array_push($locationProperties, $item);
      	   array_push($tmp, $locationProperties);
       } else if($i==1) {
      		$tmp["occupied"] = 1;

      } else if($i==2){
    		$item = "Overview of the bicycle";
    		$tmp["overview"] = $item;
      } else if($i==3){
  		  $item = "06 July 2018";
        $tmp["release_date"] = $item;
  	  } else if($i==4) {
      		$tmp["bike_id"] = 44;
      } else if($i==5) {
      		$tmp["rating"] = $item;
      }
    }

    array_push($posts, $tmp);

         }
     array_push($main, $posts);

    $main["totalResults"] = 2;
    $main["total_bikes"] = 20;

    //$main->close();
    // echo json_encode($main);

  echoRespnse(201,$main);


});

$app->get('/signUpUser', function() use ($app)  {

	$Username = $_GET['username'];
	$Password = $_GET['password'];
	$Email = $_GET['email'];
	$Phone = $_GET['phone'];
	$Address = $_GET['address'];
	$Promo = getToken(5);


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

	$strings="INSERT INTO user (phone, email, username, password, ridecount, default_promo, wallet)
	VALUES ('".$Phone."', '".$Email."', '".$Username."', '".$Password."', '0','".$Promo."', '0')";

  $result = $conn->prepare($strings);
  $result->execute();

	 $main = array();
   $main["nearby"] = 1;

   $posts = array();


   for ($j = 0; $j <2 ; $j++) {
      $tmp = array();
      for ($i = 0; $i <= 6; $i++) {

          if ($i==0) {
  	    $locationProperties = array();
  	   $item = 46.74;
  	   array_push($locationProperties, $item);
  	   array_push($locationProperties, $item);
  	   array_push($tmp, $locationProperties);

          } else if($i==1) {
      		$tmp["occupied"] = 1;
          } else if($i==2){
  		$tmp["overview"] = $Promo;
          } else if($i==3){
  		$item = "06 July 2018";
                  $tmp["release_date"] = $item;
  	} else if($i==4) {
      		$tmp["bike_id"] = 44;
          } else if($i==5) {
      		$tmp["rating"] = $item;
          }
      }

         array_push($posts, $tmp);

         }
     array_push($main, $posts);

    $main["totalResults"] = 2;
    $main["total_bikes"] = 20;

  	echoRespnse(201,$main);


});

$app->get('/bikeLocation', function() use ($app)  {

	$Latitude = $_GET['lat'];
	$Longitude = $_GET['lng'];
	$State = $_GET['state'];
	
	$Bike_No = $_GET['id'];
	

  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

	$strings="UPDATE bicycle SET latitude = "."'".$Latitude."'"." , longitude = "."'".$Longitude."'"." WHERE bicycle_id=". "'".$Bike_No."'"."";


  $result = $conn->prepare($strings);
  $result->execute();


   $main = array();
   $main["nearby"] = 1;

   $posts = array();


   for ($j = 0; $j <2 ; $j++) {
      $tmp = array();
      for ($i = 0; $i <= 6; $i++) {

          if ($i==0) {
  	    $locationProperties = array();
  	   $item = 46.74;
  	   array_push($locationProperties, $item);
  	   array_push($locationProperties, $item);
  	   array_push($tmp, $locationProperties);

          } else if($i==1) {
      		$tmp["occupied"] = 1;
          } else if($i==2){
  		$tmp["overview"] = "overview";
          } else if($i==3){
  		$item = "06 July 2018";
                  $tmp["release_date"] = $item;
  	} else if($i==4) {
      		$tmp["bike_id"] = 44;
          } else if($i==5) {
      		$tmp["rating"] = $item;
          }
      }

         array_push($posts, $tmp);

         }
     array_push($main, $posts);

    $main["totalResults"] = 2;
    $main["total_bikes"] = 20;

  	echoRespnse(201,$main);


});

$app->get('/admin', function() use ($app)  {

	//$Latitude = $_GET['lat'];
  //$Longitude = $_GET['lng'];
  $Bike_No = $_GET['table'];


  $conn = new mysqli("localhost", "root", "aquarium201", "cycle_demo");

  //$strings="UPDATE bicycle SET state = 'unlock' WHERE bicycle_id=". "'".$Bike_No."'"."";

  //$result = $conn->prepare($strings);

  //$result->execute();

   $main = array();
   $main["nearby"] = 1;

   $posts = array();


   for ($j = 0; $j <2 ; $j++) {
      $tmp = array();
      for ($i = 0; $i <= 6; $i++) {

          if ($i==0) {
  	    $locationProperties = array();
  	   $item = 46.74;
  	   array_push($locationProperties, $item);
  	   array_push($locationProperties, $item);
  	   array_push($tmp, $locationProperties);

          } else if($i==1) {
      		$tmp["occupied"] = 1;
          } else if($i==2){
  		$item = "Overview of the bicycle";
  		$tmp["overview"] = $item;
          } else if($i==3){
  		$item = "06 July 2018";
                  $tmp["release_date"] = $item;
  	} else if($i==4) {
      		$tmp["bike_id"] = 44;
          } else if($i==5) {
      		$tmp["rating"] = $item;

          }
      }

         array_push($posts, $tmp);

         }
     array_push($main, $posts);

    $main["totalResults"] = 2;
    $main["total_bikes"] = 20;



  //   $main->close();
    // echo json_encode($main);


  echoRespnse(201,$main);


});


function getToken($length){
	 $token = "";
	 $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	 $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	 $codeAlphabet.= "0123456789";
	 $max = strlen($codeAlphabet); // edited

	for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
	}

	return $token;
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
