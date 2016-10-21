$( document ).ready(function() {

  $( '#dl-menu' ).dlmenu({
	  animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
  });

  $( '#sidr' ).dlmenu({
	  animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
  });
  $('#dl-menu button.dl-trigger, #dl-menu .closeMenuMobile').click(function() {
	$('#dl-menu .closeMenuMobile').toggleClass('showCloseButton');
	// $('body').toggleClass('fixingBackground');


  });


 // var floater = false;
 //  $('.visible-xs.visible-sm #dl-menu button.dl-trigger, .visible-xs.visible-sm #dl-menu .closeMenuMobile').click(function(){
 //    var top = $(window).scrollTop();
 //    var left = $(window).scrollLeft()
 //    if(!floater){
 //      $('body').css('overflow', 'hidden');
 //      $('.containerBanner').css('overflow', 'hidden');
      
 //      $(window).scroll(function(){
 //        $(this).scrollTop(top).scrollLeft(left);
 //      });
 //    } else {
 //      $('body').css('overflow', 'auto');
 //      $('.containerBanner').css('overflow', 'auto');
 //      $(window).unbind('scroll');
 //    }
    
 //    floater = !floater;
 //  });







  $( ".roundedImages" ).find( "img" ).addClass( "img-circle" );


   //$(this).parents(".in").addClass('selected');
   $(".panel-heading").click(function(){

	setTimeout(function(){
	  $(".panel-heading").each(function(){
		if( $(this).next().hasClass('in') ) {
		  $(this).addClass("panel-active");
		}
		else {
		  $(this).removeClass("panel-active");
		}
	  });
	}, 400);



   });



  });

$(".fullWrap h2").each(function(){
  $(this).click(function(){
	 $(this).toggleClass("openBox");
	$(this).parent().next().find(".tab-v1").toggleClass("showBox");
	$(this).parent().next().find(".panel-group").toggleClass("showBox");

	});

});
$(".fullWrap h3").each(function(){
  $(this).click(function(){
	 $(this).toggleClass("openBox");
	 $(this).parent().next().find(".tab-v1").toggleClass('showBox');
	 $(this).parent().next().find(".panel-group").toggleClass('showBox');


	 /*

	$(this).parent().next().find(".tab-v1").toggle('500', function() {
		$(this).toggleClass('showBox');
	  });

	$(this).parent().next().find(".panel-group").toggle('500', function() {
		$(this).toggleClass('showBox');
	  });
*/

	});

});



$('.productsBox a.viewProducts').each(function(){
	  $(this).click(function(){
		$(this).parent().parent().parent().parent().parent().parent().next().slideToggle('200', function() {
			$(this).toggleClass('showBox');
		});

	});
});


$('.owl-item').each(function(){
	  e.preventDefault;
	  $(this).click(function(){
	   
		$(this).child().toggleClass('active');
	  

	});
});




  $().ready(function() {
  //$('.truncateContent').truncate({max_length: 256});

// $(".relativeTriggerButton, .closeBox i").click(function() {
//   $('#ajax-content-wrap .fullscreen-header').toggleClass("relativeBox");
//   // return false;
// });


  // $('#simple-menu').sidr();
  // $('.closeBox i').sidr();

$("#showLeft").click(function() {
  // $('#ajax-content-wrap .fullscreen-header').toggleClass("relativeBox");
  // return false;
});

$('#sidr').hide();
$('#sidr').addClass("sidr left cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left").show();
$('#ajax-content-wrap .fullscreen-header').addClass("relativeBox");


  var menuLeft = document.getElementById( 'sidr' ),
	body = document.body;

  showLeft.onclick = function() {
	classie.toggle( this, 'active' );
	classie.toggle( menuLeft, 'cbp-spmenu-open' );
	disableOther( 'showLeft' );
  };

  var menuLeftClose = document.getElementById( 'sidr' ),
	body = document.body;

  closeMenuLeft.onclick = function() {
	classie.toggle( this, 'active' );
	classie.toggle( menuLeftClose, 'cbp-spmenu-open' );
	disableOther( 'closeMenuLeft' );
  };


//add class video-open to link on mobile version
$('#pageID_81 .visible-xs.visible-sm .text h3 a').addClass("video-open");


  //Change Title in dl-menu
  var backLink = $('.dl-back').find('a');
	$(backLink).each(function(){
	  var titleText = $(this).parent().parent().prev().attr('title');
	  $(this).text(titleText);
	});

//ScrollTo for aboutMenu div
  $(".aboutMenu a, #selectBoxMenu").click(function(event){
	   event.preventDefault();
	 //calculate destination place
	 var dest=0;
	 if($(this.hash).offset().top > $(document).height()-$(window).height()){
		  dest=$(document).height()-$(window).height();
	 }else{
		  dest=$(this.hash).offset().top;
	 }
	 //go to destination
	 $('html,body').animate({scrollTop:dest-128}, 1000,'swing');
  });

  // $(".aboutMenu li a").click(function(event){
  //      event.preventDefault();
  //      $('.aboutMenu li').removeClass('active');
  //      $(this).parent().addClass('active');
  // });


//scrollTo for select list About Us page
  // $("#selectBoxMenu").click(function(){
  //    $(this).find("option").eq(someMiddleNumber).focus().blur();
  // });




$(".tx-indexedsearch-res .tx-indexedsearch-res").click(function() {
  window.location = $(this).find("a").attr("href");
  return false;
});

if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 $(".truncateMobile .fullWrap").addClass("mobileWrap");

  $('.mobileWrap').truncate({max_length: 158});

  $(".products").each(function(){
	   $(this).find('.textBox').insertAfter($(this).find('.imageBox').next());
	   //$('.clearfix').remove();

  });

  $('.productsBox a.viewProducts').each(function(){
	  $(this).click(function(){
		$(this).toggleClass("openBox");


	});




});


}
//setup

if (typeof window_resize != 'undefined') { // Avoid generating errors

	window.onresize = function(event) {
		window_resize(event);
	}

}

$('#navbar').headtacular({ scrollPoint: 0 });

  var heightX = $( window ).height();
  // console.log('heightX='+heightX);

$('#pageID_1 #navbar').headtacular({ scrollPoint: (heightX - 64) });
$('#pageID_1 .inverstorsLink').headtacular({ scrollPoint: (heightX - 74) });

$("*[class^='html5gallery-elem-']").children().next().next().addClass( "logoOut");


  $("*[class^='html5gallery-tn'], .html5gallery-right-0, .html5gallery-left-0").click(function(event){
	  event.preventDefault();
	  $("*[class^='html5gallery-elem-']").children().next().next().addClass( "logoOut");
  });

});



