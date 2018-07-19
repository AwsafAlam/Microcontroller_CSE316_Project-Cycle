<?php 

include  'FlightSearch.php';

  $table=$_GET["table"];
  $Passport=$_GET["Passport"];
  $Flight = $_GET["Flight"];


    $query = "SELECT NAME,CITY,COUNTRY  FROM AIRPORT";





    fetchJSON($query); 




 ?>