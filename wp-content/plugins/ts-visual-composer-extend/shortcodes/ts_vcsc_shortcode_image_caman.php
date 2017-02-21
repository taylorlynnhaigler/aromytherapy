<?php
	add_shortcode('TS-VCSC-Image-Caman', 'TS_VCSC_Image_Caman_Function');
	function TS_VCSC_Image_Caman_Function ($atts) {
		ob_start();
		
		if ((get_option('ts_vcsc_extend_settings_loadHeader', 0) == 0)) {
			$FOOTER = true;
		} else {
			$FOOTER = false;
		}
		
		if (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 0) {
			wp_enqueue_style('ts-extend-simptip',                 			TS_VCSC_GetResourceURL('css/jquery.simptip.css'), null, false, 'all');
			wp_enqueue_style('ts-extend-animations',                 		TS_VCSC_GetResourceURL('css/ts-visual-composer-extend-animations.min.css'), null, false, 'all');
			wp_enqueue_style('ts-visual-composer-extend-front',				TS_VCSC_GetResourceURL('css/ts-visual-composer-extend-front.min.css'), null, false, 'all');
		}
		wp_enqueue_script('ts-extend-caman', 								TS_VCSC_GetResourceURL('js/jquery.caman.full.min.js'), array('jquery'), false, $FOOTER);
		if (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 0) {
			wp_enqueue_script('ts-visual-composer-extend-front',			TS_VCSC_GetResourceURL('js/ts-visual-composer-extend-front.min.js'), array('jquery'), false, $FOOTER);
		}
		
		extract( shortcode_atts( array(
			'image'						=> '',
			'attribute_alt'				=> 'false',
			'attribute_alt_value'		=> '',
			'image_fixed'				=> 'true',
			"image_width_percent"		=> 100,
			'image_width'				=> 300,
			'image_height'				=> 200,
			'image_position'			=> 'ts-imagefloat-center',
			'caman_effect'				=> 'vintage',
			'caman_switch_type'			=> 'ts-imageswitch-flip',
			'caman_trigger_flip'		=> 'ts-trigger-click',
			'caman_trigger_fade'		=> 'ts-trigger-hover',
			'caman_handle_show'			=> 'true',
			'caman_handle_color'		=> '#0094FF',
			'tooltip_css'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id' 					=> '',
			'el_class'                  => '',
		), $atts ));
	
		$caman_image = wp_get_attachment_image_src($image, 'large');
		
		$caman_margin = 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$output = "";
		
		if (!empty($el_id)) {
			$caman_number			= mt_rand(999999, 9999999);
			$caman_image_id			= $el_id;
		} else {
			$caman_number			= mt_rand(999999, 9999999);
			$caman_image_id			= 'ts-vcsc-image-caman-' . $caman_number;
		}
	
		// Handle Padding
		if ($caman_handle_show == "true") {
			$caman_padding			= "padding-bottom: 18px;";
		} else {
			$caman_padding			= "";
		}
		
		// Tooltip
		if ($tooltip_css == "true") {
			if (strlen($tooltip_content) != 0) {
				$caman_tooltipclasses	= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
				$caman_tooltipcontent	= ' data-tooltip="' . $tooltip_content . '"';
			} else {
				$caman_tooltipclasses	= "";
				$caman_tooltipcontent	= "";
			}
		} else {
			$caman_tooltipclasses		= "";
			if (strlen($tooltip_content) != 0) {
				$caman_tooltipcontent	= ' title="' . $tooltip_content . '"';
			} else {
				$caman_tooltipcontent	= "";
			}
		}
		
		// Image Size
		if ($image_fixed == "false") {
			$caman_dimensions			= "width: " . $image_width_percent . "%; height: auto;";
			$caman_frame_size			= "width: " . $image_width_percent . "%;";
			$caman_wrapper_size			= "width: " . $image_width_percent . "%; height: auto;";
			$caman_tag					= "responsive";
			$caman_height				= "auto";
			$caman_width				= $image_width_percent;
		} else {
			$caman_dimensions			= "width: " . $image_width . "px; height: " . $image_height . "px;";
			$caman_frame_size			= "width: " . $image_width . "px;";
			$caman_wrapper_size			= "width: " . $image_width . "px; height: auto;";
			$caman_tag					= "fixed";
			$caman_height				= $image_height;
			$caman_width				= $image_width;
		}
	
		// Trigger
		if ($caman_switch_type == "ts-imageswitch-flip") {
			$switch_trigger 			= $caman_trigger_flip;
		} else if ($caman_switch_type == "ts-imageswitch-fade") {
			$switch_trigger 			= $caman_trigger_fade;
		} else if ($caman_switch_type == "ts-imageswitch-slide") {
			$switch_trigger 			= "ts-trigger-slide";
		}
		
		// Handle Icon
		if ($switch_trigger == "ts-trigger-click") {
			$switch_handle_icon			= 'handle_click';
		} else if ($switch_trigger == "ts-trigger-hover") {
			$switch_handle_icon			= 'handle_hover';
		} else if ($switch_trigger == "ts-trigger-slide") {
			$switch_handle_icon			= 'handle_slide';
		}
		
		$image_extension 				= pathinfo($caman_image[0], PATHINFO_EXTENSION);
		
		if (($tooltip_css == "true") && (strlen($tooltip_content) != 0)) {
			$output .= '<div class="ts-image-caman-tooltip' . $caman_tooltipclasses . '" style="width: 100%;" ' . $caman_tooltipcontent . '>';
		}
			$output .= '<div id="' . $caman_image_id . '" data-trigger="' . $switch_trigger . '" class="ts-image-caman-frame ' . $el_class . ' ts-imageswitch ts-imageswitch-before ' . $caman_switch_type . ' ' . $switch_trigger . '"' . ($tooltip_css == "false" ? $caman_tooltipcontent : "") . ' data-number="' . $caman_number . '" style="width: 100%; ' . $caman_margin . $caman_padding .'">';
				$output .= '<img id="ts-image-caman-original-' . $caman_number . '" class="ts-image-caman-original ts-imageswitch__after" src="' . $caman_image[0] . '" alt="' . basename($caman_image[0], "." . $image_extension) . '" style=""/>';
				$output .= '<img id="ts-image-caman-canvas-' . $caman_number . '" class="ts-image-caman-canvas ts-imageswitch__before ' . ($caman_switch_type == "ts-imageswitch-fade" ? "active" : "") . '" src="' . $caman_image[0] . '" alt="' . basename($caman_image[0], "." . $image_extension) . '" data-number="' . $caman_number . '" data-effect="' . $caman_effect . '"/>';
				$output .= '<div id="ts-image-caman-process-' . $caman_number . '" class="ts-image-caman-process"><span class="ts-image-caman-gears"></span></div>';
				if ($caman_handle_show == "true") {
					$output .= '<div id="ts-image-caman-handle-' . $caman_number . '" class="ts-image-caman-handle" style="display: none;"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $caman_handle_color . ';"><i class="' . $switch_handle_icon . '"></i></span></div>';
				}
			$output .= '</div>';
		if (($tooltip_css == "true") && (strlen($tooltip_content) != 0)) {
			$output .= '</div>';
		}
	
		echo $output;

		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>