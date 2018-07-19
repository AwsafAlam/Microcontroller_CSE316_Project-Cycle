<?php 

function connect()
{
	# code...
	$conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
	if (!$conn) {
	  $e = oci_error();
	  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	return $conn;
}

 ?>