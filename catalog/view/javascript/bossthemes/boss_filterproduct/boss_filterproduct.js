function checkDevices($module){
	if(getWidthBrowser() > 767){
		$('.content_tabs'+$module).show();
		$('.home_filter_content h3').addClass('color_active');
	}
	else {
		//$('.content_tabs'+$module).hide();
		$('.home_filter_content h3').removeClass('color_active');
		var $tabs = $(".head_tabs");
		$tabs.each(function() {
		
			//  Here we get the active element
			var parent = $(this).parent();
			if($(parent).hasClass('active')){
				
				var href = $(parent).find("a").attr("href");
				$(href).show();
				//break;
			}
		});
	}
}

function execCarousel($carousel,$limit,$width) {
	if ($(window).width() > 768) {
		var width = $width;
	}else{
		var width = 250;
	}
	
	$($carousel).carouFredSel({
		auto: {
			play: true,
			timeoutDuration: 3500,
		},
		responsive: true,
		width: '100%',
		height: 'variable',
		prev: $($carousel).attr("data-prev"),
		next: $($carousel).attr("data-next"),
		swipe: {
			onTouch : false
		},
		items: {
			width: width,
			height: 'variable',
			visible: {
				min: 1,
				max: $limit
			}
		},
		scroll: {
			direction : 'left',    //  The direction of the transition.
			duration  : 1500,   //  The duration of the transition.
			items: 2,
		}
	});
}

function initCarousel($use_tab,$module,$use_scrolling_panel,$limit,$width){
	if(!$use_tab) {
		
		//	Only init the carousel for the content in actived tab, because after click the tab, we will init it again
		var $tabs = $('.head_tabs'+$module);
		if($use_scrolling_panel) {
			$tabs.each(function() {
			
				//  Here we get the data-crs(carousel) value of the selected tab
				var $carousel = $(this).attr("data-crs");

				//	Here we call function "execCarousel"
				execCarousel($carousel,$limit,$width);
				
			});
		}
	} else { 
		//	Only init the carousel for the content in actived tab, because after click the tab, we will init it again
		var $tabs = $("#tabs"+$module+" li.active").first();
		
		if ($use_scrolling_panel) {
		//  Here we get the data-crs(carousel) value of the selected tab
		var $carousel = $($tabs).find("a").attr("data-crs");
		//	Here we call function "execCarousel"
		execCarousel($carousel,$limit,$width);
		}
	} 
}