function addContainerBox() {
  //$(".slides").addClass( "container");

}
setTimeout(addContainerBox, 50);


function addContainerBoxControls() {
  $(".owl-controls").addClass( "container");

}
setTimeout(addContainerBoxControls, 1000);




// $("#simple-menu").click(function() {
//   $('.fullscreen-header').togleClass("relativeBox");
// };



function randOrd() {
	return (Math.round(Math.random())-0.5);
}

$(document).ready(function() {
	var klasses = [ 'background1', 'background3' ];
	klasses.sort( randOrd );
	$('.containerBanner').each(function(i, val) {
		$(this).addClass(klasses[i]);
	});
});

$(window).scroll(function () {
	if($(this).scrollTop() > 0)
	{
		if (!$('.navbar').hasClass('fixed'))
		{
			$('.navbar').stop().addClass('fixed').css('top', '-64px').animate(
				{
					'top': '0px'
				}, 1);
		}
	}
	else
	{
		$('.navbar').removeClass('fixed');
	}
});



// $("#c781").click(function() {
//   window.location = $(this).find("a").attr("href");
//  return false;
//  });

// $("#c466 .col-md-6").click(function() {
//   window.location = $(this).find("a").attr("href");
//  return false;
//  });

// $("#c782").click(function() {
//   window.location = $(this).find("a").attr("href");
//  return false;
//  });

// $("#c489 .col-md-6").click(function() {
//   window.location = $(this).find("a").attr("href");
//  return false;
//  });

$(".productHomeBox").click(function() {
  window.location = $(this).find("a[href]").attr("href");
 return false;
 });


$('.main-section').click(function() {
   $('#sidr').removeClass('cbp-spmenu-open');
   $('#sidr').prev().find('.closeMenuMobile').removeClass('showCloseButton');
});
$('#ajax-content-wrap').click(function() {
   $('#sidr').removeClass('cbp-spmenu-open');
   $('#sidr').prev().find('.closeMenuMobile').removeClass('showCloseButton');
  
});

$('#indexedsearch').click(function() {
   $('.searchBox').addClass('searchActive');
});

$('ul.dl-submenu li').not('.dl-back').click(function() {
   $('#sidr').removeClass('cbp-spmenu-open');
   

   $('#dl-menu .closeMenuMobile').toggleClass('showCloseButton');
   $('#dl-menu .closeMenuMobile').trigger('click');
   $('#dl-menu .closeMenuMobile').toggleClass('showCloseButton');


});

// $('ul.dl-submenu li').not('.dl-back').trigger();

$(window).on("hashchange", function () {
	window.scrollTo(window.scrollX, window.scrollY - 70);
});

// $('.cbp-spmenu-open').click(function(event){
//    event.stopPropagation();
// });


// $(function() {
//   $('a[href*=#]:not([href=#])').click(function() {
//     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
//       var target = $(this.hash);
//       target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
//       if (target.length) {
//         $('html,body').animate({
//           scrollTop: target.offset().top - 70
//         }, 1000);
//         return false;
//       }
//     }
//   });
// });