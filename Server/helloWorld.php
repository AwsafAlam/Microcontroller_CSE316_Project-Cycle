<?php 

echo "#unlock";

$connect = mysqli_connect('onlinesohopathi.com','root','aquarium201','Cycle');


if(!$connect){

   die("Connection error:   ".mysqli_connect_error());
}
else{
	echo "\nConnected\n";
$result = mysql_query("SHOW DATABASES");        
while ($row = mysql_fetch_array($result)) {        
    echo $row[0]."<br>";        
}
}


if(isset($_GET['Lat']) && isset($_GET['Lng']) && isset($_GET['bk'])){
    $lat = $_GET['Lat'];
    $long = $_GET['Lng'];
    $bike_no = $_GET['bk'];

    $myfile = fopen("testfile.txt", "w") 



    echo $query =  "UPDATE `Bicycle` SET latitude={$lat}, longitude={$long} WHERE bicycle_id  = {$bike_no};";
    mysqli_query($connect, $query);


}

?> 
