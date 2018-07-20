<?php 
require ('mailer.php');
	echo "string";
  	$Book_ID=$_POST["Book_ID"];
  	$Name=$_POST["Name"];
  	$Email=$_POST["Email"];
  	$Status=$_POST["Status"];
  	$Status=$_POST["Status"];
  	$SrcAirport=$_POST["SrcAirport"];
  	$DstAirport=$_POST["DstAirport"];
  	$Flight_ID=$_POST["Flight_ID"];
  	$Amount=$_POST["Amount"];
  	$Payment_ID=$_POST["Payment_ID"];
  	


  
  	$strings = "DELETE FROM BOOKING WHERE BOOKING_ID = '".$Book_ID."'";

	
 	 $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
		if (!$conn) {
		  $e = oci_error();
		  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
	

	    
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

	
	$message_body = "<p><span style=\"color: #ff0000;\"><strong>Dear ".$Name.",
	</strong></span></p>
	<p>Your Payent has been confirmed<br />I am pleased to confirm receipt of your booking as follows:</p>
	<p>Booking Status: ".$Status."</p>
	<p>YOUR TOUR DETAILS<br />Flight ID : ".$FLIGHT_ID."<br />Route: ".$SrcAirport." to ".$DstAirport."</p>";


$message_subject = "Greetings From BuetAirlines";

$EMAIL_ID = $Email;

	    $message_title = "BUET Airlines";

$mailSender = new MailSender($EMAIL_ID, $message_subject, $message_title, $message_body);

$mailSender->requestMailSend();





?>