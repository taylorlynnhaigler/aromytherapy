<?php
    if (function_exists('vc_map')) {
		vc_map(array(
			"name"					=> __( "TS Social Networks", "js_composer" ),
			"base"					=> "TS-VCSC-Social-Icons",
			"icon"					=> "icon-wpb-ts_vcsc_icon_social",
			"class"					=> "",
			"category"				=> __('VC Extensions', 'js_composer'),
			"description" 		    => __("Place social network links", "js_composer"),
			//"admin_enqueue_js"	=> array(TS_VCSC_GetResourceURL('/js/...')),
			//"admin_enqueue_css"	=> array(TS_VCSC_GetResourceURL('/css/...')),
			"params"				=> array(
			// Main Icon Settings
			array(
				"type"              => "seperator",
				"heading"           => __( "", "js_composer" ),
				"param_name"        => "seperator_1",
				"value"             => "Icon Settings",
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Style", "js_composer" ),
				"param_name"        => "icon_style",
				"admin_label"       => true,
				"value"             => array(
				"Simple"        	=> "simple",
				"Square"        	=> "square",
				"Rounded"       	=> "rounded",
				"Circle"        	=> "circle",
				),
			),
			array(
				"type"              => "colorpicker",
				"heading"           => __( "Icon Background Color", "js_composer" ),
				"param_name"        => "icon_background",
				"value"             => "#f5f5f5",
				"description"       => __( "", "js_composer" ),
				"dependency"        => array( 'element' => "icon_style", 'value' => array('square', 'rounded', 'circle') )
			),
			array(
				"type"              => "colorpicker",
				"heading"           => __( "Icon Border Color", "js_composer" ),
				"param_name"        => "icon_frame_color",
				"value"             => "#f5f5f5",
				"description"       => __( "", "js_composer" ),
				"dependency"        => array( 'element' => "icon_style", 'value' => array('square', 'rounded', 'circle') )
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Icon Frame Border Thickness", "js_composer" ),
				"param_name"        => "icon_frame_thick",
				"value"             => "1",
				"min"               => "1",
				"max"               => "10",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "", "js_composer" ),
				"dependency"        => array( 'element' => "icon_style", 'value' => array('square', 'rounded', 'circle') )
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Icon Margin", "js_composer" ),
				"param_name"        => "icon_margin",
				"value"             => "5",
				"min"               => "0",
				"max"               => "50",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Icons Align", "js_composer" ),
				"param_name"        => "icon_align",
				"width"             => 150,
				"value"             => array(
				__( 'Left', "js_composer" )     => "left",
				__( 'Right', "js_composer" )    => "right",
				__( 'Center', "js_composer" )   => "center" ),
				"admin_label"       => true,
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Icons Hover Animation", "js_composer" ),
				"param_name"        => "icon_hover",
				"width"             => 150,
				"value"             => $this->TS_VCSC_CSS_Hovers,
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"				=> "seperator",
				"heading"			=> __( "", "js_composer" ),
				"param_name"		=> "seperator_4",
				"value"				=> "Tooltips",
				"description"		=> __( "", "js_composer" )
			),
			array(
				"type"              => "switch",
				"heading"           => __( "Show Tooltip Title", "js_composer" ),
				"param_name"        => "tooltip_show",
				"value"             => "false",
				"on"				=> __( 'Yes', "js_composer" ),
				"off"				=> __( 'No', "js_composer" ),
				"style"				=> "select",
				"design"			=> "toggle-light",
				"description"       => __( "Switch the toggle if you want to show a tooltip with the social link information.", "js_composer" ),
				"dependency"        => ""
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "Title Pre Text", "js_composer" ),
				"param_name"        => "tooltip_text",
				"value"             => "Click here to view our profile on ",
				"description"       => __( "The name of the social network will be added to the end of your text string automatically.", "js_composer" ),
				"dependency"        => array( 'element' => "tooltip_show", 'value' => 'true' )
			),
			array(
				"type"              => "switch",
				"heading"			=> __( "Use CSS3 Tooltip", "js_composer" ),
				"param_name"		=> "tooltip_css",
				"value"             => "false",
				"on"				=> __( 'Yes', "js_composer" ),
				"off"				=> __( 'No', "js_composer" ),
				"style"				=> "select",
				"design"			=> "toggle-light",
				"description"		=> __( "Switch the toggle if you want to apply a CSS3 tooltip to the image.", "js_composer" ),
				"dependency"        => array( 'element' => "tooltip_show", 'value' => 'true' )
			),
			array(
				"type"				=> "dropdown",
				"class"				=> "",
				"heading"			=> __( "Tooltip Position", 'js_composer' ),
				"param_name"		=> "tooltip_position",
				"value"				=> $this->TS_VCSC_OtherTooltip_Position,
				"description"		=> __( "Select the tooltip position in relation to the image.", "js_composer" ),
				"dependency"		=> array( 'element' => "tooltip_css", 'value' => 'true' )
			),
			array(
				"type"				=> "dropdown",
				"class"				=> "",
				"heading"			=> __( "Tooltip Style", 'js_composer' ),
				"param_name"		=> "tooltip_style",
				"value"				=> $this->TS_VCSC_Tooltip_Style,
				"description"		=> __( "Select the tooltip style.", "js_composer" ),
				"dependency"		=> array( 'element' => "tooltip_css", 'value' => 'true' )
			),
			// Link Settings
			array(
				"type"              => "seperator",
				"heading"           => __( "", "js_composer" ),
				"param_name"        => "seperator_2",
				"value"             => "Link Settings",
				"file"              => "",
				"path"              => "",
				"enqueue"           => "",
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-email'></i> Email Address", "js_composer" ),
				"param_name"        => "email",
				"value"             => get_option('ts_vcsc_social_link_email',          ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-phone'></i> Phone Number", "js_composer" ),
				"param_name"        => "phone",
				"value"             => get_option('ts_vcsc_social_link_phone',          ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-cell'></i> Cell Number", "js_composer" ),
				"param_name"        => "cell",
				"value"             => get_option('ts_vcsc_social_link_cell',          ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-portfolio'></i> Portfolio URL", "js_composer" ),
				"param_name"        => "portfolio",
				"value"             => get_option('ts_vcsc_social_link_portfolio',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-link'></i> Other Link URL", "js_composer" ),
				"param_name"        => "link",
				"value"             => get_option('ts_vcsc_social_link_link',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-behance'></i> Behance URL", "js_composer" ),
				"param_name"        => "behance",
				"value"             => get_option('ts_vcsc_social_link_behance',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-digg'></i> Digg URL", "js_composer" ),
				"param_name"        => "digg",
				"value"             => get_option('ts_vcsc_social_link_digg', 	        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-dribbble'></i> Dribbble URL", "js_composer" ),
				"param_name"        => "dribbble",
				"value"             => get_option('ts_vcsc_social_link_dribbble',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-dropbox'></i> Dropbox URL", "js_composer" ),
				"param_name"        => "dropbox",
				"value"             => get_option('ts_vcsc_social_link_dropbox',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-envato'></i> Envato URL", "js_composer" ),
				"param_name"        => "envato",
				"value"             => get_option('ts_vcsc_social_link_envato',         ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-evernote'></i> Evernote URL", "js_composer" ),
				"param_name"        => "evernote",
				"value"             => get_option('ts_vcsc_social_link_evernote',       ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-facebook'></i> Facebook URL", "js_composer" ),
				"param_name"        => "facebook",
				"value"             => get_option('ts_vcsc_social_link_facebook', 	''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-flickr'></i> Flickr URL", "js_composer" ),
				"param_name"        => "flickr",
				"value"             => get_option('ts_vcsc_social_link_flickr',         ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-github'></i> GitHub URL", "js_composer" ),
				"param_name"        => "github",
				"value"             => get_option('ts_vcsc_social_link_github',          ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-gplus'></i> Google Plus URL", "js_composer" ),
				"param_name"        => "gplus",
				"value"             => get_option('ts_vcsc_social_link_gplus',     	''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-instagram'></i> Instagram URL", "js_composer" ),
				"param_name"        => "instagram",
				"value"             => get_option('ts_vcsc_social_link_instagram',      ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-lastfm'></i> Last-FM URL", "js_composer" ),
				"param_name"        => "lastfm",
				"value"             => get_option('ts_vcsc_social_link_lastfm',         ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-linkedin'></i> Linkedin URL", "js_composer" ),
				"param_name"        => "linkedin",
				"value"             => get_option('ts_vcsc_social_link_linkedin',       ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-paypal'></i> Paypal URL", "js_composer" ),
				"param_name"        => "paypal",
				"value"             => get_option('ts_vcsc_social_link_paypal',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-picasa'></i> Picasa URL", "js_composer" ),
				"param_name"        => "picasa",
				"value"             => get_option('ts_vcsc_social_link_picasa',        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-pinterest'></i> Pinterest URL", "js_composer" ),
				"param_name"        => "pinterest",
				"value"             => get_option('ts_vcsc_social_link_pinterest',      ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-rss'></i> RSS URL", "js_composer" ),
				"param_name"        => "rss",
				"value"             => get_option('ts_vcsc_social_link_rss', 	        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-skype'></i> Skype URL", "js_composer" ),
				"param_name"        => "skype",
				"value"             => get_option('ts_vcsc_social_link_skype', 	        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-soundcloud'></i> Soundcloud URL", "js_composer" ),
				"param_name"        => "soundcloud",
				"value"             => get_option('ts_vcsc_social_link_soundcloud',     ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-spotify'></i> Spotify URL", "js_composer" ),
				"param_name"        => "spotify",
				"value"             => get_option('ts_vcsc_social_link_spotify',     ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-stumbleupon'></i> StumbleUpon URL", "js_composer" ),
				"param_name"        => "stumbleupon",
				"value"             => get_option('ts_vcsc_social_link_stumbleupon',    ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-tumblr'></i> Tumblr URL", "js_composer" ),
				"param_name"        => "tumblr",
				"value"             => get_option('ts_vcsc_social_link_tumblr',         ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-twitter'></i> Twitter URL", "js_composer" ),
				"param_name"        => "twitter",
				"value"             => get_option('ts_vcsc_social_link_twitter', 	''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-vimeo'></i> Vimeo URL", "js_composer" ),
				"param_name"        => "vimeo",
				"value"             => get_option('ts_vcsc_social_link_vimeo', 	        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-xing'></i> Xing URL", "js_composer" ),
				"param_name"        => "xing",
				"value"             => get_option('ts_vcsc_social_link_xing', 	        ''),
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "<i class='ts-social-icon ts-social-youtube'></i> Youtube URL", "js_composer" ),
				"param_name"        => "youtube",
				"value"             => get_option('ts_vcsc_social_link_youtube',        ''),
				"description"       => __( "", "js_composer" )
			),
			// Other Icon Settings
			array(
				"type"              => "seperator",
				"heading"           => __( "", "js_composer" ),
				"param_name"        => "seperator_3",
				"value"             => "Other Settings",
				"file"              => "",
				"path"              => "",
				"enqueue"           => "",
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "Define ID Name", "js_composer" ),
				"param_name"        => "el_id",
				"value"             => "",
				"description"       => __( "", "js_composer" )
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "Extra Class Name", "js_composer" ),
				"param_name"        => "el_class",
				"value"             => "",
				"description"       => __( "", "js_composer" )
			),
			// Load Custom CSS/JS File
			array(
				"type"              => "load_file",
				"heading"           => __( "", "js_composer" ),
				"param_name"		=> "el_file",
				"value"             => "Social Icon Files",
				"file_type"         => "js",
				"file_path"         => "js/ts-visual-composer-extend-element.min.js",
				"description"       => __( "", "js_composer" )
			),
			))
		);
    }
?>