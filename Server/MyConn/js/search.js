

function StringSet() {
    var setObj = {}, val = {};

    this.add = function(str) {
        setObj[str] = val;
    };

    this.contains = function(str) {
        return setObj[str] === val;
    };

    this.remove = function(str) {
        delete setObj[str];
    };

    this.values = function() {
        var values = [];
        for (var i in setObj) {
            if (setObj[i] === val) {
                values.push(i);
            }
        }
        return values;
    };
}

function fetchUserDetail(alldivss)
    {
        FB.api('/me', function(response) {
                alert("Name: "+ response.name + "\nFirst name: "+ response.first_name + "ID: "+response.id);
                if(alldivss.id=="myModals")
				  logger(response.id);
			    else
					loggers(response.id);
			    
				 				
				
			});
			
             
    }

 function checkFacebookLogin(alldiv) 
  {      
        FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
            fetchUserDetail(alldiv);
			
          } 
          else 
          {
            
          }
         });
		 
    }


function logger(pqs)
{  uid=pqs;
   alert("HOG");
   uploadQuestion(); 

            
			if(uid!="hiru")
			{   
				
				//$("#myModals").modal("hide"); 
			}
    
}

function loggers(pqs)
{  uid=pqs;
   alert("HOG");
   uploadanswers(quesd); 

            
			if(uid!="hiru")
			{   
				
				//$("#myModals").modal("hide"); 
			}
    
}
	
$("#myModals").on('show.bs.modal', function () {
            
			if(uid!="hiru")
			{   alert("HOGs");
		        uploadQuestion();  
		         
		           
				$("#myModals").modal("hide"); 
			}
    });
	
$("#myModalss").on('show.bs.modal', function () {
            
			if(uid!="hiru")
			{   alert("HOGs");
		        uploadanswers(quesd);  
		         
		           
				$("#myModalss").modal("hide"); 
			}
    });	
	
	
	

	
	





    $(".dropdown-content li a").click(function(){
      console.log( $(this).text());
      var link=document.getElementById('category-sel');	  
      console.log( link.innerHTML);
	  var stry=$(this).text();
	  if(stry.charAt(0)=='p')
		  stry="Physics";
	  else if(stry.charAt(0)=='a')
		  stry="Chemistry";
	  else if(stry.charAt(0)=='f')
		  stry="Biology";
	  else if(stry.charAt(0)=='i')
		  stry="Math";
	  else if(stry.charAt(0)=='e')
		  stry="English";
	  
	  link.innerHTML=stry;
      //$(".dropdown-button btn:first-child").val($(this).text());

   });
   

$('.chips').on('chip.add', function(e, chip){
    var obj=$('.chips').material_chip('data');
	
	console.log(obj[0].tag);
	// you have the added chip here
  });
  
$("#image-picker").change(function (event) {
    console.log("Clicked");
    readURLs(this , "img-grid");
});






