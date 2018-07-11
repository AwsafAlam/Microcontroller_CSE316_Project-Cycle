



function loadallprofiles(ids)
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
      uploadQuestion(response);     
	 //alert(response.name);
      //resy=response;
	  //console.log(response.name);
      // Insert your code here
  }
);

}

function parsingAllNotis(mydiv){
   // alert("Hello bro...")    ; 
    var getFromDb="v1/index.php/checknotifs";
   var Obj;
   xmlhttp = new XMLHttpRequest();
   var data=new FormData();
   data.append('userid',mydiv);
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
       
          Obj = JSON.parse(this.responseText);
		  //alert(this.responseText);
		  
		  loadAllNotis(mydiv,this.responseText,"Notifydiv");
           
          console.log("Printings response...");
         
          

     }
   };
   xmlhttp.open("POST", getFromDb, true);
   xmlhttp.send(data);
   
 }
 
 function updatenotifystate(uidess,strn){
    //alert("Hello bro...")    ; 
    var getFromDb="v1/index.php/modifynotifs";
   var Obj;
   xmlhttp = new XMLHttpRequest();
   var data=new FormData();
   data.append('userid',uidess);
   data.append('quesid',strn);
   //alert(uidess);
  // alert(strn);
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
       
          //Obj = JSON.parse(this.responseText);
		  var btr="http://www.onlinesohopathi.com/onequestion.html?question=".concat(strn);
		  window.location.replace(btr);
           
          console.log("Printings response...");
         
          

     }
   };
   xmlhttp.open("POST", getFromDb, true);
   xmlhttp.send(data);
   
 }




function uploadQuestion(profinf) {
	
    var title= document.getElementById("input_text").value;
	
		
	
	var its;
	console.log(title);
	var question= document.getElementById("textarea1").value;
	if(question.length==0)
	{
		alert("Please mention the subject: e.g.- Physics, Math");
		return;
	}		
	var category= document.getElementById("category-sel").value;
	
	if(category=="None")
	{
		alert("Please select a category");
		return;
	}	
	console.log(category);
	var notification= document.getElementById("filled-in-box").checked;
	var notifications,imagelink,bol="'";
	
	
	
    var tags="none";
    
	
	if(notification)
	  notifications=1;
	else
      notifications=0;
    //alert(notifications);
    //return;	

	
	var uploadtoDb="v1/index.php/uploadquestion";
	var temp1=profinf.picture;
	var temp2=temp1.data;
	var fbpic=temp2.url;
	
	var j=11,k=0,f=0;
	var user=profinf.id;
	var usern=profinf.name;
	//alert(fbpic);
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
	
	localStorage.removeItem(j);
	
	data.append(imagelink,ster);
	
	}
	
	}
	localStorage.removeItem("count");
	data.append('userid',user);
	
	data.append('title',title);
	data.append('username',usern);
	data.append('question',question);
	data.append('category',tags);
	data.append('notifications',notifications);
	data.append('imagecount',k);
	data.append('tag',category);
	data.append('fbpics',fbpic);
	
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 201) {
                
				alert("Question Uploaded");
				myLoader();
                      
                
            }
			else if(this.readyState == 4)
			{
				alert("Please try again");
			}
        };
		xmlhttp.open("POST", uploadtoDb, true); 
			
        
		xmlhttp.send(data);
    
}
function myLoader() {
	
    location.href="http://www.onlinesohopathi.com";
}


function parsingAllQuestions(filter,cbd){
    
    var getFromDb="v1/index.php/viewallquestions";
    
    var PageToSendTo = "v1/index.php/viewallquestions?";
	var MyVariable = filter;
	var VariablePlaceholder = "filter=";
	var UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;
	
   var Obj;
   var data=new FormData();
   data.append('filter',filter);
   data.append('lastq',localStorage.getItem(cbd));
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
          //Obj = this.responseText;
          Obj = JSON.parse(this.responseText);

          
          loadallquestions(this.responseText,cbd);
           
          console.log("Printing response...");
          
     }
   };
   xmlhttp.open("POST", getFromDb, true);
   xmlhttp.send(data);
    
    
 
    
 }



