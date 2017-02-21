<?php
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                          => __( "TS Lightbox Gallery", "js_composer" ),
            "base"                          => "TS-VCSC-Lightbox-Gallery",
            "icon" 	                        => "icon-wpb-ts_vcsc_lightbox_gallery",
            "class"                         => "",
            "category"                      => __( 'VC Extensions', 'js_composer' ),
            "description"                   => __("Place multiple images in a lightbox element", "js_composer"),
            "admin_enqueue_js"              => "",
            "admin_enqueue_css"             => "",
            "params"                        => array(
                // Gallery Content
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_1",
                    "value"                 => "Gallery Content",
                    "description"           => __( "", "js_composer" )
                ),
				array(
					"type"                  => "attach_images",
					"heading"               => __( "Select Images", "js_composer" ),
					"param_name"            => "content_images",
					"value"                 => "",
                    "admin_label"           => true,
					"description"           => __( "Select the images for your gallery overlay; move image to arrange order in which to display.", "js_composer" ),
					"dependency"            => array( 'element' => "content_type", 'value' => 'gallery' )
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Gallery Title", "js_composer" ),
					"param_name"            => "content_title",
					"value"                 => "",
					"description"           => __( "Enter a title for the gallery itself; leave empty if you don't want to show a title.", "js_composer" )
				),
                array(
                    "type"		            => "textarea_html",
                    "holder"                => "div",
                    "class"		            => "",
                    "heading"               => __( "Gallery Description", 'js_composer' ),
                    "param_name"            => "content",
                    "value"                 => "",
                    "admin_label"           => false,
                    "description"           => __( "Create a detailed description / summary for the gallery.", "js_composer" ),
                    "dependency"            => ""
                ),
                array(
                    "type"                  => "exploded_textarea",
                    "heading"               => __( "Image Titles", "js_composer" ),
                    "param_name"            => "content_images_titles",
                    "value"                 => "",
                    "description"           => __( "Enter titles for the images; seperate by line break.", "js_composer" ),
                    "dependency"            => array( 'element' => "content_type", 'value' => 'gallery' )
                ),
                // Grid Settings
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_2",
                    "value"                 => "Gallery Grid Settings",
                    "description"           => __( "", "js_composer" )
                ),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Grid Break Points", "js_composer" ),
					"param_name"            => "data_grid_breaks",
					"value"                 => "240,480,720,960",
					"description"           => __( "Define the break points (columns) for the grid based on available screen size; seperate by comma.", "js_composer" )
				),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Grid Space", "js_composer" ),
                    "param_name"            => "data_grid_space",
                    "value"                 => "2",
                    "min"                   => "0",
                    "max"                   => "20",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Define the space between images in grid.", "js_composer" )
                ),
				array(
					"type"              	=> "switch",
					"heading"			    => __( "Maintain Image Order", "js_composer" ),
					"param_name"		    => "data_grid_order",
					"value"				    => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"		    => __( "Switch the toggle to keep original image order in grid; it is adviced to have the plugin determine order for best layout.", "js_composer" ),
					"dependency"        	=> ""
				),
                // Lightbox Settings
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "js_composer" ),
                    "param_name"            => "seperator_3",
                    "value"                 => "Lightbox Settings",
                    "description"           => __( "", "js_composer" )
                ),
				array(
					"type"              	=> "switch",
					"heading"			    => __( "Open on Pageload", "js_composer" ),
					"param_name"		    => "lightbox_pageload",
					"value"				    => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"		    => __( "Switch the toggle if you want automatically open the lightbox gallery on page load.", "js_composer" ),
					"dependency"        	=> ""
				),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Thumbnail Position", "js_composer" ),
                    "param_name"            => "thumbnail_position",
                    "width"                 => 150,
                    "value"                 => array(
                        __( 'Bottom', "js_composer" )       => "bottom",
                        __( 'Top', "js_composer" )          => "top",
                        __( 'Left', "js_composer" )         => "left",
                        __( 'Right', "js_composer" )        => "right",
                        __( 'None', "js_composer" )         => "0",
                    ),
                    "admin_label"           => true,
                    "description"           => __( "Select the position of the thumbnails in the lightbox.", "js_composer" ),
                    "dependency"            => ""
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Thumbnail Height", "js_composer" ),
                    "param_name"            => "thumbnail_height",
                    "value"                 => "100",
                    "min"                   => "50",
                    "max"                   => "200",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Define the height of the thumbnails in the lightbox.", "js_composer" ),
                    "dependency"            => array( 'element' => "thumbnail_position", 'value' => array('bottom', 'top', 'left', 'right') )
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Transition Effect", "js_composer" ),
                    "param_name"            => "lightbox_effect",
                    "width"                 => 150,
                    "value"                 => array(
                        __( 'Random', "js_composer" )       => "random",
                        __( 'Swipe', "js_composer" )        => "swipe",
                        __( 'Fade', "js_composer" )         => "fade",
                        __( 'Scale', "js_composer" )        => "scale",
                        __( 'Slide Up', "js_composer" )     => "slideUp",
                        __( 'Slide Down', "js_composer" )   => "slideDown",
                        __( 'Flip', "js_composer" )         => "flip",
                        __( 'Skew', "js_composer" )         => "skew",
                        __( 'Bounce Up', "js_composer" )    => "bounceUp",
                        __( 'Bounce Down', "js_composer" )  => "bounceDown",
                        __( 'Break In', "js_composer" )     => "breakIn",
                        __( 'Rotate In', "js_composer" )    => "rotateIn",
                        __( 'Rotate Out', "js_composer" )   => "rotateOut",
                        __( 'Hang Left', "js_composer" )    => "hangLeft",
                        __( 'Hang Right', "js_composer" )   => "hangRight",
                        __( 'Cycle Up', "js_composer" )     => "cicleUp",
                        __( 'Cycle Down', "js_composer" )   => "cicleDown",
                        __( 'Zoom In', "js_composer" )      => "zoomIn",
                        __( 'Throw In', "js_composer" )     => "throwIn",
                        __( 'Fall', "js_composer" )         => "fall",
                        __( 'Jump', "js_composer" )         => "jump",
                    ),
                    "admin_label"           => true,
                    "description"           => __( "Select the transition effect to be used for each image in the lightbox.", "js_composer" ),
                    "dependency"            => ""
                ),
				array(
					"type"              	=> "switch",
					"heading"			    => __( "Autoplay Lightbox", "js_composer" ),
					"param_name"		    => "lightbox_autoplay",
					"value"				    => "false",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"		    => __( "Switch the toggle if you want start an autoplay of the gallery once opened.", "js_composer" ),
					"dependency"        	=> ""
				),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Autoplay Speed", "js_composer" ),
                    "param_name"            => "lightbox_speed",
                    "value"                 => "5000",
                    "min"                   => "1000",
                    "max"                   => "20000",
                    "step"                  => "100",
                    "unit"                  => 'ms',
                    "description"           => __( "Define the speed at which autoplay should rotate between images.", "js_composer" ),
                    "dependency"            => array( 'element' => "lightbox_autoplay", 'value' => 'true' )
                ),
				
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Backlight Effect", "js_composer" ),
                    "param_name"            => "lightbox_backlight",
                    "width"                 => 150,
                    "value"                 => array(
                        __( 'Auto Color', "js_composer" )       => "auto",
                        __( 'Custom Color', "js_composer" )     => "custom",
                        __( 'No Backlight', "js_composer" )     => "hideit",
                    ),
                    "admin_label"           => true,
                    "description"           => __( "Select the backlight effect for the gallery images.", "js_composer" ),
                    "dependency"            => ""
                ),
				array(
					"type"                  => "colorpicker",
					"heading"               => __( "Custom Backlight Color", "js_composer" ),
					"param_name"            => "lightbox_backlight_color",
					"value"                 => "#ffffff",
					"description"           => __( "Define the backlight color for the gallery images.", "js_composer" ),
					"dependency"            => array( 'element' => "lightbox_backlight", 'value' => 'custom' )
				),
				array(
					"type"              	=> "switch",
					"heading"			    => __( "Social Share Buttons", "js_composer" ),
					"param_name"		    => "lightbox_social",
					"value"				    => "true",
					"on"					=> __( 'Yes', "js_composer" ),
					"off"					=> __( 'No', "js_composer" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"		    => __( "Switch the toggle if you want show social share buttons with deeplinking for each image.", "js_composer" ),
					"dependency"        	=> ""
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
                    "value"                 => "0",
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
                    "value"                 => "0",
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
					"description"           => __( "Enter a unique ID name for the image gallery.", "js_composer" )
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Extra Class Name", "js_composer" ),
					"param_name"            => "el_class",
					"value"                 => "",
					"description"           => __( "Enter a class name for the image gallery.", "js_composer" )
				),
				array(
					"type"                  => "load_file",
					"heading"               => __( "", "js_composer" ),
                    "param_name"            => "el_file",
					"value"                 => "",
					"file_type"             => "js",
					"file_path"             => "js/ts-visual-composer-extend-element.min.js",
					"description"           => __( "", "js_composer" )
				),
            ))
        );
    }
?>