function makeExpandingArea(container) {
 var area = container.querySelector('textarea');
 var span = container.querySelector('span');
 if (area.addEventListener) {
   area.addEventListener('input', function() {
     span.textContent = area.value;
   }, false);
   span.textContent = area.value;
 } else if (area.attachEvent) {
   // IE8 compatibility
   area.attachEvent('onpropertychange', function() {
     span.innerText = area.value;
   });
   span.innerText = area.value;
 }
// Enable extra CSS
container.className += "active";
}var areas = document.querySelectorAll('.expandingArea');
var l = areas.length;while (l--) {
 makeExpandingArea(areas[l]);
}

// $('#expand').click(function () {
//   console.log("Clicked hidden");
//   var active = true;
//   $('#Answer').removeClass('hidden');
//   if(!active)
//   {
//     $('#Answer').addClass('hidden');
//     active = false;
//   }
// });



//Initialising Golbal variables

var questiondiv =  document.getElementById("questiontest");
var Answerdiv; 
    
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
//var uid;

function fblogin(){
     var getFromDb="https://graph.facebook.com/v2.11/me?fields=id,name,picture";
   var Obj;
   /* xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 201) {
          //Obj = this.responseText;
          Obj = JSON.parse(this.responseText);
          alert(this.responseText);
          
           
          console.log("Printing fbresponse...");
          

     }
   };
   xmlhttp.open("GET", getFromDb, true);
   xmlhttp.send();*/
    
    FB.api(
  '/me',
  'GET',
  {"fields":"id,name,picture", "async" : "true"},
  function(response) {
      alert(response.name);
      //uid = response.id;
      
      // Insert your code here
  }
);

    
    
    
    
}



function loadallquestions(myObjs)
{
    var responsefromfbname;
    
   /* FB.api(
  '/me',
  'GET',
  {"fields":"id,name,picture"},
  function(response) {
     //response.name;
      //var responsefromfbpic=response.picture.data.url;
      alert(response.name);
      
      // Insert your code here
  }
); */
    
    
    
      //alert(responsefromfbname);
    
    
  console.log("Inside loading....");
   
  var getFromDb="v1/index.php/viewallquestions";
  
  var myObj=JSON.parse(myObjs);
  if(questiondiv.hasChildNodes())
  {
  while (questiondiv.hasChildNodes()) {
  questiondiv.removeChild(questiondiv.lastChild);
  }
  }
  
        
for(var it = 0 ; it< myObj.length; it++){
  
  // Question div
  
  var questionitem = document.createElement("div");
    //fblogin();
  
  questionitem.id = "q"+myObj[it].id;
  questionitem.classList.add('question-item');
  questionitem.classList.add('col-md-12');
    questiondiv.append(questionitem);
    
  // Profile pic
  var profilepic = document.createElement("img");

  profilepic.style.cssText = 'height:90px; width:90px';  
  profilepic.src = "img/profile-pic.png";
  profilepic.classList.add('img-circle');
  profilepic.classList.add('profile-img');

  questionitem.append(profilepic);

   // alert("Hells..")  ;

  // User Name
  var name = document.createElement("div");
  //lert(myObj[0].id);
  name.classList.add('name');
    var nameh4 = document.createElement("h4");
    nameh4.textContent = myObj[it].username;
    name.append(nameh4);
  questionitem.append(name);

  // Question Title
  var questiontitle = document.createElement("div");
  questiontitle.classList.add('question');
    var questiontitleh2 = document.createElement("h2");
    questiontitleh2.textContent = myObj[it].category;
    questiontitle.append(questiontitleh2);
  questionitem.append(questiontitle);

  // Question Content
  var questioncontent = document.createElement("div");
  questioncontent.classList.add('content');
    // var contentpara=document.createElement("p");
    //  contentpara.textContent="Styling not added yet, so does not show on div";
    questioncontent.textContent=myObj[it].question;
    //questioncontent.textContent = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
    // questioncontent.append(questioncontenth2);
  questionitem.append(questioncontent);

  // Image Grid
  var imagediv = document.createElement("div");
  
  var list = document.createElement("ul");
  list.style.cssText = 'margin: 0 auto; text-align: center;'
  imagediv.appendChild(list);
  var str,images;
  str=myObj[it].image;
  var images=str.split(",");
  var urls;
  
    for (var i = 0; i < images.length; i++) {
      
      var listItem = document.createElement("li");
      listItem.style.cssText = 'display: inline-block; vertical-align: top;'
      if(images[i].length==0)continue;
	  var image = document.createElement("img");
	  
	  urls='http://198.211.96.87/hridoy2/v1/'.concat(images[i]);
	  
      image.src =urls;
      image.style.cssText = 'height:150px; width:200px;';  
      listItem.appendChild(image);
      list.appendChild(listItem);

    }
  questionitem.append(imagediv);


  // Comment Box
  var commentbox = document.createElement("div");
  commentbox.classList.add('commentbox');
  
  var upvote = document.createElement("a");
  upvote.textContent = myObj[it].upvote;
  
  var downvote = document.createElement("a");
  downvote.textContent = myObj[it].downvote;
  commentbox.append(upvote);
  commentbox.append(downvote);

  var comment = document.createElement("textarea");
  comment.classList.add('leave-your-comment-css');
  comment.id = "comment"+myObj[it].id;
  commentbox.append(comment);

  questionitem.append(commentbox);

  var submitbtn = document.createElement("button");
  submitbtn.classList.add('btn');
  submitbtn.classList.add('user-comment-send');
  submitbtn.id="sub"+myObj[it].id;
  buttonanswer="sub"+myObj[it].id;
  
    var sendicon = document.createElement("i");
    sendicon.classList.add("fa");
    sendicon.classList.add("fa-paper-plane");
	submitbtn.append(sendicon);
  
  

  questionitem.append(submitbtn);
  submitbuttonforanswer(buttonanswer);

  // Image button
  var imageans = document.createElement("INPUT");
  imageans.id = "i"+myObj[it].id;
  imageans.classList.add('btn');
  imageans.setAttribute("type", "file");
  imageans.accept = "image/*";
  imageans.style.cssText = "background: red;"
  // imageans.classList.add('user-comment-send');

    var imageicon= document.createElement("i");
    imageicon.classList.add("fa");
    imageicon.classList.add("fa-camera");
    imageans.id=myObj[it].id;
	
	imageans.append(imageicon);
    value=myObj[it].id;
    
  
  questionitem.append(imageans);
  
  imagedisplay(value);
  
  // Read Answers span
  var readAnswer = document.createElement("span");
  // readAnswer.id = expand;
  readAnswer.classList.add("read-more");
  readAnswer.textContent = "Read More";
  readAnswer.style.cssText = "cursor: pointer; color: blue;";
  readAnswer.id="s"+myObj[it].id;
  ansvalue="s"+myObj[it].id;

  // Creating answer div
  Answerdiv = document.createElement("div");
  Answerdiv.classList.add('hidden');
  Answerdiv.classList.add('awswers-wrapper');
  Answerdiv.id = "as"+myObj[it].id;
  
  
   
  

  questionitem.append(readAnswer);
  
  questionitem.append(Answerdiv);
  
  readmorepart(ansvalue);
   
  console.log("Created div");
   
   
}

   console.log("Finish");
   //return;

}
function readmorepart(objc)
{
	
document.getElementById(objc).addEventListener("click", function(event){
    console.log("Clicked hidden");
    // var active = true;
    // $('#Answer').removeClass('hidden');
    // if(!active)
    // {
    //   $('#Answer').addClass('hidden');
    //   active = false;
    // }
	objd="a".concat(objc);
	//alert(objd);
	var indo=document.getElementById(objd);
    indo.classList.toggle('hidden');
    parsingAllAnswers(indo);
    


  });
	
}

