<?php 

  $FirstName=$_POST["FirstName"];
  $LastName=$_POST["LastName"];
  $PhoneNumber=$_POST["PhoneNumber"];
  $Address=$_POST["Address"];
  $EmailID=$_POST["EmailID"];
  $HireDate=$_POST["HireDate"];
  // $Gender=$_POST["Gender"];
  $Nationality=$_POST["Nationality"];
  $Designation=$_POST["Designation"];
  $Salary=$_POST["Salary"];

  

  // $strings = "INSERT INTO EMPLOYEE VALUES (SEQ_PASSENGER.NEXTVAL ,"."'".$FirstName ."','".$LastName."', 'Male','".$PhoneNumber."' ,'".$Address."','".$EmailID."','".$HireDate."','".$Nationality."','".$Salary."','".$Designation."' )" ;

   $strings = "INSERT INTO EMPLOYEE VALUES (1002 ,"."'".$FirstName."','".$LastName."', 'Male','".
   $PhoneNumber."' ,'".$Address."','".$EmailID."','".$HireDate."','".$HireDate."',".$Salary.",'".$Designation."' )" ;

  // $strings "INSERT into EMPLOYEE (EMPLOYEE_ID,  FIRST_NAME, LAST_NAME , GENDER, PHONE_NUMBER, ADDRESS, EMAIL_ID, HIRE_DATE, NATIONALITY, SALARY, DESIGNATION) VALUES (1001, 'Heindrick', 'Trencher', 'Male', '8369589823', '526 Laurel Crossing', 'htrencher0@alibaba.com', TO_DATE('18-Dec-2008','DD-MM-YYYY'), 'Netherlands', 30000, 'Human Resources Manager')";


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






?>