function parsingAllAnswers(mydiv){
    //alert("Hello bro...")    ; 
    var getFromDb="v1/index.php/viewallanswers";
   var Obj;
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
       
          Obj = JSON.parse(this.responseText);
		  loadAllanswers(this,mydiv,Obj);
           
          console.log("Printing response...");
         //alert(this.responseText);
          

     }
   };
   xmlhttp.open("GET", getFromDb, true);
   xmlhttp.send();
   
 }
 
 function parsingAllBlogs(filter,cbd){
    var myNode=document.getElementById(cbd);
	//while(myNode.firstChild)
		//myNode.removeChild(myNode.firstChild);
    var getFromDb="v1/index.php/viewallblogs?filter=".concat(filter);
	
	getFromDb=getFromDb.concat("&lastq=");
	var fils="+-".concat(localStorage.getItem("bloglast"));
	getFromDb=getFromDb.concat(fils);
	

    var PageToSendTo = "v1/index.php/viewallblogs";
	//var MyVariable = filter;
	var VariablePlaceholder = "filter=";
	//var UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;
	//alert(cbd);
   var Obj;
   
   
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status != 404) {
          //Obj = this.responseText;
          //alert(this.responseText);
		  Obj = JSON.parse(this.responseText);

          
          LoadBlog(this.responseText,cbd);
           
          console.log("Printing response...");
          
     }
   };
   xmlhttp.open("GET", getFromDb, true);
   xmlhttp.send();
    
    
 
    
 }



function parsingAllAnswers(mydiv){
    //alert("Hello bro...")    ; 
    var getFromDb="v1/index.php/viewallanswers";
   var Obj;
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
       
          Obj = JSON.parse(this.responseText);
		  loadAllanswers(this,mydiv,Obj);
           
          console.log("Printing response...");
         //alert(this.responseText);
          

     }
   };
   xmlhttp.open("GET", getFromDb, true);
   xmlhttp.send();
   
 }
 
function searchanswer(search,cbd){
     
     var getFromDb="v1/index.php/viewsearchanswer";
	 var myNode=document.getElementById(cbd);
	while (myNode.firstChild) {
       
	   myNode.removeChild(myNode.firstChild);
}
	 
  
	//alert(search);
   var Obj;
   var data=new FormData();
   data.append('search',search);
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 ) {
          //Obj = this.responseText;
          Obj = JSON.parse(this.responseText);
            // alert(this.responseText);
         console.log("Hello search........");
          loadallquestions(this.responseText,cbd);
                     
     }
   };
   xmlhttp.open("POST", getFromDb, true);
   xmlhttp.send(data);

        
}

function uploadBlog()
{
  var title= document.getElementById("title").value;
	var its;
	console.log(title);
	var username= document.getElementById("username").value;
	var userid= document.getElementById("userid").value;
	//console.log(question);
	var content= document.getElementById("content").value;
	var type= document.getElementById("type").value;
	var imagecount= document.getElementById("imagecount").value;
	

	
	var uploadtoDb="v1/index.php/uploadblog";
	var data=new FormData();
	/*var temp1=profinf.picture;
	var temp2=temp1.data;
	var fbpic=temp2.url;
	
	var j=11,k=0,f=0;
	var user=profinf.id;
	var usern=profinf.name;
	//alert(fbpic);
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
	
	localStorage.removeItem(j);
	
	data.append(imagelink,ster);
	
	}
	
	}
	localStorage.removeItem("count");*/
	data.append('userid',userid);
	
	data.append('title',title);
	data.append('username',username);
	data.append('content',content);
	data.append('type',type);
	
	data.append('imagecount',imagecount);
	
	
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 201) {
                
				// alert("success");
				
                      
                
            }
        };
		xmlhttp.open("POST", uploadtoDb, true); 
			
        
		xmlhttp.send(data);

}	




