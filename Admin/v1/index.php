<<<<<<< HEAD
<?php

include  'FlightSearch.php';

  $source=$_GET["source"];
  $destination=$_GET["destination"];
  $Departure=$_GET["Departure"];
  // $Arrival=$_GET["Arrival"];


if ($destination != null && $Departure == null  && $source !=null) {

    // Both Source and destination
    $query = "SELECT R.ROUTE_ID , S.CITY \"Source\", S.AIRPORT_CODE \"SourceCode\", D.CITY \"Destination\", D.AIRPORT_CODE \"DestinationCode\", F.ARRIVAL_DATE_TIME, R.DURATION,F.DEPARTURE_DATE_TIME, F.FLIGHT_ID, S.NAME \"SRC_NAM\",D.NAME \"DST_NAM\" 
        FROM FLIGHT F JOIN ROUTE R
        ON F.ROUTE_ID = R.ROUTE_ID
        JOIN AIRPORT S
        ON (S.AIRPORT_ID = R.SOURCE AND (S.NAME = ". "'".$source. "'"." OR 
        S.CITY =". "'".$source. "'"." OR S.COUNTRY =". "'".$source. "'"."))
        JOIN AIRPORT D
        ON (D.AIRPORT_ID = R.DESTINATION AND (D.NAME = ". "'".$destination. "'"." OR 
        D.CITY =". "'".$destination. "'"." OR D.COUNTRY =". "'".$destination. "'"."))
        WHERE TO_DATE(F.DEPARTURE_DATE_TIME , 'YYYY-MM-DD HH24:MI:SS') > SYSDATE
        ORDER BY F.DEPARTURE_DATE_TIME ASC
        ";

    // $query = "SELECT R.ROUTE_ID , S.CITY \"Source\", S.AIRPORT_CODE \"SourceCode\",
    //     D.CITY \"Destination\", D.AIRPORT_CODE \"DestinationCode\", F.ARRIVAL_DATE_TIME,
    //     R.DUR, F.DEPARTURE_DATE_TIME, F.FLIGHT_ID 
    //     FROM (SELECT R1.ROUTE_ID,R1.SOURCE \"SRC\",R2.DESTINATION \"DEST\",
    //     R1.DURATION \"DUR\"
    //     FROM ROUTE R1 JOIN ROUTE R2
    //     ON R1.ROUTE_ID=R2.ROUTE_ID
    //     WHERE R1.SOURCE=(SELECT AIRPORT_ID FROM AIRPORT S1 WHERE (S1.NAME = "."'".$source. 
    //     "'"." )) 
    //     AND R1.DESTINATION=(SELECT SOURCE FROM ROUTE WHERE DESTINATION=(SELECT AIRPORT_ID FROM AIRPORT D1 WHERE (D1.NAME = ". "'".$destination. "'"." ))) 
    //     OR  R2.DESTINATION=(SELECT AIRPORT_ID FROM AIRPORT D2 WHERE (D2.NAME = ". "'".$destination. "'"." ))) R JOIN FLIGHT F
    //     ON F.ROUTE_ID = R.ROUTE_ID
    //     JOIN AIRPORT S
    //     ON (S.AIRPORT_ID = R.SRC )
    //     JOIN AIRPORT D
    //     ON (D.AIRPORT_ID = R.DEST)
    //     WHERE TO_DATE(F.DEPARTURE_DATE_TIME , 'YYYY-MM-DD HH24:MI:SS') > SYSDATE
    //     ORDER BY F.DEPARTURE_DATE_TIME ASC";

    // ShowTable($query);
    // JSONsendFLight($query);
        JSONsendFLight($query);

}
 else if ($destination != null && $Departure == null && $source == null) 
{
    // Only Destination
    $query = "SELECT R.ROUTE_ID , S.CITY \"Source\", S.AIRPORT_CODE \"SourceCode\", D.CITY \"Destination\", D.AIRPORT_CODE \"DestinationCode\", F.ARRIVAL_DATE_TIME, R.DURATION, F.DEPARTURE_DATE_TIME , F.FLIGHT_ID
        FROM FLIGHT F JOIN ROUTE R
        ON F.ROUTE_ID = R.ROUTE_ID
        JOIN AIRPORT S
        ON (S.AIRPORT_ID = R.SOURCE)
        JOIN AIRPORT D
        ON (D.AIRPORT_ID = R.DESTINATION AND (D.NAME = ". "'".$destination. "'"." OR 
        D.CITY =". "'".$destination. "'"." OR D.COUNTRY =". "'".$destination. "'"."))
        WHERE TO_DATE(F.DEPARTURE_DATE_TIME , 'YYYY-MM-DD HH24:MI:SS') > SYSDATE
        ORDER BY F.DEPARTURE_DATE_TIME ASC
        ";

    // ShowTable($query);
    // JSONsendFLight($query);
    JSONsendFLight($query);



}
else if ($destination == null && $Departure == null  && $source != null) 
{
    // Only Source
    $query = "SELECT R.ROUTE_ID , S.CITY \"Source\", S.AIRPORT_CODE \"SourceCode\", D.CITY \"Destination\", D.AIRPORT_CODE \"DestinationCode\", F.ARRIVAL_DATE_TIME, R.DURATION, F.DEPARTURE_DATE_TIME , F.FLIGHT_ID
        FROM FLIGHT F JOIN ROUTE R
        ON F.ROUTE_ID = R.ROUTE_ID
        JOIN AIRPORT S
        ON (S.AIRPORT_ID = R.SOURCE AND (S.NAME = ". "'".$source. "'"." OR 
        S.CITY =". "'".$source. "'"." OR S.COUNTRY =". "'".$source. "'"."))
        JOIN AIRPORT D
        ON (D.AIRPORT_ID = R.DESTINATION )
        WHERE TO_DATE(F.DEPARTURE_DATE_TIME , 'YYYY-MM-DD HH24:MI:SS') > SYSDATE
        ORDER BY F.DEPARTURE_DATE_TIME ASC
        ";

        JSONsendFLight($query);

}
else if ($destination != null && $Departure != null  && $source != null) 
{
    // SOURCE DESTINATION DEPARTURE ALL GIVEN
    $query = "SELECT R.ROUTE_ID , S.CITY \"Source\", S.AIRPORT_CODE \"SourceCode\", D.CITY \"Destination\", D.AIRPORT_CODE \"DestinationCode\", F.ARRIVAL_DATE_TIME, R.DURATION, F.DEPARTURE_DATE_TIME , F.FLIGHT_ID
        FROM FLIGHT F JOIN ROUTE R
        ON F.ROUTE_ID = R.ROUTE_ID
        JOIN AIRPORT S
        ON (S.AIRPORT_ID = R.SOURCE AND (S.NAME = ". "'".$source. "'"." OR 
        S.CITY =". "'".$source. "'"." OR S.COUNTRY =". "'".$source. "'"."))
        JOIN AIRPORT D
        ON (D.AIRPORT_ID = R.DESTINATION AND (D.NAME = ". "'".$destination. "'"." OR 
        D.CITY =". "'".$destination. "'"." OR D.COUNTRY =". "'".$destination. "'"."))
        WHERE   TO_DATE(F.DEPARTURE_DATE_TIME , 'YYYY-MM-DD HH24:MI:SS') > 
                TO_DATE("."'".$Departure." 00:00:00' , 'YYYY-MM-DD HH24:MI:SS')
        ORDER BY F.DEPARTURE_DATE_TIME ASC
        ";

    // $query = "SELECT R.ROUTE_ID , S.CITY \"Source\", S.AIRPORT_CODE \"SourceCode\",
    //     D.CITY \"Destination\", D.AIRPORT_CODE \"DestinationCode\", F.ARRIVAL_DATE_TIME,
    //     R.DUR, F.DEPARTURE_DATE_TIME, F.FLIGHT_ID 
    //     FROM (SELECT R1.ROUTE_ID,R1.SOURCE \"SRC\",R2.DESTINATION \"DEST\",
    //     R1.DURATION \"DUR\"
    //     FROM ROUTE R1 JOIN ROUTE R2
    //     ON R1.ROUTE_ID=R2.ROUTE_ID
    //     WHERE R1.SOURCE=(SELECT AIRPORT_ID FROM AIRPORT S1 WHERE (S1.NAME = "."'".$source. 
    //     "'"." OR S1.CITY =". "'".$source. "'".")) 
    //     AND R1.DESTINATION=(SELECT SOURCE FROM ROUTE WHERE DESTINATION=(SELECT AIRPORT_ID FROM AIRPORT D1 WHERE (D1.NAME = ". "'".$destination. "'"." OR 
    //     D1.CITY =". "'".$destination. "'"." ))) 
    //     OR  R2.DESTINATION=(SELECT AIRPORT_ID FROM AIRPORT D2 WHERE (D2.NAME = ". "'".$destination. "'"." OR 
    //     D2.CITY =". "'".$destination. "'"." OR D2.COUNTRY =". "'".$destination. "'"."))) R JOIN FLIGHT F
    //     ON F.ROUTE_ID = R.ROUTE_ID
    //     JOIN AIRPORT S
    //     ON (S.AIRPORT_ID = R.SRC )
    //     JOIN AIRPORT D
    //     ON (D.AIRPORT_ID = R.DEST)
    //     WHERE   TO_DATE(F.DEPARTURE_DATE_TIME , 'YYYY-MM-DD HH24:MI:SS') > 
    //             TO_DATE("."'".$Departure." 00:00:00' , 'YYYY-MM-DD HH24:MI:SS')
    //     ORDER BY F.DEPARTURE_DATE_TIME ASC";


    JSONsendFLight($query);
  
}
else if($destination == null && $source == null && $Departure != null){
   
    $query = "SELECT B.BOOKING_ID \"ID\", B.BOOKING_DATE_TIME \"BOOK_DATE\",
            F.ARRIVAL_DATE_TIME \"ARRIVAL\", F.DEPARTURE_DATE_TIME \"DEPARTURE\",
            P.PASSENGER_ID , P.FIRST_NAME ||' '||P.LAST_NAME \"FULLNAME\",P.EMAIL_ID,
            B.PAYMENT_STATUS, S.AIRPORT_CODE \"SRC_CODE\", S.NAME \"SRC_NAME\", 
            S.LATITUDE \"SRCLAT\", S.LONGITUDE \"SRCLON\",
            D.AIRPORT_CODE \"DST_CODE\", D.NAME \"DNAME\", 
            D.LATITUDE \"DLAT\", D.LONGITUDE \"DLNG\", F.FLIGHT_ID \"FLIGHT\" ,
            B.PRICE_CATEGORY_ID, P.PASSPORT_NUMBER \"PASSPORT\", K.TOTAL_PAYABLE ,
            K.PAYMENT_ID FROM BOOKING B JOIN 
            FLIGHT F ON F.FLIGHT_ID = B.FLIGHT_ID
            JOIN ROUTE R ON F.ROUTE_ID = R.ROUTE_ID
            JOIN PASSENGER P ON B.PASSENGER_ID = P.PASSENGER_ID
            JOIN AIRPORT S ON S.AIRPORT_ID = R.SOURCE
            JOIN AIRPORT D ON D.AIRPORT_ID = R.DESTINATION
            JOIN PAYMENT K ON B.PAYMENT_ID = K.PAYMENT_ID
            WHERE BOOKING_ID ='".$Departure."'";


    fetchJSON($query);

}
  



  
=======
<?php

include  'TableSearch.php';

  $table = $_GET["table"];
  

if ($table == "Employee") {
    $query = "SELECT * FROM EMPLOYEE ";

    // ShowTable($query);
    JSONsendFLight($query);
}
else if ($table == "Validate") {
    $query = "SELECT * FROM ADMIN ";

    // ShowTable($query);
    EmployeeValidate($query);
}


  
>>>>>>> 992f8121048f4ac04de3f93b95cb0bdc07641fac
?>