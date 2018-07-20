<?php 
require ('mailer.php');
require ('connection.php');

  	$Book_ID=$_POST["Book_ID"];
  	$Flight_ID=$_POST["Flight_ID"];
  	$Name=$_POST["Name"];
  	$Email=$_POST["Email"];
  	$Status=$_POST["Status"];
  	$SrcAirport=$_POST["SrcAirport"];
  	$DstAirport=$_POST["DstAirport"];
  	$Amount=$_POST["Amount"];
  	$Amount=$_POST["Payment_ID"];
  	

  	
  
  	$strings = "DELETE FROM BOOKING WHERE BOOKING_ID = '".$Book_ID."'";

	
 	//  $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
		// if (!$conn) {
		//   $e = oci_error();
		//   trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		// }
	

  	$conn = connect();
	    
		$stid = oci_parse($conn, $strings);
		if (!$stid) {
		    $e = oci_error($conn);
		      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

	    // Perform the logic of the query
	    $r = oci_execute($stid);
	    if (!$r) {
	      $e = oci_error($stid);
	      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }

	
$message_body = "<p><span style=\"color: #ff0000;\"><strong>Dear Mr Awsaf,
</strong></span></p>
<p>Your Booking has been cancelled <br />
<p>YOUR TOUR DETAILS<br />Flight ID : ".$Flight_ID."<br />Route: Dhaka to Dubai</p>";

 

$message_subject = "Greetings From BuetAirlines";

$EMAIL_ID = "awsafalam@gmail.com";

	    $message_title = "BUET Airlines";

$mailSender = new MailSender($EMAIL_ID, $message_subject, $message_title, $message_body);

$mailSender->requestMailSend();













 ?>