<?php
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      => __( "TS Countdown", "js_composer" ),
            "base"                      => "TS-VCSC-Countdown",
            "icon" 	                    => "icon-wpb-ts_vcsc_countdown",
            "class"                     => "",
            "category"                  => __( 'VC Extensions', 'js_composer' ),
            "description"               => __("Place a countdown element", "js_composer"),
            //"admin_enqueue_js"        => array(ts_fb_get_resource_url('/Core/JS/jquery.js-composer.fb-album.js')),
            //"admin_enqueue_css"       => array(ts_fb_get_resource_url('/Core/CSS/jquery.js-composer.fb-album.css')),
            "params"                    => array(
                // Countdown Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "js_composer" ),
                    "param_name"        => "seperator_1",
                    "value"             => "Countdown Settings",
                    "description"       => __( "", "js_composer" )
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Style", "js_composer" ),
                    "param_name"        => "style",
                    "width"             => 150,
                    "value"             => array(
						__( 'Minimum Styling', "js_composer" )				=> "minimum",
						__( 'Basic Styling with Columns', "js_composer" )	=> "columns",
                        __( 'Bars Layout', "js_composer" )					=> "bars",
                        __( 'Digital Clock 1', "js_composer" )        		=> "clock1",
						__( 'Digital Clock 2', "js_composer" )        		=> "clock2",
						__( 'Circles Layout', "js_composer" )				=> "circles",
                    ),
					"admin_label"		=> true,
                    "description"       => __( "Select the style for the countdown element.", "js_composer" ),
					"dependency"        => ''
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Circle Width", "js_composer" ),
                    "param_name"        => "circle_width",
                    "value"             => "5",
                    "min"               => "5",
                    "max"               => "25",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "Define the circle width in pixel.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
                ),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Countdown Border Type", "js_composer" ),
					"param_name"        => "border_type",
					"width"             => 300,
					"value"             => $this->TS_VCSC_Border_Type,
					"description"       => __( "Select the type of border around the countdown element.", "js_composer" ),
					"dependency"        => ""
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Countdown Border Thickness", "js_composer" ),
					"param_name"        => "border_thick",
					"value"             => "1",
					"min"               => "1",
					"max"               => "10",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Define the thickness of the countdown element border.", "js_composer" ),
					"dependency"        => array( 'element' => "border_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Countdown Border Radius", "js_composer" ),
					"param_name"        => "border_radius",
					"value"             => $this->TS_VCSC_Box_Border_Radius,
					"description"       => __( "Define the radius of the countdown element border.", "js_composer" ),
					"dependency"        => array( 'element' => "border_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Countdown Border Color", "js_composer" ),
					"param_name"        => "border_color",
					"value"             => "#dddddd",
					"description"       => __( "Define the color of the countdown element border.", "js_composer" ),
					"dependency"        => array( 'element' => "border_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
                // Date and Time Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "js_composer" ),
                    "param_name"        => "seperator_2",
                    "value"             => "Date & Time Settings",
                    "description"       => __( "", "js_composer" )
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Date / Time Limitations", "js_composer" ),
                    "param_name"        => "counter_scope",
                    "width"             => 150,
                    "value"             => array(
						__( 'Specify Date Only', "js_composer" )									=> "1",
						__( 'Specify Date and Time', "js_composer" )								=> "2",
                        __( 'Specifiy Time Only (repeating on every day)', "js_composer" )			=> "3",
                    ),
                    "description"       => __( "Select the countdown scope in terms of date and time.", "js_composer" )
                ),
				
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Minute Intervals", "js_composer" ),
                    "param_name"        => "counter_interval",
                    "width"             => 150,
                    "value"             => array(
						__( '60 Minutes', "js_composer" )											=> "60",
						__( '30 Minutes', "js_composer" )											=> "30",
                        __( '15 Minutes', "js_composer" )											=> "15",
						__( '10 Minutes', "js_composer" )											=> "10",
						__( '5 Minutes', "js_composer" )											=> "5",
						__( '1 Minute', "js_composer" )												=> "1",
                    ),
                    "description"       => __( "Select the intervals for the time selector.", "js_composer" ),
					"dependency"        => array( 'element' => "counter_scope", 'value' => array('2', '3') )
                ),
				
                array(
                    "type"              => "date_input",
                    "heading"           => __( "Date", "js_composer" ),
                    "param_name"        => "counter_date",
                    "value"             => "",
                    "admin_label"		=> true,
                    "description"       => __( "Select the date to which you want to count down to.", "js_composer" ),
					"dependency"        => array( 'element' => "counter_scope", 'value' => array('1') )
                ),
                array(
                    "type"              => "datetime_input",
                    "heading"           => __( "Date / Time", "js_composer" ),
                    "param_name"        => "counter_datetime",
                    "value"             => "",
                    "admin_label"		=> true,
                    "description"       => __( "Select the date and time to which you want to count down to.", "js_composer" ),
					"dependency"        => array( 'element' => "counter_scope", 'value' => array('2') )
                ),
                array(
                    "type"              => "time_input",
                    "heading"           => __( "Time", "js_composer" ),
                    "param_name"        => "counter_time",
                    "value"             => "",
                    "admin_label"		=> true,
                    "description"       => __( "Select the time on the day above to which you want to count down to.", "js_composer" ),
					"dependency"        => array( 'element' => "counter_scope", 'value' => array('3') )
                ),
				array(
					"type"				=> "switch",
                    "heading"           => __( "Show Leading Zeros", "js_composer" ),
                    "param_name"        => "date_zeros",
                    "value"             => "true",
					"on"				=> __( 'Yes', "js_composer" ),
					"off"				=> __( 'No', "js_composer" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want to show a leading zero for values less than 10.", "js_composer" ),
                    "dependency"        => ""
				),
				array(
					"type"				=> "switch",
                    "heading"           => __( "Show Remaining Days", "js_composer" ),
                    "param_name"        => "date_days",
                    "value"             => "true",
					"on"				=> __( 'Yes', "js_composer" ),
					"off"				=> __( 'No', "js_composer" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want to show the number of days remaining.", "js_composer" ),
                    "dependency"        => array( 'element' => "style", 'value' => array('minimum','columns','bars','circles') )
				),
				array(
					"type"				=> "switch",
                    "heading"           => __( "Show Remaining Hours", "js_composer" ),
                    "param_name"        => "date_hours",
                    "value"             => "true",
					"on"				=> __( 'Yes', "js_composer" ),
					"off"				=> __( 'No', "js_composer" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want to show the number of hours remaining.", "js_composer" ),
                    "dependency"        => ""
				),
				array(
					"type"				=> "switch",
                    "heading"           => __( "Show Remaining Minutes", "js_composer" ),
                    "param_name"        => "date_minutes",
                    "value"             => "true",
					"on"				=> __( 'Yes', "js_composer" ),
					"off"				=> __( 'No', "js_composer" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want to show the number of minutes remaining.", "js_composer" ),
                    "dependency"        => ""
				),
				array(
					"type"				=> "switch",
                    "heading"           => __( "Show Remaining Seconds", "js_composer" ),
                    "param_name"        => "date_seconds",
                    "value"             => "true",
					"on"				=> __( 'Yes', "js_composer" ),
					"off"				=> __( 'No', "js_composer" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want to show the number of seconds remaining.", "js_composer" ),
                    "dependency"        => ""
				),
				// Color Settings for Basic Style
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "js_composer" ),
                    "param_name"        => "seperator_3",
                    "value"             => "Color Settings",
                    "description"       => __( "", "js_composer" )
                ),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Background Color", "js_composer" ),
					"param_name"        => "color_background_basic",
					"value"             => "#f7f7f7",
					"description"       => __( "Define the background color for the countdown element.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => array('minimum', 'columns') )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Numbers Color", "js_composer" ),
					"param_name"        => "color_numbers_basic",
					"value"             => "#000000",
					"description"       => __( "Define the font color for the numbers.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => array('minimum', 'columns') )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Text Color", "js_composer" ),
					"param_name"        => "color_text_basic",
					"value"             => "#000000",
					"description"       => __( "Define the font color for the text stings.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => array('minimum', 'columns') )
				),
				// Color Settings for Bars Style
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Background Color", "js_composer" ),
					"param_name"        => "color_background_bars",
					"value"             => "#ffc728",
					"description"       => __( "Define the background color for the countdown element.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'bars' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Numbers Color", "js_composer" ),
					"param_name"        => "color_numbers_bars",
					"value"             => "#ffffff",
					"description"       => __( "Define the font color for the numbers.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'bars' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Text Color", "js_composer" ),
					"param_name"        => "color_text_bars",
					"value"             => "#a76500",
					"description"       => __( "Define the font color for the text stings.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'bars' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Bar Background Color", "js_composer" ),
					"param_name"        => "color_barback_bars",
					"value"             => "#a66600",
					"description"       => __( "Define the background color for the animated bars.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'bars' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Bar Value Color", "js_composer" ),
					"param_name"        => "color_barfore_bars",
					"value"             => "#ffffff",
					"description"       => __( "Define the foreground color for the animated bars.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'bars' )
				),
				// Color Settings for Digital Clock Style 1
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Background Color", "js_composer" ),
					"param_name"        => "color_background_clock1",
					"value"             => "#000000",
					"description"       => __( "Define the background color for the countdown element.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'clock1' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Numbers Color", "js_composer" ),
					"param_name"        => "color_numbers_clock1",
					"value"             => "#ffffff",
					"description"       => __( "Define the font color for the numbers.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'clock1' )
				),
				// Color Settings for Digital Clock Style 2
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Background Color", "js_composer" ),
					"param_name"        => "color_background_clock2",
					"value"             => "#000000",
					"description"       => __( "Define the background color for the countdown element.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'clock2' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Numbers Color", "js_composer" ),
					"param_name"        => "color_numbers_clock2",
					"value"             => "#00deff",
					"description"       => __( "Define the font color for the numbers.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'clock2' )
				),
				// Color Settings for Circles Style
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Background Color", "js_composer" ),
					"param_name"        => "color_background_circles",
					"value"             => "#000000",
					"description"       => __( "Define the background color for the countdown element.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Numbers Color", "js_composer" ),
					"param_name"        => "color_numbers_circles",
					"value"             => "#ffffff",
					"description"       => __( "Define the font color for the numbers.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Text Color", "js_composer" ),
					"param_name"        => "color_text_circles",
					"value"             => "#929292",
					"description"       => __( "Define the font color for the text stings.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Circles Background Color", "js_composer" ),
					"param_name"        => "color_circleback_all",
					"value"             => "#282828",
					"description"       => __( "Define the background color for the animated circles.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Circles Value Color: Days", "js_composer" ),
					"param_name"        => "color_circlefore_days",
					"value"             => "#117d8b",
					"description"       => __( "Define the background color for the animated days value.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Circles Value Color: Hours", "js_composer" ),
					"param_name"        => "color_circlefore_hours",
					"value"             => "#117d8b",
					"description"       => __( "Define the background color for the animated hours value.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Circles Value Color: Minutes", "js_composer" ),
					"param_name"        => "color_circlefore_minutes",
					"value"             => "#117d8b",
					"description"       => __( "Define the background color for the animated minutes value.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Circles Value Color: Seconds", "js_composer" ),
					"param_name"        => "color_circlefore_seconds",
					"value"             => "#117d8b",
					"description"       => __( "Define the background color for the animated seconds value.", "js_composer" ),
					"dependency"        => array( 'element' => "style", 'value' => 'circles' )
				),
				// Column Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "js_composer" ),
                    "param_name"        => "seperator_4",
                    "value"             => "Column Settings",
                    "description"       => __( 'These settings only apply to "Basic Styling with Columns".', "js_composer" )
                ),
				array(
					"type"				=> "switch",
                    "heading"           => __( "Equalize Column Width", "js_composer" ),
                    "param_name"        => "column_equal_width",
                    "value"             => "true",
					"on"				=> __( 'Yes', "js_composer" ),
					"off"				=> __( 'No', "js_composer" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want all columns to have an equal width based on the largest column.", "js_composer" ),
                    "dependency"        => ""
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Column Background Color", "js_composer" ),
					"param_name"        => "column_background_color",
					"value"             => "#f7f7f7",
					"description"       => __( "Define the color of the countdown column border.", "js_composer" ),
					"dependency"        => array( 'element' => "border_column_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Column Border Type", "js_composer" ),
					"param_name"        => "column_border_type",
					"width"             => 300,
					"value"             => $this->TS_VCSC_Border_Type,
					"description"       => __( "Select the type of border around countdown columns.", "js_composer" ),
					"dependency"        => ""
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Column Border Thickness", "js_composer" ),
					"param_name"        => "column_border_thick",
					"value"             => "1",
					"min"               => "1",
					"max"               => "10",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Define the thickness of the countdown column border.", "js_composer" ),
					"dependency"        => array( 'element' => "column_border_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Column Border Radius", "js_composer" ),
					"param_name"        => "column_border_radius",
					"value"             => $this->TS_VCSC_Icon_Border_Radius,
					"description"       => __( "Define the radius of the countdown column border.", "js_composer" ),
					"dependency"        => array( 'element' => "column_border_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Column Border Color", "js_composer" ),
					"param_name"        => "column_border_color",
					"value"             => "#dddddd",
					"description"       => __( "Define the color of the countdown column border.", "js_composer" ),
					"dependency"        => array( 'element' => "column_border_type", 'value' => $this->TS_VCSC_Border_Type_Values )
				),
				// Other Settings
				array(
					"type"              => "seperator",
					"heading"           => __( "", "js_composer" ),
					"param_name"        => "seperator_5",
					"value"             => "Other Settings",
					"description"       => __( "", "js_composer" )
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Margin Top", "js_composer" ),
					"param_name"        => "margin_top",
					"value"             => "0",
					"min"               => "-50",
					"max"               => "200",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Select the top margin for the countdown element.", "js_composer" )
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Margin Bottom", "js_composer" ),
					"param_name"        => "margin_bottom",
					"value"             => "0",
					"min"               => "-50",
					"max"               => "200",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Select the bottom margin for the countdown element.", "js_composer" )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Define ID Name", "js_composer" ),
					"param_name"        => "el_id",
					"value"             => "",
					"description"       => __( "Enter a unique ID name for the countdown element.", "js_composer" )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Extra Class Name", "js_composer" ),
					"param_name"        => "el_class",
					"value"             => "",
					"description"       => __( "Enter a class name for the countdown element.", "js_composer" )
				),
				// Load Custom CSS/JS File
				array(
					"type"              => "load_file",
					"heading"           => __( "", "js_composer" ),
                    "param_name"        => "el_file",
					"value"             => "",
					"file_type"         => "js",
					"file_path"         => "js/ts-visual-composer-extend-element.min.js",
					"description"       => __( "", "js_composer" )
				),
            ))
        );
    }
?>