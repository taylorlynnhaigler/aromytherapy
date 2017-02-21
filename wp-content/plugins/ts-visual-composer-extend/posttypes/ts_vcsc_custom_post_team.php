<?php
    // Create "VC Team" Post Type and Custom Taxonomies
    function TS_VCSC_Team_Post_Type() {
        $labels = array(
            'name'                  	=> _x( 'Members',			'post type general name' ),
            'singular_name'         	=> _x( 'Team Member',		'post type singular name' ),
            'add_new'               	=> _x( 'Add New',			'book' ),
            'add_new_item'          	=> __( 'Add New Teammate' ),
            'edit_item'             	=> __( 'Edit Teammate' ),
            'new_item'              	=> __( 'New Teammate' ),
            'view_item'             	=> __( 'View Teammate' ),
            'search_items'          	=> __( 'Search Teammates' ),
            'not_found'             	=> __( 'No Teammate(s) found' ),
            'not_found_in_trash'    	=> __( 'No Teammate(s) found in the Trash' ), 
            'parent_item_colon'     	=> '',
            'menu_name'             	=> 'VC Team'
        );
        $args = array(
            'labels'                	=> $labels,
            'description'           	=> 'Add Team Information to be used with the Visual Composer Extensions plugin.',
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
        register_post_type('ts_team', $args);
        
		$labels = array(
			'name'                  	=> __( 'Team / Group'),
			'singular_name'         	=> __( 'Team / Group'),
			'search_items'          	=> __( 'Search in Teams / Groups'),
			'all_items'             	=> __( 'Teams / Groups'),
			'parent_item'           	=> __( 'Parent Team / Group'),
			'parent_item_colon'     	=> __( 'Parent Team / Group:'),
			'edit_item'             	=> __( 'Edit Team / Group'), 
			'update_item'           	=> __( 'Update Team / Group'),
			'add_new_item'          	=> __( 'Add New Team / Group'),
			'new_item_name'         	=> __( 'New Team / Group Name'),
			'menu_name'             	=> __( 'Teams / Groups')
		);
        
		register_taxonomy(
			'ts_team_category',
			array('ts_team'),
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
    add_action('init', 'TS_VCSC_Team_Post_Type');
   
    
    // Create Custom Messages
    function TS_VCSC_Team_Post_Messages($messages) {
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
    add_filter('post_updated_messages', 'TS_VCSC_Team_Post_Messages');

    
    // Add Content for Contextual Help Section
    function TS_VCSC_Team_Post_Help( $contextual_help, $screen_id, $screen ) { 
        if ( 'edit-ts_team' == $screen->id ) {
            $contextual_help = '<h2>Team Members</h2>
            <p>Team Members show the details and contact information for staff or group members that you want to provide to your visitors.</p> 
            <p>You can view/edit the details of each team member by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
        } else if ('ts_team' == $screen->id) {
            $contextual_help = '<h2>Editing Team Members</h2>
            <p>This page allows you to view/modify team member details. Please make sure to fill out the available boxes with the appropriate details. Team Member information can only be used with the Visual Composer Extensions Plugin.</p>';
        }
        return $contextual_help;
    }
    add_action('contextual_help', 'TS_VCSC_Team_Post_Help', 10, 3);

	
    // Configure Metabox - File Information
    $ts_team_file_config = array(
        'id'                => 'ts-vcsc-team-file',            	// meta box id, unique per meta box 
        'title'             => 'File Attachment',             	// meta box title
        'pages'             => array('ts_team'),                // post types, accept custom post types as well, default is array('post'); optional
        'context'           => 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
        'priority'          => 'high',                          // order of meta box: high (default), low; optional
        'fields'            => array(),                         // list of meta fields (can be added by field arrays) or using the class's functions
        'local_images'      => false,                           // Use local or hosted images (meta box images for add/remove)
        'use_with_theme'    => false                            // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );
    $ts_team_file_meta     			= new AT_Meta_Box($ts_team_file_config);
	$prefix                 		= 'ts_vcsc_team_basic_';
	$ts_team_file_meta->addFile($prefix.'attachment',array('desc'=>'Attach a file, including information such as a resume, for your viewers to download.','name'=> 'Attachment:'));
	$ts_team_file_meta->addText($prefix.'buttonlabel', array('std'=>'Download File','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Button Label:'));
	$ts_team_file_meta->addText($prefix.'buttontooltip', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Button Tooltip:'));
    $ts_team_file_meta->Finish();
	
    
    // Configure Metabox - Basic Information
    $ts_team_basic_config = array(
        'id'                => 'ts-vcsc-team-basic',            // meta box id, unique per meta box 
        'title'             => 'Basic Information',             // meta box title
        'pages'             => array('ts_team'),                // post types, accept custom post types as well, default is array('post'); optional
        'context'           => 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
        'priority'          => 'high',                          // order of meta box: high (default), low; optional
        'fields'            => array(),                         // list of meta fields (can be added by field arrays) or using the class's functions
        'local_images'      => false,                           // Use local or hosted images (meta box images for add/remove)
        'use_with_theme'    => false                            // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );
    $ts_team_basic_meta     = new AT_Meta_Box($ts_team_basic_config);
	$prefix                 = 'ts_vcsc_team_basic_';
	$ts_team_basic_meta->addText($prefix.'position', array('std'=>'','desc'=>'Provide some information about the team members position in your company or group.','style' =>'width: 50%;','name'=> 'Position:'));
    $prefix                 = 'ts_vcsc_team_contact_';
    $ts_team_basic_meta->addText($prefix.'email', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-email2 ts-font-icon"></i> Email Address:'));
    $ts_team_basic_meta->addText($prefix.'emaillabel', array('std'=>'','desc'=>'If left empty, the actual email address will be shown.','style' =>'width: 50%;','name'=> 'Label for Email Address:'));
	$ts_team_basic_meta->addText($prefix.'phone', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-phone2 ts-font-icon"></i> Phone Number:'));
    $ts_team_basic_meta->addText($prefix.'cell', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-mobile ts-font-icon"></i> Cell Number:'));
    $ts_team_basic_meta->addText($prefix.'portfolio', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-portfolio ts-font-icon"></i> Portfolio URL:'));
	$ts_team_basic_meta->addText($prefix.'portfoliolabel', array('std'=>'','desc'=>'If left empty, the actual URL to the portfolio site will be shown.','style' =>'width: 50%;','name'=> 'Label for Portfolio URL:'));
    $ts_team_basic_meta->addText($prefix.'other', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-link ts-font-icon"></i> Personal URL:'));
	$ts_team_basic_meta->addText($prefix.'otherlabel', array('std'=>'','desc'=>'If left empty, the actual URL to the personal site will be shown.','style' =>'width: 50%;','name'=> 'Label for Personal URL:'));
    $ts_team_basic_meta->addText($prefix.'skype', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-skype ts-font-icon"></i> Skype User Name:'));
    $ts_team_basic_meta->Finish();

    
    // Configure Metabox - Social Networks
    $ts_team_social_config = array(
        'id'                => 'ts-vcsc-team-social',           // meta box id, unique per meta box 
        'title'             => 'Social Networks',               // meta box title
        'pages'             => array('ts_team'),                // post types, accept custom post types as well, default is array('post'); optional
        'context'           => 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
        'priority'          => 'high',                          // order of meta box: high (default), low; optional
        'fields'            => array(),                         // list of meta fields (can be added by field arrays) or using the class's functions
        'local_images'      => false,                           // Use local or hosted images (meta box images for add/remove)
        'use_with_theme'    => false                            // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );
    $ts_team_social_meta    = new AT_Meta_Box($ts_team_social_config);
    $prefix                 = 'ts_vcsc_team_social_';
    $ts_team_social_meta->addText($prefix.'facebook', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-facebook1 ts-font-icon"></i> Facebook URL:'));
    $ts_team_social_meta->addText($prefix.'google', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-googleplus1 ts-font-icon"></i> Google+ URL:'));
    $ts_team_social_meta->addText($prefix.'twitter', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-twitter1 ts-font-icon"></i> Twitter URL:'));
    $ts_team_social_meta->addText($prefix.'linkedin', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-linkedin ts-font-icon"></i> Linkedin URL:'));
    $ts_team_social_meta->addText($prefix.'xing', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-xing3 ts-font-icon"></i> Xing URL:'));
	$ts_team_social_meta->addText($prefix.'envato', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-envato ts-font-icon"></i> Envato URL:'));
	$ts_team_social_meta->addText($prefix.'rss', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-rss1 ts-font-icon"></i> RSS URL:'));
	$ts_team_social_meta->addText($prefix.'forrst', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-forrst1 ts-font-icon"></i> Forrst URL:'));
    $ts_team_social_meta->addText($prefix.'flickr', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-flickr3 ts-font-icon"></i> Flickr URL:'));
    $ts_team_social_meta->addText($prefix.'instagram', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-instagram ts-font-icon"></i> Instagram URL:'));
    $ts_team_social_meta->addText($prefix.'picasa', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-picasa1 ts-font-icon"></i> Picasa URL:'));
	$ts_team_social_meta->addText($prefix.'pinterest', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-pinterest1 ts-font-icon"></i> Pinterest URL:'));
    $ts_team_social_meta->addText($prefix.'vimeo', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-vimeo1 ts-font-icon"></i> Vimeo URL:'));
    $ts_team_social_meta->addText($prefix.'youtube', array('std'=>'','desc'=>'','style' =>'width: 50%;','name'=> '<i class="ts-teamicon-youtube1 ts-font-icon"></i> Youtube URL:'));
    $ts_team_social_meta->Finish();
	
	
	// Configure Metabox - Skills
    $ts_team_skills_config = array(
        'id'                => 'ts-vcsc-team-skills',           // meta box id, unique per meta box 
        'title'             => 'Skills',               			// meta box title
        'pages'             => array('ts_team'),                // post types, accept custom post types as well, default is array('post'); optional
        'context'           => 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
        'priority'          => 'high',                          // order of meta box: high (default), low; optional
        'fields'            => array(),                         // list of meta fields (can be added by field arrays) or using the class's functions
        'local_images'      => false,                           // Use local or hosted images (meta box images for add/remove)
        'use_with_theme'    => false                            // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );
    $ts_team_skills_meta    = new AT_Meta_Box($ts_team_skills_config);
    $prefix                 = 'ts_vcsc_team_skills_';
	$ts_team_skills_meta->addText($prefix.'skillname1', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill 1:','group' => 'start'));
	$ts_team_skills_meta->addText($prefix.'skillvalue1', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Level in %:'));
	$ts_team_skills_meta->addColor($prefix.'skillcolor1',array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill Color:','group' => 'end'));
	$ts_team_skills_meta->addText($prefix.'skillname2', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill 2:','group' => 'start'));
	$ts_team_skills_meta->addText($prefix.'skillvalue2', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Level in %:'));
	$ts_team_skills_meta->addColor($prefix.'skillcolor2',array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill Color:','group' => 'end'));
	$ts_team_skills_meta->addText($prefix.'skillname3', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill 3:','group' => 'start'));
	$ts_team_skills_meta->addText($prefix.'skillvalue3', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Level in %:'));
	$ts_team_skills_meta->addColor($prefix.'skillcolor3',array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill Color:','group' => 'end'));
	$ts_team_skills_meta->addText($prefix.'skillname4', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill 4:','group' => 'start'));
	$ts_team_skills_meta->addText($prefix.'skillvalue4', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Level in %:'));
	$ts_team_skills_meta->addColor($prefix.'skillcolor4',array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill Color:','group' => 'end'));
	$ts_team_skills_meta->addText($prefix.'skillname5', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill 5:','group' => 'start'));
	$ts_team_skills_meta->addText($prefix.'skillvalue5', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Level in %:'));
	$ts_team_skills_meta->addColor($prefix.'skillcolor5',array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill Color:','group' => 'end'));
	$ts_team_skills_meta->addText($prefix.'skillname6', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill 6:','group' => 'start'));
	$ts_team_skills_meta->addText($prefix.'skillvalue6', array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Level in %:'));
	$ts_team_skills_meta->addColor($prefix.'skillcolor6',array('std'=>'','desc'=>'','style' =>'width: 50%; float: left;','name'=> 'Skill Color:','group' => 'end'));
	$ts_team_skills_meta->Finish();
	
	
	// Load Required CSS Styles
	add_action('admin_enqueue_scripts', 				'TS_VCSC_Team_Post_Files');
	function TS_VCSC_Team_Post_Files($hook_suffix) {
		global $typenow;
		if ($typenow=="ts_team") {
			echo "<link type='text/css' rel='stylesheet' href='" . TS_VCSC_GetResourceURL('css/ts-font-teammates.css') . "' />";
		}
	}
	
	
	// Add Featured Image Column
	add_filter( 'manage_ts_team_posts_columns', 		'TS_VCSC_Add_Team_Image_Column' );
	add_action( 'manage_ts_team_posts_custom_column', 	'TS_VCSC_Show_Team_Image_Column', 10, 2 );
	function TS_VCSC_Add_Team_Image_Column( $defaults ){
		$defaults = array_merge(
			array('ts_team_post_thumbs' => __('Thumbnail')),
			$defaults
		);
		return $defaults;
	}
	function TS_VCSC_Show_Team_Image_Column( $column_name, $id ) {
		if ( $column_name === 'ts_team_post_thumbs' ) {
			echo the_post_thumbnail('thumbnail');
		}
	}
?>