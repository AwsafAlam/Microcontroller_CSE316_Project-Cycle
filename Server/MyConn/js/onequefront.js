function checklog()
{
	if(uid=="hiru")
	{
		
	  $('#myModals').modal('show');
	
	}
	else
		loadallprofiles(uid);

}

function checkuser()
{
	
	if(uid!="hiru")
	{
		location.href="http://www.onlinesohopathi.com/myquestion.html";
	}
	else
		location.href="http://www.onlinesohopathi.com/fblogin.html";
}

function redirectnow()
{
	var str="http://www.onlinesohopathi.com/index.html";
  //str=str.concat(quesidss);
 window.location.replace(str);

}

function fetchUserDetail(alldivss)
    {
        FB.api('/me', function(response) {
                //alert("Name: "+ response.name + "\nFirst name: "+ response.first_name + "ID: "+response.id);
                if(alldivss.id=="myModals")
				  logger(response.id);
			    else
				{   
					loadallprofilesme(quesd,response.id);
					
                }					
			    
				 				
				
			});
			
             
    }

 function checkFacebookLogin(alldiv) 
  {     $("#myModalss").modal("hide");
        $("#myModals").modal("hide");    
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
   if(uid!="hiru")
			{   
				
				$("#myModals").modal("hide"); 
			}
   //alert("HOG");
   loadallprofiles(uid); 

            
			
    
}

function loggers(pqs)
{  uid=pqs;
   //alert("HOG");
   uploadanswers(quesd); 

            
			if(uid!="hiru")
			{   
				$("#myModalss").modal("hide"); 
				
			}
    
}

	

   

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
     listItem.style.cssText = 'display: inline-block; vertical-align: top;';

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
  






var CollapsibleBody =  document.getElementById("CollapseBody");



var CollapseBody =  document.getElementById("CollapseBody");

