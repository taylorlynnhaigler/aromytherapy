<?php

if ( ! class_exists('ether_builder'))
{
	class ether_builder extends ether_module
	{
		protected static $widget_classes = array();
		protected static $widget_data = array();
		protected static $widget_slugs = array();
		protected static $widgets = array();

		protected static $disabled_fields = array();
		protected static $locations = array();
		protected static $buffer = NULL;

		protected static $generated_content_registry = array();
		protected static $content_output = array();
		protected static $setup_done = FALSE;

		public static function init()
		{
			self::register_location('main', ether::langr('Main content'));
		}

		public static function widgets_init()
		{
			if (is_admin())
			{
				wp_enqueue_script('tiny_mce');
				wp_enqueue_style('editor-buttons');
			}

			self::$widget_classes = apply_filters('ether_builder_widgets', self::$widget_classes);

			$count = count(self::$widget_classes);

			for ($i = 0; $i < $count; $i++)
			{
				$class = self::$widget_classes[$i];

				if (class_exists($class))
				{
					$object = new $class();

					if ( ! isset(self::$widget_slugs[$object->get_slug()]))
					{
						self::$widgets[] = $object;
						self::$widget_slugs[$object->get_slug()] = $class;
					} else
					{
						unset($obejct);
					}
				}
			}
		}

		public static function builder_sidebar_widgets_init()
		{
			global $wp_widget_factory;

			foreach ($wp_widget_factory->widgets as $widget_class => $widget_object)
			{
				if (substr($widget_class, 0, strlen(ether::config('prefix'))) != ether::config('prefix'))
				{
					$code = '';
					$code .= 'class '.$widget_class.'_builder_widget extends ether_wp_widget';
					$code .= '{';
					$code .= '	public function __construct()';
					$code .= '	{';
					$code .= '		parent::__construct(\''.ether::slug('wp_widget_'.$widget_object->name).'\', \'WP '.addslashes($widget_object->name).'\');';
					$code .= '		$this->label = \''.addslashes(isset($widget_object->widget_options['description']) ? $widget_object->widget_options['description'] : '').'\';';
					$code .= '		$this->wp_class = \''.$widget_class.'\';';
					$code .= '		$this->wp_widget = new $this->wp_class;';
					$code .= '	}';
					$code .= '}';

					// evil!
					eval($code);
					ether_builder::register_widget($widget_class.'_builder_widget');
				}
			}
		}

		public static function sidebar_builder_widgets_init()
		{
			global $wp_widget_factory;

			// list of widgets from content builder included in sidebar widgets
			$builder_widgets = array
			(
				'ether_plain_text_widget',
				'ether_rich_text_widget',
				'ether_html_widget',
				'ether_heading_widget',
				'ether_image_widget',
				'ether_divider_widget',
				'ether_message_widget',
				'ether_blockquote_widget',
				'ether_list_widget',
				'ether_button_widget',
				'ether_video_widget',
				'ether_table_widget',
				'ether_tabs_widget',
				'ether_accordion_widget',
				'ether_gallery_widget',
				'ether_services_widget',
				'ether_testimonials_widget',
				'ether_twitter_feed_widget',
				'ether_googlemap_widget',
				'ether_contact_widget',
				'ether_pricing_table_widget',
				'ether_pricing_box_widget',
				'ether_fb_button_widget',
				'ether_fb_comments_widget',
				'ether_fb_likebox_widget'
			);

			$builder_widgets = apply_filters('ether_builder_sidebar_widgets', $builder_widgets);

			foreach ($builder_widgets as $index => $widget_class)
			{
				if ( ! in_array($widget_class, self::$widget_classes))
				{
					unset($builder_widgets[$index]);
				}
			}

			foreach ($builder_widgets as $widget_class)
			{
				$class = $widget_class;

				$code = '';
				$code .= 'class '.$class.'_sidebar_widget extends ether_builder_sidebar_widget';
				$code .= '{';
				$code .= '	public function __construct()';
				$code .= '	{';
				$code .= '		$this->builder_class = \''.$class.'\';';
				$code .= '		$this->builder_widget = new $this->builder_class;';
				$code .= '		parent::__construct(FALSE, \'&nbsp;'.ether::langr('Builder').' \'.$this->builder_widget->get_title(), array(\'description\' => $this->builder_widget->get_label()));';
				$code .= '	}';
				$code .= '}';

				// evil, ekhm i mean...
				eval($code);

				register_widget($class.'_sidebar_widget');

				// this action is ran after widgets_init and auto registration of widgets
				// so we have to register widgets manually
				$wp_widget_factory->widgets[$class.'_sidebar_widget']->_register();
			}
		}

		public static function header()
		{
			if (is_admin())
			{
				global $post_type;

				// if not add new post or edit post screen
				if (empty($post_type))
				{
					if (function_exists('add_thickbox'))
					{
						add_thickbox();
					}

					if (function_exists('wp_tiny_mce'))
					{
						wp_tiny_mce();
					}
				}
			} else
			{
				if (did_action('ether_builder_header') > 0)
				{
					$style = apply_filters('ether_builder_style', stripslashes(ether::option('builder_style')));

					if ( ! empty($style))
					{
						echo '<style type="text/css">'.$style.'</style>';
					}
				}
			}
		}

		public static function canvas()
		{
			global $post;

			if ( ! is_admin())
			{
				if (isset($post->ID) AND ether::meta('canvas', TRUE, $post->ID) == 'on')
				{
					do_action('ether_canvas_init');
					?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php the_title(); ?></title>
<?php wp_head(); ?>
		<style>body { background-color: #e6e6e6; } .ether-canvas { width: 960px; margin: 20px auto; padding: 20px 40px; box-shadow: 0 2px 6px rgba(100, 100, 100, 0.3);  background-color: #fff; }</style>
	</head>

	<body <?php body_class(); ?>>
		<div class="ether-canvas">
			<?php the_content(); ?>
		</div>
	</body>
</html><?php
					wp_footer();

					do_action('shutdown');

					die;
				}
			}
		}

		public static function register_widget($class)
		{
			self::$widget_classes[] = $class;
		}

		public static function register_wp_widget($class, $title, $label)
		{
			self::$wp_widget_classes[] = $class;
		}

		public static function register_widget_data($slug, $title)
		{
			$slug = ether::slug($slug);

			self::$widget_data[] = array('slug' => $slug, 'title' => $title);
		}

		public static function get_disabled_fields()
		{
			return apply_filters('ether_builder_disabled_fields', self::$disabled_fields);
		}

		public static function disable_field($name)
		{
			if ( ! in_array($name, self::$disabled_fields))
			{
				self::$disabled_fields[] = $name;
			}
		}

		public static function get_widgets()
		{
			return self::$widgets;
		}

		public static function get_widget_class($slug)
		{
			$slug = ether::slug($slug);

			if (isset(self::$widget_slugs[$slug]))
			{
				return self::$widget_slugs[$slug];
			}

			return '';
		}

		public static function get_widget_title($slug)
		{
			$slug = ether::slug($slug);

			foreach (self::$widget_data as $widget_data)
			{
				if ($widget_data['slug'] == $slug)
				{
					return $widget_data['title'];
				}
			}

			return ether::langr('Widget');
		}

		public static function register_location($slug, $name)
		{
			$slug = ether::slug($slug);

			if ( ! isset(self::$locations[$slug]))
			{
				self::$locations[$slug] = $name;

				return TRUE;
			}

			return FALSE;
		}

		public static function get_locations()
		{
			return self::$locations;
		}

		public static function extract_widgets($arr, $skip_fields = array())
		{
			$output = array();

			foreach ($arr as $key => $value)
			{
				if (isset($value['__SLUG__']))
				{
					if ( ! isset($value['__CORE__']))
					{
						if ( ! empty($skip_fields))
						{
							foreach ($skip_fields as $field)
							{
								if (isset($output[$field]))
								{
									unset($output[$field]);
								}
							}
						}

						$output[$key] = $value;
					}
				} else
				{
					$output = array_merge($output, self::extract_widgets($value, $skip_fields));
				}
			}

			return $output;
		}

		public static function flatten($builder, $prefix = '', $parse = TRUE)
		{
			$output = array();

			if (is_array($builder))
			{
				foreach ($builder as $key => $value)
				{
					$entry = ($prefix ? $prefix.'][' : '').$key;

					if (is_array($value))
					{
						$output = array_merge($output, self::flatten($value, $entry, FALSE));
					} else
					{
						$output['['.$entry.']'] = $value;
					}
				}

				if ($parse)
				{
					$builder = $output;
					$output = array();

					foreach ($builder as $k => $v)
					{
						preg_match_all('/\[(.*?)\]\[(.*?)\]\[(.*?)\]\[(.*?)\]\[(.*?)\]/is', $k, $matches);

						if (isset($matches[4][0]) AND ! empty($matches[4][0]) AND isset($matches[5][0]) AND ! empty($matches[5][0]))
						{
							$id = $matches[4][0];
							$field = $matches[5][0];

							if ( ! isset($output[$id]))
							{
								$output[$id] = array();
							}

							$output[$id][$field] = $v;
						}
					}
				}
			}

			return $output;
		}

		public static function parse($builder_widgets, $location, $admin = FALSE, $data = array())
		{
			$builder_widgets_output = '';

			$row_begin = FALSE;
			$first_row_data = array();
			$row_id = '__ID__';
			$after_buffer = array();

			if (isset($builder_widgets[$location]) AND is_array($builder_widgets[$location]))
			{
				foreach ($builder_widgets[$location] as $row_name => $row_data)
				{
					if ($row_name !== '__ROW__')
					{
						$columns = array(array(), array(), array(), array());

						foreach ($row_data as $column_name => $column_data)
						{
							if ($column_name === '__COLUMN__')
							{
								foreach ($column_data as $widget_id => $widget_data)
								{
									if ( ! isset($widget_data['__CORE__']))
									{
										if ($widget_id != '__ID__')
										{
											$class = self::get_widget_class($widget_data['__SLUG__']);

											if ( ! empty($class) AND class_exists($class))
											{
												$object = new $class();
												$object->set_id($widget_id);
												$object->set_location($location);
												$object->set_row($row_name);
												$object->set_column($column_name);

												if ($admin)
												{
													$builder_widgets_output .= $object->admin_form(array_merge($widget_data, isset($data[$widget_id]) ? $data[$widget_id] : array(), array('__ID__' => $widget_id)));
												} else
												{
													$widget_data = array_merge($widget_data, isset($data[$widget_id]) ? $data[$widget_id] : array(), array('__ID__' => $widget_id));
													$output = '';

													if ($object->is_after())
													{
														$after_buffer[] = array('widget' => $object, 'widget_data' => $widget_data, 'widget_id' => $widget_id);

														$builder_widgets_output .= '<!--ETHER_BUILDER_WIDGET_AFTER_'.$widget_id.'-->';
													} else
													{
														$builder_widgets_output = $object->content_filter($widget_data, $builder_widgets_output);

														$output = $object->widget($widget_data);
														$output = apply_filters('ether_builder_widget', $output, $widget_id, $widget_data, $object->get_slug());
														$output = apply_filters('ether_builder_'.$object->get_slug().'_widget', $output, $widget_id, $widget_data, $object->get_slug());

														$builder_widgets_output .= $output;
													}
												}

												$row_begin = FALSE;
											}
										}
									} else
									{
										$row_id = $widget_id;
										$row_begin = TRUE;
										$first_row_data = array_merge($widget_data, array('__ID__' => $widget_id));
									}
								}
							} else
							{
								foreach ($column_data as $widget_id => $widget_data)
								{
									$columns[$column_name][] = array_merge($widget_data, array('__ID__' => $widget_id));
								}
							}
						}

						if ($row_begin)
						{
							$row_columns = array();

							foreach ($columns as $column_index => $column_data)
							{
								foreach ($column_data as $widget)
								{
									$class = self::get_widget_class($widget['__SLUG__']);

									if ( ! empty($class) AND class_exists($class))
									{
										$object = new $class();
										$object->set_id($widget['__ID__']);
										$object->set_location($location);
										$object->set_row($row_name);
										$object->set_column($column_index);

										if ( ! isset($row_columns['col-'.($column_index + 1)]))
										{
											$row_columns['col-'.($column_index + 1)] = '';
										}

										if ($admin)
										{
											$row_columns['col-'.($column_index + 1)] .= $object->admin_form(array_merge($widget, isset($data[$widget['__ID__']]) ? $data[$widget['__ID__']] : array()));
										} else
										{
											$widget_id = $widget['__ID__'];
											$widget_data = array_merge($widget, isset($data[$widget['__ID__']]) ? $data[$widget['__ID__']] : array());
											$output = '';

											if ($object->is_after())
											{
												$after_buffer[] = array('widget' => $object, 'widget_data' => $widget_data, 'widget_id' => $widget_id);

												$output = '<!--ETHER_BUILDER_WIDGET_AFTER_'.$widget_id.'-->';
											} else
											{
												$builder_widgets_output = $object->content_filter($widget_data, $builder_widgets_output);

												$output = $object->widget($widget_data);

												$output = apply_filters('ether_builder_widget', $output, $widget_id, $widget_data, $object->get_slug());
												$output = apply_filters('ether_builder_'.$object->get_slug().'_widget', $output, $widget_id, $widget_data, $object->get_slug());



												$row_columns['col-'.($column_index + 1)] .= $output;
											}
										}
									}
								}
							}

							$class = self::get_widget_class($first_row_data['__SLUG__']);

							if ( ! empty($class) AND class_exists($class))
							{
								$object = new $class();

								$object->set_id($row_id);
								$object->set_location($location);
								$object->set_row($row_name);

								if ($admin)
								{
									$builder_widgets_output .= $object->admin_form(array_merge(array('__ID__' => $row_id), $row_columns));
								} else
								{
									$output = $object->widget(array_merge(array('__ID__' => $row_id), $row_columns));
									$output = apply_filters('ether_builder_widget', $output, $row_id, array(), $object->get_slug());
									$output = apply_filters('ether_builder_'.$object->get_slug().'_widget', $output, $row_id, array(), $object->get_slug());

									$builder_widgets_output .= $output;

								}
							}
						}
					}
				}
			}

			if ( ! $admin)
			{
				foreach ($after_buffer as $after)
				{
					$builder_widgets_output = $after['widget']->content_filter($after['widget_data'], $builder_widgets_output);

					$output = $after['widget']->widget($after['widget_data']);

					$output = apply_filters('ether_builder_widget', $output, $after['widget_id'], $after['widget_data'], $after['widget']->get_slug());
					$output = apply_filters('ether_builder_'.$after['widget']->get_slug().'_widget', $output, $after['widget_id'], $after['widget_data'], $after['widget']->get_slug());

					$builder_widgets_output = str_replace('<!--ETHER_BUILDER_WIDGET_AFTER_'.$after['widget_id'].'-->', $output, $builder_widgets_output);
				}

				if (function_exists('qtrans_init'))
				{
					return ether::langr($builder_widgets_output);
				} else
				{
					return $builder_widgets_output;
				}
			}

			return $builder_widgets_output;
		}

		public static function bootstrap($template)
		{
			global $post;
			$custom_template = ether::meta('template', TRUE, $post->ID);

			if ( ! empty($custom_template))
			{
				$dynamic_template = ether::bootstrap_template_exists('dynamic.php');

				if ($dynamic_template !== FALSE)
				{
					$template = $dynamic_template;
					self::$buffer = ether::meta('builder_data', TRUE, $custom_template);
				}
			}

			return $template;
		}

		public static function get($location)
		{
			global $post;

			if (self::$buffer != NULL)
			{
				$buffer = ether::meta('builder_data', TRUE, $post->ID);
				$data = array();

				// overwrite builder data with custom data
				//$data = ether::meta('builder_widget_post_data', TRUE, $post->ID);

				echo self::parse($buffer, $location, FALSE);
			}
		}

		// template tag, use it in custom query loops
		public static function get_the_content($id = NULL, $skip_the_content = FALSE)
		{
			global $post;

			if (did_action('ether_builder_header') == 0)
			{
				do_action('ether_builder_header');
			}

			$data = ether::meta('builder_data', TRUE, ($id !== NULL ? $id : $post->ID));

			$data_flatten = self::flatten($data, '', FALSE);
			$prepend_content = TRUE;

			foreach ($data_flatten as $k => $v)
			{
				// if content widget found in buffer, print empty content for now
				if ($v == 'post-content' AND strpos($k, '__SLUG__') !== FALSE)
				{
					$prepend_content = FALSE;
					break;
				}
			}

			return (($prepend_content AND ! $skip_the_content) ? apply_filters('the_content', get_the_content()) : '').self::parse($data, 'main', FALSE);
		}

		public static function the_content($id = NULL, $skip_the_content = FALSE)
		{
			echo self::get_the_content($id);
		}

		// HACK #1
		public static function builder_tab($content)
		{
			global $post;
			global $post_type;

			$builder_metabox = ether::admin_metabox_get('Builder post');

			if ( ! empty($builder_metabox) AND in_array($post_type, $builder_metabox['permissions']))
			{
				if (strpos($content, 'editorcontainer') !== FALSE OR strpos($content, 'wp-content-editor-container') !== FALSE)
				{
					echo '<div id="editor-builder-tab" class="hide-if-no-js hide">'.ether_metabox_builder::body().'</div>';
				}
			}

			return $content;
		}

		// HACK #2
		// CHECK HACK#3
		/*public static function editor_content($content)
		{
			global $post;
			global $post_type;

			if ($post AND $post->post_type != 'section')
			{
				if ( ! empty($post->ID) AND ! isset(self::$generated_content_registry[$post->ID]))
				{
					// "last" tab hack
					self::$generated_content_registry[$post->ID] = TRUE;
					// content builder structure data
					$buffer = ether::meta('builder_data', TRUE, $post->ID);

					if ( ! empty($buffer))
					{
						$buffer_flatten = self::flatten($buffer, '', FALSE);

						foreach ($buffer_flatten as $k => $v)
						{
							// if content widget found in buffer, print empty content for now
							if ($v == 'post-content' AND strpos($k, '__SLUG__') !== FALSE)
							{
								$content = '';

								break;
							}
						}

						$builder_content = self::parse($buffer, 'main', FALSE);

						$content .= $builder_content;
					}
				}
			}

			return $content;
		}*/

		public static function builder_content($content)
		{
			global $post;
			global $post_type;

			if ( ! self::$setup_done)
			{
				self::builder_setup();
			}

			if ($post)
			{
				if ( ! empty($post->ID) AND ! isset(self::$generated_content_registry[$post->ID]))
				{
					if (isset(self::$content_output[$post->ID]))
					{
						$content .= _n.do_shortcode(self::$content_output[$post->ID]);
						//unset(self::$content_output[$post->ID]);
					}
				} else
				{
					// builder content found and contains post content widget, overwrite first the_content call
					if (isset(self::$content_output[$post->ID]))
					{
						$content = _n.do_shortcode(self::$content_output[$post->ID]);
						//unset(self::$content_output[$post->ID]);
					}
				}
			}

			return $content;
		}

		// HACK #3
		// setup content and parse all widgets before the_content action
		// some of the widgets may include additional scripts or stylesheets
		// or change output of the_content/the_title
		public static function builder_setup()
		{
			global $post;
			global $post_type;

			// for some reason, template_redirect action is not called on singular page in twenty eleven and ether builder does not work.
			// so, whenever $setup_done was not set to TRUE, the_content filter will check this and run builder_setup() for himself
			self::$setup_done = TRUE;

			global $wp_query;

			if ( ! is_singular() AND ether::config('builder_archive_hide'))
			{
				return;
			}

			$tmp_post = $post;

			$posts = array();

			if (isset($wp_query->posts))
			{
				$posts = $wp_query->posts;
			} else
			{
				$posts[] = $post;
			}

			foreach ($posts as $post)
			{
				if ($post)
				{
					if ( ! empty($post->ID) AND ! isset(self::$content_output[$post->ID]))
					{
						// content builder structure data

						$id = $post->ID;
						$data = array();

						if ($post->post_type == 'project' AND $post->post_parent > 0)
						{
							$id = $post->post_parent;

							$data = ether::meta('builder_widget_post_data', TRUE, $post->ID);
						}

						$buffer = ether::meta('builder_data', TRUE, $id);

						if ( ! empty($buffer))
						{
							$builder_content = self::parse($buffer, 'main', FALSE, $data);

							$buffer_flatten = self::flatten($buffer, '', FALSE);

							foreach ($buffer_flatten as $k => $v)
							{
								// if content widget found in buffer, print empty content for now
								if ($v == 'post-content' AND strpos($k, '__SLUG__') !== FALSE)
								{
									self::$generated_content_registry[$post->ID] = TRUE;

									break;
								}
							}

							self::$content_output[$post->ID] = $builder_content;

							if ( ! empty(self::$content_output[$post->ID]))
							{
								if ( ! is_admin() AND did_action('ether_builder_header') == 0)
								{
									do_action('ether_builder_header');
								}
							}
						}
					}
				}
			}

			$post = $tmp_post;

			self::canvas();
		}

		public static function builder_search($where)
		{
			global $wp_query;
			global $wpdb;
			global $wp;

			if ( ! is_admin() AND $wp_query->is_search)
			{
				$query = str_replace('/', '\/', $wp->query_vars['s']);

				$where = preg_replace("/(posts.post_title (LIKE '%{$query}%'))/i", "$0) OR ($wpdb->postmeta.meta_key = 'ether_builder_data' AND $wpdb->postmeta.meta_value LIKE '%{$query}%'", $where);
			}

			return $where;
		}

		public static function builder_search_join($join)
		{
			global $wp_query;
			global $wpdb;
			global $wp;

			if ( ! is_admin() AND $wp_query->is_search)
			{
				if ( ! preg_match("/(on)( |\()*($wpdb->postmeta.post_id)( )*(=)( )*($wpdb->posts.ID)/i", $join) AND ! preg_match("/(on)( |\()*($wpdb->posts.ID)( )*(=)( )*($wpdb->postmeta.post_id)/i", $join))
				{
					return $join .= " LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) ";
				}
			}

			return $join;
		}

		public static function builder_search_distinct($distinct)
		{
			$distinct = 'DISTINCT';

			return $distinct;
		}

		public static function unserialize($data)
		{
			// replace timestamps stored as integers to strings
			return ether::unserialize(preg_replace('!i:([0-9]{13,20}?);!e', "'s:'.strlen('$1').':\"$1\";'", $data));
		}

		public static function unserialize_fix($null, $object_id, $meta_key, $single)
		{
			$meta_type = 'post';

			if ($meta_key == 'ether_builder_data')
			{
				$meta_cache = wp_cache_get($object_id, $meta_type.'_meta');

				if ( ! $meta_cache)
				{
					$meta_cache = update_meta_cache($meta_type, array($object_id));
					$meta_cache = $meta_cache[$object_id];
				}

				if (isset($meta_cache[$meta_key]))
				{
					if ($single)
					{
						if (is_serialized($meta_cache[$meta_key][0]) AND ! maybe_unserialize($meta_cache[$meta_key][0]))
						{
							return array(self::unserialize($meta_cache[$meta_key][0]));
						}
					} else
					{
						foreach ($meta_cache[$meta_key] as $k => $v)
						{
							if (is_serialized($v) AND ! maybe_unserialize($v))
							{
								return array_map(array('ether_builder', 'unserialize'), $meta_cache[$meta_key]);
							}
						}
					}
				}
			}
		}
	}
}

if ( ! class_exists('ether_builder_widget'))
{
	class ether_builder_widget
	{
		protected $id;
		protected $slug;
		protected $title;
		protected $location;
		protected $row;
		protected $column;
		protected $core;
		protected $label;
		protected $excerpt;
		protected $visible;

		// parse this widget at the end
		protected $after;

		// some private data, special options or smth
		protected $data;

		public function __construct($slug, $title, $id = NULL, $location = NULL, $row = NULL, $column = NULL)
		{
			$this->core = FALSE;
			$this->slug = ether::slug($slug);
			$this->title = $title;

			$this->id = $id;
			$this->location = $location;
			$this->row = $row;
			$this->column = $column;
			$this->label = '';
			$this->excerpt = '';
			$this->visible = TRUE;
			$this->after = FALSE;
			$this->after_id = '';

			if ($this->id == NULL)
			{
				$this->id = '__ID__';
			}

			if ($this->location == NULL)
			{
				$this->location = '__LOCATION__';
			}

			if ($this->row == NULL)
			{
				$this->row = '__ROW__';
			}

			if ($this->column == NULL)
			{
				$this->column = '__COLUMN__';
			}

			ether_builder::register_widget_data($slug, $title);
		}

		public function is_core()
		{
			return $this->core;
		}

		public function get_field_name($name)
		{
			return ether::config('prefix').'builder_widget['.$this->location.']['.$this->row.']['.$this->column.']['.$this->id.']['.$name.']';
		}

		public function get_field_atts($name)
		{
			$disabled_fields = ether_builder::get_disabled_fields();

			if (in_array($name, $disabled_fields))
			{
				return ' disabled="disabled"';
			}

			return '';
		}

		public function strip($data, $valid_tags = NULL)
		{
			$regexp = '#\s*<(/?\w+)\s+(?:on\w+\s*=\s*(["\'\s])?.+?\(\1?.+?\1?\);?\1?|style=["\'].+?["\'])\s*>#is';

			return preg_replace($regexp, '<${1}>', strip_tags($data, $valid_tags));
		}

		public function encode($code)
		{
			return htmlentities($code, ENT_NOQUOTES);
		}

		public function decode($code)
		{
			return html_entity_decode($code, ENT_NOQUOTES);
		}

		public function attr($attr = array())
		{
			if (is_array($attr))
			{
				$attrs = '';

				foreach($attr as $key => $value)
				{
					if ($value === TRUE)
					{
						$attrs .= ' '.$key;
					} elseif (is_array($value) OR trim($value) !== '')
					{
						if (is_array($value))
						{
							$attrs .= ' '.$key.'="'.$this->strip(implode(' ', $value)).'"';
						} else
						{
							$attrs .= ' '.$key.'="'.$this->strip($value).'"';
						}
					}
				}
			} else
			{
				$attrs = ' '.$attr;
			}

			$attrs = trim($attrs);

			return ( ! empty($attrs) ? ' ' : '').$attrs;
		}

		public function _class($classes = array(), $no_prefix_classes = array())
		{
			if ( ! is_array($classes))
			{
				$classes = explode(' ', $classes);
			}

			if ( ! is_array($no_prefix_classes))
			{
				$no_prefix_classes = explode(' ', $no_prefix_classes);
			}

			$class = '';

			if ( ! empty($classes))
			{
				$_classes = array();

				foreach ($classes as $c)
				{
					$c = trim($c);

					if ( ! empty($c))
					{
						$_classes[] = $c;
					}
				}

				$class = ether::config('builder_widget_prefix').implode(' '.ether::config('builder_widget_prefix'), $_classes);
			}

			if ( ! empty($no_prefix_classes))
			{
				$_no_prefix_classes = array();

				foreach ($no_prefix_classes as $c)
				{
					$c = trim($c);

					if ( ! empty($c))
					{
						$_no_prefix_classes[] = $c;
					}
				}

				$class .= ( ! empty($class) ? ' ' : '').implode(' ', $_no_prefix_classes);
			}

			return ( ! empty($class) ? ' class="'.trim($class).'"' : '');
		}

		public function tag_open($tag, $attr = array(), $single = FALSE)
		{
			return '<'.$tag.$this->attr($attr).($single ? ' /' : '').'>';
		}

		public static function tag_close($tag, $single = FALSE)
		{
			if ($single)
			{
				return '';
			}

			return '</'.$tag.'>';
		}

		public static function tag($tag, $content = '', $attr = array(), $single = FALSE)
		{
			return $this->tag_open($tag, $attr, $single).$content.$this->tag_close($tag, $single);
		}

		public function field($type, $name, $data = NULL, $options = array())
		{
			$value = '';

			if (is_array($data))
			{
				$key = $name;
				$key = str_replace(array('[', ']'), array('', ''), $key);

				if (isset($data[$name]))
				{
					$value = $data[$name];
				}
			} else
			{
				$value = $data;
			}

			if ($type == 'select')
			{
				$option_list = '';

				if (isset($options['options']))
				{
					foreach ($options['options'] as $k => $v)
					{
						$option_list .= '<option value="'.$k.'"'.($value == $k ? ' selected="selected"' : '').'>'.$v.'</option>';
					}
				} else
				{
					if ( ! empty($value))
					{
						$option_list .= '<option value="'.$value.'" selected="selected">'.$value.'</option>';
					} else
					{
						$option_list .= '<option></option>';
					}
				}

 				return '<select'.$this->get_field_atts($name).' name="'.$this->get_field_name($name).'" value="'.$value.'"'.((isset($options['class']) AND ! empty($options['class'])) ? ' class="'.$options['class'].'"' : '').'>'.$option_list.'</select>';
			} else if ($type == 'textarea')
			{
				if ( ! isset($options['rows']) OR empty($options['rows']))
				{
					$options['rows'] = 5;
				}

				return '<textarea'.$this->get_field_atts($name).' name="'.$this->get_field_name($name).'"'.((isset($options['rows']) AND ! empty($options['rows'])) ? ' rows="'.$options['rows'].'"' : '').((isset($options['cols']) AND ! empty($options['cols'])) ? ' cols="'.$options['cols'].'"' : '').((isset($options['class']) AND ! empty($options['class'])) ? ' class="'.$options['class'].'"' : '').'>'.htmlspecialchars($value).'</textarea>';
			} else
			{
				return '<input'.$this->get_field_atts($name).' name="'.$this->get_field_name($name).'" type="'.$type.'"'.((isset($options['class']) AND ! empty($options['class'])) ? ' class="'.$options['class'].'"' : '').($type == 'checkbox' ? ($value == 'on' ? ' checked="checked"' : '') : ' value="'.$value.'"').' />';
			}
		}

		public function group_field($type, $name, $index, $data = NULL, $options = array())
		{
			if ($data == NULL OR ! isset($data[$name]) OR ! isset($data[$name][$index]))
			{
				$value = NULL;
			} else
			{
				$value = $data[$name][$index];
			}

			return $this->field($type, $name.'][', $value, $options);
		}

		public function group_item($widget, $index)
		{
			return '';
		}

		public function is_after()
		{
			return $this->after;
		}

		public function get_slug()
		{
			return $this->slug;
		}

		public function get_title()
		{
			return $this->title;
		}

		public function get_id()
		{
			return $this->id;
		}

		public function set_id($id)
		{
			$this->id = $id;
		}

		public function get_location()
		{
			return $this->location;
		}

		public function set_location($location)
		{
			$this->location = $location;
		}

		public function get_row()
		{
			return $this->row;
		}

		public function set_row($row)
		{
			$this->row = $row;
		}

		public function get_column()
		{
			return $this->column;
		}

		public function set_column($column)
		{
			$this->column = $column;
		}

		public function get_label()
		{
			return $this->label;
		}

		public function get_excerpt()
		{
			return '';
		}

		public function set_label($label)
		{
			$this->label = $label;
		}

		public function show()
		{
			$this->visible = TRUE;
		}

		public function hide()
		{
			$this->visible = FALSE;
		}

		// this method was initially added for "heading menu" widget
		// so the widget can iteract and modify currently generetaed content
		public function content_filter($widget, $content)
		{
			return $content;
		}

		public function widget($widget)
		{
			return '';
		}

		public function form($widget)
		{
			return '';
		}

		public function admin_form($widget = NULL)
		{
			return '<div class="builder-widget-wrapper column-1 '.($this->id != '__ID__' ? 'initialized ' : '').($this->is_core() ? 'builder-widget-core ' : '').'builder-widget-type-'.$this->get_slug().( ! $this->visible ? ' hide' : '').'">
				<div class="builder-widget">
					<div class="builder-widget-bar widget widget-top">
						<div class="builder-widget-icon-'.$this->get_slug().( ! $this->visible ? ' hide' : '').'"></div>
						<div class="builder-widget-title">'.((isset($widget['admin-label']) AND ! empty($widget['admin-label'])) ? $widget['admin-label'] : $this->get_title()).'</div>
						<div class="builder-widget-excerpt">'.$this->get_excerpt().'</div>
						<div class="builder-widget-label">'.$this->get_label().'</div>
						<div class="builder-widget-actions">
							<a href="#edit" class="duplicate">'.ether::langr('Duplicate').'</a>
							<a href="#edit" class="edit">'.ether::langr('Edit').'</a>
							<a href="#remove" class="remove">'.ether::langr('Remove').'</a>
						</div>
					</div>
					'.( ! $this->is_core() ? '<div class="builder-widget-content closed"><div class="builder-widget-bar widget widget-top"><div class="builder-widget-title">'.$this->get_title().'</div></div><div class="builder-widget-inner"><div class="builder-widget-content-form">'.$this->form($widget).'</div><div class="builder-widget-content-actions">
						<div class="builder-widget-inner">
							<button name="builder-widget-save" class="save">'.ether::langr('Save').'</button>
							<button name=builder-modal-close" class="builder-modal-close">'.ether::langr('Close').'</button>
						</div>
					</div></div></div>' : '').
					'<input type="hidden" name="'.ether::config('prefix').'builder_widget['.$this->location.']['.$this->row.']['.$this->column.']['.$this->id.'][__SLUG__]" value="'.$this->get_slug().'" />'.($this->is_core() ? $this->form($widget).'<input type="hidden" name="'.ether::config('prefix').'builder_widget['.$this->location.']['.$this->row.']['.$this->column.']['.$this->id.'][__CORE__]" value="true" />' : '').'
				</div>
			</div>'._n;
		}

		public function wp_admin_form($widget, $id_base, $number)
		{
			$form = $this->admin_form($widget);
			$atts = array('name', 'id');

			foreach ($atts as $attr)
			{
				preg_match_all('| '.$attr.'=\"'.ether::config('prefix').'builder_widget\[(.*)\]\[(.*)\]\[(.*)\]\[(.*)\]\[(.*)\](.*)\"|iU', $form, $fields);

				if (isset($fields[5]) AND count($fields[5]) > 0)
				{
					$count = count($fields[3]);

					for ($i = 0; $i < $count; $i++)
					{
						$form = str_replace($fields[0][$i], ' '.$attr.'="widget-'.$id_base.'['.$number.']['.$fields[5][$i].']'.$fields[6][$i].'"', $form);
					}
				}
			}

			return $form;
		}

		protected function form_common($widget)
		{
			$columns = array();
			$rows = array();

			for ($i = 1; $i <= 10; $i++)
			{
				if ($i == 7 || $i == 9)
				{
					$i++;
				}

				$columns[$i] = $i;
				$rows[$i] = $i;
			}

			$output = '';
			$output .= '<h2 class="ether-tab-title">'.ether::langr('Grid Settings').'</h2>
				<div class="ether-tab-content">
					<div class="cols cols-3">
						<div class="col"><label><span class="label-title">'.ether::langr('Columns').'</span> '.$this->field('select', 'columns', $widget, array('options' => $columns)).'</label></div>
						<div class="col"><label><span class="label-title">'.ether::langr('Rows').'</span> '.$this->field('select', 'rows', $widget, array('options' => $rows)).'<small>'.ether::langr('Row count applies only if element is a slider. If you want to limit element count for non slider elements set a proper \'Count\' value if available or limit the amount of included elements').'</small></label></div>
						<div class="col">
						<label>'.$this->field('checkbox', 'disable_spacing', $widget).'<span class="label-title"> '.ether::langr('Disable spacing').'</span> <small>'.ether::langr('Most useful for galleries with images/videos where you don\'t want spacing between elements to occur').'</small></label>
						</div>
					</div>
				</div>';

			return $output;
		}

		protected function form_media_frame($widget)
		{
			$frames = array
			(
				'' => ether::langr('Theme default'),
				'1' => ether::langr('Ether frame 1'),
				'2' => ether::langr('Ether frame 2')
			);
			$height = array
			(
				'auto' => ether::langr('Default'),
				'200' => ether::langr('Short (200px)'),
				'300' => ether::langr('Medium (300px)'),
				'400' => ether::langr('Tall (400px)'),
				'constrain' => ether::langr('Constrain (max 400px)')
			);

			$image_mode = array
			(
				'auto' => ether::langr('Default'),
				'x' => ether::langr('Stretch X'),
				'y' => ether::langr('Stretch Y'),
				'fit' => ether::langr('Fit'),
				'fill' => ether::langr('Fill')
			);

			$ratio = array
			(
				50 => ether::langr('50%%'),
				75 => ether::langr('75%%'),
				100 => ether::langr('100%%'),
				150 => ether::langr('150%%'),
				200 => ether::langr('200%%')
			);

			$output = '';

			$output .= '<div class="cols-2">
					<div class="col">
						<label><span class="label-title">'.ether::langr('Elements Height').'</span> '.$this->field('select', 'height', $widget, array('options' => $height, 'class' => 'ether-cond ether-group-1')).'<small>'.ether::langr('Default: Does nothing. Constrain: Constrains element container size ratio to 1:1. If you want to constrain images size instead, use crop width/height fields below').'</small></label>
						<label class="ether-cond-constrain ether-group-1 "><span class="label-title">'.ether::langr('Constrain Ratio').'</span> '.$this->field('select', 'ratio', $widget, array('options' => $ratio, 'class' => '')).'<small>'.ether::langr('Height to width ratio for constrained galleries.').'</small></label>
					</div>
					<div class="col">
						<label><span class="label-title">'.ether::langr('Frame Style').'</span> '.$this->field('select', 'frame', $widget, array('options' => $frames)).'</label>
					</div>
				</div>
				<div class="cols-3">
				<div class="col">
					<label><span class="label-title">'.ether::langr('Image mode').'</span> '.$this->field('select', 'image_mode', $widget, array('options' => $image_mode)).'<small>'.ether::langr('Default: No image manipulations. Fit: Images will be scaled to fit whole available space. Stretch: Stretches images horizontally/vertically. Fit: Fits image within container - will usually leave out blank spaces').'</small></label>
				</div>
				<div class="col">
					<label class="label-alt-1">'.$this->field('checkbox', 'disable_lightbox', $widget).' <span class="label-title">'.ether::langr('Disable lightbox').'</span></label>
				</div>
				<div class="col">
					<label>'.$this->field('checkbox', 'enable_title', $widget).' <span class="label-title">'.ether::langr('Enable titles').'</span></label>
				</div>
			</div>';

			return $output;
		}

		protected function form_image_dimensions($widget)
		{
			$output = '';

			$output .= '<div class="cols-2">
				<div class="col">
					<label><span class="label-title">'.ether::langr('Image width').'</span> '.$this->field('text', 'image_width', $widget).'<small>'.ether::langr('"0" or blank field skips scaling through image width attribute.').'</small></label>
				</div>
				<div class="col">
					<label><span class="label-title">'.ether::langr('Image height').'</span> '.$this->field('text', 'image_height', $widget).'<small>'.ether::langr('"0" or blank field skips scaling through image width attribute.').'</small></label>
				</div>
			</div>
			<div class="cols-2 cols">
				<div class="col">
					<label><span class="label-title">'.ether::langr('Image crop width').'</span> '.$this->field('text', 'image_crop_width', $widget).'<small>'.ether::langr('"0" or blank field skips scaling/croping image. This function will generate thumbnail.').'</small></label>
				</div>
				<div class="col">
					<label><span class="label-title">'.ether::langr('Image crop height').'</span> '.$this->field('text', 'image_crop_height', $widget).'<small>'.ether::langr('"0" or blank field skips scaling/croping image. This function will generate thumbnail.').'</small></label>
				</div>
			</div>';

			return $output;
		}

		protected function form_widget_general($widget, $height = false)
		{
			$aligns = array
			(
				'' => ether::langr('Default'),
				'left' => ether::langr('Left'),
				'right' => ether::langr('Right'),
				'center' => ether::langr('Center')
			);

			$output = '';

			$output .= '<div class="cols cols-'.($height == true ? 3 : 2).'">
				<div class="col">
					<label><span class="label-title">'.ether::langr('Widget Alignment').'</span> '.$this->field('select', 'align', $widget, array('options' => $aligns)).'</label>
				</div>
				<div class="col">
					<label><span class="label-title">'.ether::langr('Widget width').'</span> '.$this->field('text', 'width', $widget).'</label>
				</div>'
				.($height == true ? '<div class="col">
					<label><span class="label-title">'.ether::langr('Widget height').'</span> '.$this->field('text', 'height', $widget).'</label>
				</div>
				' : '').'
			</div>';

			return $output;
		}
	}
}

