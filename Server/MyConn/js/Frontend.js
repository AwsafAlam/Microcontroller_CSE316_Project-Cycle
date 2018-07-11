var unidiv = "CollapseBody";
var ourdiv = "None";
var flag = "0";
var vlu = 0;
var uidtrue="";

function loadus() { //alert("0");
    window.location.href = "aboutus.html";
}

function getBrowserSize() {
    var w, h;

    if (typeof window.innerWidth != 'undefined') {
        w = window.innerWidth; //other browsers
        h = window.innerHeight;
    } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
        w = document.documentElement.clientWidth; //IE
        h = document.documentElement.clientHeight;
    } else {
        w = document.body.clientWidth; //IE
        h = document.body.clientHeight;
    }
    return {
        'width': w,
        'height': h
    };
}


$(window).on("scroll", function () {
    var scrollHeight = $(document).height();
    var scrollPosition = $(window).height() + $(window).scrollTop();
    // alert(scrollHeight);
    if (scrollPosition >= scrollHeight - 100 && vlu == 0) {
        //alert("misu");
        vlu = 1;
        if (unidiv == "CollapseBody")
            parsingAllQuestions("1", unidiv);
        else if (unidiv == "CollapseBody1")
            parsingAllQuestions("hscs", unidiv);
        else if (unidiv == "CollapseBody2")
            parsingAllQuestions("sscs", unidiv);
        else if (unidiv == "CollapseBody4")
            parsingAllQuestions(uid, unidiv);
        localStorage.setItem(unidiv.concat("scroll"), 1);

        // when scroll to bottom of the page
    } else if (scrollPosition < scrollHeight - 100) {
        vlu = 0;
    }
})






/*$(window).on('scroll', function(){

    //get the viewport height. i.e. this is the viewable browser window height
    var clientHeight = document.body.clientHeight,
        //height of the window/document. $(window).height() and $(document).height() also return this value.
        windowHeight = $(this).outerHeight(),
        //current top position of the window scroll. Seems this *only* works when bound inside of a scoll event.
        scrollY = $(this).scrollTop();

    if( windowHeight - clientHeight === scrollY )
		{
	    //alert("miss");
		if(unidiv=="CollapseBody")
		  parsingAllQuestions("1",unidiv);
	    else if(unidiv=="CollapseBody1")
		  parsingAllQuestions("hscs",unidiv);
        else if(unidiv=="CollapseBody2")
		  parsingAllQuestions("sscs",unidiv);
	    else if(unidiv=="CollapseBody4")
		  parsingAllQuestions(uid,unidiv);
        localStorage.setItem(unidiv.concat("scroll"),1);  	  
			
		// when scroll to bottom of the page
	}
	
	});

/*$(window).on("scroll", function() {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if($(window).scrollTop() + $(window).height() == $(document).height()) 
});*/

function redirects() {
    var str = "http://www.onlinesohopathi.com/index.html";
    //str=str.concat(quesidss);
    window.location.replace(str);

}


function checkLog() {

    if (uid != "hiru") {
        loadallprofiles(uid);
    }
}

function checkuser() {

    if (uid != "hiru") {
        location.href = "http://www.onlinesohopathi.com/myquestion.html";
    } else
        location.href = "http://www.onlinesohopathi.com/fblogin.html";
}

function checkFacebook() {
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            location.href = "http://www.onlinesohopathi.com/myquestion.html";

        } else {

        }
    });

}

$("#myModals").on('show.bs.modal', function () {


    if (uid != "hiru") {

        $('#myModals').modal('hide');

        loadallprofiles(uid);
    }


});

function fetchUserDetail(alldivss) {
    FB.api('/me', function (response) {
        uid = response.id;
        //alert("Name: "+ response.name + "\nFirst name: "+ response.first_name + "ID: "+response.id);
        if (alldivss.id == "myModals")
            logger(response.id);

        else if (alldivss.id == "myModalm") {
            uid = response.id;
            $("#myModalm").modal("hide");
            parsingAllQuestions(response.id, "CollapseBody4");

        } else {
            loadallprofiless(quesd, unidiv, response.id);

        }



    });


}

