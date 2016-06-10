
$(document).ready(function() {


   
$('.navbar-default li a[href*=#]').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top -90
    }, 500);
    return false;
	
});

jQuery('.navbar-collapse ul li a').on("click", function() {
		jQuery('.navbar-toggle:visible').click();
	});
	

	if($('.sigle-boat-slider').length){
		$('.sigle-boat-slider').slick({
			 arrows: true,
			 autoplay:true
		});
	}

	if($(".chosen,.chosen-no-search").length){
		$(".chosen").chosen({
			// disable_search_threshold: 10,
			no_results_text: "Oops, nothing found!",
		  });
		  $(".chosen-no-search").chosen({
			disable_search_threshold: 10,
			no_results_text: "Oops, nothing found!",
		  });
	}
	  
	  
	  
});

// Customs script

$(document).ready(function () {
	
	$('[data-toggle="tooltip"]').tooltip();
	
	$('.datepicker').datetimepicker({
             format: "DD/MM/YYYY"        
    });

    $('.timepicker').datetimepicker({
		format: 'LT'
	});
	
	$('#reserve-date').datetimepicker({
		 format: "DD/MM/YYYY"        
	 });

	$('#time_period, #today_time_period').datetimepicker({
		format: 'LT'
	});
	
	$("#reserve-date-check").on("click",function(){
		
		if($(this).prop('checked')){
			$(".reservation-date-time").slideDown();
			$("#today_time_period").attr("disabled","disabled");
		}
		else{
			$(".reservation-date-time").slideUp();
			$("#today_time_period").removeAttr("disabled","disabled");
		}
	});

	
	$(".check-btn").on("click",function(){
		
		$(this).closest('.check-btn-group').find('.check-block').removeClass('selected');
	
		if($(this).prop('checked')){
			$(this).closest('.check-block').addClass('selected');
		}
	});
	
	
	// $( ".rangeSlider" ).slider({
		// range: true,
		// values: [ 0, 1000 ]
	// });


    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        // some code..
    } else {
        // $('#navbar-collapse-1 .dropdown-toggle').removeAttr('data-toggle');
    }


});




