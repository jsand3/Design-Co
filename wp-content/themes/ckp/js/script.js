(function($)
{
	$(document).ready(function($)
	{
		// If not a mobile device
		if (! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
		{
			// Stellar Parallax
			$.stellar({
			 	positionProperty: 'transform',
			 	hideDistantElements: false,
			});

			// Take out tel links 
			$('.tel-link').attr('href', '/contact/');
		}

		// If it is a mobile device
		else
		{
			$('.back-to-top').hide();
		}

		// Sticky header
        $(window).on('scroll', function(){
            var fromTop = $(window).scrollTop();
            if (fromTop > 100) {
            	$('.navbar').addClass('alternate');
            }
            else {
            	$('.navbar').removeClass('alternate');
            }
        });

		// Mobile Dropdowns
		$('.menu-item-has-children .fa-angle-down').click(function(){
		    if ($(this).hasClass('fa-angle-down'))
		    {
		        $(this).next('ul').slideDown();
		        $(this).removeClass('fa-angle-down').addClass('fa-angle-up');
		    }
		    else {
		        $(this).next('ul').slideUp();
		        $(this).removeClass('fa-angle-up').addClass('fa-angle-down');            
		    }
		});

		// Smooth Anchor Jumps
		$('a[href*=#]:not([href=#])').click(function()
		{
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				if (target.length)
				{
					$('html,body').animate({
						scrollTop: target.offset().top
					}, 1000);
					return false;
				}
			}
		});

		// Office Select Dropdown Link
		$('.office-select').click(function(){
			if ($('.office-select-dropdown').hasClass('active'))
				$('.office-select-dropdown').slideUp().removeClass('active');
			else
				$('.office-select-dropdown').slideDown().addClass('active');
		});

		// Masonry Grid
		$('.blogs').imagesLoaded(function(){
			$('.blogs').masonry({
				columnWidth: '.grid-sizer',
				itemSelector: '.blog-column'
			});
		});
	
		// Slider
		$('.texts').owlCarousel({
			autoPlay: false,
			items: 1,
			singleItem: true,
			pagination: true,
			navigation: false,
		});

		// Carousel 
		$('.areas').owlCarousel({
			autoPlay: false,    
			items: 7,
			itemsDesktop: [1199,5],
			itemsDesktopSmall: [979,4],
			itemsTablet: [768,3],
			itemsMobile: [479,1],
			pagination: false,
			navigation: true,
			navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
		});

		//Meet the designers
		$('.big-designers').each(function(){
			$('.big-designers .designer-img-info:first').show();
		});

		$('.small-designers').each(function(){
			$('.small-designers .designers:first').addClass('active');
		});

		$('.small-designers .designers').click(function(){
		    	$('.designers').removeClass('active');
		    	//$(this).parents('.d1').find('.small-designers .designers').hide();
		        $(this).addClass('active');
		        var teamid = $(this).attr('id');
		        $('.big-designers .designer-img-info').hide();
		        $('.big-designers .'+teamid).fadeIn();
		        return false;
		});

		//Back To The Top Button
		if ( ($(window).height() + 100) < $(document).height() ) {
		    $('#top-link-block').removeClass('hidden').affix({
		        // how far to scroll down before link "slides" into view
		        offset: {top:100}
		    });
		}
	});
})(jQuery);