function checkFacebookLogin(alldiv) {
    $("#myModalss").modal("hide");
    $("#myModals").modal("hide");
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            fetchUserDetail(alldiv);

        } else {

        }
    });

}


function logger(pqs) {
    uid = pqs;
    if (uid != "hiru") {

        $("#myModals").modal("hide");
    }
    //alert("HOG");
    loadallprofiles(uid);




}

function loggers(pqs) {
    uid = pqs;
    //alert("HOG");
    uploadanswers(quesd);


    if (uid != "hiru") {
        $("#myModalss").modal("hide");

    }

}





/*$(".dropdown-content li a").click(function(){
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

   });*/



$("#image-picker").change(function (event) {
    console.log("Clicked");
    readURLs(this, "img-grid");
});

function readURLs(input, imgdiv) {
    var imgdiv = document.getElementById(imgdiv);


    var curFiles = input.files;
    var b64string = "hello!@1";
    var q = 0,
        start;

    console.log(curFiles);

    if (curFiles != 0) {
        var list = document.createElement("ul");
        list.style.cssText = 'margin: 0 auto; text-align: center;'

        imgdiv.appendChild(list);
        var l = 2;
        for (var i = 0; i < curFiles.length; i++) {
            var listItem = document.createElement("li");
            var bstring;
            listItem.style.cssText = 'display: inline-block; vertical-align: top;'

            var para = document.createElement("p");
            l = 2;
            para.id = "paras";
            para.textContent = "File name " + curFiles[i].name + ".";
            var image = document.createElement("img");

            //image.src = window.URL.createObjectURL(curFiles[i]);
            if (localStorage.getItem("count") === null) {
                q = 1;
            } else {
                q = Number(localStorage.getItem("count")) + 1;
            }

            var FR = new FileReader();
            FR.addEventListener("load", function (e) {
                image.src = e.target.result;
                bstring = e.target.result;
                //alert(bstring);
                localStorage.setItem(q, bstring);
                l = 1;
            });

            FR.readAsDataURL(input.files[i]);


            image.id = "shadman".concat(i);

            localStorage.setItem("count", q);

            //localStorage.setItem("start",start);

            //localStorage.setItem(q,b64string);
            //document.getElementById("paras").innerHTML="File name " + curFiles[i].name + ".";
            image.style.cssText = 'max-height:300px; width:auto';
            listItem.appendChild(image);
            listItem.appendChild(para);

            //var lst=getBase64Image(document.getElementById(image.id),listItm);
            list.appendChild(listItem);
        }

    }
}

$('#search').keypress(function (e) {
    if (e.which == 13) {
        e.preventDefault();
        //alert("HO");
        ourdiv = "yes";
        if (unidiv != "CollapseBody3")
            searchanswer(this.value, unidiv);
        else
            parsingAllBlogs(document.getElementById("search").value, "CollapseBody3");

        //do something   
    }
});

function loadhome(uidme) {
    queslid = "none";
    if (parseInt(getBrowserSize().width) < 1026) {
        //alert("ohl");
        document.getElementById("blogsCollapseBody1").style.visibility = "hidden";
        document.getElementById("blogsCollapseBody1").style.position = "absolute";
        document.getElementById("blogsCollapseBody1").style.left = "-9999px";
        document.getElementById("blogsCollapseBody").style.visibility = "hidden";
        document.getElementById("blogsCollapseBody").style.position = "absolute";
        document.getElementById("blogsCollapseBody").style.left = "-9999px";
        document.getElementById("blogsCollapseBody2").style.visibility = "hidden";
        document.getElementById("blogsCollapseBody2").style.position = "absolute";
        document.getElementById("blogsCollapseBody2").style.left = "-9999px";
    }
	uidtrue=uidme;
    //alert("ok");
    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);

    localStorage.removeItem("count");
    localStorage.setItem("CollapseBody".concat("scroll"), 0);

    parsingAllQuestions("0", "CollapseBody");



};

