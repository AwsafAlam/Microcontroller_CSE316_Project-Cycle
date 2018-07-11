



$("#Home").ready(function (event) {
  /* for(var i=1;i<=30;i++)
    localStorage.removeItem(i);
*/
  var urls=window.location.href;
   var res = urls.split("=");
   parsingoneQuestion(res[1]);
});


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

function uploadQuestion(profinf) {
	
    var title= document.getElementById("input_text").value;
	var its;
	console.log(title);
	var question= document.getElementById("textarea1").value;
	var category= document.getElementById("category-sel").value;
	console.log(question);
	var notification= document.getElementById("filled-in-box").checked;
	var notifications,imagelink,bol="'";
	var obn=$('.chips').material_chip('data');
    var tags="";
    for(its=0;its<obn.length;its++)
	{
		tags=tags.concat(obn[its].tag);
		if(its!=obn.length-1)
			tags=tags.concat(",");
	}
	
	if(notification=='true')
	  notifications=1;
	else
      notifications=0;  	

	
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
	data.append('category',category);
	data.append('notifications',notifications);
	data.append('imagecount',k);
	data.append('tag',tags);
	data.append('fbpics',fbpic);
	
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status != 404) {
                
				//alert(this.responseText);
				myLoader();
                      
                
            }
        };
		xmlhttp.open("POST", uploadtoDb, true); 
			
        
		xmlhttp.send(data);
    
}
function myLoader() {
	
    location.reload();
}



function parsingoneQuestion(url){
    
    var getFromDb="v1/index.php/viewonequestion?question=";

    var PageToSendTo = "v1/index.php/viewonequestion?";
	
   var Obj;
    var onequestion=url;
	getFromDb=getFromDb.concat(onequestion);
    
    
   var data=new FormData();
       data.append('onequestion',onequestion);

  // data.append('filter',filter);
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
          //Obj = this.responseText;
          Obj = JSON.parse(this.responseText);

          
          loadonequestion(this.responseText);
           
          console.log("Printing response...");
          
     }
   };
   xmlhttp.open("POST", getFromDb, true);
   xmlhttp.send(data);
    
    
 
    
 }

