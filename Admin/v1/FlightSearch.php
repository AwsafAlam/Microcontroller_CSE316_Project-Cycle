<?php 
require ('connection.php');

	
	function JSONsendFLight($strings)
	{
		// $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
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

	  // Fetch the results of the query
	   $posts = array();
	    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    $tmp = array();
	    $i = 0;
	       	foreach ($row as $item) {
	       		if($i == 0){
	   				array_push($tmp, getPrice($item));
	       		}
	       		
		        array_push($tmp, $item);

		        if ($i == 8) {
					array_push($tmp, getSeats($item));	       		
	       		}

		        $i++;
		    }
	     array_push($posts, $tmp);
	  
	  	}
	  
	  echo json_encode($posts);

	  
	  oci_free_statement($stid);

	  
	  oci_close($conn);

	}


	function getPrice($route_id){

		// $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
		//     if (!$conn) {
		//       $e = oci_error();
		//       trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		//   	}


  		$conn = connect();

		  	$strings = "SELECT R.ROUTE_ID , C.PRICE_CATEGORY_ID, I.PRICE
			FROM ROUTE R JOIN PRICE P
			ON R.ROUTE_ID = P.ROUTE_ID AND R.ROUTE_ID = ".$route_id."
			JOIN PRICE_ITEM I
			ON P.PRICE_ID = I.PRICE_ID
			JOIN PRICE_CATEGORY C
			ON C.PRICE_CATEGORY_ID = I.PRICE_CATEGORY_ID";
	    
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
	
	 $prices = array();
	  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    $tmp = array();
	    $i =0 ;   
	  	foreach ($row as $item) {
	          // echo "<th>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</th>\n";
	    	// $tmp["Flight"] = $item;
	    	if ($i==0) {
	    		$tmp["Route"] = $item;

	        } else if($i==1) {
	    		$tmp["Category_id"] = $item;
	        }else{
		     	$tmp["price"] = $item;
		    }
	    	$i++;
	    }
	     array_push($prices, $tmp);
	  
	  	}
	  
	 	return $prices;
	  
	  oci_free_statement($stid);

	  
	  oci_close($conn);
	}

	function getSeats($flight_id){

		$strings = "DECLARE
				BEGIN
					SEAT_NUMBER(:bind1,:bind2,:bind3,:bind4);
				END;";


 	//  	$conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
		// if (!$conn) {
		//   $e = oci_error();
		//   trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		// }
	
  		$conn = connect();

	// $s = oci_parse($conn, "begin proc1(:bind1, :bind2); end;");
	   $stid = oci_parse($conn, $strings);
		if (!$stid) {
		    $e = oci_error($conn);
		      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
		oci_bind_by_name($stid, ":bind1", $flight_id);
	   	oci_bind_by_name($stid, ":bind2", $Economy);
	   	oci_bind_by_name($stid, ":bind3", $Business);
	   	oci_bind_by_name($stid, ":bind4", $First);
	    
		
	    // Perform the logic of the query
	    $r = oci_execute($stid , OCI_DEFAULT);
	    if (!$r) {
	      $e = oci_error($stid);
	      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }

		
	 	$prices = array();
		array_push($prices, $Economy);
		array_push($prices, $Business);
		array_push($prices, $First);


	  // 	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	  //   // $tmp = array();
		 //    $i =0 ;   
		 //  	foreach ($row as $item) {
		 //    	if ($i==0) {
		 //    		$Economy = $item;
		 //    		array_push($prices, $Economy);
		 //        } else if($i==1) {
		 //    		$Business = $item;
		 //    		array_push($prices, $Business);
			//      }else{
			// 		$First = $item;
		 //    		array_push($prices, $First);
			//     }
		 //    	$i++;
		 //    }
	  //   }
	  
	 	// return $prices;
	  
	  oci_free_statement($stid);

	  
	  oci_close($conn);
	 	return $prices;

	}


	function ShowTable($strings)
	{
		// $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
	 //    if (!$conn) {
	 //      $e = oci_error();
	 //      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	 //  	}

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

	  	// Fetch the results of the query
		echo "<div class=\"row\">
	        <div class=\"col-lg-12\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                </div>
                <div class=\"panel-body\">
                    <table width=\"100%\" class=\"table table-striped highlight centered table-bordered table-hover\" id=\"dataTables-example\">
                        <thead>
                            <tr>
                              <th>Flight</th>
                              <th>Source</th>
                              <th>Destination</th>
                              <th>Arrival</th>
                              <th>Departure</th>
                            </tr>
                        </thead>
                        <tbody>\n";


     	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    	  echo "<tr>\n";
	      	foreach ($row as $item) {
	          echo "<th>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</th>\n";
	      }
	      	echo "</tr>\n";
  		}
	  		echo "</table>\n";

	  	oci_free_statement($stid);

		  oci_close($conn);
	}

	function fetchJSON($strings)
	{
		# code...
		// $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
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

	  // Fetch the results of the query
	   $posts = array();
	  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    $tmp = array();
	   	foreach ($row as $item) {
	        array_push($tmp, $item);
	    }
	     array_push($posts, $tmp);
	  
	  	}
	  
	  echo json_encode($posts);

	  
	  oci_free_statement($stid);

	  
	  oci_close($conn);
	}


	

 ?>