$(".Homes").ready(function () {
    queslid = "none";
    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);

    localStorage.removeItem("count");
    localStorage.setItem("CollapseBody".concat("scroll"), 0);
    localStorage.setItem("CollapseBody1".concat("scroll"), 0);
    localStorage.setItem("CollapseBody2".concat("scroll"), 0);

    //parsingAllQuestions("0", "CollapseBody");



});

function loadhsc(uidme) {
    queslid = "none";
    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);

    localStorage.removeItem("count");
    localStorage.setItem("CollapseBody1".concat("scroll"), 0);
	uidtrue=uidme;

    parsingAllQuestions("hsc", "CollapseBody1");
    //parsingAllBlogs("CollapseBody1");
    //LoadBlog();


};

function loadssc(uidme) {
    queslid = "none";
    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);
    uidtrue=uidme;
    localStorage.removeItem("count");
    localStorage.setItem("CollapseBody2".concat("scroll"), 0);

    parsingAllQuestions("ssc", "CollapseBody2");
    //parsingAllBlogs("CollapseBody2");

    //LoadBlog();


};

$(".BLOGS").ready(function () {
    queslid = "none";



    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);

    localStorage.removeItem("count");

    //parsingAllQuestions("ssc","CollapseBody2");
    //alert(parseInt(getBrowserSize().width));
    parsingAllBlogs("0", "CollapseBody3");

    //LoadBlog();


});

$(".Notification").ready(function () {

    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);

    localStorage.removeItem("count");

    /*FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
            uid=response.id;
			parsingAllNotis(uid);
			
			
          } 
          else 
          {
            alert("To view notifications: 1. Login to Facebook. 2. Reload this page. ");
          }
         });*/



    //LoadBlog();


});

function loadmyquestions(uidme) {
    queslid = "none";
    for (var i = 1; i <= 30; i++)
        localStorage.removeItem(i);
    uidtrue=uidme;
    localStorage.removeItem("count");
    localStorage.setItem("CollapseBody4".concat("scroll"), 0);

    //parsingAllQuestions("ssc","CollapseBody2");



    //LoadBlog();


};


var blogs = document.getElementById('blogs'); // Inside html div class="conta"

function loadAllNotis(uides, myobb, divgg) {
    var myObjn = JSON.parse(myobb);
    //savedivs=coldiv;
    var CollapseBodys = document.getElementById(divgg);

    //alert(coldiv);
    var i, j, k, l, m;
    console.log(myObjn.length);
    var Nots = document.getElementById("Nott");
    Nots.textContent = "Notifications" + "(" + myObjn.length + ")";
    for (i = 0; i < myObjn.length; i++) {


        var listItems = document.createElement("li");
        listItems.id = "notif".concat(myObjn[i].id);
        var noticeid = "notif".concat(myObjn[i].id);

        CollapseBodys.appendChild(listItems);

        var QuestionTitles = document.createElement("div");
        QuestionTitles.classList.add('questioncard');
        QuestionTitles.classList.add('collapsible-header');
        //QuestionTitle.textContent = "Do native English speakers ever notice that someone isn't a native speaker despite speaking fluently? If yes, how?";
        listItems.appendChild(QuestionTitles);

        var Profilepics = document.createElement("img");
        //alert(myObj[i].anonymous);

        Profilepics.src = "img/notification.svg";
        Profilepics.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
        QuestionTitles.appendChild(Profilepics);

        var creadivs = document.createElement("div");


        creadivs.textContent = "Question Id->" + myObjn[i].id + ": You have a new reply to a question you are following ";
        QuestionTitles.appendChild(creadivs);

        viewnotifiedquestion(uides, noticeid);

    }
}