function imagedisplay(objs)
{

 
  
  document.getElementById(objs).addEventListener("change", function(event){
  // image preview
   
    console.log("Clicked imageanswer...");
	var values="q".concat(objs);
	// alert(objs);
    readURLs(this , values);

  });
 
 
}

function submitbuttonforanswer(objl)
{

 
  document.getElementById(objl).addEventListener("click", function(){
  // Uploading Comment
  var qid=objl.replace('sub','');
  console.log("Submit Answer");
  uploadanswers(qid);

  });

  
 
 
}

function loadAllanswers(event,Answerdiv,myjson){

while (Answerdiv.hasChildNodes()) {
  Answerdiv.removeChild(Answerdiv.lastChild);
}
for(var i =0 ; i<myjson.length ; i++){
  // Answer item
  var answeritem = document.createElement("div");
  answeritem.classList.add('answer-item');
    Answerdiv.append(answeritem);

  // Profile div
  var profileitem = document.createElement("div");
  profileitem.classList.add('Profile-info');
    answeritem.append(profileitem);

    // Profile pic
  var profilepic = document.createElement("img");

  profilepic.style.cssText = 'height:40px; width:40px; border-radius: 50%;';  
  profilepic.src = "img/profile-pic.png";
  // profilepic.classList.add('img-circle');
  // profilepic.classList.add('profile-img');

  profileitem.append(profilepic);

  // User Name
  var nameh5 = document.createElement("h5");
  nameh5.textContent = myjson[i].username;
  profileitem.append(nameh5);


    // Answer content
  var answercontent = document.createElement("div");
  answercontent.classList.add('answer-content');
    answeritem.append(answercontent);

  //Answer body
  var answerpara = document.createElement("p");
    answerpara.textContent = myjson[i].string;
  answercontent.append(answerpara);
  answeritem.append(answercontent);


}

}


$( "textarea.Ask" ).focusin(function() {
    // $(this).parent('div').parent('div').css('background','white');
    
    // $(this).parent('div').addClass('focused');

    console.log("Ask selected");
}).focusout(function(){

    // $(this).parent('div').removeClass('focused');
    // $(this).parent('div').css('background','transparent');
});

