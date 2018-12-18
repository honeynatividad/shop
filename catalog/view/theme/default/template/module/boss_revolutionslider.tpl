<div class="header_slider">
<?php global $config; ?>
<article <?php echo ($slidersetting['slider_type']=='custom')?'class="boss_slider" style="max-width:'.$slidersetting['slider_width'].'px;"':'';?>>
	<div class="tp-banner-container">
		<div class="tp-banner tp-banner<?php echo $module;?>" >
			<ul>	<!-- SLIDE  -->
			<?php foreach($slides as $slide){ ?>
				<?php if(isset($slide['status']) && $slide['status']) { ?>
				<?php $slideset = $slide['slideset']; ?>
				<li <?php if($slideset['enablelink'] == 1){ ?> data-link="<?php echo $slideset['url'];?>" data-target="<?php echo $slideset['target'];?>" <?php } ?> data-transition="<?php echo isset($slideset['transitions']) ? $slideset['transitions'] : 'fade';?>" data-slotamount="<?php echo isset($slideset['slotamount']) ? $slideset['slotamount'] : '7';?>" data-masterspeed="<?php echo isset($slideset['masterspeed']) ? $slideset['masterspeed'] : '500';?>"  data-saveperformance="on">
					<!-- MAIN IMAGE -->
					<img src="image/catalog/<?php echo $config->get('config_template'); ?>/dummy.png"  alt="slidebg1" data-lazyload="image/<?php echo $slide['slideset']['background']; ?>" data-bgposition="left center" data-kenburns="<?php echo isset($slideset['kenburns']) ? $slideset['kenburns'] : 'off';?>" data-duration="14000" data-ease="Linear.easeNone" data-bgpositionend="right center" />
					<?php $i=1; ?>
					<?php if(isset($slide['captions'])){ foreach($slide['captions'] as $caption){ ?>
						<!-- LAYER NR. <?php echo $i; ?> -->
						<div class="tp-caption <?php echo isset($caption['class_css']) ? $caption['class_css'] : '';?> <?php echo isset($caption['incom_animation'])?$caption['incom_animation']:'';?> <?php echo isset($caption['outgo_animation'])?$caption['outgo_animation']:'';?> rs-parallaxlevel-0"
							data-x="<?php echo isset($caption['datax']) ? $caption['datax'] : '100';?>"
							data-y="<?php echo isset($caption['datay']) ? $caption['datay'] : '100';?>" 
							data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
							data-speed="<?php echo isset($caption['dataspeed']) ? $caption['dataspeed'] : '700';?>"
							data-start="<?php echo isset($caption['datastart']) ? $caption['datastart'] : '1500';?>"
							data-end="<?php echo isset($caption['dataend'])?$caption['dataend']:'';?>" 
							data-endspeed="<?php echo isset($caption['dataafterspeed'])?$caption['dataafterspeed']:''; ?>" 
							data-easing="<?php echo isset($caption['easing'])?$caption['easing']:'';?>"
							data-endeasing="<?php echo isset($caption['endeasing'])?$caption['endeasing']:'';?>"
							data-elementdelay="0.1"
							data-endelementdelay="0.1"
							style="z-index: 2;"><?php if(isset($caption['type_caption'])&&($caption['type_caption']=='image')){?><img src="image/catalog/<?php echo $config->get('config_template'); ?>/dummy.png" alt="" data-lazyload="image/<?php echo $caption['image_caption']; ?>" /><?php }elseif(isset($caption['type_caption'])&&($caption['type_caption']=='video')){?>
							<?php if($caption['type_capvideo']=='youtube'){ ?>
							<iframe width="<?php echo $caption['video_width']; ?>" height="<?php echo $caption['video_height']; ?>" src="//www.youtube.com/embed/<?php echo $caption['video_id']; ?>?rel=0&showinfo=0" frameborder="0"></iframe>
							<?php }elseif($caption['type_capvideo']=='vimeo'){ ?>
							<iframe width="<?php echo $caption['video_width']; ?>" height="<?php echo $caption['video_height']; ?>" src="http://player.vimeo.com/video/<?php echo $caption['video_id']; ?>?title=0&byline=0&portrait=0;api=1" frameborder="0"></iframe>
							<?php }else{ ?>
							<iframe width="<?php echo $caption['video_width']; ?>" height="<?php echo $caption['video_height']; ?>" src="<?php echo $caption['video_id']; ?>" frameborder="0"></iframe>
							<?php } ?>
							<?php }else{?>
							<?php echo html_entity_decode(isset($caption['text_caption'][$config->get('config_language_id')]) ? $caption['text_caption'][$config->get('config_language_id')] : '',ENT_QUOTES, 'UTF-8');?>
							<?php } ?>
						</div>
					<?php $i++; } } ?>
				</li>
			<?php } ?>
			<?php } ?>
			</ul>
			<div class="slideshow_control"></div>
		</div>
	</div>
