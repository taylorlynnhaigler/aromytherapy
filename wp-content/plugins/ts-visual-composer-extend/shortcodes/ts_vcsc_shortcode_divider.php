<?php
	add_shortcode('TS-VCSC-Divider', 'TS_VCSC_Divider_Function');
	function TS_VCSC_Divider_Function ($atts) {
		ob_start();
		
		if ((get_option('ts_vcsc_extend_settings_loadHeader', 0) == 0)) {
			$FOOTER = true;
		} else {
			$FOOTER = false;
		}

		if (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 0) {
			wp_enqueue_style('ts-visual-composer-extend-front',				TS_VCSC_GetResourceURL('css/ts-visual-composer-extend-front.min.css'), null, false, 'all');
			wp_enqueue_script('ts-visual-composer-extend-front',			TS_VCSC_GetResourceURL('js/ts-visual-composer-extend-front.min.js'), array('jquery'), false, $FOOTER);
		}

		extract( shortcode_atts( array(
			'divider_type'				=> 'ts-divider-one',
			'divider_text_position'		=> 'center',
			'divider_text_content'		=> '',
			'divider_text_border'		=> '#eeeeee',
			'divider_image_position'	=> 'center',
			'divider_image_content'		=> '',
			'divider_image_border'		=> '#eeeeee',
			'divider_icon_position'		=> 'center',
			'divider_icon_content'		=> '',
			'divider_icon_color'		=> '#cccccc',
			'divider_icon_border'		=> '#eeeeee',
			'divider_border_type'		=> 'solid',
			'divider_border_thick'		=> 1,
			'divider_border_color'		=> '#eeeeee',
			'divider_top_content'		=> '',
			'divider_top_color'			=> '#eeeeee',
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id'						=> '',
			'el_class'					=> '',
		), $atts ));

		if (!empty($el_id)) {
			$divider_id					= $el_id;
		} else {
			$divider_id					= 'ts-vcsc-divider-' . mt_rand(999999, 9999999);
		}

		if ((!empty($divider_image_content)) && ($divider_type == "ts-divider-images")) {
			$divider_image_content_path			= wp_get_attachment_image_src($divider_image_content, 'large');
		}

		$output = '';

		if ($divider_type == "ts-divider-border") {
			$divider_border = 'border-top: ' . $divider_border_thick . 'px ' . $divider_border_type . ' ' . $divider_border_color . ';';
			$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-border" style="' . $divider_border . '"></div></div>';
		} else if ($divider_type == "ts-divider-lines") {
			if ($divider_text_position == "center") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-lines" style="border-color: ' . $divider_text_border . ';"><div class="ts-divider-text center"><div class="ts-center-help">' . $divider_text_content . '</div></div></div></div>';
			} else if ($divider_text_position == "right") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-lines" style="border-color: ' . $divider_text_border . ';"><div class="ts-divider-text right"><div class="">' . $divider_text_content . '</div></div></div></div>';
			} else if ($divider_text_position == "left"){
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-lines" style="border-color: ' . $divider_text_border . ';"><div class="ts-divider-text left"><div class="">' . $divider_text_content . '</div></div></div></div>';
			}
		} else if ($divider_type == "ts-divider-images") {
			if ($divider_image_position == "center") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-images" style="border-color: ' . $divider_image_border . ';"><div class="ts-divider-text center"><div class="ts-center-help"><img src="' . $divider_image_content_path[0] . '"></div></div></div></div>';
			} else if ($divider_image_position == "right") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-images" style="border-color: ' . $divider_image_border . ';"><div class="ts-divider-text right"><div class=""><img src="' . $divider_image_content_path[0] . '"></div></div></div></div>';
			} else if ($divider_image_position == "left") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-images" style="border-color: ' . $divider_image_border . ';"><div class="ts-divider-text left"><div class=""><img src="' . $divider_image_content_path[0] . '"></div></div></div></div>';
			}
		} else if ($divider_type == "ts-divider-icons") {
			if ($divider_icon_position == "center") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-icons" style="border-color: ' . $divider_icon_border . ';"><div class="ts-divider-text center"><div class="ts-center-help"><i class="ts-font-icon ' . $divider_icon_content . '" style="color: ' . $divider_icon_color . ';"></i></div></div></div></div>';
			} else if ($divider_icon_position == "right") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-icons" style="border-color: ' . $divider_icon_border . ';"><div class="ts-divider-text right"><div class=""><i class="ts-font-icon ' . $divider_icon_content . '" style="color: ' . $divider_icon_color . ';"></i></div></div></div></div>';
			} else if ($divider_icon_position == "left") {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-icons" style="border-color: ' . $divider_icon_border . ';"><div class="ts-divider-text left"><div class=""><i class="ts-font-icon ' . $divider_icon_content . '" style="color: ' . $divider_icon_color . ';"></i></div></div></div></div>';
			}
		} else if ($divider_type == "ts-divider-top") {
			if (!empty($divider_top_content)) {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-top" style="border-color: ' . $divider_top_border . ';"><a href="#top" class="ts-to-top"><span class="ts-to-top-text">' . $divider_top_content . '</span><span class="ts-to-top-icon"></span></a></div></div>';
			} else {
				$output .= '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-top" style="border-color: ' . $divider_top_border . ';"><a href="#top" class="ts-to-top"><span class="ts-to-top-text"></span><span class="ts-to-top-icon"></span></a></div></div>';
			}
		} else {
			$output = '<div id="' . $divider_id . '" class="ts-divider-holder ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-simple ' . $divider_type . '" style=""></div></div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>