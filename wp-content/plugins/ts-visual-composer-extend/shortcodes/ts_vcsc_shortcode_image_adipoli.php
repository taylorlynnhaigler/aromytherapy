<?php
	add_shortcode('TS-VCSC-Image-Adipoli', 'TS_VCSC_Image_Adipoli_Function');
	function TS_VCSC_Image_Adipoli_Function ($atts) {
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
		wp_enqueue_script('ts-extend-adipoli', 								TS_VCSC_GetResourceURL('js/jquery.adipoli.min.js'), array('jquery'), false, $FOOTER);
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
			'adipoli_start'           	=> 'grayscale',
			'adipoli_hover'           	=> 'normal',
			'adipoli_text'           	=> '',
			'adipoli_handle_show'		=> 'true',
			'adipoli_handle_color'		=> '#0094FF',
			'link_url'					=> '',
			'link_target'				=> '_parent',
			'tooltip_css'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id' 					=> '',
			'el_class'                  => '',
		), $atts ));
	
	
		$adipoli_margin = 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$output = "";
		
		if (!empty($el_id)) {
			$adipoli_image_id			= $el_id;
		} else {
			$adipoli_image_id			= 'ts-vcsc-image-adipoli-' . mt_rand(999999, 9999999);
		}
		
		$adipoli_image 					= wp_get_attachment_image_src($image, array($image_width, $image_height));
		
		if (intval($adipoli_image[2]) < intval($image_height)) {
			$height_adjust				= intval($image_height) - intval($adipoli_image[2]);
			$image_height				= intval($image_height) - intval($height_adjust);
		} else {
			$image_height				= $image_height;
		}
		
		// Handle Padding
		if ($adipoli_handle_show == "true") {
			$adipoli_padding			= "padding-bottom: 16px;";
		} else {
			$adipoli_padding			= "";
		}
		
		// Tooltip
		if ($tooltip_css == "true") {
			if (strlen($tooltip_content) != 0) {
				$adipoli_tooltipclasses	= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
				$adipoli_tooltipcontent	= ' data-tooltip="' . $tooltip_content . '"';
			} else {
				$adipoli_tooltipclasses	= "";
				$adipoli_tooltipcontent	= "";
			}
		} else {
			$adipoli_tooltipclasses		= "";
			if (strlen($tooltip_content) != 0) {
				$adipoli_tooltipcontent	= ' title="' . $tooltip_content . '"';
			} else {
				$adipoli_tooltipcontent	= "";
			}
		}
		
		// Image Size
		if ($image_fixed == "false") {
			$adipoli_dimensions			= "width: " . $image_width_percent . "%; height: auto;";
			$adipoli_frame_size			= "width: " . $image_width_percent . "%;";
			$adipoli_wrapper_size		= "width: " . $image_width_percent . "%; height: auto;";
			$adipoli_tag				= "responsive";
			$adipoli_height				= "auto";
			$adipoli_width				= $image_width_percent;
		} else {
			$adipoli_dimensions			= "width: " . $image_width . "px; height: " . $image_height . "px;";
			$adipoli_frame_size			= "width: " . $image_width . "px;";
			$adipoli_wrapper_size		= "width: " . $image_width . "px; height: auto;";
			$adipoli_tag				= "fixed";
			$adipoli_height				= $image_height;
			$adipoli_width				= $image_width;
		}
		
		$image_extension 				= pathinfo($adipoli_image[0], PATHINFO_EXTENSION);
		
		if ($attribute_alt == "true") {
			$alt_attribute				= $attribute_alt_value;
		} else {
			$alt_attribute				= basename($adipoli_image[0], "." . $image_extension);
		}
		
		if (!empty($link_url)) {
			$output .= '<a href="' . $link_url . '" target="' . $link_target . '">';
		}
			$output .= '<div id="' . $adipoli_image_id . '" class="ts-image-adipoli-frame ' . $adipoli_tooltipclasses . ' ' . $image_position . '"' . $adipoli_tooltipcontent . ' style="' . $adipoli_frame_size . ' ' . $adipoli_margin . '">';
				$output .= '<div id="' . $adipoli_image_id . '-counter" class="ts-fluid-wrapper " style="' . $adipoli_wrapper_size . '">';
					if ($adipoli_handle_show == "true") {
						$output .= '<div style="' . $adipoli_padding . '">';
					}
						$output .= '<img class="ts-imageadipoli" data-tag="' . $adipoli_tag . '" data-start="' . $adipoli_start . '" data-hover="' . $adipoli_hover . '" data-text="' . $adipoli_text . '" src="' . $adipoli_image[0] . '" alt="' . $alt_attribute . '" style="' . $adipoli_dimensions . '"/>';
						if ($adipoli_handle_show == "true") {
							if (!empty($link_url)) {
								$output .= '<div class="ts-image-adipoli-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_adipoli" style="background-color: ' . $adipoli_handle_color . '"><i class="handle-click"></i></span></div>';
							} else {
								$output .= '<div class="ts-image-adipoli-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_adipoli" style="background-color: ' . $adipoli_handle_color . '"><i class="handle-hover"></i></span></div>';
							}
						}
					if ($adipoli_handle_show == "true") {
						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '</div>'; 
		if (!empty($link_url)) {
			$output .= '</a>';
		}

		echo $output;

		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>