function LoadBlog(myObjss, divg) {
    //alert("blg");
    var allr = 'blogs'.concat(divg);
    var myNode = document.getElementById(allr);
    //<h3 class="text-lighten-4"><strong >Blog Posts</strong></h3>
    var head = document.createElement("h3");
    head.classList.add = "text-lighten-4";
    var header = document.createElement("strong");
    header.textContent = "Blog Posts";
    head.appendChild(header);

    if (divg == "CollapseBody3") {
        while (myNode.firstChild)
            myNode.removeChild(myNode.firstChild);
    }
    myNode.appendChild(head);
    var myObjr = JSON.parse(myObjss);
    for (var it = 0; it < myObjr.length; it++) {
        var alls = 'blogs'.concat(divg);
        if (it == myObjr.length - 1)
            localStorage.setItem("bloglast", myObjr[it].id);
        var blogs = document.getElementById(alls);
        //if(it==0)alert(myObjr[it].username);
        var blogContainer = document.createElement("div");
        blogContainer.style.cssText = 'cursor: pointer;';
        vals = divg.concat("blog");
        var rest = vals.concat(myObjr[it].id);
        blogContainer.id = vals.concat(myObjr[it].id); // Need to be assigned
        blogContainer.classList.add('timeline-item');


        var blogProfilePic = document.createElement("div");
        blogProfilePic.classList.add('cd-timeline-img');


        var blogimg = document.createElement("img");
        blogimg.src = "img/account_circle.svg";
        blogProfilePic.appendChild(blogimg);

        var writer = document.createElement("strong");
        writer.textContent = myObjr[it].username;
        blogProfilePic.appendChild(writer);
        var img = document.createElement("img");
        if (myObjr[it].id == "17")
            img.src = "http://198.211.96.87/v1/" + myObjr[it].userid + ".jpg";
        else
            img.src = "http://198.211.96.87/v1/blog" + myObjr[it].id + ".jpg";
        img.style.cssText = "height: 50%; width: 100%;";
        blogContainer.appendChild(img);
        var blogtitle = document.createElement("h5");
        var bold = document.createElement("b");
        bold.textContent = myObjr[it].title;
        bold.style.cssText = " color : #000000;";
        blogtitle.appendChild(bold);
        //blogtitle.textContent = 
        blogContainer.appendChild(blogtitle);
        blogContainer.appendChild(blogProfilePic);

        /*<div style="margin: 4px; margin-top: 15px; padding: 1px; position: absolute;">
          <span class="new badge red" data-badge-caption="Downvote">1</span>
          <span class="new badge teal" data-badge-caption="Upvote">2</span>
          <span class="new badge blue darken-4" data-badge-caption="Likes">4</span>
        </div>*/

        var blogextras = document.createElement("div");
        blogextras.style.cssText = "margin: 4px; margin-top: 15px; padding: 1px; position: absolute;";
        var downvote = document.createElement("span");
        downvote.classList.add('new');
        downvote.classList.add('badge');
        downvote.classList.add('red');
        downvote.textContent = "1 comment";
        blogextras.appendChild(downvote);

        var upvote = document.createElement("upvote");
        upvote.classList.add('new');
        upvote.classList.add('badge');
        upvote.classList.add('teal');
        upvote.textContent = "2 upvote";
        blogextras.appendChild(upvote);
        //blogContainer.appendChild(blogextras);



        blogs.appendChild(blogContainer);

        blogclick(rest, divg);



    }


}


