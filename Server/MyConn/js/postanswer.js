function loadallprofiless(quesid,valdivs,ids)
{
    var responsefromfbname,resy;
	var strl="/".concat(ids);
    
   FB.api(
  strl,
  'GET',
  {"fields":"id,name,picture"},
  function(response) {
     //response.name;
	 
      //var responsefromfbpic=response.picture.data.url;
      uploadanswers(quesid,valdivs,response);     
	 //alert(response.name);
      //resy=response;
	  //console.log(response.name);
      // Insert your code here
  }
);

}
function loadallprofilesme(quesid,ids)
{
    var responsefromfbname,resy;
	var strl="/".concat(ids);
    
   FB.api(
  strl,
  'GET',
  {"fields":"id,name,picture"},
  function(response) {
     //response.name;
	 
      //var responsefromfbpic=response.picture.data.url;
      uploadanswersme(quesid,response);     
	 //alert(response.name);
      //resy=response;
	  //console.log(response.name);
      // Insert your code here
  }
);

}


function uploadanswers(quesids,valdiva,profinf) {
    //alert(quesids);
    var txtall="ansboxx".concat(valdiva);
	var answer =  document .getElementById(txtall.concat(quesids)).value;
	var notifications,imagelink,bol="'",question;
	//alert(profinfs.name);
	var profinfs=profinf;	
//	
//	if(notification=='true')
//	  notifications=1;
//	else
//      notifications=0;  	

	
	var uploadtoDb="v1/index.php/uploadanswers";
	var temp1=profinfs.picture;
	var temp2=temp1.data;
	var fbpic=temp2.url;
	
	var j=11,k=0,f=0;
	var user=profinfs.id;
	var usern=profinfs.name;
	var data=new FormData();
	
    if(localStorage.getItem("count")===null)
	{ 
	  k=0;
	  
	}
	else
	{	     
	for(j=1;j<=Number (localStorage.getItem("count"));j++)
	{	
	var ster=localStorage.getItem(j);
	
	
	ster=ster.replace("data:image/jpeg;base64,", "");
	ster=ster.replace("data:image/png;base64,", "");
	ster=ster.replace("data:image/jpg;base64,", "");
	ster=ster.replace("data:image/gif;base64,", "");
	k=k+1;
	
	
	
	imagelink=user.concat(k);
	
	data.append(imagelink,ster);
	
	localStorage.removeItem(j);
	
	
	
	}
	
	}
	localStorage.removeItem("count");
	
    data.append('imagecount',k);
	data.append('userid',user);
    
	
    var question_id =   quesids;
    var username = profinf.name;
    var image =  123456789;
    var string = "bbbbb";
    var upvote = 0;
    var downvote = 0;
    var anonymous = 0;
    var isright = 1;
	
	data.append('username',username);
	data.append('string',answer);
	data.append('upvote',upvote);
	data.append('downvote',downvote);
    data.append('anonymous',anonymous);
	data.append('isright',isright);
	data.append('fbpics',fbpic);
	
    data.append('question_id',question_id);

    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status != 404) {
                
				//alert(this.responseText);
				redir(question_id);
                      
                
            }
        };
		xmlhttp.open("POST", uploadtoDb, true); 
			
        
		xmlhttp.send(data);
		
		
        
    
}

function uploadanswersme(quesids,profinf) {
    //alert(quesids);
    var txtall="ansboxx".concat(quesids);
	var answer =  document .getElementById(txtall).value;
	var notifications,imagelink,bol="'",question;
	//alert(profinfs.name);
	var profinfs=profinf;	
//	
//	if(notification=='true')
//	  notifications=1;
//	else
//      notifications=0;  	

	
	var uploadtoDb="v1/index.php/uploadanswers";
	var temp1=profinfs.picture;
	var temp2=temp1.data;
	var fbpic=temp2.url;
	
	var j=11,k=0,f=0;
	var user=profinfs.id;
	var usern=profinfs.name;
	var data=new FormData();
	
    if(localStorage.getItem("count")===null)
	{ 
	  k=0;
	  
	}
	else
	{	     
	for(j=1;j<=Number (localStorage.getItem("count"));j++)
	{	
	var ster=localStorage.getItem(j);
	
	
	ster=ster.replace("data:image/jpeg;base64,", "");
	ster=ster.replace("data:image/png;base64,", "");
	ster=ster.replace("data:image/jpg;base64,", "");
	ster=ster.replace("data:image/gif;base64,", "");
	k=k+1;
	
	
	
	imagelink=user.concat(k);
	
	data.append(imagelink,ster);
	
	localStorage.removeItem(j);
	
	
	
	}
	
	}
	localStorage.removeItem("count");
	
    data.append('imagecount',k);
	data.append('userid',user);
    
	
    var question_id =   quesids;
    var username = profinf.name;
    var image =  123456789;
    var string = "bbbbb";
    var upvote = 0;
    var downvote = 0;
    var anonymous = 0;
    var isright = 1;
	
	data.append('username',username);
	data.append('string',answer);
	data.append('upvote',upvote);
	data.append('downvote',downvote);
    data.append('anonymous',anonymous);
	data.append('isright',isright);
	data.append('fbpics',fbpic);
	
    data.append('question_id',question_id);

    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status != 404) {
                
				//alert(this.responseText);
				redir(question_id);
                      
                
            }
        };
		xmlhttp.open("POST", uploadtoDb, true); 
			
        
		xmlhttp.send(data);
		
		
        
    
}

function redir(quesidss)
{ var str="http://www.onlinesohopathi.com/onequestion.html?question=";
  str=str.concat(quesidss);
 window.location.replace(str);

}

