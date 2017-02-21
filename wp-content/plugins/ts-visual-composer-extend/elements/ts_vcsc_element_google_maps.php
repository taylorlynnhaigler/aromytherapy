<?php
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                          => __( "TS Google Maps", 'js_composer' ),
            "base"                          => "TS-VCSC-Google-Maps",
            "icon"                          => "icon-wpb-ts_vcsc_google_maps",
            "class"                         => "",
            "category"                      => __( "VC Extensions", "js_composer" ),
            "description" 		            => __("Place a Google Map", "js_composer"),
            //"admin_enqueue_js"            => array(ts_fb_get_resource_url('/js/...')),
            //"admin_enqueue_css"           => array(ts_fb_get_resource_url('/css/...')),
            "params"                        => array(
                // Map Settings
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_1",
                    "value"                 => "Map Settings",
                    "description"           => __( "", "js_composer" )
                ),
				array(
					"type"                  => "dropdown",
					"class"                 => "",
					"heading"               => __("Map Type", "smile"),
					"param_name"            => "maptype",
					"admin_label"           => true,
					"value"                 => array(
                        __("Road Map", "")                  => "ROADMAP",
                        __("Satellite Map", "")             => "SATELLITE",
                        __("Hybrid Map", "")                => "HYBRID",
                        __("Terrain Map", "")               => "TERRAIN",
                        __("Open Street Map", "")           => "OSM",
                    ),
                    "description"           => __( "Select the map type the map should initially be shown with.", "js_composer" )
				),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Road Map Style", 'js_composer' ),
                    "param_name"            => "mapstyle",
                    "admin_label"           => true,
                    "value"			        => array(
                        __( "Default", "")                  => "style_default",
                        __( "Pale Dawn", "" )               => "style_pale_dawn",
                        __( "Subtle Grayscale", "" )        => "style_subtle_grayscale",
                        __( "Blue Water", "" )              => "style_blue_water",
                        __( "Midnight Commander", "" )      => "style_midnight_commander",
                        __( "Retro", "" )                   => "style_retro",
                        __( "Shades of Grey", "" )          => "style_shades_grey",
                        __( "Gowalla", "" )                 => "style_gowalla",
                        __( "Light Monochrome", "" )        => "style_light_monochrome",
                        __( "Greyscale", "" )               => "style_greyscale",
                        __( "Subtle", "" )                  => "style_subtle",
                        __( "Paper", "" )                   => "style_paper",
                        __( "Neutral Blue", "" )            => "style_neutral_blue",
                        __( "Bright & Bubbly", "" )         => "style_bright_bubbly",
                        __( "Apple Maps-Esque", "" )        => "style_apple_mapsesque",
                        __( "Shift Worker", "" )            => "style_shift_worker",
                        __( "Avocado World", "" )           => "style_avocado_world",
                        __( "Map Box", "" )                 => "style_mapbox",
                        __( "Countries", "" )               => "style_countries",
                        __( "Lunar Landscape", "" )         => "style_lunar_landscape",
                        __( "Snazzy Maps", "" )             => "style_snazzy_maps",
                    ),
                    "description"           => __( "Select the color style for the road map layout.", "js_composer" )
                ),
                array(
                    "type"		            => "textfield",
                    "class"		            => "",
                    "heading"               => __( "Coordinates", 'js_composer' ),
                    "param_name"            => "coordinates",
                    "value"                 => "",
                    "admin_label"           => true,
                    "description"	        => __( "You can use <a href='http://www.gpsvisualizer.com/geocode' target='_blank'>http://www.gpsvisualizer.com/geocode</a> to find your coordinates (Example: 40.7484963, -73.9855961)", 'js_composer' )
                ),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Use Metric Dimensions", "js_composer" ),
                    "param_name"            => "metric",
                    "value"                 => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want to use metric dimensions for distances and speeds.", "js_composer" ),
                    "dependency"        	=> ""
				),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Zoom Level", "js_composer" ),
                    "param_name"            => "markerzoom",
                    "value"                 => "17",
                    "min"                   => "0",
                    "max"                   => "21",
                    "step"                  => "1",
                    "unit"                  => '',
                    "admin_label"           => true,
                    "description"           => __( "Define the initial zoom level for the map.", "js_composer" )
                ),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Make Map Full-Width", "js_composer" ),
                    "param_name"            => "mapfullwidth",
                    "value"                 => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want attempt showing the map in full width (will not work with all themes).", "js_composer" ),
                    "dependency"        	=> ""
				),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Full Width Breakouts", "js_composer" ),
                    "param_name"            => "breakouts",
                    "value"                 => "6",
                    "min"                   => "0",
                    "max"                   => "99",
                    "step"                  => "1",
                    "unit"                  => '',
                    "description"           => __( "Define the number of parent containers the map should attempt to break away from.", "js_composer" ),
                    "dependency"            => array( 'element' => "mapfullwidth", 'value' => 'true' )
                ),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Additional Map Wrapper", "js_composer" ),
                    "param_name"            => "mapfullwrapper",
                    "value"                 => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if the map should be wrapped with another div when breaking away from parent(s).", "js_composer" ),
                    "dependency"            => array( 'element' => "mapfullwidth", 'value' => 'true' )
				),
                // Map Controls
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_2",
                    "value"                 => "Map Controls",
                    "description"           => __( "", "js_composer" )
                ),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Show Directions Control Panel", "js_composer" ),
                    "param_name"            => "directions",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want show a control panel to get directions to the specified address.", "js_composer" ),
                    "dependency"            => ""
				),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Show Pan Controls", "js_composer" ),
                    "param_name"            => "controls_pan",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want show the map pan controls.", "js_composer" ),
                    "dependency"            => ""
				),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Show Zoom Controls", "js_composer" ),
                    "param_name"            => "controls_zoom",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want show the map zoom controls.", "js_composer" ),
                    "dependency"            => ""
				),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Show Scale Controls", "js_composer" ),
                    "param_name"            => "controls_scale",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want show the map scale controls.", "js_composer" ),
                    "dependency"            => ""
				),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Show StreetView Controls", "js_composer" ),
                    "param_name"            => "controls_street",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want show the map streetview controls.", "js_composer" ),
                    "dependency"            => ""
				),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Show Map Style Selector", "js_composer" ),
                    "param_name"            => "controls_style",
                    "value"                 => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want show the style selector for the roadmap type.", "js_composer" ),
                    "dependency"            => ""
				),
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_3",
                    "value"                 => "Marker Settings",
                    "description"           => __( "", "js_composer" )
                ),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Marker Style", 'js_composer' ),
                    "param_name"            => "markerstyle",
                    "value"			        => array(
                        __( "Google Default", "")           => "default",
                        __( "Marker Selection", "" )        => "marker",
                        __( "Custom Image", "" )            => "image",
                    ),
                ),
                array(
                    "type"                  => "attach_image",
                    "heading"               => __( "Custom Marker Image", "js_composer" ),
                    "param_name"            => "markerimage",
                    "value"                 => "",
                    "description"           => __( "Select the image you want to use as marker; should have a maximum equal dimension of 64x64.", "js_composer" ),
                    "dependency"            => array( 'element' => "markerstyle", 'value' => 'image' )
                ),
                array(
                    "type"		            => "mapmarker",
                    "class"		            => "",
                    "heading"               => __( "Map Marker", 'js_composer' ),
                    "param_name"            => "markerinternal",
                    "value"                 => "",
                    "description"	        => __( "", 'js_composer' ),
                    "dependency"            => array( 'element' => "markerstyle", 'value' => 'marker' )
                ),
				array(
					"type"              	=> "switch",
                    "heading"               => __( "Marker Animation", "js_composer" ),
                    "param_name"            => "markeranimation",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"           => __( "Switch the toggle if you want to animate the marker when it enters the map.", "js_composer" ),
                    "dependency"            => ""
				),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Animation Type", 'js_composer' ),
                    "param_name"            => "markeranimationtype",
                    "value"			        => array(
                        __( "Drop", "")                 => "drop",
                        __( "Bounce", "" )              => "bounce",
                    ),
                    "description"           => __( "Select the type of animation the marker should have when it enters the map.", "js_composer" ),
                    "dependency"            => array( 'element' => "markeranimation", 'value' => 'true' )
                ),
                array(
                    "type"		            => "textarea_html",
                    "holder"                => "div",
                    "class"		            => "",
                    "heading"               => __( "Marker Content", 'js_composer' ),
                    "param_name"            => "content",
                    "value"                 => "",
                    "description"           => __( "Enter the map marker tooltip content but keep its limites size in mind.", "js_composer" )
                ),
                // Other Settings
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_4",
                    "value"                 => "Other Settings",
                    "description"           => __( "", "js_composer" )
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Margin Top", "js_composer" ),
                    "param_name"            => "margin_top",
                    "value"                 => "20",
                    "min"                   => "0",
                    "max"                   => "200",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "", "js_composer" )
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Margin Bottom", "js_composer" ),
                    "param_name"            => "margin_bottom",
                    "value"                 => "20",
                    "min"                   => "0",
                    "max"                   => "200",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "", "js_composer" )
                ),
                array(
                    "type"                  => "textfield",
                    "heading"               => __( "Define ID Name", "js_composer" ),
                    "param_name"            => "el_id",
                    "value"                 => "",
                    "description"           => __( "Enter an unique ID for the Google Map.", "js_composer" )
                ),
                array(
                    "type"                  => "textfield",
                    "heading"               => __( "Extra Class Name", "js_composer" ),
                    "param_name"            => "el_class",
                    "value"                 => "",
                    "description"           => __( "Enter a class name for the Google Map.", "js_composer" )
                ),
                // Load Custom CSS/JS File
                array(
                    "type"                  => "load_file",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "el_file",
                    "value"                 => "",
                    "file_type"             => "js",
                    "file_path"             => "js/ts-visual-composer-extend-element.min.js",
                    "description"           => __( "", "js_composer" )
                ),
            )
        ));
    }
?>