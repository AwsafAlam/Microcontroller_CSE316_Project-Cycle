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

$app->post('/answerUpVotefaz', function() use ($app)  {

 $ansid = $app->request->post('ansid');
  $upvote_uid = $app->request->post('upvote_uid');
     $flag = $app->request->post('flag');
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
    $strings="11";
        if($flag==1){
            $strings ="CALL UPVOTE_TRACK("."'".$ansid."','".$upvote_uid."')";
        }
        else{
            $strings ="CALL ANS_VOTE_TRACE("."'".$ansid."','".$upvote_uid."')";
        }
    //  $strings = "UPDATE answers SET upvote=upvote+1 WHERE answer_id =". "'".$ansid."'";
      $result = $conn->query($strings);
      //$result->close();
 echoRespnse(201,$strings);

});


$app->post('/checkexistencefaz', function() use ($app)  {

 $ansid = $app->request->post('ansid');
  $upvote_uid = $app->request->post('upvote_uid');
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
 $strings ="SELECT * FROM answer_vote where answer_id=". "'".$ansid."'". "AND fbuserid="."'".$upvote_uid."'". "order by voteid desc";

     $result = $conn->prepare($strings);
  $result->execute();
  $result->bind_result($voteid,$answer_id,$fbuserid,$upvote,$downvote);
  $qanda=array();
  $posts = array();
  while($result->fetch()) {
      $tmp = array();
          $tmp["voteid"] = $voteid;
          $tmp["answer_id"] = $answer_id;
          $tmp["fbuserid"] = $fbuserid;
          $tmp["upvote"] = $upvote;
          $tmp["downvote"] = $downvote;


          array_push($posts, $tmp);

       }


     $result->close();
        echoRespnse(201,$posts);
});




$app->post('/answerDownVotefaz', function() use ($app)  {

     $ansid = $app->request->post('ansid');
  $upvote_uid = $app->request->post('upvote_uid');
     $flag = $app->request->post('flag');
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
    $strings="11";
        if($flag==1){
            $strings ="CALL DOWNVOTE_TRACK("."'".$ansid."','".$upvote_uid."')";
        }
        else{
            $strings ="CALL ANS_DOWNVOTE_TRACE("."'".$ansid."','".$upvote_uid."')";
        }
    //  $strings = "UPDATE answers SET upvote=upvote+1 WHERE answer_id =". "'".$ansid."'";
      $result = $conn->query($strings);
      //$result->close();
 echoRespnse(201,$strings);




});




$app->post('/viewanswerscount', function() use ($app)  {

     $meid = $app->request->post('meid');
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");

$strings="SELECT count(*) from answers where userid=". "'".$meid."'";
      $result = $conn->prepare($strings);
  $result->execute();
  $result->bind_result($count);
  $posts = array();
  while($result->fetch()) {
      $tmp = array();
          $tmp["count"] = $count;

          array_push($posts, $tmp);

       }


     $result->close();
        echoRespnse(201,$posts);

});



$app->post('/uploadquestion', function() use ($app)  {

	$title=$app->request->post('title');
	$userid=$app->request->post('userid');
	$username=$app->request->post('username');
	$question=$app->request->post('question');
	$category=$app->request->post('category');
	$anonymous=$app->request->post('anonymous');
	$imagecount=$app->request->post('imagecount');
	$tags=$app->request->post('tag');
	$fbpic=$app->request->post('fbpics');
	$imagenames="";
	if($userid=="157927098325740" || $userid=="110785063091217" || $userid=="108053220034996")//Block Sakhawat or Pria Jahan
	{

	}

	else
	{

	$image=$userid;
	for($i=1;$i<=$imagecount;$i++)
	{
	  $image=$userid.$i;
	  $imgmap= $app->request->post($image);
	  $path=$image.".png";

		while(file_exists($path))
           {
              $image=$image."1";
              $path=$image.".png";

           }

		   $imagenames=$imagenames.$path;
		   $imagenames=$imagenames.",";


    file_put_contents($path,base64_decode($imgmap));

	}




  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $title=mysqli_real_escape_string($conn,$title);
	$question=mysqli_real_escape_string($conn,$question);
  $strings="INSERT INTO questions(title,userid,username,question,category,anonymous,notification,image,tags,userpic) VALUES (" . "'". $title . "'". "," . "'". $userid . "'". "," . "'". $username . "'". "," . "'". $question . "'". "," . "'". $category. "'" ."," ."'" . $anonymous. "'" . "," . "'". $imagecount. "'" . "," . "'". $imagenames. "'" . ",". "'". $tags . "'". "," . "'". $fbpic . "'".  ")";
  $str= "INSERT INTO questions(username,question,category,notification,image) VALUES ( ";


  $result = $conn->query($strings);

  uploadnotifications($userid,"question");
  echoRespnse(201,$strings);


	}


});

