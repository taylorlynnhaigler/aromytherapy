<?php

if ( ! class_exists('ether_metabox_builder'))
{
	class ether_metabox_builder extends ether_metabox
	{
		public static function init()
		{
			if (is_admin())
			{
				ether::script( array
				(
					array
					(
						'path' => 'admin/media/scripts/builder.js',
						'deps' => array('jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable'),
						'version' => ether::config('version')
					)
				));

				ether::stylesheet( array
				(
					array
					(
						'path' => 'admin/media/stylesheets/builder.css',
						'version' => ether::config('version')
					)
				));

				ether::configjs('hide_visual_tab', ether::option('hide_visual_tab') == 'on');
				ether::configjs('hide_html_tab', ether::option('hide_html_tab') == 'on');
			}
		}

		public static function header()
		{

		}

		public static function restore_revision($post_id, $revision_id)
		{
			if (ether::option('builder_revisions') == 'on')
			{
				$post = get_post($post_id);
				$revision = get_post($revision_id);
				$data = get_metadata('post', $revision->ID, ether::config('prefix').'builder_data', TRUE);

				if ($data !== FALSE)
				{
					update_post_meta($post_id, ether::config('prefix').'builder_data', $data);
				} else
				{
					delete_post_meta($post_id, ether::config('prefix').'builder_data');
				}
			}
		}

		public static function save($post_id)
		{
			global $post;
			global $post_type;

			if (isset($_POST['ether_builder_widget']['__LOCATION__']))
			{
				unset($_POST['ether_builder_widget']['__LOCATION__']);
			}

			if (isset($_POST['ether_builder_widget']['__ID__']))
			{
				unset($_POST['ether_builder_widget']['__ID__']);
			}

			if (ether::option('builder_revisions') == 'on')
			{
				$parent_id = wp_is_post_revision($post_id);

				if ($parent_id)
				{
					$parent = get_post($parent_id);

					$data = get_post_meta($parent->ID, ether::config('prefix').'builder_data', TRUE);

					if ($data !== FALSE)
					{
						add_metadata('post', $post_id, ether::config('prefix').'builder_data', $_POST['ether_builder_widget']);
					}
				} else
				{
					ether::meta('builder_data', $_POST['ether_builder_widget'], $post->ID, TRUE);
				}
			} else
			{
				if ($post != NULL)
				{
					ether::meta('builder_data', $_POST['ether_builder_widget'], $post->ID, TRUE);
				}
			}

			ether::handle_field($_POST, array
			(
				'checkbox' => array
				(
					array
					(
						'name' => 'editor_tab',
						'relation' => 'meta',
						'value' => ''
					)
				)
			));
		}

		public static function body($builder_data = array(), $parent_id = NULL, $read_only = FALSE)
		{
			global $post;
			global $post_type;
			global $_D;

			$body = '';

			// this piece of sh... code provides tinymce initialization when visual editing is disabled for current user
			// it's required for builder widgets using rich editing
			// and yes, those users except rich text to be working in the builder when visual editor was disabled:)
			if ( ! user_can_richedit())
			{
				add_filter('user_can_richedit', '__return_true');
				ob_start();
				wp_editor('dummy_editor_only_for_tinymce_initialization');
				$dirty_solution = ob_get_clean();
				remove_filter('user_can_richedit', '__return_true');
			}

			//if (($post->post_type == 'section' OR $post->post_type == 'portfolio') OR $force_output)
			{
				$widgets_output = '';

				$builder_hidden_widgets = ether::option('builder_hidden_widgets');

				if (isset($builder_hidden_widgets[0]) AND ! empty($builder_hidden_widgets[0]))
				{
					$builder_hidden_widgets = $builder_hidden_widgets[0];
				}

				if ( ! is_array($builder_hidden_widgets))
				{
					$builder_hidden_widgets = array();
				}

				$widgets = ether_builder::get_widgets();

				foreach ($widgets as $widget)
				{
					if (isset($builder_hidden_widgets[$widget->get_slug()]) AND $builder_hidden_widgets[$widget->get_slug()] == 'on')
					{
						$widget->hide();
					}

					$widgets_output .= $widget->admin_form(/*$_D['widgets']*/);
				}

				$body .= '<div id="builder-widgets" style="display: none;">
					<button name="builder-modal-close" class="builder-modal-close">close</button>
					<fieldset class="ether-form filter-builder-widgets">
						<label class="hidden-widgets"><div class="hidden-widgets-count">'.ether::langr('%s hidden widgets', count($builder_hidden_widgets)).' &bull; </div><div class="hidden-widgets-show"><a href="#show-hidden-widgets">'.ether::langr('Show all widgets').'</a> &bull; </div><div><a href="admin.php?page=ether-ether-builder" target="_blank">'.ether::langr('Manage visible widgets').'</a></div></label>
						<label class="filter"><input type="text" placeholder="'.ether::langr('Filter widgets').'" name="builder-widget-filter" value="" /></label>
					</fieldset>
					<div class="builder-widgets-wrap">
					'.$widgets_output.'
					</div>
				</div>';

				$body .= '<div class="builder-location-wrapper'.($read_only ? ' read-only' : '').'"><fieldset class="ether-form">';//.($post_type == 'portfolio' ? '<p class="hint">'.ether::langr('The following layout will be applied to all projects that belong to this portfolio. Make sure gallery widget is included or else you won\'t be able to add images to those projects.').'</p>' : '');

				$widgets_output = '';
				$widgets = ether_builder::get_widgets();
				$locations = ether_builder::get_locations();
				$builder_widgets = array();

				if ( ! is_array($builder_data))
				{
					$builder_data = array();
				}

				$tmp_post = NULL;

				if (ether::option('builder_revisions') != 'on')
				{
					if (isset($_GET['post']) AND $_GET['post'] != $post->ID)
					{
						$tmp_post = $post;

						$post = get_post($_GET['post']);
					}
				}

				$id = $post->ID;

				if ($parent_id != NULL AND $parent_id > 0)
				{
					$id = $parent_id;
				}

				$builder_widgets = ether::meta('builder_data', TRUE, $id);

				if (defined('ICL_LANGUAGE_CODE') AND ( ! is_array($builder_widgets) OR empty($builder_widgets)))
				{
					global $sitepress;

					if (ICL_LANGUAGE_CODE != $sitepress->get_default_language())
					{
						if ($post->post_status == 'auto-draft' AND isset($_GET['trid']) AND isset($_GET['source_lang']))
						{
							global $wpdb;
							global $table_prefix;

							$prefix = $table_prefix;

							$id = $wpdb->get_var('SELECT element_id FROM `'.$prefix.'icl_translations` WHERE `trid`=\''.$_GET['trid'].'\' AND `language_code`=\''.$_GET['source_lang'].'\'');
						} else
						{
							$id = icl_object_id($post->ID, $post->post_type, true, (isset($_GET['source_lang']) ? $_GET['source_lang'] : $sitepress->get_default_language()));
						}

						$builder_widgets = ether::meta('builder_data', TRUE, $id);
					}
				}

				if (defined('ICL_LANGUAGE_CODE') AND is_string($builder_widgets))
				{
					// wpml breaks sometimes serialized data
					$builder_widgets = ether_builder::unserialize($builder_widgets);
				}

				foreach ($locations as $location => $name)
				{
					$builder_widgets_output = '';

					$body .= '<div class="buttonset-1"><button name="builder-widget-add" class="button-1 button-1-2 builder-widget-add" ><span>'.ether::langr('Add widget').'</span></button></div>';
					$body .= '<div id="builder-location-'.$location.'" class="builder-location">';
					$body .= ether_builder::parse($builder_widgets, $location, TRUE, $builder_data);
					$body .= '</div>';
					$body .= '<div class="buttonset-1"><button name="builder-widget-add" class="button-1 button-1-2 builder-widget-add"><span>'.ether::langr('Add widget').'</span></button></div>';
				}

				$builder_tab_default = FALSE;

				if ( ! isset($_GET['post']) AND ether::option('builder_tab_default'))
				{
					$builder_tab_default = TRUE;
				}

				$body .= ether::make_field('editor_tab', array('type' => 'hidden', 'relation' => 'meta', 'use_default' => $builder_tab_default, 'value' => ($builder_tab_default ? 'builder' : '')));

				if ($tmp_post != NULL)
				{
					$post = $tmp_post;
				}

				$body .= '</fieldset></div>';
			}

			return $body;
		}
	}
}

?>
