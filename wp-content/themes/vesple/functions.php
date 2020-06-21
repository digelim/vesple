<?php
require_once( 'wp-less/bootstrap.php' );

/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

// Define path and URL to the ACF plugin.
define( 'ACF_PATH', get_stylesheet_directory() . '/inc/acf/' );
define( 'ACF_URL', get_stylesheet_directory_uri() . '/inc/acf/' );

// Include the ACF plugin.
include_once( ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
    return ACF_URL;
}

// Add options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5db71e1d3e08c',
	'title' => 'Block: Call to action 1',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'normal' => 'Normal',
				'large' => 'Large',
			),
			'default_value' => array(
				0 => 'large',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db71e1d46d29',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db71e1d46d34',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db71e1d46d3b',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White',
				'text-black' => 'Black'
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db71e1d46d41',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db71e1d52de4',
					'label' => 'Url',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db71e1d52dff',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e6',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db71e1d52e1d',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db71e1d52e2f',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db71e1d6c501',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db71e1d6fa20',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db71e1d726c6',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Get the customer a benefit, not a feature.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db71e1d7542f',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Keep it to the top 3 benefits. Provide a clear image of the benefit you receive, but not the specifics. This deliberate vagueness arouses the reader’s curiosity and keeps them interested.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db71e1d782b6',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'small: Small' => 'small: Small',
				'medium: Medium' => 'medium: Medium',
				'large: Large' => 'large: Large',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a300',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'normal' => 'Normal',
        'large' => 'Large',
      ),
      'default_value' => array(
        0 => 'large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/cta-1',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db71f17e9591',
	'title' => 'Block: Call to action 2',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a31',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'normal' => 'Normal',
				'large' => 'Large',
			),
			'default_value' => array(
				0 => 'large',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db71f17f2647',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db71f17f2654',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db71f17f265c',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-black' => 'Black',
				'text-white' => 'White',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db71f17f2663',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db71f180967f',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db71f1809698',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e7',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db71f18096c1',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db71f18096d8',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db71f181f1be',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db71f1821b1a',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db71f1824a24',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db71f182754a',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db71f1829be4',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'small: Small' => 'small: Small',
				'medium: Medium' => 'medium: Medium',
				'large: Large' => 'large: Large',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a301',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'normal' => 'Normal',
        'large' => 'Large',
      ),
      'default_value' => array(
        0 => 'large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/cta-2',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db516138f77a',
	'title' => 'Block: Content 1',
	'fields' => array(
    array(
			'key' => 'field_05e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5163198102',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db5168798103',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db516a598104',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				2 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5171a98105',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Get the customer a benefit, not a feature.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db5172f98106',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Keep it to the top 3 benefits. Provide a clear image of the benefit you receive, but not the specifics. This deliberate vagueness arouses the reader’s curiosity and keeps them interested.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db5173e98107',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db517b298108',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 2,
			'max' => 4,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db517cd98109',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db518139810a',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db5181b9810b',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db519b495fc0',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db51b86e537f',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_15e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-1',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52e4438f5a',
	'title' => 'Block: Content 10',
	'fields' => array(
    array(
			'key' => 'field_15ey31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e4444f42',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52e4444f90',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52e4444fe7',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e444501e',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Make meetings happen',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52e4445034',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Use short paragraphs, rather than long blocks of text. Any paragraph over five lines long can be hard to digest.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52e4445046',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e447033b',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52e4474363',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db52e4478c97',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_25e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-10',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52e643419c',
	'title' => 'Block: Content 11',
	'fields' => array(
    array(
			'key' => 'field_j25e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e64418f5',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52e6441901',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52e6441915',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e6441925',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Me in 30 seconds',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52e6441939',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'It\'s nice to be innovative and creative when talking about yourself because no one knows you better than you. Your bio doesn’t need to be exhaustive. Find a balance between being personal and professional.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52e644194b',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e64633f0',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52e6465bb7',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db52e6468fdc',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbamm4d68d2d',
			'label' => 'Image size',
			'name' => 'image_size',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 35,
			'placeholder' => '%',
			'prepend' => '',
			'append' => '',
			'min' => 35,
			'max' => 80,
			'step' => 1,
		),
    array(
      'key' => 'field_35e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-11',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db5308a191e5',
	'title' => 'Block: Content 12',
	'fields' => array(
    array(
			'key' => 'field_k35e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5308a2f9eb',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db5308a2f9fb',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db5308a2fa02',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5308a2fa08',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Our Principles',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db5308a2fa15',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5308a2fa1d',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db5308a45ea9',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db5308a45eb0',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db5308a51217',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db5308a53b34',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_45e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-12',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db531015f881',
	'title' => 'Block: Content 13',
	'fields' => array(
    array(
			'key' => 'field_g45e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db531016c9b3',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db531016ca00',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db531016ca14',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db531016ca2b',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'We\'re [Company], a multi award-winning digital agency based in London.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db531016ca44',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'We have a unique design led approach, guided by creativity and evolution, not budgets and accounts.<br><br>We build captivating online experiences for companies big and small. You always liaise directly with the designer. This makes the work we do more personal.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db531016ca56',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5310190e20',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db5310193b2f',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_55e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-13',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db53179a8503',
	'title' => 'Block: Content 14',
	'fields' => array(
    array(
			'key' => 'field_55e31kkac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-large',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db53179b8195',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db53179b81d0',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db53179b8202',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db53179b821f',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Our design team is the reason many clients work with us over and over. After years of successful execution, [Company] is now recognized as one of the best teams in User Interaction Design.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db53179b8279',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db53179b8293',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_65e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-large',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-14',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db531db3cccc',
	'title' => 'Block: Content 15',
	'fields' => array(
    array(
			'key' => 'field_n65e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-large',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db531db46726',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db531db46731',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db531db46745',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db531db4674c',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Be simple.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db531db4675e',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Use short paragraphs, rather than long blocks of text. Any paragraph over five lines long can be hard to digest.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db531db4677a',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'large'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db531db63864',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db531db670a7',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db53200e4a7e',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbafc4d68d2d',
			'label' => 'Image size',
			'name' => 'image_size',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 35,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 35,
			'max' => 80,
			'step' => 1,
		),
    array(
      'key' => 'field_75e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-large',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-15',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db532387f732',
	'title' => 'Block: Content 16',
	'fields' => array(
    array(
			'key' => 'field_75e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db532388bbb0',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db532388bbc8',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db532388bbd7',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db532388bc04',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db53238a4c4e',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db53238a4c66',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
				array(
					'key' => 'field_5dbc876e123e0',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
		),
		array(
			'key' => 'field_5db53238ae93a',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db53238b2c18',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_85e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-16',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db5328aa8e20',
	'title' => 'Block: Content 17',
	'fields' => array(
    array(
			'key' => 'field_b85e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5328ab3ad0',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db5328ab3af1',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db5328ab3b15',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db5328ab3b52',
			'label' => 'Statistics',
			'name' => 'statistics_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db5328ac08f1',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db5328ac08fc',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db5328ac87dd',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db5328acb404',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_95e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-17',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52c4893544',
	'title' => 'Block: Content 2',
	'fields' => array(
    array(
			'key' => 'field_r95e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52c489df87',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52c489dfa5',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52c489dfb4',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52c489dfe5',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52c48b5d1b',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52c48b5d29',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52c48b5d32',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52c48c36fa',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52c48c6593',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_e105e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-2',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db532fbeb24d',
	'title' => 'Block: Content 20',
	'fields' => array(
    array(
			'key' => 'field_105e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db532fc0bf88',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db532fc0bf9a',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db532fc0bfb7',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db532fc0bfcc',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Give them a reson to come back',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db532fc0bfed',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Landing pages are the new store-fronts, your first introduction to a potential customer. Give them a reason to come back, or better yet, convert web visitors into product users on the spot.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db532fc0bffd',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db532fc2b58e',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db532fc2f075',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_115e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-20',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5dbca42566b34',
	'title' => 'Block: Content 21',
	'fields' => array(
    array(
			'key' => 'field_115e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbca42572436',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbca4257246c',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbca42574067',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbca42574ce9',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'What we can do for you',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5dbca42574fcc',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbca425750ef',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5dbca42590700',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5dbca42590f95',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
				array(
					'key' => 'field_5dbca4491247d',
					'label' => 'Content',
					'name' => 'content',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5dbca425a5b19',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5dbca425a92f7',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_125e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-21',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db533c0a01d1',
	'title' => 'Block: Content 24',
	'fields' => array(
    array(
			'key' => 'field_1025e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db533c0ab77d',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db533c0ab789',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db533c0ab790',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db533c0ab796',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Frequently Asked Questions',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db533c0ab7a3',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db533c0ab7aa',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db533c0ab7b0',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db534079892f',
			'label' => 'Faqs',
			'name' => 'faqs',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db5341598930',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db5342a98931',
					'label' => 'Content',
					'name' => 'content',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
    array(
      'key' => 'field_135e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-normal',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-24',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5dbca0a4c18ce',
	'title' => 'Block: Content 25',
	'fields' => array(
    array(
			'key' => 'field_135ec31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbca0a4cfd62',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbca0a4d0039',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbca0a4d00b3',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbca0a4d0368',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'What happens after I purchase the service?',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5dbca0a4d0afe',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'After purchasing a plan, you’ll receive a calendly invite to setup a 15 minute kick-off call where we’ll setup a shared slack channel and get started on your first request.<br><br><b>Still have doubts? <a href="#">Contact us</a></b>',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5dbca0a4d0bb2',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbca0a4d0c8f',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5dbca0a4d0e1a',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5dbca0f03ebac',
			'label' => 'Client image',
			'name' => 'client_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_145e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-25',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5djjb52e4438f5a',
	'title' => 'Block: Pricing 1',
	'fields' => array(
    array(
			'key' => 'field_15jjey31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5djjb52e4444f42',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbjj52yye4444f90',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5e3bd0ccyyb9f70',
			'label' => 'Pricing',
			'name' => 'pricing_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5e3yybd0e3b9f71',
					'label' => 'Package name',
					'name' => 'package_name',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e3yybd0f2b9f72',
					'label' => 'Price',
					'name' => 'price',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e3hhbe962677bb',
					'label' => 'Payment cycle',
					'name' => 'payment_cycle',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e3yybd15bb9f73',
					'label' => 'Package description',
					'name' => 'description',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e3byyd165b9f74',
					'label' => 'Package includes',
					'name' => 'package_includes',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_yy5e3bd183b9f75',
							'label' => 'Item',
							'name' => 'item',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
				array(
					'key' => 'field_5yye3bd1a0b9f76',
					'label' => 'Package excludes',
					'name' => 'package_excludes',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_5e3bdyy1afb9f77',
							'label' => 'Item',
							'name' => 'item',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
				array(
					'key' => 'field_gg5db71e1d52de4',
					'label' => 'Button url',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_gg5db71e1d52dff',
					'label' => 'Button label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_gg5e32ed574292e6',
					'label' => 'Button open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db7dd1e1d52e1d',
					'label' => 'Button color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5dbdd71e1d52e2f',
					'label' => 'Button size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5djjb52e4444fe7',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbjj52e444501e',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Pricing for every business, at any stage.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db5jj2e4445046',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbjj52e447033b',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5jjdb52e4474363',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_25ejj31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/pricing-1',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5dccb52e4438f5a',
	'title' => 'Block: Pricing 2',
	'fields' => array(
    array(
			'key' => 'field_15jjey31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5djjb52e4444f42',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5dbjj52yye4444f90',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5e3000ccyyb9f70',
			'label' => 'Pricing',
			'name' => 'pricing_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5e3yybdde3b9f71',
					'label' => 'Package name',
					'name' => 'package_name',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5eddybd0f2b9f72',
					'label' => 'Price',
					'name' => 'price',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e3yddd15bb9f73',
					'label' => 'Package description',
					'name' => 'description',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_gg5dbvve1d52de4',
					'label' => 'Button url',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_gg5dss1e1d52dff',
					'label' => 'Button label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_ggss32ed574292e6',
					'label' => 'Button open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5dbaad1e1d52e1d',
					'label' => 'Button color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5aadd71e1d52e2f',
					'label' => 'Button size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_ddjjb52e4444fe7',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dddj52e444501e',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Simple, all inclusive pricing.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5ssdj52e444501e',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Start with our 30 day trial. No credit card required.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db5jj2kk445046',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dkkj52e447033b',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5kkjdb52e4474363',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_25ekk31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/pricing-2',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52cb17243f',
	'title' => 'Block: Content 3',
	'fields' => array(
    array(
			'key' => 'field_145e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52cb180b62',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52cb180b6d',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52cb180b74',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52cb180b87',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52cb180b98',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52cb180baa',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52cb180bbc',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52cb195efe',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52cb195f15',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52cb195f4c',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52cb1a1d7d',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52cb1a533d',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_155e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-3',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52cf1e2f20',
	'title' => 'Block: Content 4',
	'fields' => array(
    array(
			'key' => 'field_155e31ac9767c7a30v',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c6c',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c7a',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c81',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c88',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'A new way to acquire, engage and retain customers',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c8e',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Provide a clear image of the benefit you receive, but not the specifics. This deliberate vagueness arouses the reader’s curiosity and keeps them interested.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c95',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52cf1f0c9d',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52cf21aebe',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52cf21aee1',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52cf21aef6',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52cf226536',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52cf229a38',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db52d1a61de0',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_165e31ac9767c7a30x',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-4',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52d61ec461',
	'title' => 'Block: Content 5',
	'fields' => array(
    array(
			'key' => 'field_165e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52d620487a',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52d6204891',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52d62048a6',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52d62048b0',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'What do I need to become an affiliate?',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52d62048c0',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52d62048c7',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52d62203df',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52d62203ec',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52d62203f3',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52d622ca55',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52d6230245',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_175e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-5',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52da140210',
	'title' => 'Block: Content 6',
	'fields' => array(
    array(
			'key' => 'field_175e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52da14d9b3',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52da14d9c3',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52da14d9cb',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52da14d9d3',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52da14d9da',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52da14d9e1',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52da14d9e9',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52da167ab5',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52da167ac2',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52da167ac9',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52da179df3',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52da17da3c',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db52da181cda',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_185e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-6',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52dd0552ba',
	'title' => 'Block: Content 7',
	'fields' => array(
    array(
			'key' => 'field_185e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52dd05e352',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52dd05e36c',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52dd05e380',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52dd05e389',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'The 4 ingredients of a high-converting landing page',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52dd05e391',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'A landing page is a single focused objective page used to inspire visitors to take a specific action like download an ebook, sign up for a trial, request a demo, etc.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52dd05e39a',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52dd05e3a4',
			'label' => 'Benefits',
			'name' => 'benefits_row',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52dd074027',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52dd074032',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52dd07403d',
					'label' => 'Description',
					'name' => 'description',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52dd07f20b',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52dd082132',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_195e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-7',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52df6a515a',
	'title' => 'Block: Content 8',
	'fields' => array(
    array(
			'key' => 'field_ff195e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52df6b091f',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52df6b0afe',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52df6b0b24',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52df6b0bb7',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '3 Secrets to selling anything',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52df6b0bcc',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'The secret headline plays on your reader’s curiosity. Who doesn’t want to know a secret?!',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52df6b0bdb',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
				0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52df6b0c09',
			'label' => 'Tabs',
			'name' => 'tabs',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 2,
			'max' => 4,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db52f2bad894',
					'label' => 'Id',
					'name' => 'id',
					'type' => 'text',
					'instructions' => 'No spaces and no special characters allowed.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52f74ad895',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52fbf6a594',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'large',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db52fcc6a595',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db52ff66a596',
					'label' => 'Content',
					'name' => 'content',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
		array(
			'key' => 'field_5db52df6d786c',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52df6da595',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
    array(
      'key' => 'field_dd205e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-8',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db52e2954896',
	'title' => 'Block: Content 9',
	'fields' => array(
    array(
			'key' => 'field_205e31ac9767c7a30',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'None',
				'block-top-padding-normal' => 'Normal',
				'block-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-top-padding-normal',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e296232b',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52e2962337',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db52e296233f',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e2962347',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Bring people together',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db52e296234e',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Use short paragraphs, rather than long blocks of text. Any paragraph over five lines long can be hard to digest.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db52e2962354',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'large' => 'Large',
				'medium' => 'medium',
				'small' => 'small',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db52e2984ee8',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db52e2987e95',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db52e298b0eb',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_215e31ac9767c7a30',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'choices' => array(
				'none' => 'None',
				'block-bottom-padding-normal' => 'Normal',
				'block-bottom-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'block-bottom-padding-normal',
			),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-9',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db60f49a1548',
	'title' => 'Block: Header 1',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a3a',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
				'none' => 'None',
				'header-top-padding-normal' => 'Normal',
				'header-top-padding-large' => 'Large',
			),
			'default_value' => array(
				0 => 'header-top-padding-large',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db60f49adce8',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db60f49adcf4',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db60f49adcfb',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db60f49add01',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db6159200815',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db615a700816',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574d292e',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db615e300818',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'primary',
						'secondary' => 'secondary',
						'tertiary' => 'tertiary',
						'ghost' => 'ghost',
						'white' => 'white',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db6166f0081a',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'small',
						'medium' => 'medium',
						'large' => 'Large',
					),
					'default_value' => array(
            0 => 'medium',
          ),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db60f49cda08',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db60f49d1fd8',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db616fd0081c',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'It’s not about your product. It’s about your customer.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db617040081d',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'If you can describe your customers current problem better than they can, they will unconsciously assume you have the solution.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db6172b0081e',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
    array(
			'key' => 'field_5e31ac9767c7a30a',
			'label' => 'Bottom padding',
			'name' => 'bottom_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-1',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db6448266455',
	'title' => 'Block: Header 10',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a4hh',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db6448278482',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db64482784d2',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db6448278573',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db6448278588',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db6448287955',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db6448287975',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_a5e32ed574292e',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db644828798d',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db64482879a6',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db64482a58e3',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db64482a938d',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db64482adc8b',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Maintain the sales momentum',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db64482b0e8a',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'A sales CRM built for minimum input and maximum output.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db64482b4736',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db64482b875b',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a31h',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'none',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-10',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db644e4ed5fd',
	'title' => 'Block: Header 12',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a5',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db644e506377',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db644e515b4c',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db644e515b57',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e1',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db644e515b71',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db644e515b87',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db644e5365db',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db644e53a8af',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db644e5465a1',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db644e5499b7',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db711e686e09',
			'label' => 'Slider',
			'name' => 'slider',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db7133fbfe23',
					'label' => 'Heading',
					'name' => 'heading',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'All you need to power your online store',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5db71349bfe24',
					'label' => 'Subheading',
					'name' => 'subtitle',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'Our all-in-one platform gives you everything you need to run your business. Whether you’re just getting started or are an established brand, our powerful platform helps your ecommerce grow.',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
				array(
					'key' => 'field_5db71353bfe25',
					'label' => 'Background image',
					'name' => 'background_image_desktop',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'full',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db7138ebfe26',
					'label' => 'Mobile background image',
					'name' => 'background_image_mobile',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'large',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5db713a1bfe27',
					'label' => 'Text color',
					'name' => 'text_color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'text-white' => 'White',
            'text-black' => 'Black'
					),
					'default_value' => array(
            0 => 'text-black'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
    array(
      'key' => 'field_5e31ac9767c7a32',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'default_value' => array(
        0 => 'large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-12',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db617652aef0',
	'title' => 'Block: Header 2',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a6',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db617653ba22',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db617653ba2e',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db617653ba35',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db617653ba3b',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db617654d9c7',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db617654d9dd',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e2',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db617654da10',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db617654da32',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db6176568c77',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db617656bc31',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db617656e808',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Write headlines that make your customers take notice',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db6176571728',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'The best headlines get you to stop, jerk your attention, have greed, curiosity, and unexpected surprises in them.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db6176574816',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large',
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db617840ce86',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a33',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-2',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db617dea9033',
	'title' => 'Block: Header 3',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a6',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db617deb8837',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db617deb8843',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db617deb884d',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db617deb8855',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db617dec788d',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db617dec7898',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e3',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db617dec78a5',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db617dec78b1',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db617dee038c',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db617dee3ad4',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db617dee7c00',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Determine Your Wow Factor',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db617deeb0e4',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'The best headlines get you to stop, jerk your attention, have greed, curiosity, and unexpected surprises in them.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db617deee2ae',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db617def113b',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a34',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-3',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db618551166b',
	'title' => 'Block: Header 4',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a7',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db618551bda3',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db618551bdb0',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db618551bdb7',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db618551bdbd',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db6185529c11',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db6185529c1e',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e3',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db6185529c2d',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db6185529c3e',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db6185542334',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db61855452d4',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db618554919c',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Be clear. Not clever. Clarity trumps persuasion.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db618554c606',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db61855504bf',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db6185554029',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a36',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-4',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db618ace9dca',
	'title' => 'Block: Header 5',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a0',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db618ad02b15',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db618ad02b2b',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db618ad02b38',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db618ad02b44',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db618ad132bb',
					'label' => 'Url',
					'name' => 'url',
'type' => 'url',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db618ad132d4',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e4',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db618ad132f0',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db618ad13306',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db618ad322c3',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db618ad34a93',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5dhh61ad376a2',
			'label' => 'Pre-heading text',
			'name' => 'intro',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'THE HEADLINE MAGIC FORMULA',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db618ad376a2',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Double your website traffic in 2 months or your money back',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db618ad3aaae',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Benefit to customer + time period + overcome his objections',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db618ad3e52a',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large',
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db618ad40dea',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'large',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db618ea632e0',
			'label' => 'Intro',
			'name' => 'intro',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5e3d44d48edd0',
			'label' => 'Form shortcode',
			'name' => 'cf7_shortcode',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
    array(
      'key' => 'field_5e31ac9767c7a37',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-5',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db6195a17924',
	'title' => 'Block: Header 6',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a1',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db6195a28b25',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db6195a29104',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db6195a29141',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db6195a54c8a',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db6195a58599',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db6195a5be3c',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Build trust with a testimonial focused headline',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db6195a651e1',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large',
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5e3dhud48edd0',
			'label' => 'Form shortcode',
			'name' => 'cf7_shortcode',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_5db6434194ffc',
			'label' => 'Testimonial',
			'name' => 'testimonial',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '“Working with [Company] was (and continues to be) an outstanding experience. Since relaunching our website with their design ideas, services and recommendations, our company has experienced a 35% increase in conversions”',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db6435894ffd',
			'label' => 'Client name',
			'name' => 'testimonial_name',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Kyle Lee',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db6437b94ffe',
			'label' => 'Client profession',
			'name' => 'client_role',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Marketing Manager, Opentech',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db6439494fff',
			'label' => 'Client picture',
			'name' => 'testimonial_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a38',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-6',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db642d452941',
	'title' => 'Block: Header 8',
	'fields' => array(
    array(
			'key' => 'field_5e31ac9767c7a2',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'header-top-padding-normal' => 'Normal',
        'header-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db642d466a96',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db642d466ad0',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db642d466b0b',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
    array(
			'key' => 'field_5db71e1d46d41z',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 2,
			'layout' => 'block',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5db71e1d52de4z',
					'label' => 'Url',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '#',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db71e1d52dffz',
					'label' => 'Label',
					'name' => 'label',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
  'width' => '',
  'class' => '',
  'id' => '',
),
'default_value' => 'Call to action',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
        array(
					'key' => 'field_5e32ed574292e6z',
					'label' => 'Open',
					'name' => 'target',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'_blank' => 'New tab',
						'' => 'Same tab',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5db71e1d52e1dz',
					'label' => 'Color',
					'name' => 'color',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'tertiary' => 'Tertiary',
						'ghost' => 'Ghost',
						'white' => 'White',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5db71e1d52e2fz',
					'label' => 'Size',
					'name' => 'size',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'small' => 'Small',
'medium' => 'Medium',
'large' => 'Large',
),
'default_value' => array(0 => 'medium'
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5db642d4a2029',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db642d4a5ed2',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db642d4abd36',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Get 30-40 High-Quality B2B Leads Every Single Month On Autopilot!',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db642d4afa11',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Without Having To Do Any Prospecting, Without Having To Spend Crazy Money On PPC Ads or SEO, And You DO NOT Need To Build Any Complicated Marketing Funnels! ',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db642d4b30e8',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'medium'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
    array(
      'key' => 'field_5e31ac9767c7a39',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'header-bottom-padding-normal' => 'Normal',
        'header-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'header-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/header-8',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db642dc452941',
	'title' => 'Block: Content 18',
	'fields' => array(
    array(
			'key' => 'field_5me31ac9767c7a2',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'block-top-padding-normal' => 'Normal',
        'block-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-top-padding-large',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5db64l2d466a96',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db64c2d466ad0',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db6b42d466b0b',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dcb642bbd4a2029',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db6b42d4a5ed2',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5db6d42d4abd36',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Proven process delivers successful campaigns.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5tdb642d4avfa11',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'We mix together the right combination of research, experience design, execution and testing to make sure that you and your products reach the maximum potential.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db64c2d4b30e8',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5e3axa431b3ab9',
			'label' => 'video',
			'name' => 'video',
			'type' => 'oembed',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'width' => '',
			'height' => '',
		),
    array(
      'key' => 'field_5fe31ac9767c7a39',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-large',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-18',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5dbc6448266455',
	'title' => 'Block: Content 19',
	'fields' => array(
    array(
			'key' => 'field_5e3c1ac9767c7a4hh',
			'label' => 'Top padding',
			'name' => 'top_padding',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
      'choices' => array(
        'none' => 'None',
        'block-top-padding-normal' => 'Normal',
        'block-top-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-top-padding-normal',
      ),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5cdb6448278482',
			'label' => 'Background image',
			'name' => 'background_image_desktop',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db6b4482784d2',
			'label' => 'Mobile background image',
			'name' => 'background_image_mobile',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db6v448278573',
			'label' => 'Text color',
			'name' => 'text_color',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'text-white' => 'White','text-black' => 'Black',
			),
			'default_value' => array(
				0 => 'default',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dcb6b4482a58e3',
			'label' => 'Overlay color',
			'name' => 'overlay_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5db64c482a938d',
			'label' => 'Overlay opacity',
			'name' => 'overlay_opacity',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 1,
			'step' => '0.01',
		),
		array(
			'key' => 'field_5dbn64482adc8b',
			'label' => 'Heading',
			'name' => 'heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Good ideas go a long way. Proven ideas drive growth.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5db644c82b0e8a',
			'label' => 'Subheading',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Strategy, Design & Advertising for Apps.',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5db64l482b4736',
			'label' => 'Heading size',
			'name' => 'heading_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
			),
			'default_value' => array(
        0 => 'small'
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_h5e3axa431b3ab9',
			'label' => 'video',
			'name' => 'video',
			'type' => 'oembed',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'width' => '',
			'height' => '',
		),
    array(
      'key' => 'field_5el31ac9767c7a31h',
      'label' => 'Bottom padding',
      'name' => 'bottom_padding',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array(
        'none' => 'None',
        'block-bottom-padding-normal' => 'Normal',
        'block-bottom-padding-large' => 'Large',
      ),
      'default_value' => array(
        0 => 'block-bottom-padding-normal',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'return_format' => 'value',
      'ajax' => 0,
      'placeholder' => '',
    ),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/content-19',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5db88fa324148',
	'title' => 'Theme options',
	'fields' => array(
		array(
			'key' => 'field_5db8fb129236a',
			'label' => 'White logo',
			'name' => 'white_logo',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5db8fb691e6ee',
			'label' => 'Black logo',
			'name' => 'black_logo',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
    array(
			'key' => 'field_5e31ac9767c7aa',
			'label' => 'Color primary',
			'name' => 'color_primary',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#50bc7f',
		),
		array(
			'key' => 'field_5e32a233a8bd9b',
			'label' => 'Color secondary',
			'name' => 'color_secondary',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#000000',
		),
		array(
			'key' => 'field_5e32a282a8bdac',
			'label' => 'Color tertiary',
			'name' => 'color_tertiary',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#000000',
		),
		array(
			'key' => 'field_5e35cb05a2g7a6',
			'label' => 'Add shadow to elements?',
			'name' => 'shadow',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5db71e1d52e26',
			'label' => 'Make buttons round?',
			'name' => 'round',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'round' => 'yes',
				'' => 'No',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'round',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5dbcacf9df85a',
			'label' => 'Extra navigation elements',
			'name' => 'extra_navigation_elements',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5dbcad0adf85b',
					'label' => 'Item',
					'name' => 'item',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => '',
				),
			),
		),
    array(
			'key' => 'field_5e31ac9767c7a',
			'label' => 'Mobile navigation breakpoint',
			'name' => 'mobile_navigation_breakpoint',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 991,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5dbcb22df561d',
			'label' => 'Navigation',
			'name' => 'navigation',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				1 => '1',
				2 => '2',
				3 => '3',
				4 => '4',
				6 => '6',
				7 => '7',
				8 => '8',
				9 => '9',
			),
			'default_value' => array(
				0 => 'header-1',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbe3d6823a57',
			'label' => 'Footer',
			'name' => 'footer',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				1 => '1',
				2 => '2',
				3 => '3',
				4 => '4',
				5 => '5',
				6 => '6',
				7 => '7',
				8 => '8',
				9 => '9',
				10 => '10',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5dbcb4ec39811',
			'label' => 'Navigation theme',
			'name' => 'navigation_theme',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'dark' => 'dark',
				'light' => 'light',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5dbcdfcb1fd46',
			'label' => 'Navigation background color',
			'name' => 'navigation_background_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#ffffff',
		),
		array(
			'key' => 'field_5dbe3c434313f',
			'label' => 'Footer theme',
			'name' => 'footer_theme',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'dark' => 'dark',
				'light' => 'light',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'light',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5dbe3c5d43140',
			'label' => 'Footer background color',
			'name' => 'footer_background_color',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#ffffff',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

if (class_exists('WPLessPlugin')){
	$less = WPLessPlugin::getInstance();

  $color_primary = get_field('color_primary', 'options');
  $color_secondary = get_field('color_secondary', 'options');
  $color_tertiary = get_field('color_tertiary', 'options');
  $navigation_background_color = get_field('navigation_background_color', 'options');
	$footer_background_color = get_field('footer_background_color', 'options');
  $mobile_navigation_breakpoint = get_field('mobile_navigation_breakpoint', 'options');
	$shadow = get_field('shadow', 'options') ? '0px 7px 20px rgba(0, 0, 0, 0.24)' : 'none';

  $less->addVariable( 'color-primary', $color_primary );
  $less->addVariable( 'color-secondary', $color_secondary );
  $less->addVariable( 'color-tertiary', $color_tertiary );
  $less->addVariable('menu-breakpoint', $mobile_navigation_breakpoint );
  $less->addVariable('navigation-bg',  $navigation_background_color);
  $less->addVariable('footer-bg',  $footer_background_color);
	$less->addVariable('shadow',  $shadow);
}


function project_scripts() {
  if ( ! is_admin() ) {
    //wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/less/landing/style.less' );
    if ( is_front_page() ) {
			wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/less/landing/style.less' );
    } else {
			wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/less/app/style.less' );
		}

    wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'wp-util'), '1.0', true );
		wp_enqueue_script( 'd3', get_stylesheet_directory_uri() . '/js/vendor/d3.js' );
		wp_enqueue_script( 'rickshaw', get_stylesheet_directory_uri() . '/js/vendor/rickshaw.js' );
		wp_enqueue_script( 'radarchart', get_stylesheet_directory_uri() . '/js/vendor/radarchart.js' );
		wp_enqueue_script('moment', get_stylesheet_directory_uri() . '/js/vendor/moment.min.js' );

		$input_mask  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/vendor/jquery.inputmask.min.js' ));

		wp_enqueue_script( 'input-mask', get_stylesheet_directory_uri() . '/js/vendor/jquery.inputmask.min.js', array(), $input_mask );

		if ( is_page('thank-you') ) {
			$thankyou  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/thankyou.js' ));

			wp_enqueue_script( 'thankyou', get_stylesheet_directory_uri() . '/js/thankyou.js', array(), $thankyou );
			wp_localize_script( 'thankyou', 'assets', $assets );
		}

		$current_fp = get_query_var('fpage');

		global $wp_the_query;

		$post_id = $wp_the_query->get_queried_object_id();
		$assets = get_field( 'assets', $post_id );

		foreach ( $assets as $key => $asset ) {
			$args = array(
				'post_type' => 'asset',
				'numberposts' => 1,
				'name' => $asset['symbol'],
			);

			$asset_id = get_posts( $args )[0]->ID;
			$assets[$key]['returns'] = json_decode( get_field( 'returns', $asset_id ) );
			$assets[$key]['name'] = get_post_field( 'post_content', $asset_id );
		}

		$current_results = get_field( 'current_portfolio_expected_results', $post_id );

		if ( is_singular('portfolio') && !$current_fp ) {
			wp_enqueue_script( 'donutchart', get_stylesheet_directory_uri() . '/js/donutchart.js' );
			wp_enqueue_script( 'dashboard', get_stylesheet_directory_uri() . '/js/dashboard.js' );
			wp_localize_script( 'dashboard', 'assets', $assets );
			wp_localize_script( 'dashboard', 'currentResults', $current_results );
		}

		if ($current_fp == 'assets') {
			wp_enqueue_script( 'typeahead', get_stylesheet_directory_uri() . '/js/vendor/typeahead.bundle.js' );
			wp_enqueue_script( 'wizard-assets', get_stylesheet_directory_uri() . '/js/wizard-assets.js' );
			wp_localize_script( 'wizard-assets', 'assetsToLoad', $assets );
		} else if ($current_fp == 'investment') {
		 	wp_enqueue_script( 'wizard-investment', get_stylesheet_directory_uri() . '/js/wizard-investment.js' );
	 } else if ( $current_fp === 'portfolio' ) {
		wp_enqueue_script('math', get_stylesheet_directory_uri() . '/js/vendor/math.min.js' );
		wp_enqueue_script('portfolio_allocation', get_stylesheet_directory_uri() . '/js/vendor/portfolio_allocation.dist.min.js' );
		wp_enqueue_script('wizard-portfolio', get_stylesheet_directory_uri() . '/js/wizard-portfolio.js' );

 		$i_will_invest = get_field('initial_investment', $post_id );
 		$regular_investment_interval = get_field('investment_interval', $post_id );
 		$regular_investment_amount = get_field('investment_amount', $post_id );
		$inflation = get_field( 'inflation', $post_id );
		$regular_investment_growth_rate = get_field( 'regular_investment_growth_rate', $post_id );

 		wp_localize_script( 'wizard-portfolio', 'assets', $assets );
 		wp_localize_script( 'main-js', 'investment', array(
 			'iWillInvest' => $i_will_invest,
 			'regularMonthsPeriod' => $regular_investment_interval,
 			'regularInvestment' => $regular_investment_amount,
			'inflation' => $inflation,
			'regularInvestmentGrowthRate' => $regular_investment_growth_rate,
 		));
	 }
  } else {
  	wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/less-admin/style.less' );
  }
}
add_action( 'wp_enqueue_scripts', 'project_scripts' );

function theme_name_scripts() {
	wp_localize_script( 'main-js', 'MyAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	));
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

function my_run_only_once() {

    if ( get_option( 'my_run_only_once_01' ) != '260-337' ) {
			update_option( 'my_run_only_once_01', '260-337' );

			if ( get_option( 'my_run_only_once_01' ) == '260-337' ) {
				$exchanges = array(
					'US',
					'LSE',
					'TO',
					'V',
					'BE',
					'HM',
					'XETRA',
					'MU',
					'DU',
					'HA',
					'STU',
					'F',
					'VI',
					'LU',
					'MI',
					'PA',
					'BR',
					'AS',
					'MC',
					'LS',
					'VX',
					'SW',
					'NFN',
					'CO',
					'IC',
					'HE',
					'IR',
					'NB',
					'ST',
					'OL',
					'HK',
					'TA',
					'KO',
					'KQ',
					'PSE',
					'WAR',
					'BUD',
					'SG',
					'BSE',
					'SN',
					'TSE',
					'KAR',
					'SR',
					'BK',
					'JSE',
					'JK',
					'SHE',
					'AT',
					'SHG',
					'VN',
					'AU',
					'KLSE',
					'SA',
					'BA',
					'MX',
					'IL',
					'CC',
					'COMM',
					'FOREX',
					'IS',
					'TWO',
					'TW',
					'INDX',
					'BOND',
					'EUFUND',
					'RUFUND',
				);

				for ($i=0; $i < sizeof( $exchanges ); $i++) {
					$json_url = 'https://eodhistoricaldata.com/api/exchanges/' . $exchanges[$i] . '?api_token=5e8bf2d5ef8800.10311711&fmt=json';
					$json = file_get_contents($json_url);

					$assets = json_decode($json, true);

					for ($j=0; $j < sizeof( $assets ); $j++) {

						switch ( $exchanges[$i] ) {
							case 'US':
							$category = 95;
							 break;

							case 'LSE':
							$category = 96;
							 break;

							case 'TO':
							$category = 97;
							 break;

							case 'V':
							$category = 98;
							 break;

							case 'BE':
							$category = 99;
							 break;

							case 'HM':
							$category = 100;
							 break;

							case 'XETRA':
							$category = 101;
							 break;

							case 'MU':
							$category = 102;
							 break;

							case 'DU':
							$category = 103;
							 break;

							case 'HA':
							$category = 104;
							 break;

							case 'STU':
							$category = 105;
							 break;

							case 'F':
							$category = 106;
							 break;

							case 'VI':
							$category = 107;
							 break;

							case 'LU':
							$category = 108;
							 break;

							case 'MI':
							$category = 109;
							 break;

							case 'PA':
							$category = 110;
							 break;

							case 'BR':
							$category = 111;
							 break;

							case 'AS':
							$category = 112;
							 break;

							case 'MC':
							$category = 113;
							 break;

							case 'LS':
							$category = 114;
							 break;

							case 'VX':
							$category = 115;
							 break;

							case 'SW':
							$category = 116;
							 break;

							case 'NFN':
							$category = 117;
							 break;

							case 'CO':
							$category = 118;
							 break;

							case 'IC':
							$category = 119;
							 break;

							case 'HE':
							$category = 120;
							 break;

							case 'IR':
							$category = 121;
							 break;

							case 'NB':
							$category = 122;
							 break;

							case 'ST':
							$category = 123;
							 break;

							case 'OL':
							$category = 124;
							 break;

							case 'HK':
							$category = 125;
							 break;

							case 'TA':
							$category = 126;
							 break;

							case 'KO':
							$category = 127;
							 break;

							case 'KQ':
							$category = 128;
							 break;

							case 'PSE':
							$category = 129;
							 break;

							case 'WAR':
							$category = 130;
							 break;

							case 'BUD':
							$category = 131;
							 break;

							case 'SG':
							$category = 132;
							 break;

							case 'BSE':
							$category = 133;
							 break;

							case 'SN':
							$category = 135;
							 break;

							case 'TSE':
							$category = 136;
							 break;

							case 'KAR':
							$category = 137;
							 break;

							case 'SR':
							$category = 138;
							 break;

							case 'BK':
							$category = 139;
							 break;

							case 'JSE':
							$category = 140;
							 break;

							case 'JK':
							$category = 141;
							 break;

							case 'SHE':
							$category = 142;
							 break;

							case 'AT':
							$category = 143;
							 break;

							case 'SHG':
							$category = 144;
							 break;

							case 'VN':
							$category = 145;
							 break;

							case 'AU':
							$category = 146;
							 break;

							case 'KLSE':
							$category = 147;
							 break;

							case 'SA':
							$category = 148;
							 break;

							case 'BA':
							$category = 149;
							 break;

							case 'MX':
							$category = 150;
							 break;

							case 'IL':
							$category = 151;
							 break;

							case 'CC':
							$category = 152;
							 break;

							case 'COMM':
							$category = 153;
							 break;

							case 'FOREX':
							$category = 154;
							 break;

							case 'IS':
							$category = 155;
							 break;

							case 'TWO':
							$category = 156;
							 break;

							case 'TW':
							$category = 157;
							 break;

							case 'INDX':
							$category = 158;
							 break;

							case 'BOND':
							$category = 159;
							 break;

							case 'EUFUND':
							$category = 160;
							 break;

							case 'RUFUND':
							$category = 161;
							 break;

							default:
								$category = 1;
								break;
						}

						$post = array(
							'post_title' => $assets[$j]['Code'] . '.' . $exchanges[$i],
							'post_content' => $assets[$j]['Name'],
							'post_excerpt' => $assets[$j]['Type'],
							'post_status' => 'publish',
							'post_type' => 'asset',
							'post_category' => array( $category ),
						);

						$post_id = wp_insert_post( $post, true );
					}
				}
			}
    }
}
add_action( 'admin_init', 'my_run_only_once' );

function update_prices( $offset ) {
	// Get posts
	$my_posts = get_posts(
		array(
			'post_type' => 'asset',
			'post_status' => 'publish',
			'numberposts' => 2500,
			'offset' => intval( $offset ),
			'order' => 'ASC',
	    'orderby' => 'date',
		)
	);

	foreach ( $my_posts as $my_post ) {
		// Fetch the data
		$symbol = $my_post->post_title;
		$json_url = 'https://eodhistoricaldata.com/api/eod/' . $symbol . '?from=' . date("Y-m-d", strtotime("-8 years")) . '&api_token=5e8bf2d5ef8800.10311711&fmt=json';
		$json = file_get_contents($json_url);
		$data = json_decode($json, true);

		// Get history and period of dates
		$history = array_reverse( $data );
		$last_refreshed = $history[0]['date'];
		$last_date = end( $history )['date'];

		// Generate dates for the given period
		$period = new DatePeriod(
	     new DateTime( $last_date ),
	     new DateInterval('P1D'),
	     new DateTime( $last_refreshed )
		 );

		// Set up variables
		$close = end( $data )['adjusted_close'];
		$returns = array();

		foreach ($period as $key => $value) {
			$history_item = array_search( $value->format('Y-m-d'), array_column( $history, 'date'));
			$close = $history_item ? $history[$history_item]['adjusted_close'] : $close;
			$date = $value->format('Y-m-d');
			$previous_date = date( 'Y-m-d', strtotime( '-1 day', strtotime( $date ) ) );
			$previous_close = $key > 0 ? $returns[$previous_date]['close'] : $close;
			$change = $previous_close !== 0 ? ( ( $close - $previous_close ) / $previous_close ) : 0;
			$return = array( 'close' => floatval( $close ), 'change' => round( ( $change * 100 ), 2 ) );
			$returns[$date] = $return;
		}

		$new_json = json_encode( $returns );

		if ( sizeof( $returns ) > 0 ) {
			update_field( 'returns', $new_json, $my_post->ID );
		}
	}
}

//add_action( 'admin_init', 'update_prices' );

add_action( 'admin_init', 'create_cron_jobs' );
function create_cron_jobs() {
	if ( get_option('create_cron_jobs') !== '007' ) {
		update_option('create_cron_jobs', '007');

		for ($i=0; $i < 53; $i++) {
			if ( ! wp_next_scheduled( 'get_historical_data_' . $i ) ) {
				wp_schedule_event( time() + ( 35 * 60 * $i ), 'daily', 'get_historical_data_' . $i, array( 'offset' => $i * 2500 ) );
		  }
		}
	}
}

add_action( 'wp_loaded', 'wp_loaded_actions' );
function wp_loaded_actions() {
	for ($i=0; $i < 47; $i++) {
		add_action( 'get_historical_data_' . $i, function( $offset ) {
			update_prices( $offset );
		}, 10, 1 );
	}
}

function create_portfolio() {
	$existing_portfolios = array(
		'post_status' => 'publish',
		'post_type' => 'portfolio',
		'author' => get_current_user_id(),
		'numberposts' => -1,
	);

	$existing_portfolios_found = get_posts( $existing_portfolios );
	$count = sizeof( $existing_portfolios_found );
	$post_title = 'Portfolio ' . ( $count + 1 );

	$blank_portfolio = array(
		'post_status' => 'publish',
		'post_type' => 'portfolio',
		'author' => get_current_user_id(),
		'post_title' => $post_title
	);

	$post_id = wp_insert_post( $blank_portfolio, true );
	wp_redirect( home_url('portfolio/' . $post_id . '/assets') );
	exit;
}
add_action( 'admin_post_create_portfolio', 'create_portfolio' );

$my_fake_pages = array(
  'assets' => 'Assets',
  'investment' => 'Investment',
  'portfolio' => 'Portfolio'
);

add_filter('rewrite_rules_array', 'fsp_insertrules');
add_filter('query_vars', 'fsp_insertqv');

// Adding fake pages' rewrite rules
function fsp_insertrules( $rules ) {
  global $my_fake_pages;

  $newrules = array();

  foreach ($my_fake_pages as $slug => $title)
      $newrules['portfolio/([0-9]+)/' . $slug . '/?$'] = 'index.php?post_type=portfolio&p=$matches[1]&fpage=' . $slug;
			$newrules['portfolio/([0-9]+)/?$'] = 'index.php?post_type=portfolio&p=$matches[1]&fpage=';

  return $newrules + $rules;
}

// Tell WordPress to accept our custom query variable
function fsp_insertqv( $vars ) {
  array_push( $vars, 'fpage' );

	return $vars;
}

function mycustomname_links( $post_link, $post = 0 ) {
	if( $post->post_type === 'portfolio' ) {
		return home_url( 'portfolio/' . $post->ID );
	}
	else{
		return $post_link;
	}
}
add_filter('post_type_link', 'mycustomname_links', 1, 3);

remove_filter('wp_head', 'rel_canonical');
add_filter('wp_head', 'fsp_rel_canonical');
function fsp_rel_canonical() {
  global $current_fp, $wp_the_query;

  if (!is_singular())
      return;

  if (!$id = $wp_the_query->get_queried_object_id())
      return;

  $link = trailingslashit(get_permalink($id));

  // Make sure fake pages' permalinks are canonical
  if (!empty($current_fp))
      $link .= user_trailingslashit($current_fp);

  echo '<link rel="canonical" href="'.$link.'" />';
}

function wpseo_canonical_exclude( $canonical ) {
        global $post;
        if (is_singular('portfolio')) {
            $canonical = false;
    }
    return $canonical;
}

add_filter( 'wpseo_canonical', 'wpseo_canonical_exclude' );

add_action( 'admin_post_add_assets_to_portfolio', 'add_assets_to_portfolio' );
function add_assets_to_portfolio() {
	$symbols_to_add = $_POST['symbols'];
	$quantity = $_POST['stock-quantity'];
	$post_id = intval( $_POST['post_id'] );
	$user_can_update = get_current_user_id() == get_post($post_id)->post_author;

	if ( $user_can_update ) {
		if ( have_rows( 'assets', $post_id ) ) {
			$symbols_in_portfolio = array();

			while( have_rows( 'assets', $post_id ) ) {
			 the_row();

			 $symbols_in_portfolio[get_row_index()] = get_sub_field('symbol');
			}
		}

		// Add assets
		foreach ( $symbols_to_add as $key => $symbol ) {
			if ( !in_array( $symbol, $symbols_in_portfolio ) ) {
				$add_date = new DateTime();
				$add_date = $add_date->format('Y-m-d H:i:s');

				$row = array(
					'symbol' => $symbol,
					'add_date' => $add_date,
					'quantity' => $quantity[$key],
				);

				add_row( 'assets', $row, $post_id );
			} else {
				while ( have_rows( 'assets', $post_id ) ) {
				  the_row();

				  if ( get_sub_field( 'symbol' ) === $symbol ) {
						$row = get_row_index();

						$value = array(
							'symbol' => $symbol,
							'add_date' => $add_date,
							'quantity' => $quantity[$key],
						);

						update_row( 'assets', $row, $value, $post_id );
				  }

				}
			}
		}

		// Delete assets
		foreach ( $symbols_in_portfolio as $row => $symbol_in_portfolio ) {
			if ( !in_array( $symbol_in_portfolio, $symbols_to_add ) ) {
				delete_row( 'assets', $row, $post_id );
			}
		}
	}

	wp_redirect( home_url('portfolio/' . $post_id . '/investment') );
	exit;
}

add_action( 'admin_post_update_portfolio_investment', 'update_portfolio_investment' );
function update_portfolio_investment() {
	$optimal_weights = $_POST['optimal_weights'];
	$initial_investment = intval( $_POST['investment-value'] );
	$regular_investment = $_POST['radio-group'] === 'on' ? true : false;
	$inflation = floatval( $_POST['inflation'] );
	$regular_investment_growth_rate = floatval( $_POST['regular-investment-growth-rate'] );
	$investment_interval = $regular_investment ? intval( $_POST['investment-interval'] ) : 0;
	$investment_amount = $regular_investment ? $_POST['investment-amount'] : 0;
	$post_id = intval( $_POST['post_id'] );
	$user_can_update = ( get_current_user_id() == get_post($post_id)->post_author ) || ( get_current_user_id() === 1 );

	if ( $user_can_update ) {
		update_field( 'initial_investment', $initial_investment, $post_id );
		update_field( 'regular_investment', $regular_investment, $post_id );
		update_field( 'investment_interval', $investment_interval, $post_id );
		update_field( 'investment_amount', $investment_amount, $post_id );
		update_field( 'inflation', $inflation, $post_id );
		update_field( 'regular_investment_growth_rate', $regular_investment_growth_rate, $post_id );
	}

	wp_redirect( home_url('portfolio/' . $post_id . '/portfolio') );
	exit;
}


function save_optimal_portfolio() {
	$post_id = intval( $_POST['post_id'] );
	$weight = $_POST['weight'];
	$optimal_weights = $_POST['optimal_weights'];
	$optimal_quantity = $_POST['optimal_quantity'];
	$needs_to_buy_or_sell = $_POST['needs_to_buy_or_sell'];
	$risk_reduction = $_POST['risk_reduction'];
	$return_increase = $_POST['return_increase'];
	$expected_monthly_average_return = $_POST['expected_monthly_average_return'];
	$current_average_monthly_return = $_POST['current_average_monthly_return'];
	$portfolio_value = $_POST['portfolio_value'];
	$current_portfolio_expected_results = $_POST['current_portfolio_expected_results'];
	$optimal_portfolio_expected_results = $_POST['optimal_portfolio_expected_results'];

	if ( have_rows( 'assets', $post_id ) ) {
		while ( have_rows( 'assets', $post_id ) ) {
			the_row();

			update_sub_field( 'optimal_weight', number_format( $optimal_weights[ get_row_index() - 1 ], 2 ), $post_id );
			update_sub_field( 'optimal_quantity', intval( $optimal_quantity[ get_row_index() - 1 ] ), $post_id );
			update_sub_field( 'needs_to_buy_or_sell', intval( $needs_to_buy_or_sell[ get_row_index() - 1 ] ), $post_id );
			update_sub_field( 'weight', number_format( $weight[ get_row_index() - 1 ], 2 ), $post_id );
		}
	}

	update_field( 'risk_reduction', $risk_reduction, $post_id );
	update_field( 'return_increase', $return_increase, $post_id );
	update_field( 'expected_monthly_average_return', $expected_monthly_average_return, $post_id );
	update_field( 'current_average_monthly_return', $current_average_monthly_return, $post_id );
	update_field( 'portfolio_value', $portfolio_value, $post_id );
	update_field( 'current_portfolio_expected_results', $current_portfolio_expected_results, $post_id );
	update_field( 'optimal_portfolio_expected_results', $optimal_portfolio_expected_results, $post_id );

	wp_redirect( home_url('portfolio/' . $post_id ) );
	exit;
}

add_action( 'admin_post_save_optimal_portfolio', 'save_optimal_portfolio' );

function delete_portfolio() {
	$post_id = intval( $_POST['post_id'] );
	wp_delete_post( $post_id, true );
	wp_redirect( home_url('portfolio') );
	exit;
}
add_action( 'admin_post_delete_portfolio', 'delete_portfolio' );

add_action( 'template_redirect', 'redirect_to_first_portfolio' );
function redirect_to_first_portfolio() {
	$current_fp = get_query_var('fpage');

	if (!$current_fp && is_archive() && !is_woocommerce() ) {
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'portfolio',
			'author' => get_current_user_id()
		);

		$posts = get_posts( $args );

		if ( $posts[0] ) {
			$redirect_url = get_permalink( $posts[0]->ID );

			wp_redirect( $redirect_url );
			exit;
		}
	}
}

add_filter( 'woocommerce_login_redirect', 'redirect_after_login', 10, 3 );
function redirect_after_login( $redirect_to, $user ) {
	$args = array(
		'posts_per_page' => 1,
		'post_type' => 'portfolio',
		'author' => $user->ID
	);

	$posts = get_posts( $args );

	if ( $posts[0] ) {
		$redirect_to = get_permalink( $posts[0]->ID );
	} else {
		$redirect_to = home_url('portfolio');
	}

	return $redirect_to;
}

add_filter('show_admin_bar', '__return_false');

add_action( 'template_redirect', 'require_login' );
function require_login() {
	if ( is_singular('portfolio') && !is_user_logged_in() ) {
		wp_redirect( home_url('my-account') );
		exit;
	}
}

add_action( 'template_redirect', 'redirect_my_account' );
function redirect_my_account() {
	if ( is_user_logged_in() && is_account_page() ) {
		wp_redirect( home_url('portfolio') );
		exit;
	}
}

function archive_page_query( $query ) {
    if ( is_post_type_archive( 'portfolio' ) && !is_admin() ) {
        $query->set( 'author', get_current_user_id() );
    }
}
add_filter( 'pre_get_posts', 'archive_page_query' );

add_action('wp_logout','redirect_after_logout');
function redirect_after_logout(){
	wp_redirect( home_url('portfolio') );
	exit();
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    return $fields;
}

add_action( 'after_setup_theme', 'wc_remove_frame_options_header', 11 );

function wc_remove_frame_options_header() {
	remove_action( 'template_redirect', 'wc_send_frame_options_header' );
}

add_action( 'woocommerce_thankyou', 'close_iframe');

function close_iframe( $order_id ){
    $order = wc_get_order( $order_id );
    $url = home_url('thank-you');

		wp_localize_script( 'thankyou', 'transactionId', $order_id );
		wp_localize_script( 'thankyou', 'value', $order->get_total() );

		if ( ! $order->has_status( 'failed' ) ) {
      wp_safe_redirect( $url );
			exit;
    }
}

add_filter( 'woocommerce_add_to_cart_redirect', 'skip_cart' );

function skip_cart() {
   return wc_get_checkout_url();
}

function has_active_subscription( $user_id = null ) {
    if( null == $user_id && is_user_logged_in() )
        $user_id = get_current_user_id();
    if( $user_id == 0 )
        return false;

    $active_subscriptions = get_posts( array(
        'numberposts' => 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'post_type'   => 'shop_subscription',
        'post_status' => 'wc-active',
        'fields'      => 'ids',
    ) );

    return sizeof($active_subscriptions) == 0 ? false : true;
}

function has_available_credits( $credits, $user_id = null ) {
	if( null == $user_id && is_user_logged_in() )
			$user_id = get_current_user_id();

	if( $user_id == 0 )
			return false;

	$user_data = get_userdata( $user_id );
	$registered_at = $user_data->user_registered;
	$diff = abs( strtotime( $registered_at ) - strtotime() );
	$years = floor( $diff / ( 365*60*60*24 ) );
	$months = floor( ( $diff - $years * 365*60*60*24 ) / ( 30*60*60*24 ) );
	$days = floor( ( $diff - $years * 365*60*60*24 - $months*30*60*60*24 ) / ( 60*60*24 ) );

	$usage = get_user_meta( $user_id, 'usage', true ) ? get_user_meta( $user_id, 'usage', true ) : 0;

	$has_availabe_credits = ( $usage / $months ) < $credits ? true : false;

	// return $has_availabe_credits;
	return true;
}

function update_usage( $amount, $user_id = null ) {
	if( null == $user_id && is_user_logged_in() )
			$user_id = get_current_user_id();

	if( $user_id == 0 )
			return false;

	$current_usage = intval( get_user_meta( $user_id, 'usage', true ) );
	$new_usage = $current_usage + $amount;

	return update_user_meta( $user_id, 'usage', $new_usage );
}


add_action( 'template_redirect', 'validate_user_credits' );
function validate_user_credits() {
	$current_fp = get_query_var('fpage');

	if ( $current_fp == 'portfolio' ) {
		if ( !has_active_subscription() && !has_available_credits(5) ) {
			$url = home_url( 'shop' );

			wp_redirect( $url );
			exit;
		} else if ( !has_active_subscription() && has_available_credits(5) ) {
			update_usage(1);
		}
	}
}

function reset_usage( $user_id, $subscription_key ) {
	update_user_meta( $user_id, 'usage', 0 );
	exit();
}
add_action( 'cancelled_subscription', 'reset_usage', 10, 2 );
//
// add_action( 'notify_on_empty_portfolio_', 'notify_on_empty_portfolio' );
//
// function notify_on_empty_portfolio() {
// 	// Has no assets
// 	$has_no_assets = array(
// 		'post_status' => 'publish',
// 		'post_type' => 'portfolio',
// 		'numberposts' => -1,
// 		'meta_query'	=> array(
// 			'relation'		=> 'AND',
// 			array(
// 				'key'	 	=> 'assets_$_symbol',
// 				'compare' 	=> 'NOT EXISTS',
// 			),
// 		),
// 	);
// 	$has_no_assets_found = get_posts( $has_no_assets );
//
// 	foreach ( $has_no_assets_found as $key => $post ) {
// 		$author = $post->post_author;
// 		$email = get_the_author_meta( 'user_email', $author );
// 		$permalink = get_post_permalink( $post->ID );
// 		$empty_assets_notification_sent = get_field('empty_assets_notification_sent', $post->ID );
//
// 		if ( !$empty_assets_notification_sent ) {
// 			do_action( 'send_no_assets_notification', $email, $permalink );
// 			update_field( 'empty_assets_notification_sent', true, $post->ID );
// 		}
// 	}
//
// 	// Has investments
// 	$has_no_investment = array(
// 		'post_status' => 'publish',
// 		'post_type' => 'portfolio',
// 		'numberposts' => -1,
// 		'meta_query'	=> array(
// 			'relation'		=> 'AND',
// 			array(
// 				'key' => 'initial_investment',
// 				'compare' => 'NOT EXISTS',
// 			),
// 		),
// 	);
//
// 	$has_no_investment_found = get_posts( $has_no_investment );
//
// 	foreach ( $has_no_investment_found as $key => $post ) {
// 		$author = $post->post_author;
// 		$email = get_the_author_meta( 'user_email', $author );
// 		$permalink = get_post_permalink( $post->ID );
// 		$no_investment_notification_sent = get_field('no_investment_notification_sent', $post->ID );
// 		$empty_assets_notification_sent = get_field('empty_assets_notification_sent', $post->ID );
//
// 		if ( !$no_investment_notification_sent && !$empty_assets_notification_sent ) {
// 			do_action( 'send_no_investment_notification', $email, $permalink );
// 			update_field( 'no_investment_notification_sent', true, $post->ID );
// 		}
// 	}
//
// 	// Has not optimized
// 	$has_not_optimized = array(
// 		'post_status' => 'publish',
// 		'post_type' => 'portfolio',
// 		'numberposts' => -1,
// 		'meta_query'	=> array(
// 			'relation'		=> 'AND',
// 			array(
// 				'key' => 'current_portfolio_expected_results',
// 				'compare' => 'NOT EXISTS',
// 			),
// 		),
// 	);
//
// 	$has_not_optimized_found = get_posts( $has_not_optimized );
//
// 	foreach ( $has_not_optimized_found as $key => $post ) {
// 		$author = $post->post_author;
// 		$email = get_the_author_meta( 'user_email', $author );
// 		$permalink = get_post_permalink( $post->ID );
// 		$no_investment_notification_sent = get_field('no_investment_notification_sent', $post->ID );
// 		$empty_assets_notification_sent = get_field('empty_assets_notification_sent', $post->ID );
// 		$optimization_notification_sent = get_field( 'optimization_notification_sent', $post->ID );
//
// 		if ( !$no_investment_notification_sent && !$empty_assets_notification_sent && !$optimization_notification_sent ) {
// 			do_action( 'send_optimization_notification', $email, $permalink );
// 			update_field( 'optimization_notification_sent', true, $post->ID );
// 		}
// 	}
//
// }
//
// class NotifyEmptyPortfolio extends \BracketSpace\Notification\Abstracts\Trigger {
//
//     public function __construct() {
//
//         // Add slug and the title.
//         parent::__construct(
//             'notifyemptyportfolio',
//             __( 'Notification sent', 'notifyemptyportfolio' )
//         );
//
//         // Hook to the action.
//         $this->add_action( 'send_no_assets_notification', 10, 2 );
//
//     }
//
// 		public function merge_tags() {
//
// 		    $this->add_merge_tag( new \BracketSpace\Notification\Defaults\MergeTag\UrlTag( array(
// 		        'slug'        => 'permalink',
// 		        'name'        => __( 'Post URL', 'notifyemptyportfolio' ),
// 		        'resolver'    => function( $trigger ) {
// 		            return get_permalink( $trigger->post->ID );
// 		        },
// 		    ) ) );
//
// 		    $this->add_merge_tag( new \BracketSpace\Notification\Defaults\MergeTag\StringTag( array(
// 		        'slug'        => 'post_title',
// 		        'name'        => __( 'Post title', 'reportabug' ),
// 		        'resolver'    => function( $trigger ) {
// 		            return $trigger->post->post_title;
// 		        },
// 		    ) ) );
//
// 		    $this->add_merge_tag( new \BracketSpace\Notification\Defaults\MergeTag\HtmlTag( array(
// 		        'slug'        => 'message',
// 		        'name'        => __( 'Message', 'reportabug' ),
// 		        'resolver'    => function( $trigger ) {
// 		            return nl2br( $trigger->message );
// 		        },
// 		    ) ) );
//
// 		    $this->add_merge_tag( new \BracketSpace\Notification\Defaults\MergeTag\EmailTag( array(
// 		        'slug'        => 'post_author_email',
// 		        'name'        => __( 'Post author email', 'reportabug' ),
// 		        'resolver'    => function( $trigger ) {
// 		            $author = get_userdata( $trigger->post->post_author );
// 		            return $author->user_email;
// 		        },
// 		    ) ) );
//
// 		}
//
// }

// Disable emojijs
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