function uploadnotifications($userid,$type)
{
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");

    if($type=="question")
  {
	  $str="SELECT id from questions where userid=".$userid." order by id desc limit 1";

	  $result = $conn->prepare($str);
      $result->execute();
      $result->bind_result($ids);

      while($result->fetch()) {


		   $myid=$ids;

       }
       $result->close();
	   //echoRespnse(201,$myid);

	   $newstr="q".$userid.".";


	   $str="INSERT into notificationstates(ques_id,userids) VALUES ( "."'". $myid . "'". "," . "'". $newstr . "'". ")";
       $result = $conn->prepare($str);
       $result->execute();

	   $result->close();
	   //echoRespnse(201,$str);


  }
  else
  {
    $str="SELECT userid from questions where id=".$type." order by id desc limit 1";

	  $result = $conn->prepare($str);
      $result->execute();
      $result->bind_result($ids);
      $newstr="";
      while($result->fetch()) {


		   $myid=$ids;

       }
       $result->close();
	   //echoRespnse(201,$myid);
	   if($userid!=$myid)
	   $newstr="q".$myid.".";




	$str="SELECT userid from answers where question_id="."'".$type. "'"." order by answer_id desc";


	$result = $conn->prepare($str);
	$result->execute();
    $result->bind_result($newids);

      while($result->fetch()) {


		   $thisstr="a".$newids.".";
		   if (stripos($newstr, $thisstr) != true ){
		     if($userid!=$newids)
			  $newstr=$newstr.$thisstr;
			 else
				$newstr=$newstr.".a.";

		   }

       }
       $result->close();

	   $str="UPDATE notificationstates SET userids= "."'". $newstr . "'". " where ques_id=" . "'". $type . "'"." order by id desc limit 1";

	   $result = $conn->prepare($str);
       $result->execute();

	   $result->close();

  }
}

$app->post('/checknotifs',function() use ($app)  {

$userid=$app->request->post('userid');
$ansid="a".$userid.".";
$quesid="q".$userid.".";
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
$str= "SELECT ques_id,userids from notificationstates where userids LIKE " ."'%".$ansid."%' OR userids LIKE '%". $quesid."%' ";
$result = $conn->prepare($str);
$result->execute();
$result->bind_result($newids,$users);
//echoRespnse(201,$str);
$posts = array();

  while($result->fetch()) {

           $tmp = array();
		   if(stripos($users,"a")!=false)
		   {
		   $tmp["id"]=$newids;
		   array_push($posts, $tmp);
		   }

	};
	$result->close();
        echoRespnse(201,$posts);
});

$app->post('/modifynotifs',function() use ($app)  {

$userid=$app->request->post('userid');
$quesid=$app->request->post('quesid');
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");


	  $str="SELECT userids from notificationstates where ques_id=".$quesid." order by id desc limit 1";

	  $result = $conn->prepare($str);
      $result->execute();
      $result->bind_result($ids);
	  $newstr="";

      while($result->fetch()) {


		   $myid=$ids;

       }
       $result->close();
	   $valu="q".$userid.".";
	   $valuans="a".$userid.".";
	   //echoRespnse(201,$myid);

	      $newstr=str_replace($valu,"",$myid);
		  $newstr=str_replace($valuans,"",$newstr);


	   $str="UPDATE notificationstates SET userids= "."'". $newstr . "'". " where ques_id=" . "'". $quesid . "'"." order by id desc limit 1";

	   $result = $conn->prepare($str);
       $result->execute();

	   $result->close();
	   echoRespnse(201,$str);


	   });