if ( ! class_exists('ether_wp_widget'))
{
	class ether_wp_widget extends ether_builder_widget
	{
		protected $wp_class;
		protected $wp_widget;

		public function widget($widget)
		{
			// fix for sidebar widgets with custom loops (if sidebar widgets has custom loop, it breaks slug generation and some other things)
			global $post;
			$tmp = $post;

			ob_start();
			$this->wp_widget->widget(array(), $widget);

			$output = '<div class="ether-widget ether-wp">'.ob_get_clean().'</div>';

			if (isset($widget['classes']) AND ! empty($widget['classes']))
			{
				$output = ether::set_attr('*', 'class', $widget['classes'], $output, TRUE);
			}

			$post = $tmp;

			return $output;
		}

		public function form($widget)
		{
			// fix for sidebar widgets with custom loops (if sidebar widgets has custom loop, it breaks slug generation and some other things)
			global $post;
			$tmp = $post;

			if (is_array($widget) AND ! empty($widget))
			{
				foreach ($widget as $key => $value)
				{
					if ($widget[$key] === 'on')
					{
						$widget[$key] = TRUE;
					}
				}
			}

			ob_start();
			$this->wp_widget->form($widget);
			$form = ob_get_clean();

			preg_match_all('| name=\"widget-(.+)\[(.*)\]\[(.*)\]\"|iU', $form, $fields);

			if (isset($fields[3]) AND count($fields[3]) > 0)
			{
				$count = count($fields[3]);

				for ($i = 0; $i < $count; $i++)
				{
					$form = str_replace($fields[0][$i], ' name="'.$this->get_field_name($fields[3][$i]).'"', $form);
				}
			}

			$post = $tmp;

			return $form.'<fieldset class="ether-form"><label>'.ether::langr('Additional classes').' <input type="text"'.$this->get_field_atts('classes').' name="'.$this->get_field_name('classes').'" value="'.(isset($widget['classes']) ? $widget['classes'] : '').'" /></label><label>'.ether::langr('Widget label').' '.$this->field('text', 'admin-label', $widget).'<small>'.ether::langr('Custom widget label which will be shown instead of widget name in the admin view').'</small></label></fieldset>';
		}
	}
}

if ( ! class_exists('ether_builder_sidebar_widget'))
{
	class ether_builder_sidebar_widget extends WP_Widget
	{
		protected $builder_class;
		protected $builder_widget;

		public function widget($args, $instance)
		{
			if ( ! is_admin() AND did_action('ether_builder_header') == 0)
			{
				do_action('ether_builder_header');
			}

			echo $this->builder_widget->widget($instance);
		}

		public function update($new_instance, $old_instance)
		{
			return $new_instance;
		}

		public function form($instance)
		{
			echo $this->builder_widget->wp_admin_form($instance, $this->id_base, $this->number);
		}
	}
}

ether::import('modules.builder-widget');

?>