function savediv(divid) {
    if (ourdiv == "yes") {

        if (unidiv == "CollapseBody")
            parsingAllQuestions("0", unidiv);
        else if (unidiv == "CollapseBody1")
            parsingAllQuestions("hsc", unidiv);
        else if (unidiv == "CollapseBody2")
            parsingAllQuestions("ssc", unidiv);
        else if (unidiv == "CollapseBody3") {
            var myNodes = document.getElementById("blogsCollapseBody3");

            parsingAllBlogs("0", unidiv);

        } else if (unidiv == "CollapseBody4") {
            parsingAllQuestions(uid, "CollapseBody4");
        }

    } else {
        if (divid == "CollapseBody4") {
            if (uid == "hiru") {
                flag = "1";
                // alert("OH");
                $('#myModalm').modal('show');
            } else if (flag == "0") {
                flag = "1";
                parsingAllQuestions(uid, "CollapseBody4");
            }
        } else if (divid == "Notifydiv") {
            /*if(uid=="hiru")
		 alert("To view notifications: 1. Login to Facebook. 2. Reload this page. ");
	 else
		 parsingAllNotis(uid);*/

        }
    }
    unidiv = divid;
    document.getElementById("search").value = "";
    ourdiv = "None";
    //alert(unidiv);

}




function loadallquestions(myObjs, coldiv) {
    // body...
    // alert(coldiv);
    var myObj = JSON.parse(myObjs);
    //savedivs=coldiv;
    var CollapseBody = document.getElementById(coldiv);

    //alert(CollapseBody.id);
    var i, j, k, l, m;
    console.log(myObj.length);

    for (i = 0; i < myObj.length; i++) {

        if (i == myObj.length - 1) {
            queslid = "OK";
            localStorage.setItem(coldiv, myObj[i].id);
        }
        var listItem = document.createElement("li");
        CollapseBody.appendChild(listItem);

        var QuestionTitle = document.createElement("div");
        QuestionTitle.classList.add('questioncard');
        QuestionTitle.classList.add('collapsible-header');
        //QuestionTitle.textContent = "Do native English speakers ever notice that someone isn't a native speaker despite speaking fluently? If yes, how?";
        listItem.appendChild(QuestionTitle);

        var Profilepic = document.createElement("img");
        //alert(myObj[i].anonymous);
        if (myObj[i].notification == "0")
            Profilepic.src = myObj[i].fbpics;
        else
            Profilepic.src = "img/account_circle.svg";
        Profilepic.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
        QuestionTitle.appendChild(Profilepic);

        var creadiv = document.createElement("div");

        if (myObj[i].notification == "0")
            creadiv.textContent = "Q" + myObj[i].id + "." + (myObj[i].username) + " asked: ";
        else
            creadiv.textContent = "Q" + myObj[i].id + "." + "Somebody" + " asked: ";

        var creatitl = document.createElement("p");
        creatitl.textContent = "     ".concat(myObj[i].title);
        creatitl.style.cssText = "font-weight: bold;";
        creadiv.appendChild(creatitl);


        var ViewsDiv = document.createElement("div");
        ViewsDiv.style.cssText = 'margin: 4px; margin-top: 15px; padding: 1px; position: absolute;';
        creadiv.appendChild(ViewsDiv);

        var ViewsSpan = document.createElement("span");
        ViewsSpan.setAttribute("data-badge-caption", "");
        ViewsSpan.classList.add('new');
        ViewsSpan.classList.add('badge');
        ViewsSpan.textContent = (myObj[i].tags).toUpperCase();
        ViewsDiv.appendChild(ViewsSpan);

        var AnsSpan = document.createElement("span");
        AnsSpan.setAttribute("data-badge-caption", " Answers");
        AnsSpan.classList.add('new');
        AnsSpan.classList.add('badge');
        AnsSpan.classList.add('grey');
        var and = myObj[i].answers;
        AnsSpan.textContent = and.length;
        ViewsDiv.appendChild(AnsSpan);

        var SubSpan = document.createElement("span");
        SubSpan.setAttribute("data-badge-caption", "");
        SubSpan.classList.add('new');
        SubSpan.classList.add('badge');
        SubSpan.classList.add('red');
        var ands = myObj[i].question;
        SubSpan.textContent = ands;
        ViewsDiv.appendChild(SubSpan);

        QuestionTitle.appendChild(creadiv);




        var Description = document.createElement("div");

        var des = "q".concat(coldiv);
        Description.id = des.concat(myObj[i].id);
        Description.classList.add('collapsible-body');
        listItem.appendChild(Description);

        var DescText = document.createElement("span");
        DescText.textContent = "Subject: ".concat(myObj[i].question);
        Description.appendChild(DescText);
        str = myObj[i].image;

        var images = str.split(",");

        var urls;
        for (j = 0; j < images.length; j++) {
            if (images[j].length == 0) continue;

            urls = 'http://198.211.96.87/v1/'.concat(images[j]);


            var qimgdiv = document.createElement("div");
            qimgdiv.classList.add('flexbin');
            qimgdiv.classList.add('flexbin-margin');
            var qimg = document.createElement('img');
            qimg.style.cssText = 'max-width: 100%; max-height: 400px; height:auto; width:auto;  ';
            qimg.src = urls;
            $('.materialboxed').materialbox();
            qimg.classList.add('materialboxed');
            qimgdiv.id = images[j].concat(coldiv);
            dividss = images[j];
            //loadimgques(dividss,coldiv);
            qimgdiv.appendChild(qimg);
            Description.appendChild(qimgdiv);

        }

        var ansdiv = document.createElement("div");
        ansdiv.classList.add('conta');
        var acount = document.createElement('h5');

        //Answer starts loading here

        var anss = myObj[i].answers;
        acount.textContent = anss.length + " answers";
        ansdiv.appendChild(acount);
        Description.appendChild(ansdiv);

        for (k = 0; k < anss.length; k++) {

            //var profs=loadallprofiles(anss[k].answer_id);
            var timediv = document.createElement("div");
            timediv.classList.add('timeline-item');
			var vl = "time".concat(k);
            vl = vl.concat(coldiv);
            timediv.id = vl.concat(myObj[i].id);
            var subdiv = document.createElement("div");
            subdiv.classList.add('cd-timeline-img');
            var anspro = document.createElement('img');
            anspro.src = anss[k].fbimg;
            anspro.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
            subdiv.appendChild(anspro);
            var ansname = document.createElement('strong');
            ansname.textContent = (anss[k].username).concat(" replied: ");
            subdiv.appendChild(ansname);
            timediv.appendChild(subdiv);
            var anspara = document.createElement("p");
            anspara.textContent = anss[k].string;
            timediv.appendChild(anspara);


            Description.appendChild(timediv);



            var strs = anss[k].image;
            var imagess = strs.split(",");
            var urlss;
            for (l = 0; l < imagess.length; l++) {


                if (imagess[l].length == 0) continue;
                var qimgdivs = document.createElement("div");
                var matdivs = document.createElement("div");
                urlss = 'http://198.211.96.87/v1/'.concat(imagess[l]);

                qimgdivs.classList.add('flexbin');
                qimgdivs.classList.add('flexbin-margin');
                matdivs.classList.add('material-placeholder');

                var qimgs = document.createElement('img');

                qimgs.style.cssText = 'max-width: 100%; max-height: 400px; height:auto; width:auto;   ';



                qimgs.src = urlss;
                $('.materialboxed').materialbox();
                qimgs.classList.add('materialboxed');
                qimgdivs.id = imagess[l].concat(coldiv);
                dividsss = imagess[l];
                //loadimgans(dividsss,coldiv);
                matdivs.appendChild(qimgs);
                qimgdivs.appendChild(matdivs);
                timediv.appendChild(qimgdivs);
            }
            var likediv = document.createElement("div");
			var vl = "like".concat(k);
            vl = vl.concat(coldiv);
            likediv.id = vl.concat(myObj[i].id);
          //  likediv.style.cssText = " margin: 4px; padding: 1px; position: absolute; ";
            var ViewsSpan = document.createElement("span");
            ViewsSpan.setAttribute("data-badge-caption", " Upvotes");
            ViewsSpan.classList.add('new');
            ViewsSpan.classList.add('badge');
            ViewsSpan.textContent = "0";
            likediv.appendChild(ViewsSpan);

            var AnsSpan = document.createElement("span");
            AnsSpan.setAttribute("data-badge-caption", " Downvotes");
            AnsSpan.classList.add('new');
            AnsSpan.classList.add('badge');
            AnsSpan.classList.add('grey');
            AnsSpan.textContent = "0";
            likediv.appendChild(AnsSpan);

            if(uid==anss[k].userid){
            var del = document.createElement("span");
            del.setAttribute("data-badge-caption", " Delete");
            del.classList.add('new');
            //   del.classList.add('badge');
            del.classList.add('red');
            del.textContent = "  Delete  ";
            var vl = "del".concat(k);
            vl = vl.concat(coldiv);
            del.id = vl.concat(myObj[i].id);
            likediv.append(del);
            }
            Description.appendChild(likediv);
			if(uid==anss[k].userid){
			 //alert(timediv.id);	
             delansid(del.id, timediv.id, likediv.id, anss[k].answer_id);
            }
            
        }


        var timedivs = document.createElement("div");
        timedivs.classList.add('timeline-item');
        var myimg = document.createElement('div');
        myimg.style.cssText = "margin-top:15 px;";
        myimg.classList.add('cd-timeline-img');
        var proimgs = document.createElement('img');
        proimgs.src = "img/account_circle.svg";
        proimgs.style.cssText = 'border-radius: 50%;width: 40px; height: 40px; margin-right:10px;';
        var strngme = document.createElement('strong');
        strngme.textContent = "Myself";
        myimg.appendChild(proimgs);
        myimg.appendChild(strngme);
        timedivs.appendChild(myimg);


        var ansbox = document.createElement('div');
        var txtbox = document.createElement('textarea');
        txtbox.classList.add('materialize-textarea');
        var txtids = "ansboxx".concat(coldiv);
        txtbox.id = txtids.concat(myObj[i].id);
        txtbox.type = "text";
        txtbox.placeholder = "New Comment";
        ansbox.appendChild(txtbox);
        timedivs.appendChild(ansbox);
        var imganbt = document.createElement("button");
        imganbt.classList.add('waves-effect');
        imganbt.classList.add('waves-light');
        imganbt.classList.add('btn');
        var imgandbt = document.createElement("input");
        imgandbt.setAttribute("type", "file");
        imgandbt.accept = "image/*";
        var vll = "image-picker".concat(coldiv);
        imgandbt.id = vll.concat(myObj[i].id);
        imgandbt.style.cssText = "visibility: hidden; display: none;";
        var imgpick = "document.getElementById('image-picker').click()";
        var vlls = "anssub".concat(coldiv);
        imganbt.id = vlls.concat(myObj[i].id);
        var valuess = (myObj[i].id);
        var icn = document.createElement("i");

        icn.classList.add('fa');
        icn.classList.add('fa-camera');
        imganbt.appendChild(icn);
        var content = document.createTextNode("Image");
        imganbt.appendChild(content);
        imganbt.appendChild(imgandbt);




        timedivs.appendChild(imganbt);
        var subbt = document.createElement("button");
        subbt.classList.add('waves-effect');
        subbt.classList.add('waves-light');
        subbt.classList.add('btn');
        var vl = "submit".concat(coldiv);
        subbt.id = vl.concat(myObj[i].id);
        subbt.style.cssText = "margin-left: 10px;";
        subbt.type = "button";

        var buttonanswer = vl.concat(myObj[i].id);

        var icns = document.createElement("i");

        icns.classList.add('fa');
        icns.classList.add('fa-paper-plane');
        subbt.appendChild(icns);
        var contents = document.createTextNode("Submit");
        subbt.appendChild(contents);
        timedivs.appendChild(subbt);




        //document.add( '<button class=\"waves-effect waves-light btn\"><i class=\"fa fa-camera\"></i>Image</button>' );

        //button for answer image and submit goes here


        Description.appendChild(timedivs);

        //var mis=loadallprofiles(myObj[i].id);




        imagedisplay(valuess, coldiv);
        imagepreview(valuess, coldiv);



        submitbuttonforanswer(buttonanswer, coldiv);





    }

    if (ourdiv != "yes" && localStorage.getItem(coldiv.concat("scroll")) != 1 && parseInt(getBrowserSize().width) >= 1026)
        parsingAllBlogs("0", coldiv);


}





