<?php 

	
	function JSONsendFLight($strings)
	{
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

	  // Fetch the results of the query
	   $posts = array();
	  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    $tmp = array();
	    $i =0 ;   
	  	foreach ($row as $item) {
	        
	        if ($i==0) {
	    		$tmp["Employee_id"] = $item;
	    	
	        } else if($i==1) {
	    		$tmp["FirstName"] = $item;
	        } else if($i==2){
				$tmp["LastName"] = $item;
	        } else if($i==3){
	         $tmp["Gender"] = $item;	
		    } else if($i==4) {
	    		$tmp["PhoneNumber"] = $item;
	        } else if($i==5) {
	    		$tmp["Address"] = $item;
	        } else if($i==6) {
	    		$tmp["EmailID"] = $item;
	        }else if($i==7) {
	    		$tmp["HireDate"] = $item;
	        }else if($i==8) {
	    		$tmp["Nationality"] = $item;
	        }else if($i==9) {
	    		$tmp["Salary"] = $item;
	        }
		    else{
		     	$tmp["Designation"] = $item;
		    }
	    	$i++;
	    }
	     array_push($posts, $tmp);
	  
	  	}
	  
	     // $posts->close();

	  echo json_encode($posts);

	  
	  oci_free_statement($stid);

	  
	  oci_close($conn);
	}


	
	function ShowTable($strings)
	{
	
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

	function EmployeeValidate($strings)
	{

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

	  // Fetch the results of the query
	   $posts = array();
	  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    $tmp = array();
	    $i =0 ;   
	  	foreach ($row as $item) {
	        
	        if ($i==0) {
	    		$tmp["id"] = $item;
	    	
	        } else{
	    		$tmp["pass"] = $item;
	        }
	    	$i++;
	    }
	     array_push($posts, $tmp);
	  
	  	}
	  
	     // $posts->close();

	  echo json_encode($posts);

	  
	  oci_free_statement($stid);

	  
	  oci_close($conn);

	}
	

 ?>