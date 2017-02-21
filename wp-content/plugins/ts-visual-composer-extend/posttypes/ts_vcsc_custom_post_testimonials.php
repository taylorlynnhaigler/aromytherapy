<?php
    // Create "VC Testimonials" Post Type and Custom Taxonomies
    function TS_VCSC_Testimonials_Post_Type() {
        $labels = array(
            'name'                  	=> _x( 'Testimonials',		'post type general name' ),
            'singular_name'         	=> _x( 'Testimonial',		'post type singular name' ),
            'add_new'               	=> _x( 'Add New',			'book' ),
            'add_new_item'          	=> __( 'Add New Testimonial' ),
            'edit_item'             	=> __( 'Edit Testimonial' ),
            'new_item'              	=> __( 'New Testimonial' ),
            'view_item'             	=> __( 'View Testimonial' ),
            'search_items'          	=> __( 'Search Testimonials' ),
            'not_found'             	=> __( 'No Testimonial(s) found' ),
            'not_found_in_trash'    	=> __( 'No Testimonial(s) found in the Trash' ), 
            'parent_item_colon'     	=> '',
            'menu_name'             	=> 'VC Testimonials'
        );
        $args = array(
            'labels'                	=> $labels,
            'description'           	=> 'Add Testimonials to be used with the Visual Composer Extensions plugin.',
            'public'                	=> false,
			'rewrite'               	=> true,
			'exclude_from_search'		=> true,
            'publicly_queryable'    	=> false,
            'show_ui'               	=> true,
            'show_in_menu'          	=> true, 
            'query_var'             	=> true,
            'rewrite'               	=> true,
            'capability_type'       	=> 'post',
            'has_archive'           	=> false, 
            'hierarchical'          	=> false,
            'menu_position'         	=> 5,
            'supports'              	=> array('title', 'editor', 'thumbnail'),
        );
        register_post_type('ts_testimonials', $args);
        
		$labels = array(
			'name'                  	=> __( 'Categories'),
			'singular_name'         	=> __( 'Category'),
			'search_items'          	=> __( 'Search in Categories'),
			'all_items'             	=> __( 'Categories'),
			'parent_item'           	=> __( 'Parent Category'),
			'parent_item_colon'     	=> __( 'Parent Category:'),
			'edit_item'             	=> __( 'Edit Category'), 
			'update_item'           	=> __( 'Update Category'),
			'add_new_item'          	=> __( 'Add New Category'),
			'new_item_name'         	=> __( 'New Category'),
			'menu_name'             	=> __( 'Categories')
		);
        
		register_taxonomy(
			'ts_testimonials_category',
			array('ts_testimonials'),
			array(
				'hierarchical'          => true,
				'public'                => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'rewrite'               => true,
				'show_admin_column'		=> true,
			)
		);
    }
    add_action('init', 'TS_VCSC_Testimonials_Post_Type');
   
    
    // Create Custom Messages
    function TS_VCSC_Testimonials_Post_Messages($messages) {
		global $post, $post_ID;
		$post_type = get_post_type( $post_ID );
		$obj = get_post_type_object($post_type);
		$singular = $obj->labels->singular_name;
		$messages[$post_type] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __($singular.' updated.')),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __($singular.' updated.'),
			5 => isset($_GET['revision']) ? sprintf( __($singular.' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __($singular.' published.')),
			7 => __('Page saved.'),
			8 => sprintf( __($singular.' submitted.')),
			9 => sprintf( __($singular.' scheduled for: <strong>%1$s</strong>.'), date_i18n( __('M j, Y @ G:i'), strtotime($post->post_date))),
			10 => sprintf( __($singular.' draft updated.')),
		);
		return $messages;
    }
    add_filter('post_updated_messages', 'TS_VCSC_Testimonials_Post_Messages');

    
    // Add Content for Contextual Help Section
    function TS_VCSC_Testimonials_Post_Help( $contextual_help, $screen_id, $screen ) { 
        if ( 'edit-ts_testimonials' == $screen->id ) {
            $contextual_help = '<h2>Testimonials</h2>
            <p>Testimonials are an easy way to display feedback you received from your customers or to show any other quotes on your website.</p> 
            <p>You can view/edit the details of each testimonial by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
        } else if ('ts_testimonials' == $screen->id) {
            $contextual_help = '<h2>Editing Testimonials</h2>
            <p>This page allows you to view/modify testimonial details. Please make sure to fill out the available boxes with the appropriate details. Testimonial information can only be used with the Visual Composer Extensions Plugin.</p>';
        }
        return $contextual_help;
    }
    add_action('contextual_help', 'TS_VCSC_Testimonials_Post_Help', 10, 3);


    // Configure Metabox - Basic Information
    $ts_testimonial_basic_config = array(
        'id'                => 'ts-vcsc-testimonial-basic',		// meta box id, unique per meta box 
        'title'             => 'Testimonial Information',		// meta box title
        'pages'             => array('ts_testimonials'),		// post types, accept custom post types as well, default is array('post'); optional
        'context'           => 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
        'priority'          => 'high',                          // order of meta box: high (default), low; optional
        'fields'            => array(),                         // list of meta fields (can be added by field arrays) or using the class's functions
        'local_images'      => false,                           // Use local or hosted images (meta box images for add/remove)
        'use_with_theme'    => false                            // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );
    $ts_testimonial_basic_meta     	= new AT_Meta_Box($ts_testimonial_basic_config);
	$prefix                 		= 'ts_vcsc_testimonial_basic_';
	$ts_testimonial_basic_meta->addText($prefix.'author', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> 'Author Name:'));
    $ts_testimonial_basic_meta->addText($prefix.'position', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> 'Company / Position:'));
    $ts_testimonial_basic_meta->Finish();

	
	// Load Required CSS Styles
	add_action('admin_enqueue_scripts', 				'TS_VCSC_Testimonials_Post_Files');
	function TS_VCSC_Testimonials_Post_Files($hook_suffix) {
		global $typenow;
		if ($typenow=="ts_testimonials") {
			echo "<link type='text/css' rel='stylesheet' href='" . TS_VCSC_GetResourceURL('css/ts-font-teammates.css') . "' />";
		}
	}
	
	
	// Add Featured Image Column
	add_filter( 'manage_ts_testimonials_posts_columns', 		'TS_VCSC_Add_Testimonials_Image_Column' );
	add_action( 'manage_ts_testimonials_posts_custom_column', 	'TS_VCSC_Show_Testimonials_Image_Column', 10, 2 );
	function TS_VCSC_Add_Testimonials_Image_Column( $defaults ){
		$defaults = array_merge(
			array('ts_testimonials_post_thumbs' => __('Thumbnail')),
			$defaults
		);
		return $defaults;
	}
	function TS_VCSC_Show_Testimonials_Image_Column( $column_name, $id ) {
		if ( $column_name === 'ts_testimonials_post_thumbs' ) {
			echo the_post_thumbnail('thumbnail');
		}
	}
?>