function delansid(delid, timedivid, likedivid, ansskanswer_id) {


    var el = document.getElementById(delid);
   // document.addEventListener('DOMContentLoaded', function () {
    
    
    el.onclick = function() {
              var answer = confirm("Delete  Answer?")
if (answer) {
    var elem1 = document.getElementById(timedivid);
            elem1.parentElement.removeChild(elem1);
            var elem2 = document.getElementById(likedivid);
            elem2.parentElement.removeChild(elem2);
            //  call a function of backend for deleting the specified answer by id from database

           deleteanswer(ansskanswer_id);
}
else {
    //some code
}

    }
    
}




function imagedisplay(objs, savedivs) {

    var objr = objs;
    objs = "anssub".concat(savedivs);
    objs = objs.concat(objr);
    document.getElementById(objs).addEventListener("click", function (event) {
        // image preview
        console.log("Clicked imageanswer...");
        var olb = "image-picker".concat(savedivs);
        olb = olb.concat(objr);
        document.getElementById(olb).click();




    });


}

function imagepreview(objss, savedivs) {

    var objc = objss;
    var orb = "image-picker".concat(savedivs);
    var orb = orb.concat(objc);

    document.getElementById(orb).addEventListener("change", function (event) {
        // image preview


        var values = "q".concat(savedivs);
        values = values.concat(objc);
        //alert(objs);
        readURLs(this, values);
        console.log("Clicked imagewer...");


    });


}