$app->post('/viewallquestions', function() use ($app)  {

	//$filter=$_GET["filter"];
  $filter = $app->request->post('filter');
  $quesids= $app->request->post('lastq');
  //echoRespnse(201,$filter);

$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
    if($filter=="0")
        $strings="SELECT * FROM questions order by id desc limit 50";
	else if($filter=="1")
        $strings="SELECT * FROM questions where id<". "'".$quesids."'".  " order by id desc limit 50";

	else if($filter=="hsc" || $filter=="ssc")
        $strings="SELECT * FROM questions where tags=". "'".$filter."'".  " order by id desc limit 50";
	else if($filter=="hscs")
        $strings="SELECT * FROM questions where id<". "'".$quesids."'".  "and tags='hsc' order by id desc limit 50";
	else if($filter=="sscs")
        $strings="SELECT * FROM questions where id<". "'".$quesids."'".  "and tags='ssc' order by id desc limit 50";


	else{
         $strings="SELECT * FROM questions where userid=". "'".$filter."'". "order by id desc limit 50";
    }


  $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($id,$title,$userid,$username,$question,$category,$anonymous,$notification,$image,$tags,$upvote,$downvote,$fbpic);
  $qanda=array();
  $posts = array();

  while($result->fetch()) {

           $tmp = array();



           $tmp["id"] = $id;
		   $tmp["title"] = $title;
		   $tmp["userid"]=$userid;
           $tmp["username"] = $username;
           $tmp["question"] = nl2br($question);
           $tmp["category"] = $category;
		   $tmp["anonymous"] = $anonymous;
		   $tmp["image"] = $image;
		   $tmp["upvote"] = $upvote;
		   $tmp["downvote"] = $downvote;
		   $tmp["tags"]=$tags;
		   $tmp["fbpics"]=$fbpic;
		   $tmp["answers"]=viewtheanswers($id);


           array_push($posts, $tmp);
       }
	   //array_push($qanda,$posts);

	   $result->close();
        echoRespnse(201,$posts);





});

$app->post('/viewsearchanswer', function() use ($app)  {

 $search = $app->request->post('search');




$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");


   $strings="SELECT * FROM questions order by id desc";
  $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($id,$title,$userid,$username,$question,$category,$anonymous,$notification,$image,$tags,$upvote,$downvote,$userpic);
  $qanda=array();
  $posts = array();

  while($result->fetch()) {



           if (stripos($title, $search) !== false || stripos($question, $search) !== false) {

                $tmp = array();
                       $tmp["id"] = $id;
                       $tmp["title"] = $title;
					   $tmp["userid"]=$userid;
					   $tmp["fbpics"]=$userpic;
                       $tmp["username"] = $username;
                       $tmp["question"] = $question;
                       $tmp["category"] = $category;
                       $tmp["anonymous"] = $anonymous;
                       $tmp["image"] = $image;
                       $tmp["upvote"] = $upvote;
                       $tmp["downvote"] = $downvote;
                       $tmp["tags"]=$tags;
                       $tmp["answers"]=viewtheanswers($id);

               array_push($posts, $tmp);
           }



       }
	   //array_push($qanda,$posts);

	   $result->close();
        echoRespnse(201,$posts);





});


function viewtheanswers($titles)
{
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  //$tile=(string)$titles;
  //echoRespnse(201,$titles);
  $strings= "SELECT  *FROM answers where question_id= $titles order by answer_id";
  //$strings="SELECT  *FROM answers where question_id=". "'".$tile."'". "order by answer_id";

  $result = $conn->prepare($strings);



  $result->execute();

  $result->bind_result($answer_id,$question_id,$userid,$username,$image,$string,$upvote,$downvote,$anonymous,$isright,$imglin);
  $posta = array();


  while($result->fetch()) {

           $tmp = array();



           $tmp["answer_id"] = $answer_id;
      $tmp["question_id"] = $question_id;
	  $tmp["userid"]=$userid;
           $tmp["username"] = $username;
             $tmp["string"] = $string;
		   $tmp["anonymous"] = $anonymous;
		   $tmp["image"] = $image;
		   $tmp["upvote"] = $upvote;
		   $tmp["downvote"] = $downvote;
         $tmp["isright"] = $isright;
		 $tmp["fbimg"]=$imglin;

           array_push($posta, $tmp);
       }
	   $result->close();
	   //echoRespnse(201,$posta);

	   return $posta;

}