function readURLs(input , imgdiv) {
  var imgdiv = document.getElementById(imgdiv);
  
  
  var curFiles = input.files;
  var b64string="hello!@1";
  var q=0,start;
  	
  console.log(curFiles);
   
  if (curFiles!= 0) {
    var list = document.createElement("ul");
    list.style.cssText = 'margin: 0 auto; text-align: center;'

    imgdiv.appendChild(list);
    var l=2;
    for (var i = 0; i < curFiles.length; i++) {
      var listItem = document.createElement("li");
	  var bstring;
     listItem.style.cssText = 'display: inline-block; vertical-align: top;'

      var para = document.createElement("p");
  	  l=2;
  	  para.id="paras";
      para.textContent = "File name " + curFiles[i].name + ".";
      var image = document.createElement("img");
    
      //image.src = window.URL.createObjectURL(curFiles[i]);
    	if(localStorage.getItem("count")===null)
    	{
    		q=1;
    	}
        else
    	{
    		q= Number(	localStorage.getItem("count"))+1;		
    	}
    
    	var FR= new FileReader();
    	FR.addEventListener("load", function(e) { 
          image.src       = e.target.result;
          bstring       = e.target.result;
    	  //alert(bstring);
    	localStorage.setItem(q,bstring);
    	l=1;
    	});
      
      FR.readAsDataURL( input.files[i] );
	  

      image.id="shadman".concat(i);
    	
    	localStorage.setItem("count",q);
  	
    	//localStorage.setItem("start",start);
    	
      //localStorage.setItem(q,b64string);
    	//document.getElementById("paras").innerHTML="File name " + curFiles[i].name + ".";
      image.style.cssText = 'height:90px; width:90px';	
      listItem.appendChild(image);
      listItem.appendChild(para);

    	//var lst=getBase64Image(document.getElementById(image.id),listItm);
    	list.appendChild(listItem);
    }

  }
}  
  
 
$(".Home").ready(function(){
 
 for(var i=1;i<=30;i++)
    localStorage.removeItem(i);

  localStorage.removeItem("count"); 
 //parsingAllQuestions("0");
    
    //faiza-start
    

});


/*

function loadallprofiles(ids)
{
    var responsefromfbname;
	var strl="/".concat(ids);
    
   FB.api(
  strl,
  'GET',
  {"fields":"id,name,picture"},
  function(response) {
     //response.name;
      //var responsefromfbpic=response.picture.data.url;
      alert(response.name);
      
      // Insert your code here
  }
);
} 

*/




$('#search').keypress(function (e) {                                       
       if (e.which == 13) {
            e.preventDefault();
            //alert("HO");
        
			searchanswer(this.value);
           
         
			//do something   
       }
});
      
/*
$('#search').ready(function () {
    resetForms();
});

function resetForms() {
    document.getElementById('search').reset();

}

*/

function searchanswer(search){
    
     var getFromDb="v1/index1.php/viewsearchanswer";
  
	//alert(search);
   var Obj;
   var data=new FormData();
   data.append('search',search);
   xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 ) {
          //Obj = this.responseText;
          Obj = JSON.parse(this.responseText);
            //alert(Obj);
         console.log("Hello search........");
          searchshow(this.responseText);
                     
     }
   };
   xmlhttp.open("POST", getFromDb, true);
   xmlhttp.send(data);
    
    
    
}





