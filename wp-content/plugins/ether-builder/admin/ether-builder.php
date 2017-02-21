<?php

if ( ! class_exists('ether_panel_ether_builder'))
{
	class ether_panel_ether_builder extends ether_panel
	{
		public static function init()
		{

		}

		public static function header()
		{

		}

		public static function reset()
		{
			ether::handle_field(array(), array
			(
				'checkbox' => array
				(
					array
					(
						'name' => 'builder_tab_default',
						'value' => ''
					),
					array
					(
						'name' => 'hide_visual_tab',
						'value' => ''
					),
					array
					(
						'name' => 'hide_html_tab',
						'value' => ''
					),
					array
					(
						'name' => 'builder_archive_hide',
						'value' => ''
					),
					array
					(
						'name' => 'builder_color',
						'value' => ''
					),
					array
					(
						'name' => 'builder_style',
						'value' => ''
					),
					array
					(
						'name' => 'builder_revisions',
						'value' => ''
					)
				)
			));

			ether::handle_field_group(array(), array
			(
				'builder_hidden_types' => array()
			));

			ether::handle_field_group(array(), array
			(
				'builder_hidden_widgets' => array()
			));
		}

		public static function save()
		{
			ether::handle_field($_POST, array
			(
				'checkbox' => array
				(
					array
					(
						'name' => 'builder_tab_default',
						'value' => ''
					),
					array
					(
						'name' => 'hide_visual_tab',
						'value' => ''
					),
					array
					(
						'name' => 'hide_html_tab',
						'value' => ''
					),
					array
					(
						'name' => 'builder_archive_hide',
						'value' => ''
					),
					array
					(
						'name' => 'builder_color',
						'value' => ''
					),
					array
					(
						'name' => 'builder_style',
						'value' => ''
					),
					array
					(
						'name' => 'builder_revisions',
						'value' => ''
					)
				)
			));

			$regular_types = array('post', 'page');
			$custom_types = array_keys(get_post_types(array('_builtin' => FALSE, 'public' => TRUE, 'show_ui' => TRUE)));
			$builder_post_types = array_unique(array_merge($regular_types, $custom_types));

			$post_type_fields = array();

			foreach ($builder_post_types as $type)
			{
				$post_type_fields[] = array
				(
					'name' => ''.$type,
					'value' => ''
				);
			}

			ether::handle_field_group($_POST, array
			(
				'builder_hidden_types' => array_merge(array('relation' => 'option'), $post_type_fields)
			));

			$widget_fields = array();
			$builder_widget_list = ether_builder::get_widgets();

			foreach ($builder_widget_list as $widget)
			{
				$widget_fields[] = array
				(
					'name' => ''.$widget->get_slug(),
					'value' => ''
				);
			}

			ether::handle_field_group($_POST, array
			(
				'builder_hidden_widgets' => $widget_fields
			));
		}

		public static function body()
		{
			$regular_types = array('post', 'page');
			$custom_types = array_keys(get_post_types(array('_builtin' => FALSE, 'public' => TRUE, 'show_ui' => TRUE)));
			$builder_post_types = array_unique(array_merge($regular_types, $custom_types));
			$builder_hidden_types = ether::option('builder_hidden_types');
			$colors = apply_filters('ether_builder_presets', array('light' => array('name' => ether::langr('Light')), 'dark' => array('name' => ether::langr('Dark'))));

			if (isset($builder_hidden_types[0]) AND ! empty($builder_hidden_types[0]))
			{
				$builder_hidden_types = $builder_hidden_types[0];
			}

			$post_type_fields = '';

			foreach ($builder_post_types as $type)
			{
				$post_type_fields .= '<label>'.ether::make_field(''.$type.'[]', array('type' => 'checkbox', 'relation' => 'custom'), $builder_hidden_types).' '.ether::langr('Hide builder tab for "%s" post type', $type).'</label>';
			}

			$builder_hidden_widgets = ether::option('builder_hidden_widgets');

			if (isset($builder_hidden_widgets[0]) AND ! empty($builder_hidden_widgets[0]))
			{
				$builder_hidden_widgets = $builder_hidden_widgets[0];
			}

			$col = 0;
			$widget_fields = array();
			$builder_widget_list = ether_builder::get_widgets();

			foreach ($builder_widget_list as $widget)
			{
				if ( ! isset($widget_fields[$col]))
				{
					$widget_fields[$col] = '';
				}

				$widget_fields[$col] .= '<label>'.ether::make_field(''.$widget->get_slug().'[]', array('type' => 'checkbox', 'relation' => 'custom'), $builder_hidden_widgets).' '.ether::langr('Hide "%s" builder widget', $widget->get_title()).'</label>';

				$col++;

				if ($col > 3)
				{
					$col = 0;
				}
			}

			return '<fieldset class="ether-form">
				<h2 class="title">'.ether::langr('Builder').'</h2>
				<hr class="ether-divider">
				<h3 class="title">'.ether::langr('General').'</h3>
				<div class="cols cols-1">
					<div class="col">
						<div class="inline-labels">
							<label>'.ether::make_field('builder_tab_default', array('type' => 'checkbox', 'relation' => 'option')).' '.ether::langr('Show Builder tab by default').'</label>
							<label>'.ether::make_field('hide_visual_tab', array('type' => 'checkbox', 'relation' => 'option')).' '.ether::langr('Hide "Visual" tab').'</label>
							<label>'.ether::make_field('hide_html_tab', array('type' => 'checkbox', 'relation' => 'option')).' '.ether::langr('Hide "HTML" tab').'</label>
						</div>
					</div>
					<div class="col">
						<label>'.ether::make_field('builder_archive_hide', array('type' => 'checkbox', 'relation' => 'option')).' '.ether::langr('Hide Builder content on archive/listing pages').'</label>
						<label>'.ether::make_field('builder_revisions', array('type' => 'checkbox', 'relation' => 'option')).' '.ether::langr('Enable revision support for Builder content').'</label>
					</div>
				</div>
				<hr class="ether-divider">
				<h3 class="title">'.ether::langr('Styles').'</h3>
				<div class="cols cols-1">
					<div class="col">
						<div class="inline-labels">
							<label><span>'.ether::langr('Color scheme').':</span> '.ether::make_field('builder_color', array('type' => 'select', 'relation' => 'option', 'options' => $colors, 'style' => 'width: 200px')).'</label>
						</div>
					</div>
				</div>
				<hr class="ether-divider">
				<h3 class="title">'.ether::langr('Post types').'</h3>
				<div class="cols cols-1">
					<div class="col">
						<div class="inline-labels">
							'.$post_type_fields.'
						</div>
					</div>
				</div>
				<hr class="ether-divider">
				<h3 class="title">'.ether::langr('Widgets').'</h3>
				<div class="buttonset-1">
					<button type="button" data-checkbox-group-state="0" class="checkbox-group-toggle-button checkbox-group-ref-1 button-1 button-1-1 alignleft icon-check" name="save">'.ether::langr('Select All').'</button>
				</div>
				<div id="checkbox-group-ref-1">
					<div class="cols cols-4">
						<div class="col">
							'.$widget_fields[0].'
						</div>
						<div class="col">
							'.$widget_fields[1].'
						</div>
						<div class="col">
							'.$widget_fields[2].'
						</div>
						<div class="col">
							'.$widget_fields[3].'
						</div>
					</div>
				</div>
				<hr class="ether-divider">
				<h3 class="title">'.ether::langr('Custom styles').'</h3>
				<div class="cols cols-1">
					<div class="col">
						<label>'.ether::langr('Custom CSS').' '.ether::make_field('builder_style', array('type' => 'textarea', 'rows' => '10')).'</label>
					</div>
				</div>
				<hr class="ether-divider">
				<h3 class="title">'.ether::langr('Export / Import').'</h3>
				<div class="cols cols-1">
					<div class="col">
						<label>'.ether::langr('Custom CSS').' '.ether::make_field('builder_style', array('type' => 'textarea', 'rows' => '10')).'</label>
					</div>
				</div>
				<hr class="ether-divider">
			</fieldset>';
		}
	}
}

?>