function viewthecomments($titles)
{
  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  //$tile=(string)$titles;
  //echoRespnse(201,$titles);
  $strings= "SELECT  *FROM blog_comment where blog_id= $titles order by blog_comment_id";
  //$strings="SELECT  *FROM answers where question_id=". "'".$tile."'". "order by answer_id";

  $result = $conn->prepare($strings);



  $result->execute();

  $result->bind_result($blog_comment_id,$username,$content,$image,$anonymous,$blog_id,$userid,$userpic);
  $posta = array();


  while($result->fetch()) {

           $tmp = array();



           $tmp["blog_comment_id"] = $blog_comment_id;
      $tmp["blog_id"] = $blog_id;
           $tmp["username"] = $username;
             $tmp["content"] = $content;
       $tmp["anonymous"] = $anonymous;
       $tmp["image"] = $image;
	   $tmp["fbpic"]=$userpic;



           array_push($posta, $tmp);
       }
     $result->close();
     //echoRespnse(201,$posta);

     return $posta;

}





$app->post('/uploadanswers', function() use ($app)  {



  $imagenames="";


    $username = $app->request->post('username');
	$userid=$app->request->post('userid');
    $string = $app->request->post('string');
    $upvote = $app->request->post('upvote');
    $downvote = $app->request->post('downvote');
    $anonymous = $app->request->post('anonymous');
    $isright = $app->request->post('isright');
    $fbpic=$app->request->post('fbpics');
    $question_id = $app->request->post('question_id');

    $imagecount=$app->request->post('imagecount');
	$imagenames="";
	$imgmap="JJ";

	$image=$userid;

  for($i=1;$i<=$imagecount;$i++)
	{
	  $image=$userid.$i;
	  $imgmap= $app->request->post($image);
	  echoRespnse(201,$image);

    $path=$image.".png";

		while(file_exists($path))
           {
              $image=$image."1";
              $path=$image.".png";

           }

		   $imagenames=$imagenames.$path;
		   $imagenames=$imagenames.",";


    file_put_contents($path,base64_decode($imgmap));

	}


  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $string=mysqli_real_escape_string($conn,$string);

  $strings="INSERT INTO answers(question_id, userid,username, image, string, upvote, downvote, anonymous, isright,proimg) VALUES (" . "'". $question_id . "'". "," . "'". $userid . "'". "," . "'". $username . "'". "," . "'". $imagenames. "'" ."," ."'" . $string . "'" . "," . "'". $upvote. "'" . "," . "'".$downvote. "'" . "," . "'". $imagecount. "'" . "," . "'". $isright . "'" . ",". "'" . $fbpic . "'" . ")";
  $str= "INSERT INTO answers(question_id,username,image, string, upvote, downvote, anonymous, isright) VALUES ( ";


  $result = $conn->query($strings);
  uploadnotifications($userid,$question_id);
  sendNotificationFb($userid,$question_id);

  echoRespnse(201,$strings);





});


$app->post('/uploadblog', function() use ($app)  {



  $imagenames="";

    $title=$app->request->post('title');
    $username = $app->request->post('username');
	$userid=$app->request->post('userid');
    $content = $app->request->post('content');
    $type = $app->request->post('type');





    $imagecount=$app->request->post('imagecount');
	$imagenames="";
	$imgmap="JJ";

	$image=$userid;

  for($i=1;$i<=$imagecount;$i++)
	{
	  $image=$userid.$i;
	  $imgmap= $app->request->post($image);
	  echoRespnse(201,$image);

    $path=$image.".png";

		while(file_exists($path))
           {
              $image=$image."1";
              $path=$image.".png";

           }

		   $imagenames=$imagenames.$path;
		   $imagenames=$imagenames.",";


    file_put_contents($path,base64_decode($imgmap));

	}


  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $title=mysqli_real_escape_string($conn,$title);
  $content=mysqli_real_escape_string($conn,$content);
  $type=mysqli_real_escape_string($conn,$type);

  $strings="INSERT INTO blog(title,userid,username,content,type,image) VALUES (" . "'". $title . "'". "," . "'". $userid . "'". "," . "'". $username . "'". "," . "'". $content. "'"  . "," . "'" . $type . "'" . "," . "'" . $imagenames . "'" . ")";
  $str= "INSERT INTO answers(title,username,userid,content,type,image) VALUES ( ";


  $result = $conn->query($strings);

  echoRespnse(201,$strings);





});


