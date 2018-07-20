<?php

include  'FlightSearch.php';

  $table=$_GET["table"];
  $data = $_GET["data"];
  

if ($table ==  "Airport") {

    $query = "SELECT NAME,CITY,COUNTRY  FROM AIRPORT";

    fetchJSON($query); 

}
else if ($table ==  "Passengers") {

    // $query = "SELECT PASSENGER_ID , FIRST_NAME , LAST_NAME , PASSPORT_NUMBER,
    // 		 PHONE_NUMBER, DATE_OF_BIRTH , EMAIL_ID, ADDRESS , NATIONALITY, GENDER 
    //  		FROM PASSENGER";

    $query = "SELECT PASSENGER_ID , FIRST_NAME , LAST_NAME , PASSPORT_NUMBER,
              PHONE_NUMBER, DATE_OF_BIRTH , EMAIL_ID, ADDRESS , NATIONALITY, GENDER ,
              ( SELECT NAME FROM DISCOUNT_CATEGORY WHERE DISCOUNT_CATEGORY_ID= P.DISCOUNT_CATEGORY_ID) \"CAT_NAME\",
         (SELECT D1.RATE
         FROM DISCOUNT D JOIN DISCOUNT_ITEM D1
         ON D.DISCOUNT_ID=D1.DISCOUNT_ID
         WHERE D.ROUTE_ID='".$data."' AND D1.DISCOUNT_CATEGORY_ID=P.DISCOUNT_CATEGORY_ID              
         ) \"PASS_RATE\"
        FROM PASSENGER P";

    fetchJSON($query); 

}
elseif ($table == "DiscountsShow") {
	# code...
	$query = "SELECT * FROM DISCOUNT";
	fetchJSON($query);
}


  
?>