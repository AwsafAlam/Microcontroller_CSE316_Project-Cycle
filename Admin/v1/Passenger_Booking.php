<?php 
require ('mailer.php');

  $FirstName=$_POST["FirstName"];
  $LastName=$_POST["LastName"];
  $PassportNumber=$_POST["PassportNumber"];
  $Telephone=$_POST["Telephone"];
  $Date_of_Birth=$_POST["Date_of_Birth"];
  $Email=$_POST["Email"];
  $Gender=$_POST["Gender"];
  $Address=$_POST["Address"];
  $Nationality=$_POST["Nationality"];
  $Flight_ID = $_POST["FLIGHT_ID"];
  $flight = intval($Flight_ID);
  $Lead_Passport = $_POST["Lead_Pass"];
  $Total = $_POST["Total"];
  $Price = $_POST["Price"];
  $Cata = $_POST["Category"];
  $BOOK_ID = "153";

  
  	// $strings = "DECLARE
			// 	BEGIN
			// 		INSERT_BOOKING("."'".$FirstName ."','".$LastName."','".$Telephone."','".$Date_of_Birth."','".$Gender."','".$PassportNumber."','".$Email."','".$Address."','".$Nationality."',".$flight.",'".$Price."','ECONOMY_CLASS','"
			// 			.$Lead_Passport."','".$Total."');
			// 	END;
			// 	";

	$strings = "DECLARE
				BEGIN
					INSERT_BOOKING(:bind1,:bind2,:bind3,:bind4,:bind5,:bind6,:bind7,:bind8,
						:bind9,:bind10,:bind11,:bind12,:bind13,:bind14,:bind15);
				END;";


 	 $conn=oci_connect("BUETAIRLINES" , "113114","localhost/xe");
		if (!$conn) {
		  $e = oci_error();
		  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
	
	// $s = oci_parse($conn, "begin proc1(:bind1, :bind2); end;");
	   $stid = oci_parse($conn, $strings);
		if (!$stid) {
		    $e = oci_error($conn);
		      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
		// $Cata = "ECONOMY_CLASS";
	   oci_bind_by_name($stid, ":bind1", $FirstName);
	   oci_bind_by_name($stid, ":bind2", $LastName);
	   oci_bind_by_name($stid, ":bind3", $Telephone);
	   oci_bind_by_name($stid, ":bind4", $Date_of_Birth);
	   oci_bind_by_name($stid, ":bind5", $Gender);
	   oci_bind_by_name($stid, ":bind6", $PassportNumber);
	   oci_bind_by_name($stid, ":bind7", $Email);
	   oci_bind_by_name($stid, ":bind8", $Address);
	   oci_bind_by_name($stid, ":bind9", $Nationality);
	   oci_bind_by_name($stid, ":bind10", $flight);
	   oci_bind_by_name($stid, ":bind11", $Price);
	   oci_bind_by_name($stid, ":bind12", $Cata);
	   oci_bind_by_name($stid, ":bind13", $Lead_Passport);
	   oci_bind_by_name($stid, ":bind14", $Total);


	   oci_bind_by_name($stid, ":bind15", $BOOK_ID, 7); // 32 is the return length
	   // oci_execute($s, OCI_DEFAULT);
	   // echo "Procedure returned value: " . $out_var;

	    
		
	    // Perform the logic of the query
	    $r = oci_execute($stid , OCI_DEFAULT);
	    if (!$r) {
	      $e = oci_error($stid);
	      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }

	   //  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	   //     	foreach ($row as $item) {
				// $BOOK_ID = $item;	       	
	   //     	}
	   //  }

	    $strings = "SELECT S.AIRPORT_CODE \"SRCCCODE\" , D.AIRPORT_CODE \"DSTCode\", 
	    	S.CITY \"SRCCity\", S.COUNTRY \"SrcCOun\", D.CITY \"DstCity\", 
	    	D.COUNTRY \"DstCountry\" FROM FLIGHT F 
			JOIN ROUTE R ON R.ROUTE_ID = F.ROUTE_ID
			JOIN AIRPORT S ON R.SOURCE = S.AIRPORT_ID
			JOIN AIRPORT D ON R.DESTINATION = D.AIRPORT_ID
			WHERE FLIGHT_ID = '".$Flight_ID."'";

		$stid = oci_parse($conn, $strings);
		if (!$stid) {
		    $e = oci_error($conn);
		      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

		$r = oci_execute($stid , OCI_DEFAULT);
	    if (!$r) {
	      $e = oci_error($stid);
	      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }

	    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    	$i =0;
	       	foreach ($row as $item) {

	       		if ($i==0) {
	    		$SrcCode = $item;

		        } else if($i==1) {
		    		$dstCode = $item;
		        }else if($i == 2){
			     	$SrcCity = $item;
			    
			    } else if($i==3) {
		    		$srcCountry = $item;
		        
		        } else if($i==4) {
		    		$DstCity = $item;
		        } else if($i==5) {
		    		$DstCountry = $item;
		        }
		    	$i++;
	       	}
	    }
	  
	    $DateToday = date("l")." ".date("mmmm-d-Y")." at ".date("h:i:sa");
	    

// $message_body = "Dear Mr. Awsaf\\nYour flight has been unfortunately delayed, due to severe weather conditions.\\n We are currently doing everything in our power to resume the flight as fast as possible.\\nRegards,\\nBUETAirlines.com";

// $message_body = "<p><span style=\"color: #ff0000;\"><strong>Dear ".$FirstName.",
// </strong></span></p>
// <p>Thank you for choosing to book with BUET Airlines.<br />I am pleased to confirm receipt of your booking as follows:</p>
// <p>YOUR BOOKING DETAILS<br />Booking Reference Number: ".$BOOK_ID."</p>
// <p>Booking Status: NOT PAID</p>
// <p>YOUR TOUR DETAILS<br />Flight ID : ".$Flight_ID."<br />Route: Dhaka to Dubai</p>
// <p>YOUR DETAILS<br />Name: ".$FirstName." ".$LastName."<br />Address:<br />".$Address."<br />Email: ".$Email."<br />Telephone Number: ".$Telephone."</p>
// <p>Amount Payable: $".$Price."</p>";

$message_body = "<head>
<title>BUET Airlines</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

</head>

<body bgcolor=\"#ebeff0\">
<table align=\"center\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#ebeff0\">
  <tbody><tr>
    <td align=\"center\"><table align=\"center\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
        <tbody><tr>
          <td align=\"center\">
          <table align=\"center\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ebeff0\">
<tbody><tr>
<td class=\"mobpadnav\" style=\"padding: 20px 30px 20px 30px;\" bgcolor=\"#ebeff0\">


<table class=\"emailphoneresize\" width=\"446\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"left\" bgcolor=\"#ebeff0\">
<tbody><tr>
<td class=\"padleft10\" bgcolor=\"#ebeff0\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#374959;\"><a href=\"#\" style=\"color:#374959; text-decoration:none;\" target=\"_blank\">".$DateToday."</a></td>
</tr>
</tbody></table>
  
<table class=\"nomob\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"left\" bgcolor=\"#ebeff0\">
<tbody><tr>
<td class=\"padleft10\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#374959;\">
<a href=\"#\" style=\"color:#374959; text-decoration:none;\" target=\"_blank\">View on the web</a></td>
</tr>
</tbody></table>
 


</td>

</tr>
</tbody></table>
          <table class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
                    <tbody><tr>
                      <td align=\"left\" style=\"padding-left:10px\" class=\"AAlogoPad\"><h2 border=\"0\" style=\"color: rgba(105 , 30  , 55,0.9); font-weight: 22px;\" width=\"255\" height=\"52\" align=\"left\" class=\"resizeimageto200\">BUET Airlines</h2></td>
                      <td align=\"right\" style=\"padding-right:30px;\" class=\"oneWorldPad\"><a href=\"https://www.aa.com/i18n/travel-info/partner-airlines/oneworld-airline-partners.jsp\" target=\"_blank\"><img style=\"display:block;\" title=\"oneworld\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/oneworld_logo.png\" border=\"0\" alt=\"oneworld\" width=\"30\" height=\"30\" align=\"right\"></a></td>
                    </tr>
            </tbody></table>
            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#bfbfbf\">
              <tbody><tr>
                <td height=\"1\" style=\"padding:0px; background-color:#bfbfbf; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            <table align=\"center\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
              <tbody><tr>
                <td class=\"paddingLR20px\" style=\"padding:20px 30px 24px 30px;\" bgcolor=\"#ffffff\" align=\"left\"><table class=\"stack\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"left\" bgcolor=\"#ffffff\">
                          <tbody><tr align=\"left\">
                            <td bgcolor=\"#ffffff\"><table class=\"resize140px\" width=\"325\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"left\" bgcolor=\"#ffffff\">
                                <tbody><tr>
                                  <td class=\"Resizefontto13\" bgcolor=\"#ffffff\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#36495A;\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">Hello ".$FirstName." ".$LastName.",</span></td>
                                </tr>
                              </tbody></table>
                               
                              <!--[if gte mso 9]>
        				</td>
        				<td valign=\"top\">
        				<![endif]-->
                             
                              <table class=\"resize140px\" width=\"215\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"left\" bgcolor=\"#ffffff\">
                                <tbody><tr>
                                  <td class=\"Resizefontto13\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#36495A;text-align:right;\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">  <a href=\"https://www.aa.com/loyalty/profile/summary\" style=\"color:#6699ff; text-decoration:none; font-size:14px;\" class=\"Resizefontto13\" target=\"_blank\"></a></span></td>
                                </tr>
                              </tbody></table>
                              
</td>
                          </tr>
                        </tbody></table></td>
              </tr>
            </tbody></table>
            <table align=\"center\" class=\"nomob\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
              <tbody><tr>
                <td class=\"resizeimageto320\" align=\"center\" width=\"600\"><a href=\"#\" target=\"_blank\"><img style=\"display:block;\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/check_in_banner_600_desktop.png\" border=\"0\" alt=\"It's time to check in\" title=\"It's time to check in\" class=\"nomob\" width=\"600\" height=\"166\"></a></td>
              </tr>
            </tbody></table>
            
            <!--[if !mso]><!-->
            
            <div align=\"center\" style=\"display:none; width:0px; max-height:0px; overflow:hidden;\" class=\"showmobile320\">
              <table align=\"center\" class=\"showmobile320\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"320\" bgcolor=\"#ffffff\">
                <tbody><tr>
                  <td align=\"center\" width=\"320\"><a href=\"#\" target=\"_blank\"><img style=\"display:block;\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/check_in_banner_320_mobile.png\" border=\"0\" alt=\"It's time to check in\" title=\"Your Booking Comfirmed\" width=\"320\" height=\"135\"></a></td>
                </tr>
              </tbody></table>
            </div>
            
            <!--<![endif]--> 
            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
              <tbody><tr>
                <td height=\"30\" style=\"padding:0px; background-color:#ffffff; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"30\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            
            
            <table class=\"emailphoneresize\" align=\"center\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tbody><tr>
              <td style=\"padding: 0 112px 0 113px;\" class=\"mobpad0\">
            <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"375\" bgcolor=\"#ffffff\" class=\"nomob\">
              <tbody><tr>
                <td width=\"375\" height=\"86\" align=\"center\" bgcolor=\"#ffffff\" style=\"padding:0 0 36px 0;\" class=\"paddingB30px\">
                
                </td>
              </tr>
            </tbody></table>
            
            <!--[if !mso]><!-->
<div style=\"display:none; width:0px; max-height:0px; overflow:hidden;\" class=\"showmobile280\">
            <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"280\" bgcolor=\"#ffffff\" class=\"showmobile280\">
              <tbody><tr>
                <td width=\"280\" height=\"65\" align=\"center\" bgcolor=\"#ffffff\" style=\"padding:0 20px 30px 20px;\">
                 <a href=\"#\" class=\"\" target=\"_blank\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/mobileCTA.png\" border=\"0\" style=\"display:block;\" alt=\"Check In Now\" title=\"Check In Now\" width=\"280\" height=\"35\" class=\"showmobile280\"></a>

                </td>
              </tr>
            </tbody></table>
            </div>
<!--<![endif]-->

            </td>
            </tr>
            </tbody></table>
            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#bfbfbf\">
              <tbody><tr>
                <td height=\"1\" style=\"padding:0px; background-color:#bfbfbf; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            <table class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" align=\"center\">
  <tbody><tr>
    <td class=\"paddingB30pxLR20px\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:18px; line-height:18px; color:#36495A; font-weight:bold;padding:30px 30px 34px 30px;\" align=\"left\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\"><!--Begin SPOTLIGHT HEADING-->Your Booking ID:  ".$BOOK_ID."</span></td>
  </tr>
  <tr>
    <td class=\"paddingLR20px\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:30px; line-height:30px; color:#0061AB; padding:0 30px 3px 30px;\" align=\"left\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">".$SrcCode." <span style=\"font-size:18px;\">to</span> ".$dstCode."</span></td>
  </tr>
  <tr>
    <td class=\"paddingLR20px\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:16px; color:#0061AB; padding:0 30px 36px 30px;\" align=\"left\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color: #0061AB !important; text-decoration: none;\" class=\"appleLinksBlue\">Flight ".$Flight_ID."</span></td>
  </tr>
  <tr>
    <td style=\"padding: 0 30px 15px 30px;\" align=\"left\" class=\"paddingLR20px\">
    
    
    <table class=\"email280resize\" cellspacing=\"0\" cellpadding=\"0\" width=\"306\" style=\"border-collapse:collapse;\">
        <tbody><tr>
          <td class=\"resize140px\" width=\"166\" align=\"left\" valign=\"top\">
          <table class=\"resize140px\" cellspacing=\"0\" cellpadding=\"0\" width=\"156\" style=\"border-collapse:collapse;\">
        <tbody><tr>
          <td class=\"resize114px\" width=\"130\" align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:27px; color:#36495A; text-align:left; text-decoration: none; line-height:27px; padding: 0 10px 7px 0; text-transform:uppercase;\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color: #36495A !important; text-decoration: none;\" class=\"appleLinksGrey\">".$srcCountry."</span></td>
          
          <td width=\"26\" align=\"left\" style=\"padding: 0 0 7px 0;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/grey_arrow.png\" border=\"0\" alt=\"\" title=\"\" width=\"26\" height=\"20\"></td>
        </tr>
      </tbody></table>
      <table class=\"resize140px\" cellspacing=\"0\" cellpadding=\"0\" width=\"166\" style=\"border-collapse:collapse;\">
        <tbody><tr>
          <td class=\"resize140px\" width=\"166\" align=\"left\" style=\"font-family: Arial, Helvetica, sans-serif; font-size:14px; line-height:14px; color:#36495A; text-align:left; text-decoration: none; padding: 0 0 0 0; border-collapse:collapse;\"><span class=\"Resizefontto12\" style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">".$SrcCity."</span></td>
          
          
        </tr>
      </tbody></table>
          
          </td>
          
          <td class=\"resize140px\" width=\"140\" align=\"left\" valign=\"top\">
          <table class=\"resize140px\" cellspacing=\"0\" cellpadding=\"0\" width=\"166\" style=\"border-collapse:collapse;\">
        <tbody><tr>
          <td class=\"resize140pxPadL10px\" width=\"140\" align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:27px; color:#36495A;text-align:left; text-decoration: none; line-height:27px; padding: 0 0 7px 20px; text-transform:uppercase;\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color: #36495A !important; text-decoration: none;\" class=\"appleLinksGrey\">".$DstCountry."</span></td>
          
          
        </tr>
                <tr>
          <td class=\"resize140pxPadL10px\" width=\"140\" align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:14px; color:#36495A; text-align:left; text-decoration: none; padding: 0 0 0 20px;\"><span class=\"Resizefontto12\" style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">".$DstCity."</span></td>
          
          
        </tr>
      </tbody></table>
          </td>
        </tr>
      </tbody></table>
    
    
    
      </td>
  </tr>
  <tr>
    <td class=\"paddingLR20px\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:14px; color:#36495A; padding:0 30px 0 30px;\" align=\"left\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\" class=\"appleLinksGrey\"></span></td>
  </tr>

    



    
  <tr>
  <td>
  <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"1\" bgcolor=\"#ffffff\">
              <tbody><tr>
                <td height=\"36\" style=\"padding:0px; background-color:#ffffff; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"36\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            </td>
            </tr>

</tbody></table>

            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#bfbfbf\">
              <tbody><tr>
                <td height=\"1\" style=\"padding:0px; background-color:#bfbfbf; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            <table align=\"center\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
              <tbody><tr>
                <td class=\"paddingLR20px\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:21px; line-height:21px; color:#0061AB; padding:30px 30px 15px 30px;\" align=\"left\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">Important Information</span></td>
              </tr>
            </tbody></table>
            <table class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" align=\"center\">
              <tbody><tr>
                <td style=\"padding: 0 0 36px 0;\" align=\"center\" valign=\"top\" class=\"paddingB30px\"><table class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" align=\"center\">
                    
                    <tbody><tr>
                      <td class=\"paddingL20pxFont14px\" style=\"font-family:Arial, Helvetica, sans-serif; padding: 0 0 0 30px; color:#9DA6AB; font-size:14px; line-height:24px;\" width=\"40\" align=\"center\" valign=\"top\">■</td>
                      <td style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:24px; color:#36495A; padding:0 30px 0 5px;\" width=\"100%\" align=\"left\" valign=\"top\" class=\"paddingR20px\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">We've introduced new boarding group names.                         <a href=\"https://www.aa.com/i18n/travel-info/boarding-process.jsp\" style=\"color:#0078D2; text-decoration:none;\" target=\"_blank\">View our boarding process »</a></span></td>
                    </tr>
 
                  </tbody></table></td>
              </tr>
            </tbody></table>
            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#bfbfbf\">
              <tbody><tr>
                <td height=\"1\" style=\"padding:0px; background-color:#bfbfbf; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            
            <table align=\"center\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
              <tbody><tr>
                <td class=\"mobpad0\" bgcolor=\"#ffffff\"><table class=\"email300resize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#ffffff\">
                    <tbody><tr>
                      <td style=\"padding: 36px 0 36px 0;\" class=\"paddingT30pxB0px\"><table class=\"stack\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#ffffff\">
                          <tbody><tr>
                            <td bgcolor=\"#ffffff\" valign=\"top\"><table class=\"email300resize\" width=\"292\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody><tr>
                                  <td class=\"mobpadimage\" width=\"292\" align=\"left\" style=\"padding: 0 0 20px 30px;\"><a href=\"https://www.aa.com/i18n/customer-service/support/freddie-awards.jsp?c=EML%7C%7C20170215%7CADV%7CMKT%7CTRANS%7C%7CLPM_freddie_awards_PDP\" target=\"_blank\"><img style=\"display:block;\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/262x80_freddies.jpg\" border=\"0\" width=\"262\" height=\"80\"></a></td>
                                </tr>
                              </tbody></table>
                              
                              <!--[if gte mso 9]>
        				</td>
        				<td valign=\"top\">
        				<![endif]-->
                              
                              <table class=\"email300resize\" width=\"292\" align=\"right\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody><tr>
                                  <td class=\"mobpadimage\" width=\"292\" style=\"padding: 0 30px 20px 0;\" align=\"left\"><a href=\"https://www.aa.com/i18n/travel-info/clubs/admirals-club.jsp?c=EML||20170228|ADC|MKT|TRANS||LPM_AcAcqPDP\" target=\"_blank\"><img style=\"display:block;\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/262x80_admirals-club-female.jpg\" border=\"0\" width=\"262\" height=\"80\" align=\"left\"></a></td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                        </tbody></table>
                        <table class=\"stack\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"#ffffff\">
                          <tbody><tr>
                            <td bgcolor=\"#ffffff\" valign=\"top\"><table class=\"email300resize\" width=\"292\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody><tr>
                                  <td class=\"mobpadimage\" width=\"292\" align=\"left\" style=\"padding: 0 0 20px 30px;\"><a href=\"http://www.aa.com/car?src=AAHP1C&amp;cint=EML||20170101|ANC|MKT|TRANS||LPM_Car_Planner_PDP\" target=\"_blank\"><img style=\"display:block;\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/262x80_ancillary-car.jpg\" border=\"0\" width=\"262\" height=\"80\"></a></td>
                                </tr>
                              </tbody></table>
                              
                              <!--[if gte mso 9]>
        				</td>
        				<td valign=\"top\">
        				<![endif]-->
                              
                              <table class=\"email300resize\" width=\"292\" align=\"right\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tbody><tr>
                                  <td class=\"mobpadimage\" width=\"292\" style=\"padding: 0 30px 20px 0;\" align=\"left\"><a href=\"http://www.booking.com/\" target=\"_blank\"><img style=\"display:block;\" src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/262x80_hotel-booking-com.jpg\" border=\"0\" width=\"262\" height=\"80\" align=\"left\"></a></td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                        </tbody></table></td>
                    </tr>
                  </tbody></table></td>
              </tr>
            </tbody></table>
            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#bfbfbf\">
              <tbody><tr>
                <td height=\"1\" style=\"padding:0px; background-color:#bfbfbf; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            
            
            <table align=\"center\" style=\"font-size:1px; line-height:1px; border-collapse:collapse;\" class=\"emailphoneresize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" bgcolor=\"#bfbfbf\">
              <tbody><tr>
                <td height=\"1\" style=\"padding:0px; background-color:#bfbfbf; font-size:0px; line-height:0px; border-collapse:collapse;\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/spacer50.gif\" border=\"0\" alt=\"\" width=\"1\" height=\"1\" style=\"display:block;\"></td>
              </tr>
            </tbody></table>
            
            
            <table class=\"emailphoneresize\" align=\"center\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tbody><tr>
                <td style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#0078D2; padding:36px 0 36px 0;\" align=\"center\" bgcolor=\"#ffffff\"><a href=\"https://www.aa.com/i18n/customer-service/contact-american/american-customer-service.jsp\" style=\"color:#137acf; text-decoration:underline;\" target=\"_blank\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">Contact us</span></a> &nbsp;&nbsp;<span style=\"color:#36495A; text-decoration:none;\">|</span>&nbsp;&nbsp; <a href=\"https://www.aa.com/i18n/customer-service/support/privacy-policy.jsp\" style=\"color:#0078D2; text-decoration:underline;\" target=\"_blank\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">Privacy&nbsp;policy</span></a></td>
              </tr>
            </tbody></table>
            <table class=\"emailphoneresize\" align=\"center\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tbody><tr>
              <td style=\"padding:0 150px 0 150px;\" class=\"mobpad0\">
            
            <table class=\"email280resize\" align=\"center\" width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ebeff0\" style=\"border-top:0px solid #ebeff0;border-top-left-radius:3px;border-top-right-radius:3px;\">
              <tbody><tr>
                <td style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:14px; color:#0078D2; text-decoration:none; padding:8px 0 0 0;\" align=\"center\"><a href=\"https://www.aa.com/i18n/travel-info/travel-tools/mobile-and-app.jsp\" style=\"color:#137acf; text-decoration:none;\" target=\"_blank\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">Get the BUET Airlines app</span></a></td>
              </tr>
            </tbody></table>
            </td>
            </tr>
            </tbody></table>
            
            <table class=\"appResize\" align=\"center\" width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ebeff0\">
              <tbody><tr>
                <td style=\"padding:10px 0 10px 0;\" align=\"center\"><table class=\"email280resize\" align=\"center\" width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ebeff0\">
                    <tbody><tr>
                      <td width=\"150\" style=\"padding:0 11px 0 29px;\" class=\"paddingAppIcon\"><a href=\"https://itunes.apple.com/us/app/american-airlines/id382698565?mt=8\" target=\"_blank\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/appstore.png\" border=\"0\" alt=\"\" title=\"\" style=\"display:block;\" width=\"110\" height=\"34\"></a></td>
                      <td width=\"150\" style=\"padding:0 29px 0 11px;\" class=\"paddingGoogleIcon\"><a href=\"https://play.google.com/store/apps/details?id=com.aa.android\" target=\"_blank\"><img src=\"http://www.aa.com/content/images/email/marketingOneOff/PDP/googleplay.png\" border=\"0\" alt=\"\" title=\"\" style=\"display:block;\" width=\"110\" height=\"34\"></a></td>
                    </tr>
                  </tbody></table></td>
              </tr>
            </tbody></table>
          </td>
        </tr>
        <tr>
          <td align=\"center\" style=\"background-color:#ebeff0; padding-bottom:10px;\">
          <table align=\"center\" class=\"footerResize\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" style=\"background-color:#ebeff0;\">
              <tbody><tr>
                <td class=\"paddingLR20px\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#999999; padding:20px 30px 40px 30px;\" align=\"left\"><span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\">Please do not reply to this email address as it is not monitored. This email as sent to <a href=\"#\" style=\"color:#0078D2; text-decoration:none;\" target=\"_blank\">buetairlines@gmail.com </a></span><br>
                  <br>
                  <span style=\"font-family:'Helvetica Neue', Helvetica, Arial, sans-serif !important;mso-line-height-rule:exactly;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;\"><br>
                  © BUET Airlines, Inc. All Rights Reserved.</span></td>
              </tr>
            </tbody></table>
          </td>
          </tr>
      </tbody></table></td>
  </tr>
</tbody></table>



</body>";

$message_subject = "Greetings From BuetAirlines";

$EMAIL_ID = $Email;

	    $message_title = "BUET Airlines";

$mailSender = new MailSender($EMAIL_ID, $message_subject, $message_title, $message_body);

$mailSender->requestMailSend();




?>