$app->post('/uploadblogcomment', function() use ($app)  {



  $imagenames="";

    $userpic=$app->request->post('userpic');
    $username = $app->request->post('username');
	$userid=$app->request->post('userid');
    $content = $app->request->post('content');
    $anonymous = $app->request->post('anonymous');
	$blogid = $app->request->post('blogid');





    $imagecount=$app->request->post('imagecount');
	$imagenames="";
	$imgmap="JJ";

	$image=$userid;

  for($i=1;$i<=$imagecount;$i++)
	{
	  $image=$userid.$i;
	  $imgmap= $app->request->post($image);
	  echoRespnse(201,$image);

    $path=$image.".png";

		while(file_exists($path))
           {
              $image=$image."1";
              $path=$image.".png";

           }

		   $imagenames=$imagenames.$path;
		   $imagenames=$imagenames.",";


    file_put_contents($path,base64_decode($imgmap));

	}


  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $content=mysqli_real_escape_string($conn,$content);
  $strings="INSERT INTO blog_comment(username,content,image,anonymous,blog_id,userid,userpic) VALUES (" . "'". $username. "'". "," . "'". $content . "'". "," . "'". $imagenames . "'". "," . "'". $anonymous. "'"  . "," . "'" . $blogid . "'" . "," . "'" . $userid . "'" . "," . "'" . $userpic . "'" . ")";
  $str= "INSERT INTO answers(title,username,userid,content,type,image) VALUES ( ";


  $result = $conn->query($strings);

  echoRespnse(201,$strings);





});



