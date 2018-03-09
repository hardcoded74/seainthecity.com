<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Slider Template
 * Created by CMSMasters
 * 
 */


$slider_active = get_post_meta(get_the_ID(), 'slidertools_active', true);
$slidertools_slider_id = get_post_meta(get_the_ID(), 'slidertools_slider_id', true);

$sliderManager = new cmsmsSliderManager;
$sliderOptions = $sliderManager->getSlider($slidertools_slider_id);

wp_enqueue_script('slider');

?>
<script type="text/javascript">
	jQuery(document).ready(function () { 
		jQuery('#slider').cmsmsResponsiveSlider( { 
			animationSpeed : <?php echo ($sliderOptions['slider']['slider_animation'] != '') ? (int) ($sliderOptions['slider']['slider_animation'] * 1000) : '600'; ?>, 
			animationEffect : '<?php echo ($sliderOptions['slider']['slider_effect'] != '') ? $sliderOptions['slider']['slider_effect'] : 'slide'; ?>', 
			animationEasing : '<?php echo ($sliderOptions['slider']['slider_easing'] != '') ? $sliderOptions['slider']['slider_easing'] : 'easeInOutExpo'; ?>', 
			pauseTime : <?php echo ($sliderOptions['slider']['slider_pause'] != '') ? (int) ($sliderOptions['slider']['slider_pause'] * 1000) : '7000'; ?>, 
			activeSlide : <?php echo ($sliderOptions['slider']['active_slide'] != '') ? $sliderOptions['slider']['active_slide'] : '1'; ?>, 
			buttonControls : <?php echo ($sliderOptions['slider']['button_controls'] == 'true') ? 'true' : 'false'; ?>, 
			touchControls : <?php echo ($sliderOptions['slider']['touch_controls'] == 'true') ? 'true' : 'false'; ?>, 
			pauseOnHover : <?php echo ($sliderOptions['slider']['pause_on_hover'] == 'true') ? 'true' : 'false'; ?>, 
			showCaptions : <?php echo ($sliderOptions['slider']['slides_caption'] == 'true') ? 'true' : 'false'; ?>, 
			arrowNavigation : <?php echo ($sliderOptions['slider']['arrow_navigation'] == 'true') ? 'true' : 'false'; ?>, 
			arrowNavigationHover : <?php echo ($sliderOptions['slider']['arrow_navigation_hover'] == 'true') ? 'true' : 'false'; ?>, 
			slidesNavigation : <?php echo ($sliderOptions['slider']['slides_navigation'] == 'true') ? 'true' : 'false'; ?>, 
			slidesNavigationHover : <?php echo ($sliderOptions['slider']['slides_navigation_hover'] == 'true') ? 'true' : 'false'; ?>, 
			showTimer : <?php echo ($sliderOptions['slider']['slider_timer'] == 'true') ? 'true' : 'false'; ?>, 
			timerHover : <?php echo ($sliderOptions['slider']['slider_timer_hover'] == 'true') ? 'true' : 'false'; ?> 
		} ); 
	} );
</script>
<?php cmsmasters_slider(array('slider_id' => $slidertools_slider_id)); ?>