</article>
</div>
<script type="text/javascript"><!--
jQuery(document).ready(function() {		
	jQuery('.tp-banner<?php echo $module;?>').show().revolution({
		dottedOverlay:"none",
		delay:<?php echo $slidersetting['delay'];?>,
		startWithSlide:<?php echo $slidersetting['startWithSlide'];?>,
		startwidth:<?php echo $slidersetting['slider_width'];?>,
		startheight:<?php echo $slidersetting['slider_height'];?>,
		hideThumbs:<?php echo $slidersetting['timehidethumbnail'];?>,
		hideTimerBar:"<?php echo $slidersetting['timeline'];?>",
		
		thumbWidth:<?php echo $slidersetting['thumbnailwidth'];?>,
		thumbHeight:<?php echo $slidersetting['thumbnailheight'];?>,
		thumbAmount:<?php echo $slidersetting['thumbamount'];?>,
		
		navigationType:"<?php echo $slidersetting['navigationtype'];?>",
		navigationArrows:"<?php echo $slidersetting['navigationarrow'];?>",
		navigationStyle:"<?php echo $slidersetting['navigationstyle'];?>", 
		
		touchenabled:"<?php echo $slidersetting['touchenabled'];?>",
		onHoverStop:"<?php echo $slidersetting['onhoverstop'];?>",
		
		swipe_velocity: 0.7,
		swipe_min_touches: 1,
		swipe_max_touches: 1,
		drag_block_vertical: false,
								
		parallax:"mouse",
		parallaxBgFreeze:"on",
		parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
								
		keyboardNavigation:"off",
		
		navigationHAlign:"<?php echo $slidersetting['navigationhalign'];?>",
		navigationVAlign:"<?php echo $slidersetting['navigationvalign'];?>",
		navigationHOffset:<?php echo $slidersetting['navigationhoffset'];?>,
		navigationVOffset:<?php echo $slidersetting['navigationvoffset'];?>,

		soloArrowLeftHalign:"<?php echo $slidersetting['soloarrowlefthalign'];?>",
		soloArrowLeftValign:"<?php echo $slidersetting['soloarrowleftvalign'];?>",
		soloArrowLeftHOffset:<?php echo $slidersetting['soloarrowlefthoffset'];?>,
		soloArrowLeftVOffset:<?php echo $slidersetting['soloarrowleftvoffset'];?>,

		soloArrowRightHalign:"<?php echo $slidersetting['soloarrowrighthalign'];?>",
		soloArrowRightValign:"<?php echo $slidersetting['soloarrowrightvalign'];?>",
		soloArrowRightHOffset:<?php echo $slidersetting['soloarrowrighthoffset'];?>,
		soloArrowRightVOffset:<?php echo $slidersetting['soloarrowrightvoffset'];?>,
				
		shadow:<?php echo $slidersetting['shadow'];?>,
		fullWidth:"on",
		fullScreen:"off",

		spinner:"spinner4",
		
		stopLoop:"<?php echo $slidersetting['stopslider'];?>",
		stopAfterLoops:<?php echo $slidersetting['stopafterloops'];?>,
		stopAtSlide:<?php echo $slidersetting['stopatslide'];?>,

		shuffle:"off",
		
		autoHeight:"off",						
		forceFullWidth:"off",						
								
								
								
		hideThumbsOnMobile:"off",
		hideNavDelayOnMobile:1500,						
		hideBulletsOnMobile:"off",
		hideArrowsOnMobile:"off",
		hideThumbsUnderResolution:0,
		
		hideSliderAtLimit:<?php echo $slidersetting['hideslideratlimit'];?>,
		hideCaptionAtLimit:<?php echo $slidersetting['hidecapptionatlimit'];?>,
		hideAllCaptionAtLilmit:<?php echo $slidersetting['hideallcapptionatlimit'];?>,
		videoJsPath:"rs-plugin/videojs/",
		fullScreenOffsetContainer: ""	
	});				
});	//ready

//--></script>