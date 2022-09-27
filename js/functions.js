const validateEmail = (email) => {
	return String(email)
	  .toLowerCase()
	  .match(
		/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
	  );
};

function checkMandatory() {
	var name = $('#name').val();
	var mail = $('#email').val();
	var ck01 = $('#ck01').prop('checked');
    var ck02 = $('#ck02').prop('checked');
    var ck03 = $('#ck03').prop('checked');

	if(!ck01) {
    	removeErrorBorder();
    	$('#ck01').parent().addClass('error_border');
	    return 0;
  	}
	// else if(!ck02) {
	// 	removeErrorBorder();
	// 	$('#ck02').parent().addClass('error_border');
	// 	return 0;
	// }
	// else if(!ck03) {
	// 	removeErrorBorder();
	// 	$('#ck03').parent().addClass('error_border');
	// 	return 0;
	// }
	// else if(name == '') {
	// 	removeErrorBorder();
	// 	$('#name').addClass('error_border');
	// 	return 0;
	// }
	// else if(!validateEmail(mail) || mail == '') {
	// 	removeErrorBorder();
	// 	$('#email').addClass('error_border');
	// 	return 0;
	// }
		
	return 1;
}

function removeErrorBorder() {
   $('label[for="ck01"]').removeClass('error_border');
   $('label[for="ck02"]').removeClass('error_border');
   $('label[for="ck03"]').removeClass('error_border');
   $('#name').removeClass('error_border');
   $('#email').removeClass('error_border');
}

$(function($) {
  $(document).ready(function() {
    var btn = $('.scroll_top');
    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
	
	$('.submit_form_audio').click(function(){
		//console.log("checkMandatory: "+checkMandatory());
      if(checkMandatory() == 0) {
    	  $('.message').addClass('error');
          $('.message').html('Bitte Pflichtfelder bestätigen');          
          return;
    	}
    	
      $('#recordingsList a.submit').attr('href','javascript:void(0)');
      $('#recordingsList a.submit')[0].click();
     })
  })
});

$(document).ready(function() {
  $("#goto").on('change', function(){
    name = $(this).val();
    console.log(name);
    var item = treeData.search('name', name);
    chart.drillTo(item);
  });

  // target = window.location.hash;
  // if(target) {
	// 	$("html, body").animate({scrollTop: 0}, 0);
  //       $('html, body').stop().animate({
  //           scrollTop: $(target).offset().top
  //       }, 2500, 'easeInOutExpo');
	// }
  
});
$(window).on("scroll", function() {
  setNavbar();
});
function setNavbar() {
  if($(window).scrollTop() > 50) $('.navbar').addClass('black');
  else $('.navbar').removeClass('black');
}
$(document).ready(function(){
	setNavbar();
});

jQuery(document).ready(function($) {
  function scrollToSection(event) {
    event.preventDefault();
    var $section = $($(this).attr('href')); 
    $('html, body').animate({
      scrollTop: $section.offset().top 
    }, 500);
  }
  $('[data-scroll]').on('click', scrollToSection);
  // $('.page-scroll').on('click', scrollToSection);
}(jQuery));

$(document).ready(function(){
  // if ($('.carousel').flickity != undefined) {
  //   var $carousel = $('.carousel').flickity();
  //   var isFlickity = true;
  //   
  //   if(window.matchMedia("(max-width: 767px)").matches){
  //     // The viewport is less than 768 pixels wide
  //     $carousel.flickity('destroy');
  //   } else{
  //     // The viewport is at least 768 pixels wide
  //   }
  // }
  
  $("ul.menu-circular a").click(function(e) {
     var data = $(this).attr('data');
   
   if(data != undefined) {
      $("ul.menu-circular").each(function(){
     var currentData = $(this).attr('data');
     
     if(data == currentData)
       $(this).show();
     else
       $(this).hide();
   })  
   }
  });

	target = window.location.hash;
	if(target) {
		$("html, body").animate({scrollTop: 0}, 0);
    $('html, body').stop().animate({
      scrollTop: $(target).offset().top - 100
    }, 500);
	}
    
});

$(function() {
    $('a.page-scroll').bind('click', function(event) {
	    var $anchor = $(this).attr('href');
      $anchor = $anchor.split('#');
    });
});

$(".menu-button-circular").click(function(e) {
  e.preventDefault();
});

$('body').imagesLoaded()
	.always( function( instance ) {
		// setTimeout(function () {
			$("#nest5, #waitbg, #mp").addClass("hide");
		// }, 500);
	})
	.done( function( instance ) {
	}
);
$(function($) {
	$("#movetop").on('click', function () {
		$("html, body").animate({scrollTop: 0}, 400);
	});
});

  // $('.submit').popoverButton({
  //   target: '#myPopover2'
  // });
  // 
  //          $('.btnGreen').popoverButton({
  //           target: '#myPopover2'
  //        });