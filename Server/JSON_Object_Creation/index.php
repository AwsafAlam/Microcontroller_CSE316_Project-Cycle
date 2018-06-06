<?php

 $main = array();
 $main["nearby"] = 1;
 
 $posts = array();
 

 for ($j = 0; $j <2 ; $j++) {
    $tmp = array();
    for ($i = 0; $i <= 6; $i++) {
        
        if ($i==0) {
	    $locationProperties = array();
	   $item = 46.74; 
	   array_push($locationProperties, $item);
	   array_push($locationProperties, $item);
	   array_push($tmp, $locationProperties);
    	    
        } else if($i==1) {
    		$tmp["occupied"] = 1;
        } else if($i==2){
		$item = "Overview of the bicycle";
		$tmp["overview"] = $item;
        } else if($i==3){
		$item = "06 July 2018";
                $tmp["release_date"] = $item;	
	} else if($i==4) {
    		$tmp["bike_id"] = 44;
        } else if($i==5) {
    		$tmp["rating"] = $item;
        }
    }
    
       array_push($posts, $tmp);
  
       }
   array_push($main, $posts);
  
  $main["totalResults"] = 2;
  $main["total_bikes"] = 20;

   

//   $main->close();
  echo json_encode($main);


?>
