 $(document).ready(function(){
 console.log("Ready");
 //$("#myModals").modal('show');
 // 	$('ul.tabs').tabs({
	//   swipeable: true,
	//   responsiveThreshold: Infinity
	// });

//$('.fixed-action-btn.toolbar').openToolbar();

//  function makeExpandingArea(container) {
//  var area = container.querySelector('textarea');
//  var span = container.querySelector('span');
//  if (area.addEventListener) {
//    area.addEventListener('input', function() {
//      span.textContent = area.value;
//    }, false);
//    span.textContent = area.value;
//  } else if (area.attachEvent) {
//    // IE8 compatibility
//    area.attachEvent('onpropertychange', function() {
//      span.innerText = area.value;
//    });
//    span.innerText = area.value;
//  }
// // Enable extra CSS
// container.className += "active";
// }var areas = document.querySelectorAll('.expandingArea');
// var l = areas.length;while (l--) {
//  makeExpandingArea(areas[l]);
// }

// var chip = {
//     tag: 'chip content',
//     image: '', //optional
//     id: 1, //optional
//   };

// $(document).ready(function(){
//     $('.sidenav').sidenav();
//   });

document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('.sidenav');
   var instances = M.Sidenav.init(elems, options);
   console.log("clicked - nav");
 });


$('.chips').material_chip();
  $('.chips-initial').material_chip({
    data: [{
      tag: 'Physics',
    }, {
      tag: 'Chemistry',
    }, {
      tag: 'Math',
    },{
      tag: 'English',
    },{
      tag: 'Biology',
    },{
      tag: 'General Knowledge',
    }],
  });
  $('.chips-placeholder').material_chip({
    placeholder: 'Enter a tag',
    secondaryPlaceholder: '+Tag',
  });
  $('.chips-autocomplete').material_chip({
    autocompleteOptions: {
      data: {
        'Physics': null,
        'Chemistry': null,
        'Math': null,
        'English': null,
        'Biology': null
      },
      limit: Infinity,
      minLength: 1
    }
  });


  $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      hover: true, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: false, // Displays dropdown below the button
      alignment: 'left', // Displays dropdown with edge aligned to the left of button
      stopPropagation: false // Stops event propagation
    }
  );



  });