function searchshow(myObjs)
{
 
	// body...
	var myObj=JSON.parse(myObjs);
	var i,j,k,l,m;
    
    alert(myObj.length);
  for(i=0;i<myObj.length;i++)
  {
	     
      //  Faiza-commented
      
	 /* if(i==1)
		  loadallprofiles(myObj[i].id);
      */
      //Faiza
		   
  var listItem = document.createElement("li");
  CollapseBody.append(listItem);
      
    var QuestionTitle = document.createElement("div");
    QuestionTitle.classList.add('questioncard');
    QuestionTitle.classList.add('collapsible-header');
    //QuestionTitle.textContent = "Do native English speakers ever notice that someone isn't a native speaker despite speaking fluently? If yes, how?";
   		listItem.append(QuestionTitle);
  
    var Profilepic = document.createElement("img");
    Profilepic.src = "img/account_circle.svg";
    Profilepic.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
        QuestionTitle.append(Profilepic);

    var creadiv=   document.createElement("div");
	
	
	creadiv.textContent = myObj[i].title;
	
	
    var ViewsDiv = document.createElement("div");
    ViewsDiv.style.cssText = 'margin: 4px; margin-top: 15px; padding: 1px; position: absolute;';
    	creadiv.append(ViewsDiv);

    var ViewsSpan = document.createElement("span");
    ViewsSpan.classList.add('new');
    ViewsSpan.classList.add('badge');
    ViewsSpan.textContent = myObj[i].category;
    	ViewsDiv.append(ViewsSpan);

	var AnsSpan = document.createElement("span");
    AnsSpan.classList.add('new');
    AnsSpan.classList.add('badge');
    AnsSpan.classList.add('grey');
    AnsSpan.textContent = "4";
    	ViewsDiv.append(AnsSpan);
		
	QuestionTitle.append(creadiv);	
		
		


    var Description = document.createElement("div");
	Description.id="q".concat(myObj[i].id);
    Description.classList.add('collapsible-body');
    	
    
	var DescText = document.createElement("span");
    DescText.textContent = myObj[i].question;
    	Description.append(DescText);
	str=myObj[i].image;
	
    var images=str.split(",");
	
	var urls;
    for (j = 0; j < images.length; j++) {	
    if(images[j].length==0)continue;
	
	urls='http://198.211.96.87/mojo/Admissionvaiya/v1/'.concat(images[j]);
	
	
	var qimgdiv=document.createElement("div");
    qimgdiv.classList.add('flexbin');
    qimgdiv.classList.add('flexbin-margin');
	var qimg=document.createElement('img');
	qimg.classList.add('materialboxed');
	qimg.style.cssText=' height: 100%; width: 100%;';
	qimg.src=urls;
	qimgdiv.append(qimg);
	Description.append(qimgdiv);
	
	}
	
	var ansdiv=document.createElement("div");
	ansdiv.classList.add('conta');
	var acount=document.createElement('h5');
	
	//Answer starts loading here
	
	var anss=myObj[i].answers;
	acount.textContent=anss.length+"answers";
	ansdiv.append(acount);
	Description.append(ansdiv);
	
	for(k=0;k < anss.length;k++)
	{
	
	var timediv= document.createElement("div");
	timediv.classList.add('timeline-item');
	var subdiv= document.createElement("div");
	subdiv.classList.add('cd-timeline-img');
	var anspro=document.createElement('img');
	anspro.src="img/account_circle.svg";
	subdiv.append(anspro);
	var ansname=document.createElement('strong');
	ansname.textContent=anss[k].username;
	subdiv.append(ansname);
	timediv.append(subdiv);
	
	
	Description.append(timediv);
	
	var anspara= document.createElement("p");
	anspara.textContent= anss[k].string;
	Description.append(anspara);
	
	var strs=anss[k].image;
    var imagess=strs.split(",");
	var urlss;
	for(l=0;l<imagess.length;l++)
	{
	
	
	if(imagess[l].length==0)continue;
	var qimgdivs=document.createElement("div");
	var matdivs= document.createElement("div");
	urlss='http://198.211.96.87/mojo/Admissionvaiya/v1/'.concat(imagess[l]);
	if(i==0)
		alert(urlss);
    qimgdivs.classList.add('flexbin');
    qimgdivs.classList.add('flexbin-margin');
	matdivs.classList.add('material-placeholder');
	
	var qimgs=document.createElement('img');
	qimgs.classList.add('materialboxed');
	qimgs.classList.add('initialized');
	qimgs.style.cssText=' height: 130%; width: 100%; ';
	
	qimgs.src=urlss;
	matdivs.append(qimgs);
	qimgdivs.append(matdivs);
	Description.append(qimgdivs);
	}
	var likediv=document.createElement("div");
	likediv.style.cssText=" margin: 4px; padding: 1px; position: absolute; ";
	var ViewsSpan = document.createElement("span");
    ViewsSpan.classList.add('new');
    ViewsSpan.classList.add('badge');
    ViewsSpan.textContent = "Upvote";
    	likediv.append(ViewsSpan);

	var AnsSpan = document.createElement("span");
    AnsSpan.classList.add('new');
    AnsSpan.classList.add('badge');
    AnsSpan.classList.add('grey');
    AnsSpan.textContent = "Downvote";
    	likediv.append(AnsSpan);
	Description.append(likediv);

    }	
		
		
	var timedivs= document.createElement("div");
	timedivs.classList.add('timeline-item');
	var myimg= document.createElement('div');
	myimg.style.cssText="margin-top:15 px;";
	myimg.classList.add('cd-timeline-img');
	var proimgs= document.createElement('img');
    proimgs.src= "img/account_circle.svg";
	var strngme= document.createElement('strong');
	strngme.textContent="Shadman Majid";
    myimg.append(proimgs);
    myimg.append(strngme);
	timedivs.append(myimg);
    
	
	var ansbox= document.createElement('div');
	var txtbox= document.createElement('textarea');
	txtbox.classList.add('materialize-textarea');
	txtbox.id= "ansboxx".concat(myObj[i].id);
	txtbox.type="text";
	txtbox.placeholder="New Comment";
	ansbox.append(txtbox);
	timedivs.append(ansbox);
	var imganbt= document.createElement("button");
	imganbt.classList.add('waves-effect');
	imganbt.classList.add('waves-light');
	imganbt.classList.add('btn');
	var imgandbt= document.createElement("input");
	imgandbt.setAttribute("type", "file");
    imgandbt.accept = "image/*";
	imgandbt.id="image-picker".concat(myObj[i].id);
	imgandbt.style.cssText="visibility: hidden; display: none;";
	var imgpick= "document.getElementById('image-picker').click()";
	imganbt.id="anssub".concat(myObj[i].id);
	var valuess= (myObj[i].id);
	var icn= document.createElement("i");
	
	icn.classList.add('fa');
	icn.classList.add('fa-camera');
	imganbt.appendChild(icn);
	var content = document.createTextNode("Image");
	imganbt.appendChild(content);
	imganbt.appendChild(imgandbt);
	
	
	
	
	timedivs.append(imganbt);
	var subbt= document.createElement("button");
	subbt.classList.add('waves-effect');
    subbt.classList.add('waves-light');
	subbt.classList.add('btn');
	subbt.id="submit".concat(myObj[i].id);
	var buttonanswer="submit".concat(myObj[i].id);
	var icns= document.createElement("i");
	
	icns.classList.add('fa');
	icns.classList.add('fa-paper-plane');
	subbt.appendChild(icns);
	var contents = document.createTextNode("Submit");
	subbt.appendChild(contents);
	timedivs.append(subbt);
	
	
	
	
	//document.add( '<button class=\"waves-effect waves-light btn\"><i class=\"fa fa-camera\"></i>Image</button>' );
	
	//button for answer image and submit goes here
	
	
	Description.append(timedivs);
	
		
	listItem.append(Description);
	
	imagedisplay(valuess);
	imagepreview(valuess);
	submitbuttonforanswer(buttonanswer);
	
	
	
  }
	
	


}





