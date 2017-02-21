<div id="ts-settings-general" class="tab-content">
    <h2>General Information</h2>

	<p>
		In order to use this plugin, you MUST have the Visual Composer Plugin installed; either as a normal plugin or as part of your theme. If Visual Composer is part of your theme, please ensure that it has not been modified;
		some theme developers heavily modify Visual Composer in order to allow for certain theme functions. Unfortunately, some of these modification prevent this extension pack from working correctly.
	</p>
	
	<p>
		<h4>Visual Composer Plugin</h4>

		<p style="font-size: 10px;">The following links refer to the actual Visual Composer Plugin.</p>
		
		<div style="margin-top: 20px;">
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=Tekanewa" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_Menu_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Buy Plugin</a>
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="options-general.php?page=wpb_vc_settings" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_Settings_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Settings</a>
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="http://support.wpbakery.com/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_Support_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Support</a>
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="http://demo.wpbakery.com/?theme=visual-composer" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_Demo_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Demo</a>
		</div>
		
		<p style="margin-top: 10px;">In order to use the Visual Composer Extensions, you MUST enable them in the <a href="options-general.php?page=wpb_vc_settings" target="_parent">settings</a> for the actual Visual Composer Plugin.</p>
	</p>
	
	<p>
		<h4>Visual Composer Extensions</h4>
		
		<p style="font-size: 10px;">The following links refer to the Visual Composer Extensions Plugin.</p>
		
		<div style="margin-top: 20px;">
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="http://codecanyon.net/user/Tekanewa/portfolio" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_Menu_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Buy Extensions</a>
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="admin.php?page=TS_VCSC_CSS" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_CustomCSS_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Custom CSS</a>
			<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="admin.php?page=TS_VCSC_JS" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/TS_VCSC_CustomJS_Icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Custom JS</a>
			<?php
				if (get_option('ts_vcsc_extend_settings_extended', 0) == 0) {
					echo '<a class="button-secondary" style="width: 140px; margin: 0px auto; text-align: center;" href="admin.php?page=TS_VCSC_License" target="_parent"><img src="' . TS_VCSC_GetResourceURL('images/TS_VCSC_License_Icon_16x16.png') . '" style="width: 16px; height: 16px; margin-right: 10px;">License</a>';
				}
			?>
		</div>
	</p>
	
	<h2 style="margin-top: 40px;">Visual Composer Rows & Columns</h2>
	
	<p style="margin-top: 20px;">
		Visual Composer Extensions allows you to extend the available options for Row and Column settings, adding features such as viewport animations (row + column) and a variety of background effects (row). If you already use other
		plugins that provide the same or similiar options you should decide for either one but not use both at the same time as they can cause contradicting settings. Also, if your theme incorporates Visual Composer by itself, some
		themes already provide you with similiar options. In these cases, you should disable the settings below in order to avoid any conflicts.
	</p>
	
	<p style="font-weight: bold;">The extended Row and Column Options require a Visual Composer version of 4.1 or higher, in order to function correctly!</p>
	
    <p>
        <h4>Extend Options for Visual Composer Rows:</h4>
        <p>Extend Row Options with Background Effects and Viewport Animation Settings:</p>
        <input type="hidden" name="ts_vcsc_extend_settings_additionsRows" value="0" />
        <input type="checkbox" name="ts_vcsc_extend_settings_additionsRows" id="ts_vcsc_extend_settings_additionsRows" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsRows); ?> />
        <label class="labelCheckBox" for="ts_vcsc_extend_settings_additionsRows">Extend Row Options<span title="If checked, the plugin will extend the available options for row settings." class="<?php echo $ToolTipClass; ?>"></span></label>
    </p>
	
    <p>
        <h4>Extend Options for Visual Composer Columns:</h4>
        <p>Extend Column Options with Viewport Animation Settings:</p>
        <input type="hidden" name="ts_vcsc_extend_settings_additionsColumns" value="0" />
        <input type="checkbox" name="ts_vcsc_extend_settings_additionsColumns" id="ts_vcsc_extend_settings_additionsColumns" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsColumns); ?> />
        <label class="labelCheckBox" for="ts_vcsc_extend_settings_additionsColumns">Extend Column Options<span title="If checked, the plugin will extend the available options for columns settings." class="<?php echo $ToolTipClass; ?>"></span></label>
    </p>
	
	<h2 style="margin-top: 40px;">Use of Custom Post Types</h2>
	
	<p style="margin-top: 20px;">
		Starting with version 2.0, Visual Composer Extensions introduced custom post types, to be used for some of the elements and for more complex layouts. If your theme or another plugin already provides a similiar post
		type (i.e. a post type for "teams"), you can disable the corresponding custom post type that comes with Visual Composer Extensions.
	</p>
	
    <p>
        <h4>Visual Composer Team:</h4>
        <p>Enable or disable the custom post type "VC Team":</p>
        <input type="hidden" name="ts_vcsc_extend_settings_customTeam" value="0" />
        <input type="checkbox" name="ts_vcsc_extend_settings_customTeam" id="ts_vcsc_extend_settings_customTeam" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTeam); ?> />
        <label class="labelCheckBox" for="ts_vcsc_extend_settings_customTeam">Enable "VC Team" Post Type<span title="If checked, the plugin will enable a custom post type to be used for the element(s) 'TS Teammates'." class="<?php echo $ToolTipClass; ?>"></span></label>
    </p>
	
    <p>
        <h4>Visual Composer Testimonials:</h4>
        <p>Enable or disable the custom post type "VC Testimonials":</p>
        <input type="hidden" name="ts_vcsc_extend_settings_customTestimonial" value="0" />
        <input type="checkbox" name="ts_vcsc_extend_settings_customTestimonial" id="ts_vcsc_extend_settings_customTestimonial" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTestimonial); ?> />
        <label class="labelCheckBox" for="ts_vcsc_extend_settings_customTestimonial">Enable "VC Testimonials" Post Type<span title="If checked, the plugin will enable a custom post type to be used for the element(s) 'TS Testimonials'." class="<?php echo $ToolTipClass; ?>"></span></label>
    </p>
</div>