function loadonequestion(myObjs) {
	// body...
	var myObj=JSON.parse(myObjs);
	var i,j,k,l,m;
  for(i=0;i<myObj.length;i++)
  {   //alert(myObj[0].username);
	  
	  var titles=document.getElementById("title");
	  titles.textContent=myObj[i].title+" Subject: " + myObj[i].question+ "Category: " +myObj[i].category;
		   
  var listItem = document.createElement("li");
  CollapseBody.appendChild(listItem);
      
    var QuestionTitle = document.createElement("div");
    QuestionTitle.classList.add('questioncard');
    
    //QuestionTitle.textContent = "Do native English speakers ever notice that someone isn't a native speaker despite speaking fluently? If yes, how?";
   		listItem.appendChild(QuestionTitle);
  
    var Profilepic = document.createElement("img");
	
    if(myObj[i].notification=="0")
	 Profilepic.src = myObj[i].fbpic;
    else
	  Profilepic.src = "img/account_circle.svg";;	
	Profilepic.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
        QuestionTitle.appendChild(Profilepic);

    var creadiv=   document.createElement("div");
	
	
	if(myObj[i].notification=="0")
	   creadiv.textContent = (myObj[i].username).concat(" asked: ");
    else
		creadiv.textContent = ("Somebody").concat(" asked: ");
	    
	var creatitl= document.createElement("p");
	creatitl.textContent="      ".concat(myObj[i].title);
	creatitl.style.cssText="font-weight: bold;";
	creadiv.appendChild(creatitl);
	
	var DescText = document.createElement("span");
    DescText.textContent ="Subject: ".concat(myObj[i].question);
    	creadiv.appendChild(DescText);
	
	
	
    var ViewsDiv = document.createElement("div");
    ViewsDiv.style.cssText = 'margin: 4px; margin-top: 15px; padding: 1px; position: absolute;';
    	creadiv.appendChild(ViewsDiv);

    var ViewsSpan = document.createElement("span");
    ViewsSpan.setAttribute("data-badge-caption" , "");
	ViewsSpan.classList.add('new');
    ViewsSpan.classList.add('badge');
    ViewsSpan.textContent = myObj[i].tags;
    	ViewsDiv.appendChild(ViewsSpan);

	var AnsSpan = document.createElement("span");
	AnsSpan.setAttribute("data-badge-caption" , " Answers");
    AnsSpan.classList.add('new');
    AnsSpan.classList.add('badge');
    AnsSpan.classList.add('grey');
	var counts=myObj[i].answers;
    AnsSpan.textContent = counts.length;
    	ViewsDiv.appendChild(AnsSpan);
		
	QuestionTitle.appendChild(creadiv);	
		
		


    var Description = document.createElement("div");
	Description.id="q".concat(myObj[i].id);
    
    	
    
	
	str=myObj[i].image;
	
    var images=str.split(",");
	
	var urls;
    for (j = 0; j < images.length; j++) {	
    if(images[j].length==0)continue;
	
	urls='http://198.211.96.87/v1/'.concat(images[j]);
	
	
	var qimgdiv=document.createElement("div");
    qimgdiv.classList.add('flexbin');
    qimgdiv.classList.add('flexbin-margin');
	var qimg=document.createElement('img');
	
	qimg.style.cssText=' display: block;overflow: auto';
	qimg.src=urls;
	$('.materialboxed').materialbox();
	qimg.classList.add('materialboxed');
	
	qimgdiv.appendChild(qimg);
	Description.appendChild(qimgdiv);
	
	}
	
	var ansdiv=document.createElement("div");
	ansdiv.classList.add('conta');
	var acount=document.createElement('h5');
	
	//Answer starts loading here
	
	var anss=myObj[i].answers;
	acount.textContent=anss.length+" answers";
	ansdiv.appendChild(acount);
	Description.appendChild(ansdiv);
	
	for(k=0;k < anss.length;k++)
	{
	
	var timediv= document.createElement("div");
	timediv.classList.add('timeline-item');
	var subdiv= document.createElement("div");
	subdiv.classList.add('cd-timeline-img');
	var anspro=document.createElement('img');
	anspro.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
	anspro.src=anss[k].fbimg;
	subdiv.appendChild(anspro);
	var ansname=document.createElement('strong');
	ansname.textContent=(anss[k].username).concat(" replied: ");
	subdiv.appendChild(ansname);
	timediv.appendChild(subdiv);
	var anspara= document.createElement("p");
	anspara.textContent= anss[k].string;
	timediv.appendChild(anspara);
	
	Description.appendChild(timediv);
	
	
	
	
	var strs=anss[k].image;
    var imagess=strs.split(",");
	var urlss;
	for(l=0;l<imagess.length;l++)
	{
	
	
	if(imagess[l].length==0)continue;
	var qimgdivs=document.createElement("div");
	var matdivs= document.createElement("div");
	urlss='http://198.211.96.87/v1/'.concat(imagess[l]);
	
		//alert(urlss);
    qimgdivs.classList.add('flexbin');
    qimgdivs.classList.add('flexbin-margin');
	matdivs.classList.add('material-placeholder');
	
	var qimgs=document.createElement('img');
	
	qimgs.style.cssText=' display: block;overflow: auto ';
	
	qimgs.src=urlss;
	$('.materialboxed').materialbox();
	qimgs.classList.add('materialboxed');
	matdivs.appendChild(qimgs);
	qimgdivs.appendChild(matdivs);
	timediv.appendChild(qimgdivs);
	}
	var likediv=document.createElement("div");
	likediv.style.cssText=" margin: 4px; padding: 1px; position: absolute; ";
	var ViewsSpan = document.createElement("span");
    ViewsSpan.setAttribute("data-badge-caption" , " Upvotes");
	ViewsSpan.classList.add('new');
    ViewsSpan.classList.add('badge');
    ViewsSpan.textContent = "0";
    	likediv.appendChild(ViewsSpan);

	var AnsSpan = document.createElement("span");
    AnsSpan.setAttribute("data-badge-caption" , " Downvotes");
	AnsSpan.classList.add('new');
    AnsSpan.classList.add('badge');
    AnsSpan.classList.add('grey');
    AnsSpan.textContent = "0";
    	likediv.appendChild(AnsSpan);
	Description.appendChild(likediv);

    }	
		
		
	var timedivs= document.createElement("div");
	timedivs.classList.add('timeline-item');
	var myimg= document.createElement('div');
	myimg.style.cssText="margin-top:15 px;";
	myimg.classList.add('cd-timeline-img');
	var proimgs= document.createElement('img');
    proimgs.src= "img/account_circle.svg";
	proimgs.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
	var strngme= document.createElement('strong');
	strngme.textContent="Myself";
    myimg.appendChild(proimgs);
    myimg.appendChild(strngme);
	timedivs.appendChild(myimg);
    
	
	var ansbox= document.createElement('div');
	var txtbox= document.createElement('textarea');
	txtbox.classList.add('materialize-textarea');
	txtbox.id= "ansboxx".concat(myObj[i].id);
	txtbox.type="text";
	txtbox.placeholder="New Comment";
	ansbox.appendChild(txtbox);
	timedivs.appendChild(ansbox);
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
	
	
	
	
	timedivs.appendChild(imganbt);
	var subbt= document.createElement("button");
	subbt.classList.add('waves-effect');
    subbt.classList.add('waves-light');
	subbt.classList.add('btn');
	subbt.id="submit".concat(myObj[i].id);
	subbt.style.cssText="margin-left: 10px;";
	var buttonanswer="submit".concat(myObj[i].id);
	var icns= document.createElement("i");
	
	icns.classList.add('fa');
	icns.classList.add('fa-paper-plane');
	subbt.appendChild(icns);
	var contents = document.createTextNode("Submit");
	subbt.appendChild(contents);
	timedivs.appendChild(subbt);
	
	
	
	
	//document.add( '<button class=\"waves-effect waves-light btn\"><i class=\"fa fa-camera\"></i>Image</button>' );
	
	//button for answer image and submit goes here
	
	
	Description.appendChild(timedivs);
	
		
	listItem.appendChild(Description);
	
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
     
  if(uid=="hiru")	
        $('#myModalss').modal('show');
      else
		  loadallprofilesme(quesd,uid);

  });

  
 
 
}