function imagedisplay(objs)
{

  var objr=objs;
  objs="anssub".concat(objs);
  
  document.getElementById(objs).addEventListener("click", function(event){
  // image preview
    console.log("Clicked imageanswer...");
	var olb= "image-picker".concat(objr);
	document.getElementById(olb).click();
	
    
	

  });
 
 
}

function imagepreview(objss)
{

  var objc=objss;
  var orb= "image-picker".concat(objc);
  
  document.getElementById(orb).addEventListener("change", function(event){
  // image preview
    
	
	var values="q".concat(objc);
	//alert(objs);
    readURLs(this , values);
    console.log("Clicked imagewer...");
	

  });
 
 
}



function submitbuttonforanswer(objl)
{

 
  document.getElementById(objl).addEventListener("click", function(){
  // Uploading Comment
  var qid=objl.replace('submit','');
  quesd= qid;
     
  $("#myModalss").modal("show"); 
  
  uploadanswers(qid);

  });

  
 
 
}







String.prototype.replaceAll = function(str1, str2, ignore) 
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
}

function uploadFile() {
    var blobFile = $('#filechooser').files[0];
    var formData = new FormData();
    formData.append("fileToUpload", blobFile);

    $.ajax({
       url: "upload.php",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       success: function(response) {
           // .. do something
       },
       error: function(jqXHR, textStatus, errorMessage) {
           console.log(errorMessage); // Optional
       }
    });
}









