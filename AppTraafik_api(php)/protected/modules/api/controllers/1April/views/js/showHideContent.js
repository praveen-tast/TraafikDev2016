$(document).ready(function(){

    $(".itemWraper").each(function(){
    	var $this_ = $(this);
    	var show = 0;
    	$(this).find(".showLink").click(function(){
 
       		$this_.find(".hiddenContent").toggleClass("showBox");
       		if(show == 0) {
       			$(this).html('less');
       			show = 1;
       		}
       		else {
       			$(this).html('more');
       			show = 0;
       		}
     	});

    });	


});