function blogclick(buttons, savdivs) {

    document.getElementById(buttons).addEventListener("click", function (event) {
        var strn = buttons;
        strn = strn.replace(savdivs.concat("blog"), "");
        // alert(strn);
        // body...
        if (strn == 17)
            var btr = "oneblog.html?filter=".concat(strn);
        else {
            var files = "blog" + strn + ".html";
            var btr = files + "?filter=" + strn;
        }

        location.href = btr;

    });

}

function viewnotifiedquestion(uidess, ideas) {

    document.getElementById(ideas).addEventListener("click", function (event) {
        var strn = ideas;
        strn = strn.replace("notif", "");
        // alert(strn);
        // body...

        var btr = "http://www.onlinesohopathi.com/onequestion.html?question=".concat(strn);
        updatenotifystate(uidess, strn);

        //location.href = btr;

    });

}



function submitbuttonforanswer(objl, savedivs) {


    document.getElementById(objl).addEventListener("click", function () {
        // Uploading Comment
        var alg = 'submit'.concat(savedivs);
        var qid = objl.replace(alg, '');
        quesd = qid;

        var stt = "#".concat(objl);
        if (uid == "hiru")
            $('#myModalss').modal('show');
        else
            loadallprofiless(quesd, savedivs, uid);
        //document.getElementById("myModalss").showModal(); 

        //uploadanswers(qid);

    });




}

function loadimgques(objl, savedivs) {
    alg = objl.concat(savedivs);

    document.getElementById(alg).addEventListener("click", function () {
        // Uploading Comment
        var algs = alg;
        algs = algs.replace(savedivs, '');
        algs = "http://198.211.96.87/v1".concat(algs);

        var stt = "#".concat(objl);
        if (uid == "hiru")
            $('#myModalss').modal('show');
        else
            loadallprofiless(quesd, savedivs, uid);
        //document.getElementById("myModalss").showModal(); 

        //uploadanswers(qid);

    });

}