function sendNotificationFb($useridme, $qid){

  $fb = new Facebook\Facebook([
  'app_id' => '179014802653918',
  'app_secret' => '62b225675f7b88c21f8b4214f4ebdd65',
  'default_graph_version' => 'v2.11',
]);

  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $strings="SELECT userid FROM questions where id=". "'".$qid."'";

  $result = $conn->prepare($strings);
  $string="You have new responses. Please check. ";

  $result->execute();
  $result->bind_result($userid);
  //$posts = array();


  while($result->fetch()) {
      if($userid!=$useridme){
        try {
  // Returns a `FacebookFacebookResponse` object
  $response = $fb->post(
    '/'.$userid.'/notifications',
    array (
      'href' => '?true=43',
      'template' => $string
    ),
    '179014802653918|9l61E_wTOpOyI8ZcvIGQuPKiRe4'
  );
} catch(FacebookExceptionsFacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(FacebookExceptionsFacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode = $response->getGraphNode();
	  }
       }
	   $result->close();

$strings="SELECT userid FROM answers where question_id=". "'".$qid."'";


$result = $conn->prepare($strings);

$result->execute();
  $result->bind_result($userid);
  //$posts = array();


  while($result->fetch()) {
      if($userid!=$useridme){
        try {
  // Returns a `FacebookFacebookResponse` object
  $response = $fb->post(
    '/'.$userid.'/notifications',
    array (
      'href' => '?true=43',
      'template' => $string
    ),
    '179014802653918|9l61E_wTOpOyI8ZcvIGQuPKiRe4'
  );
} catch(FacebookExceptionsFacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(FacebookExceptionsFacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode = $response->getGraphNode();
	  }
       }
	   $result->close();






 }


$app->get('/viewallanswers', function() use ($app)  {

$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $strings="SELECT  *FROM answers where question_id=123 order by answer_id";
  $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($answer_id,$question_id,$userid,$username,$image,$string,$upvote,$downvote,$anonymous,$isright,$imglin);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();



           $tmp["answer_id"] = $answer_id;
           $tmp["question_id"] = $question_id;
	       $tmp["userid"] = $userid;
           $tmp["username"] = $username;
           $tmp["string"] = nl2br($string);
		   $tmp["anonymous"] = $anonymous;
		   $tmp["image"] = $image;
		   $tmp["upvote"] = $upvote;
		   $tmp["downvote"] = $downvote;
         $tmp["isright"] = $isright;
		 $tmp["fbimg"]=$imglin;


           array_push($posts, $tmp);
       }
	   $result->close();


  echoRespnse(201,$posts);


});


$app->post('/viewmyquestions', function() use ($app)  {

	//$filter=$_GET["filter"];
  $filter = $app->request->post('filter');
  //echoRespnse(201,$filter);
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
    if($filter!="0"){
         $strings="SELECT * FROM questions where category=". "'".$filter."'"."AND username='shadman'". "order by id desc limit 30";
    }

    else
        $strings="SELECT * FROM questions order by id desc limit 30";
  $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($id,$username,$question,$category,$anonymous,$notification,$image,$upvote,$downvote);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();



           $tmp["id"] = $id;
           $tmp["username"] = $username;
           $tmp["question"] = nl2br($question);
           $tmp["category"] = $category;
		   $tmp["anonymous"] = "0";
		   $tmp["image"] = $image;
		   $tmp["upvote"] = $upvote;
		   $tmp["downvote"] = $downvote;


           array_push($posts, $tmp);
       }
	   $result->close();



  echoRespnse(201,$posts);


});


$app->post('/uploadmyanswers', function() use ($app)  {


  // $username=$app->request->post('username');
  // $question=$app->request->post('question');
  // $category=$app->request->post('category');
  // $notifications=$app->request->post('notifications');
  // $imagecount=$app->request->post('imagecount');
  $imagenames="";


    $username = $app->request->post('username');
    $string = $app->request->post('string');
    $upvote = $app->request->post('upvote');
    $downvote = $app->request->post('downvote');
    $anonymous = $app->request->post('anonymous');
    $isright = $app->request->post('isright');

    $question_id = $app->request->post('question_id');

    $imagecount=$app->request->post('imagecount');
	$imagenames="";

	$image=$username;

  for($i=1;$i<=$imagecount;$i++)
	{
	  $image=$username.$i;
	  $imgmap= $app->request->post($image);

    $path=$image.".png";

		while(file_exists($path))
           {
              $image=$image."1";
              $path=$image.".png";

           }

		   $imagenames=$imagenames.$path;
		   $imagenames=$imagenames.",";


    file_put_contents($path,base64_decode($imgmap));

	}


  $conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $strings="INSERT INTO answers(question_id, username, image, string, upvote, downvote, anonymous, isright) VALUES (" . "'". $question_id . "'". "," . "'". $username . "'". "," . "'". $imagenames. "'" ."," ."'" . $string . "'" . "," . "'". $upvote. "'" . "," . "'".$downvote. "'" . "," . "'". $anonymous. "'" . "," . "'". $isright . "'" . ")";
  $str= "INSERT INTO answers(question_id,username,image, string, upvote, downvote, anonymous, isright) VALUES ( ";


  $result = $conn->query($strings);

  //echoRespnse(201,$strings);





});



$app->get('/viewmyanswers', function() use ($app)  {

$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");
  $strings="SELECT  *FROM answers where question_id=203 order by answer_id";
  $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($answer_id,$question_id,$username,$image,$string,$upvote,$downvote,$anonymous,$isright);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();



           $tmp["answer_id"] = $answer_id;
      $tmp["question_id"] = $question_id;
           $tmp["username"] = $username;
             $tmp["string"] = $string;
		   $tmp["anonymous"] = $anonymous;
		   $tmp["image"] = $image;
		   $tmp["upvote"] = $upvote;
		   $tmp["downvote"] = $downvote;
         $tmp["isright"] = $isright;


           array_push($posts, $tmp);
       }
	   $result->close();



  echoRespnse(201,$posts);


});




$app->post('/viewonequestion', function() use ($app)  {

	//$filter=$_GET["filter"];
  $onequestion = $_GET['question'];
  //echoRespnse(201,$filter);
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");

        $strings="SELECT * FROM questions where id=". "'".$onequestion."'"."";
      $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($id,$title,$userid,$username,$question,$category,$anonymous,$notification,$image,$tags,$upvote,$downvote,$imglin);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();
          $tmp["id"] = $id;
		   $tmp["title"] = $title;
		   $tmp["userid"] = $userid;
           $tmp["username"] = $username;
           $tmp["question"] = $question;
           $tmp["category"] = $category;
		   $tmp["anonymous"] = $anonymous;
		   $tmp["image"] = $image;
		   $tmp["upvote"] = $upvote;
		   $tmp["downvote"] = $downvote;
		   $tmp["tags"]=$tags;
		   $tmp["answers"]=viewtheanswers($id);
		   $tmp["fbpic"]=$imglin;


           array_push($posts, $tmp);
       }
	   $result->close();



  echoRespnse(201,$posts);


});

$app->post('/viewoneblog', function() use ($app)  {

  //$filter=$_GET["filter"];
  $oneblog = $app->request->post('oneblog');
  //echoRespnse(201,$filter);
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");

        $strings="SELECT * FROM blog where id=". "'".$oneblog."'"."";
      $result = $conn->prepare($strings);


  $result->execute();
  $result->bind_result($id,$title,$userid,$username,$content,$type,$image,$likes);
  $posts = array();

  while($result->fetch()) {

           $tmp = array();
          $tmp["id"] = $id;
       $tmp["title"] = $title;
	   $tmp["userid"]=$userid;
           $tmp["username"] = $username;
           $tmp["content"] = $content;
           $tmp["type"] = $type;
       //$tmp["anonymous"] = $anonymous;
       $tmp["image"] = $image;
       $tmp["likes"] = $likes;
       $tmp["comments"]=viewthecomments($id);


           array_push($posts, $tmp);
       }
     $result->close();



  echoRespnse(201,$posts);


});

