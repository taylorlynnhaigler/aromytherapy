(function($){

$.fn.cattr = function(key, value, attribute)
{
	if (typeof attribute == 'undefined')
	{
		attribute = 'className';
	}

	var $object = $(this).eq(0);
	var class_name = '';

	if (key != null)
	{
		var classes = $object[0][attribute].split(' ');

		for (i = 0; i < classes.length; i++)
		{
			if (classes[i].substr(0, key.length) == key)
			{
				class_name = classes[i];
			}
		}
	}

	if (typeof value == 'undefined' || value == null)
	{
		return class_name.substr(key.length+1);
	} else
	{
		if (class_name != '')
		{
			//$object.attr(attribute, $object.attr(attribute).replace(class_name, key + '-' + value));
			$object[0][attribute] = $object[0][attribute].replace(class_name, key + '-' + value);
		} else
		{
			$object[0][attribute] = $object[0][attribute] + ' ' + key + '-' + value;
			//$object.attr(attribute, $object.attr(attribute) + ' ' + key + '-' + value);
		}
	}

	return this;
};

$( function()
{
	function ether_farbtastic_prepare()
	{
		var color = $(this).children('input').eq(0).val();

		if ($(this).children('.ether-farbtastic').length == 0)
		{
			$(this).children('input').before('<span class="ether-farbtastic-trigger" style="background-color: ' + (color == '' ? '#ffffff' : color) + ';"></span>');
			$(this).children('input').before('<div class="ether-farbtastic" style="display: none; position: absolute; z-index: 50;"></div>');
		}
	}

	function ether_farbtastic_init()
	{
		var $trigger = $(this).prev('.ether-farbtastic-trigger');
		var $input = $(this).next('input');

		if (typeof $(this).get(0).farbtastic == 'undefined')
		{
			$(this).farbtastic($trigger);
		}

		$(this).get(0).farbtastic.setColor($input.val());
	}

	$('label.ether-color').each(ether_farbtastic_prepare);

	$('.ether-farbtastic-trigger').live('click', function()
	{
		var picker = $(this).next('.ether-farbtastic').get(0).farbtastic;

		if (typeof picker == 'undefined')
		{
			$(this).next('.ether-farbtastic').farbtastic($(this));
			picker = $(this).next('.ether-farbtastic').get(0).farbtastic;
			picker.setColor($(this).siblings('input').val());
		}

		$(this).next('.ether-farbtastic').fadeIn();

		return false;
	});

	$('.widget-inside .builder-widget .builder-widget-actions .edit').live('click', function()
	{
		var $parent = $(this).closest('.builder-widget');

		var $color_fields = $parent.find('.ether-color');

		if ($color_fields.length > 0)
		{
			$color_fields.each(ether_farbtastic_prepare);
			$color_fields.children('.ether-farbtastic').each(ether_farbtastic_init);
		}
	});

	$('.ether-farbtastic').each(ether_farbtastic_init);

	var farbtastic_no_update = false;

	$('.ether-color input').change( function()
	{
		if ( ! farbtastic_no_update)
		{
			var picker = $(this).prevAll('.ether-farbtastic').get(0).farbtastic;

			if (typeof picker == 'undefined')
			{
				$(this).prev('.ether-farbtastic').farbtastic($(this).prevAll('.ether-farbtastic-trigger'));
				picker = $(this).prev('.ether-farbtastic').get(0).farbtastic;
				//picker.setColor($(this).siblings('input').val());
			}
			picker.setColor($(this).val());

			var color = $(this).val();

			if (color.substring(0, 3) == 'rgb')
			{
				color = to_hex(color.replace('rgb(', '').replace(')', '').split(', '));
			}
		}

		farbtastic_no_update = false;
	});

	$('.ether-farbtastic').live('mousemove', function()
	{
		var $trigger = $(this).prev('.ether-farbtastic-trigger');
		var $input = $(this).next('input');
		var picker = $(this).get(0).farbtastic;

		var val = $input.val();
		var color = picker.color;

		if (color != val)
		{
			$input.val(color);
			farbtastic_no_update = true;
			$input.change();
		}
	});

	$(document).mousedown( function()
	{
		$('.ether-farbtastic:visible').each( function()
		{
			var picker = $(this).get(0).farbtastic;

			$(this).next('input').val(picker.color);
			$(this).fadeOut();
		});
	});

	// old color picker, should be replace soon
    /*$('.ether-color-picker').hide();

    $('.ether-color-picker').each( function()
	{
		var $span = $(this).prev('.color-picker-trig');
		var $input = $(this).next('.ether-color');

		$(this).farbtastic($span);

		$(this).get(0).farbtastic.setColor($input.val());

		$span.click( function()
		{
			$(this).next('div').fadeIn();
		});
	});

	var color_no_update = false;

	$('input.ether-color').change( function()
	{
		if ( ! color_no_update)
		{
			var picker = $(this).prevAll('.ether-color-picker').get(0).farbtastic;

			picker.setColor($(this).val());

			var color = $(this).val();

			if (color.substring(0, 3) == 'rgb')
			{
				color = to_hex(color.replace('rgb(', '').replace(')', '').split(', '));
			}
		}

		color_no_update = false;
	});

	$('.ether-color-picker').live('mousemove', function()
	{
		var $span = $(this).prev('.color-picker-trig');
		var $input = $(this).next('.ether-color');
		var picker = $(this).get(0).farbtastic;
		var val = $input.val();
		var color = picker.color;

		if (color != val)
		{
			$input.val(color);
			color_no_update = true;
			$input.change();
		}
	});

	$(document).mousedown( function()
	{
		$('.ether-color-picker:visible').each( function()
		{
			var picker = $(this).get(0).farbtastic;

			$(this).next('.ether-color').val(picker.color);
			$(this).fadeOut();
		});
	});*/

	$('input[name=reset]').click( function()
	{
		if ( ! confirm('Are you sure you want to reset settings on this page? \'Cancel\' to stop, \'OK\' to reset.'))
		{
			return false;
		}
	});

	$('.confirm').live('click', function()
	{
		if ( ! confirm('Are you sure?'))
		{
			return false;
		}
	});

	function img_placeholder_src(src, force)
	{
		if (typeof force == 'undefined')
		{
			force = false;
		}

		if (src.length > 0 && src.match(/^(?:.*?)\.?(youtube|vimeo)\.com\/(watch\?[^#]*v=(\w+)|(\d+)).+$/))
		{
			return ether.placeholder.video;
		} else if (force || src.length == '')
		{
			return ether.placeholder.img;
		}

		return src;
	}

	$('img.upload_image').each( function()
	{
		var src = img_placeholder_src($(this).attr('src'));

		$(this).attr('src', src);
	});

	$('img.upload_image').live('error', function()
	{
		var src = img_placeholder_src($(this).attr('src'), true);

		$(this).attr('src', src);
	});

	$('input.upload_image').live('change', function()
	{
		var src = img_placeholder_src($(this).val());

		$(this).closest('.group-item-content').find('img.upload_image').attr('src', src);
	});

	$('.ether img').load( function()
	{
		$(this).show();
	});

	$('.ether .hidden').hide();

	$('.wp-editor-tools .add_media').live('click', function()
	{
		ether.editor = tinyMCE.activeEditor;
	});

	$('.checkbox-group-toggle-button').click(function ()
	{
		var ref_id = $(this).attr('class').match(/checkbox-group-ref-\d/)[0];
		var state = $(this).attr('data-checkbox-group-state');
		$(this).attr('data-checkbox-group-state', state == 0 ? 1 : 0);

		if (state == 0)
		{
			$(this).text('Deselect All');
			$('#' + ref_id).find('input[type="checkbox"]').prop('checked', true);
		} else
		{
			$(this).text('Select All');
			$('#' + ref_id).find('input[type="checkbox"]').prop('checked', false);
		}
		$(this).toggleClass('icon-check icon-uncheck');
	});

	window.wp_send_to_editor = window.send_to_editor;

	window.send_to_editor = function(html)
	{
		/*if (typeof o == "object" || typeof o == "array")
		{
			if (ether.upload_dst == null)
			{
				for (var i = 0; i < o.length; i++)
				{
					add_image(o[i]);
				}
			} else
			{
				if (o.length > 0)
				{
					var src = o[0];

					$dst = $(ether.upload_dst);

					$dst.each( function()
					{
						if ($(this).is("img"))
						{
							$(this).attr("src", src).show();
						} else if ($(this).is("a"))
						{
							$(this).attr("href", src);
						} else if ($(this).is("input"))
						{
							$(this).val(src);
						}
					});
				}
			}

			tb_remove();
			ether.upload_dst = null;
		}*/

		if ((typeof html == "object" || typeof html == "array") && ether.editor == null)
		{
			if (ether.upload_callback != '')
			{
				for (var i = 0; i < html.length; i++)
				{
					eval(ether.upload_callback + '(\'' + html[i] + '\');');
				}
			}

			if (ether.upload_dst != null)
			{
				if (html.length > 0)
				{
					var src = html[0];

					var $dst = $(ether.upload_dst);

					$dst.each( function()
					{
						if ($(this).is("img"))
						{
							$(this).attr("src", src).show();
						} else if ($(this).is("a"))
						{
							$(this).attr("href", src);
						} else if ($(this).is("input"))
						{
							$(this).val(src).change();
						}
					});
				}
			}

			tb_remove();
			ether.upload_dst = null;
			ether.upload_callback = '';
			ether.upload_caller = null;
		} else
		{
			if (ether.upload_dst != null)
			{
				var url = '';
				var alt = '';
				var title = '';

				if ($('img', html).length > 0)
				{
					url = $('img', html).attr('src');
					alt = $('img', html).attr('alt');
					title = $('img', html).attr('title');
				} else
				{
					url = html;
				}

				$dst = $(ether.upload_dst);
				$alt = $(ether.upload_dst + '_alt');
				$title = $(ether.upload_dst + '_title');

				$dst.each( function()
				{
					if ($(this).is('img'))
					{
						$(this).attr('src', url).show();
					} else if ($(this).is('a'))
					{
						$(this).attr('href', url);
					} else if ($(this).is('input'))
					{
						$(this).val(url).change();
					}
				});

				$alt.each( function()
				{
					if ($(this).is('img'))
					{
						$(this).attr('alt', alt).show();
					} else if ($(this).is('a'))
					{
						$(this).text(alt);
					} else if ($(this).is('input'))
					{
						$(this).val(alt);
					}
				});

				$title.each( function()
				{
					if ($(this).is('img'))
					{
						$(this).attr('title', title).show();
					} else if ($(this).is('a'))
					{
						$(this).attr('title', title);
					} else if ($(this).is('input'))
					{
						$(this).val(title);
					}
				});

				tb_remove();
				ether.upload_dst = null;
			} else
			{
				if (tinyMCE.activeEditor != null)
				{
					if (typeof html == "object" || typeof html == "array")
					{
						for (var i = 0; i < html.length; i++)
						{
							tinyMCE.execInstanceCommand(tinyMCE.activeEditor.id, "mceInsertContent", false, '<a href="' + html[i] + '" class="alignleft"><img src="' + html[i] + '" alt="" width="300" /></a>');
						}
					} else
					{
						tinyMCE.execInstanceCommand(tinyMCE.activeEditor.id, "mceInsertContent", false, html);
					}

					tb_remove();
				} else
				{
					window.wp_send_to_editor(html);
				}
			}
		}

		ether.editor = null;
	};

	$('.remove_image').click( function()
	{
		var name = $(this).attr('name').replace('#', '').replace(ether.prefix + 'remove_', '');

		$('input.upload_' + name).val('').change();
		$('input.upload_' + name + '_alt').val('');
		$('input.upload_' + name + '_title').val('');

		$('img.upload_' + name).attr('src', ether.placeholder.img);

		return false;
	});

	$('.upload_image').live('click', function()
	{
		if ($(this).is('button'))
		{
			var name = $(this).attr('name');
			var width = $(this).cattr('width');
			var height = $(this).cattr('height');
			var single = $(this).hasClass('single');
			var tab = $(this).cattr('tab');
			var callback = $(this).cattr('callback');

			if (tab == '')
			{
				tab = 'images';
			}

			if ( ! callback)
			{
				ether.upload_dst = '.' + name.replace(ether.prefix, '').replace('[', '\[').replace(']', '\]');

				ether.upload_callback = '';
			} else
			{
				ether.upload_dst = null;
				ether.upload_callback = callback;
			}

			ether.upload_caller = $(this);

			tb_show('', 'media-upload.php?&type=image&post_id=0&ether=true&output=html&width=' + width + '&height=' + height + '&tab=' + tab + '&single=' + single + '&TB_iframe=true');

			return false;
		}
	});

	$('.upload_media').live('click', function()
	{
		if ($(this).is('button'))
		{
			var name = $(this).attr('name');
			ether.upload_dst = '.' + name.replace(ether.prefix, '');

			tb_show('', 'media-upload.php?&post_id=0&ether=true&TB_iframe=true');

			return false;
		}
	});

	// OMG FIX FOR ITHEMES BUILDER
	var old_tb_showIframe = tb_showIframe;

	tb_showIframe = function()
	{
		old_tb_showIframe();
		tb_position();

		setTimeout( function()
		{
			tb_position();
		}, 10);
	};

	function ether_cond_fields()
	{
		var val = $(this).val();
		var group = $(this).cattr('ether-group');
		var $scope = $(this).parents('fieldset').eq(0);
		var $elements = $scope.find('.ether-group-' + group).not($(this));
		var is_checkbox = $(this).is('input') && $(this).attr('type') == 'checkbox';

		if (is_checkbox)
		{
			if ($(this).attr('checked'))
			{
				val = 'on';
			} else
			{
				val = 'off';
			}
		}

		if (val == '')
		{
			var $visible = $scope.find('.ether-group-' + group).eq(0);
		} else
		{
			var $visible = $scope.find('.ether-cond-' + val + '.ether-group-' + group);
		}

		$elements.not($visible).slideUp(500).queue(function ()
		{
			//hide(n) (as opposed to hide()) wont apply to elements within a parent that already has display: 'none'
			$(this)
				.css('display', 'none')
				.dequeue();
		});

		//if (ether.$current_builder_widget_modal)
		//{
		//	ether.set_dynamic_label();
		//};

		$visible.slideDown(500);

	};


	$('select.ether-cond, input.ether-cond, textarea.ether-cond').each(ether_cond_fields);
	$('select.ether-cond, input.ether-cond, textarea.ether-cond').live('change', ether_cond_fields);
});

})(jQuery);