$app->get('/viewallblogs', function() use ($app)  {

  $filter=$_GET["filter"];

  //echoRespnse(201,$filter);
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");

        $strings="SELECT * FROM blog order by id desc";
      $result = $conn->prepare($strings);
      $search=$filter;

  $result->execute();
  $result->bind_result($id,$title,$userid,$username,$content,$type,$image,$likes);
  $posts = array();
 if($filter=="0")
 {
  while($result->fetch()) {

           $tmp = array();
          $tmp["id"] = $id;
       $tmp["title"] = $title;
	   $tmp["userid"]=$userid;
           $tmp["username"] = $username;
           $tmp["content"] = nl2br($content);
           $tmp["type"] = $type;
       //$tmp["anonymous"] = $anonymous;
       $tmp["image"] = $image;
       $tmp["likes"] = $likes;



           array_push($posts, $tmp);
       }

     $result->close();

 }

else
{

  while($result->fetch()) {
        if (stripos($title, $search) !== false){
           $tmp = array();
          $tmp["id"] = $id;
	$tmp["title"] = $title;
	   $tmp["userid"]=$userid;
           $tmp["username"] = $username;
           $tmp["content"] = $content;
           $tmp["type"] = $type;
       //$tmp["anonymous"] = $anonymous;
       $tmp["image"] = $image;
       $tmp["likes"] = $likes;



           array_push($posts, $tmp);
		}
       }
      $result->close();

}

  echoRespnse(201,$posts);


});

$app->get('/viewallsuggestionblogs', function() use ($app)  {

  $filter=$_GET["filter"];

  //echoRespnse(201,$filter);
$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");

        $strings="SELECT * FROM blog where type='suggestion' order by id desc limit 17";
      $result = $conn->prepare($strings);
      $search=$filter;

  $result->execute();
  $result->bind_result($id,$title,$userid,$username,$content,$type,$image,$likes);
  $posts = array();
 if($filter=="0")
 {
  while($result->fetch()) {

           $tmp = array();
          $tmp["id"] = $id;
       $tmp["title"] = $title;
	   $tmp["userid"]=$userid;
           $tmp["username"] = $username;
           $tmp["content"] = nl2br($content);
           $tmp["type"] = $type;
       //$tmp["anonymous"] = $anonymous;
       $tmp["image"] = $image;
       $tmp["likes"] = $likes;



           array_push($posts, $tmp);
       }

     $result->close();

 }

else
{

  while($result->fetch()) {
        if (stripos($title, $search) !== false){
           $tmp = array();
          $tmp["id"] = $id;
	$tmp["title"] = $title;
	   $tmp["userid"]=$userid;
           $tmp["username"] = $username;
           $tmp["content"] = $content;
           $tmp["type"] = $type;
       //$tmp["anonymous"] = $anonymous;
       $tmp["image"] = $image;
       $tmp["likes"] = $likes;



           array_push($posts, $tmp);
		}
       }
      $result->close();

}

  echoRespnse(201,$posts);


});







$app->post('/deleteanswerfromdatabase', function() use ($app)  {

 $delanswer = $app->request->post('delanswer');




$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");


   $strings="DELETE FROM answers where answer_id=". "'".$delanswer."'".  "";

     $result = $conn->query($strings);

        echoRespnse(201,$strings);

});





$app->post('/delquestionfromdatabase', function() use ($app)  {

 $delquestion = $app->request->post('delquestion');




$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");


   $strings="CALL DELETE_QUESTION("."'".$delquestion."')";

     $result = $conn->query($strings);

        echoRespnse(201,$strings);

});

$app->post('/delquestionfromdatabase', function() use ($app)  {

 $delquestion = $app->request->post('delquestion');




$conn = new mysqli("localhost", "root", "aquarium201", "online_sohopathi");


   $strings="CALL DELETE_QUESTION("."'".$delquestion."')";

     $result = $conn->query($strings);

        echoRespnse(201,$strings);

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
