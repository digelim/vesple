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

// add new category to the guttenberg blocks
function project_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
								'icon'  => 'art',
                'slug' => 'headers',
                'title' => __( 'Headers', 'headers' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'content',
                'title' => __( 'Content', 'content' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'social-proof',
                'title' => __( 'Social proof', 'social-proof' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'call-to-action',
                'title' => __( 'Call to action', 'call-to-action' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'gallery',
                'title' => __( 'Gallery', 'gallery' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'contact',
                'title' => __( 'Contact', 'contact' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'pricing',
                'title' => __( 'Pricing', 'pricing' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'project',
                'title' => __( 'Portfolio', 'portfolio' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'blog',
                'title' => __( 'Blog', 'blog' )
            ),
            array(
								'icon'  => 'art',
                'slug' => 'forms',
                'title' => __( 'Forms', 'forms' )
            ),
        )
    );
}

add_filter( 'block_categories', 'project_block_categories', 10, 2 );

function register_acf_block_types() {
    acf_register_block_type(array(
        'name'              => 'content_1',
        'title'             => __('Content 1'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_1.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="137px" viewBox="0 0 270 137" enable-background="new 0 0 270 137" xml:space="preserve">  <image id="image0" width="270" height="137" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_2',
        'title'             => __('Content 2'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_2.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="81px" viewBox="0 0 270 81" enable-background="new 0 0 270 81" xml:space="preserve">  <image id="image0" width="270" height="81" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_3',
        'title'             => __('Content 3'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_3.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="178px" viewBox="0 0 270 178" enable-background="new 0 0 270 178" xml:space="preserve">  <image id="image0" width="270" height="178" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_4',
        'title'             => __('Content 4'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_4.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="161px" viewBox="0 0 270 161" enable-background="new 0 0 270 161" xml:space="preserve">  <image id="image0" width="270" height="161" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_5',
        'title'             => __('Content 5'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_5.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="113px" viewBox="0 0 270 113" enable-background="new 0 0 270 113" xml:space="preserve">  <image id="image0" width="270" height="113" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_6',
        'title'             => __('Content 6'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_6.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="152px" viewBox="0 0 270 152" enable-background="new 0 0 270 152" xml:space="preserve">  <image id="image0" width="270" height="152" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_7',
        'title'             => __('Content 7'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_7.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="141px" viewBox="0 0 270 141" enable-background="new 0 0 270 141" xml:space="preserve">  <image id="image0" width="270" height="141" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_8',
        'title'             => __('Content 8'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_8.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="152px" viewBox="0 0 270 152" enable-background="new 0 0 270 152" xml:space="preserve">  <image id="image0" width="270" height="152" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_9',
        'title'             => __('Content 9'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_9.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="142px" viewBox="0 0 270 142" enable-background="new 0 0 270 142" xml:space="preserve">  <image id="image0" width="270" height="142" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_10',
        'title'             => __('Content 10'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_10.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="140px" viewBox="0 0 270 140" enable-background="new 0 0 270 140" xml:space="preserve">  <image id="image0" width="270" height="140" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_11',
        'title'             => __('Content 11'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_11.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="93px" viewBox="0 0 270 93" enable-background="new 0 0 270 93" xml:space="preserve">  <image id="image0" width="270" height="93" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_12',
        'title'             => __('Content 12'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_12.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="138px" viewBox="0 0 270 138" enable-background="new 0 0 270 138" xml:space="preserve">  <image id="image0" width="270" height="138" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_13',
        'title'             => __('Content 13'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_13.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="86px" viewBox="0 0 270 86" enable-background="new 0 0 270 86" xml:space="preserve">  <image id="image0" width="270" height="86" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_14',
        'title'             => __('Content 14'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_14.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="131px" viewBox="0 0 270 131" enable-background="new 0 0 270 131" xml:space="preserve">  <image id="image0" width="270" height="131" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_15',
        'title'             => __('Content 15'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_15.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="131px" viewBox="0 0 270 131" enable-background="new 0 0 270 131" xml:space="preserve">  <image id="image0" width="270" height="131" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_16',
        'title'             => __('Content 16'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_16.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="174px" viewBox="0 0 270 174" enable-background="new 0 0 270 174" xml:space="preserve">  <image id="image0" width="270" height="174" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
        'name'              => 'content_17',
        'title'             => __('Content 17'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_17.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="66px" viewBox="0 0 270 66" enable-background="new 0 0 270 66" xml:space="preserve">  <image id="image0" width="270" height="66" x="0" y="0"    xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQ4AAABCCAQAAAAMVfCNAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfkAR4OLRzyEtGCAAAERklEQVR42u3cW4hUdRzA8Y/ubNOGJRnd6OJ6Ww0L2TAFN7pTVhpF+BBd6CG0O0F0sR4sIoJ6KIKICiyKIrKC1Cwig5JE7SltkbJtNy/barY1uu3M7O64PSS2G/03Z8w8D7/P038Hzo//nvPl7JmB2VGDg0L4R6OP9AZCdkUcISniCEkRR0iKOEJSxBGSIo6QFHGEpIgjJEUcISniCEkRR0iKOEJSxBGSIo6QFHGEpIgjJEUcISniCEkRR0iKOEJSxBGSIo6QFHGEpNyR3sBfOn3rYnR5H5xoAVZod43GGmcWrPC7KzSi07smuFLub+tDs1Gd6QrePPDKHUbVMOclFbAwQ5ckI3eOVjeY5S3wtRe1a/cTXrLEbvOtAEWbq5pado0P7XCRbYrm2WSZuQxbwzY/17TrFS50lfWoKCgoWOe1mtLo8YTvtGvfn0g2ZCTTsps02g26nO2Z/a8vs8giY602Hz+4QkcVW/5eg6UabLDK6Xq9rGKyDq1D1o1YYpoHa9r305aAcRaDG9xa05xOOc8d/tNcpYzcOc51tYb9653azPWADmzXhCZrDeiyC7t0HfTU6T7W4GcdztVpslFyxls/bF3QpahHl2LVu55v9rCfW33lxpp+/51yrneLtf/L2T5YGYljqMvc61m/eBIDoE7RdjPdjFnOr2pa2e2uc55+daBeadh6sZnWWGqmVw955y9YYGxNR07ykKfMsEiWvteewTia3eQsN1uDybrRrUmjNsuxRWsVswbd7SiPYdL+P1rdpgxbP6/NJe7S5o5D3Pc2qyyq8dhT3abJnX616XCe2iplMI5H3GfAOs2YY7Wiz81GXh718lXN+slSebTYodVG3ZqHrXPycurka3qQHOoVF9T8rmqlixStM8bUw3+CD1pGHkiHusf9zjbdo7jF085xmkfBRO9UteHN3sAUTPOpxy20050aGLbm4QPPO7UreMvrNR89z2qzjPN4VekfbqOy+c9bykNOUvE/uHR/GlQ5ENfQdTYMZGw/mY0jZEEGnzlCVkQcISniCEkRR0iKOEJS1t49We83U20y0Y8utdwMBc3edq0xVUwpWqneSer1+0WLL8zDe+ZYp9kuR2vTYoeZPjLeLjm9Jtghb84IUwd84EzH26Nin9EabTDLZxqdYI+K83ylySdmOM4aLb50+Ygfpw/6yHjbTfKNFh32adCj3jEKI+7j/5K5O0evCfr0KuvTb58zdNitu8opDcp6lJWUFdAJSor2ytviLHtVdNitT1nRJD1Kisr/MndAtzZbneJkJf36lRxrizZb9fhOyVinGG2fvfr02jPitIo+ZYxTZ4ySCspK8n440pcB8TlHGEHm7hwhOyKOkBRxhKSIIyRFHCEp4ghJEUdIijhCUsQRkiKOkBRxhKSIIyRFHCEp4ghJEUdIijhCUsQRkiKOkBRxhKSIIyRFHCEp4ghJOb8e6S2ErPoDqfspebwKZLsAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjAtMDEtMzBUMTQ6NDU6MjgrMDM6MDDg3Wj8AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIwLTAxLTMwVDE0OjQ1OjI4KzAzOjAwkYDQQAAAAABJRU5ErkJggg==" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
				'name'              => 'content_18',
				'title'             => __('Content 18'),
				'description'       => __('A custom content block.'),
				'render_template'   => 'template-parts/blocks/content/content_18.php',
				'category'          => 'content',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="103px" viewBox="0 0 270 103" enable-background="new 0 0 270 103" xml:space="preserve">  <image id="image0" width="270" height="103" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'content', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'content_19',
				'title'             => __('Content 19'),
				'description'       => __('A custom content block.'),
				'render_template'   => 'template-parts/blocks/content/content_19.php',
				'category'          => 'content',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="172px" viewBox="0 0 270 172" enable-background="new 0 0 270 172" xml:space="preserve">  <image id="image0" width="270" height="172" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'content', 'builder' ),
		));

		acf_register_block_type(array(
        'name'              => 'content_20',
        'title'             => __('Content 20'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_20.php',
        'category'          => 'content',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="86px" viewBox="0 0 270 86" enable-background="new 0 0 270 86" xml:space="preserve">  <image id="image0" width="270" height="86" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
				'name'              => 'content_21',
				'title'             => __('Content 21'),
				'description'       => __('A custom content block.'),
				'render_template'   => 'template-parts/blocks/content/content_21.php',
				'category'          => 'content',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="118px" viewBox="0 0 270 118" enable-background="new 0 0 270 118" xml:space="preserve">  <image id="image0" width="270" height="118" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'content', 'builder' ),
		));

		acf_register_block_type(array(
        'name'              => 'content_24',
        'title'             => __('Content 24'),
        'description'       => __('A custom content block.'),
        'render_template'   => 'template-parts/blocks/content/content_24.php',
        'category'          => 'content',
        'icon'              => '',
        'keywords'          => array( 'content', 'builder' ),
    ));

		acf_register_block_type(array(
				'name'              => 'content_25',
				'title'             => __('Content 25'),
				'description'       => __('A custom content block.'),
				'render_template'   => 'template-parts/blocks/content/content_25.php',
				'category'          => 'content',
				'icon'              => '',
				'keywords'          => array( 'content', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_1',
				'title'             => __('Header 1'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_1.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="169px" viewBox="0 0 270 169" enable-background="new 0 0 270 169" xml:space="preserve">  <image id="image0" width="270" height="169" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_2',
				'title'             => __('Header 2'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_2.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="142px" viewBox="0 0 270 142" enable-background="new 0 0 270 142" xml:space="preserve">  <image id="image0" width="270" height="142" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_3',
				'title'             => __('Header 3'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_3.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="161px" viewBox="0 0 270 161" enable-background="new 0 0 270 161" xml:space="preserve">  <image id="image0" width="270" height="161" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_4',
				'title'             => __('Header 4'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_4.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="169px" viewBox="0 0 270 169" enable-background="new 0 0 270 169" xml:space="preserve">  <image id="image0" width="270" height="169" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_5',
				'title'             => __('Header 5'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_5.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="128px" viewBox="0 0 270 128" enable-background="new 0 0 270 128" xml:space="preserve">  <image id="image0" width="270" height="128" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_6',
				'title'             => __('Header 6'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_6.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="157px" viewBox="0 0 270 157" enable-background="new 0 0 270 157" xml:space="preserve">  <image id="image0" width="270" height="157" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_8',
				'title'             => __('Header 8'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_8.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="113px" viewBox="0 0 270 113" enable-background="new 0 0 270 113" xml:space="preserve">  <image id="image0" width="270" height="113" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_10',
				'title'             => __('Header 10'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_10.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="169px" viewBox="0 0 270 169" enable-background="new 0 0 270 169" xml:space="preserve">  <image id="image0" width="270" height="169" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'header_12',
				'title'             => __('Header 12'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/header_12.php',
				'category'          => 'headers',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="143px" viewBox="0 0 270 143" enable-background="new 0 0 270 143" xml:space="preserve">  <image id="image0" width="270" height="143" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
        'name'              => 'pricing_1',
        'title'             => __('Pricing 1'),
        'description'       => __('A custom pricing block.'),
        'render_template'   => 'template-parts/blocks/pricing/pricing_1.php',
        'category'          => 'pricing',
        'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="175px" viewBox="0 0 270 175" enable-background="new 0 0 270 175" xml:space="preserve">  <image id="image0" width="270" height="175" x="0" y="0"    xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQ4AAACvCAMAAAA7WMBoAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAACalBMVEX////39/fp6ens7Ozn5+f5+fnx8fLw8PC+vr/CwsKqqqrh4eGdnZ08PDxfX19NTU3Q0NCZmZnX19e5uru4uLjLy8s2NjbV1dUsLCz9/v57e3v19fby8vN+fn54eHj4+PiEhISzs7Nvb2+wsbKRkpKam5vW1taGhoeBgYHr6+usra68vb1ycnKOjo7Gxsb8/PxKSkrExcbu7u7v7+/Nzc2mpqZpaWp1dXWJiYnb29slJSWoqKja2tqioqKrq6vk5ORXV1eVlZVFRUVaWlrOzs6Li4ykpKRCQkLe3t4pKSnU1NRlZWZRUVHf399VVVXZ2dm0tbUxMTFiYmLIyMj6+/q1trfR0dHl5eXT09O7u7vExMQdHR3c3NzKysrBwcH09PXi4uLAwMDt7vHu8PPr7fDz9fjt7/LLzfmjo/60tfqrq/3j5PjS0/nHyfnDw/7n6P3S0v+/v/75+f+mp/6ysv/c3P/q6v+env+YmP+4uP+PkPuUlP/IyP/Y2fvO0Png4P/Ky87j5eje4OIbGxvn6ewhISHh4+bV19nIys3d3uHy9Pfl5+rLzM/j4+N2d3nP0NPT1dfMzdDZ293R09bP0dTFx8m+v8LCxMbX2dvk5unp6+7b3d/v8fXOz9LNz9Hh4uXi8OuN57mg6cTY9+eo38OG4rXj6uex78/R49zZ6+Lr9POY17ew6Mrt+fO/69XE89vN89+42snm9u7I4tX2/PqD2q1ZWf9ERP9wcP/u7v92dv+Dg/9jY/9QUP97e/9aWv9VVf9dXf96ev9ra/9zc/9mZv9+fv93d/9HR/9gYP+Rkf+Kiv+Njf/09P8Ei6s+AAAAAWJLR0QAiAUdSAAAAAd0SU1FB+QBHg4tJNoQaRwAAA5XSURBVHja7d2NX9pmAgfwh0CNVECNRKRQ37UiFl+wVqyKL7RFLIUKBlRa0Zqts9uu3rrret3uVFSwykkRRHStW/d2u5fd7W43e7V2dW3Vdbv/6RLaXnWNCN4N2Oee3+dDnpAnDzHfJk9IIBQAGBgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYmPiEhbBDJWcfPUxCt9Ylc8O33b/1SUq81+R/Eh5fkJpGlekY/SxDuKUKzxSFb5sl3vLkgGSn2aQHmadn58R75Rk4ckFefkFhEa8YOVQiyxCWFuUnA3nZYQUor+BXivILpVQlAFXZh9iHEKyILqkJJZw0HsVRmKusPgJKUG5NOjgoyeYdZZfXZqvEh/Or6Qf98lXZZarcumMA1NccVFYXZjckN4KjEkBX7687RNeKGw7kqrH89MSw4QkamxpqBSk13KOlpbzm5kNlaS2SzPpWag0aSsSZmtpCqhKAmsb9tcdP1B6hS2pCbsNBak/J4tYW5mWDk5wWbbOMr2xTHGhIL9G1VgtSiugH/fIKubCdwy8HoFRU25x3Sp9Z3FKfCgBdXZ6ppGurTxv4opOig8Z4SzzlaGrAQG0DqOGepDoRiuPEvjNpAlBCcRzJZWWC6laqEoCW1o5clSAVpUtqgq71pJTeWRTtIQ5TU0cSxQF4x8tSO9rB4Yqi0IMK3p5/is2nRvbXtJaE5q3IprarUHWmhK5tOA5Op9V1dJyIt8RTjlxqEOIoKWxufsphzuysCHGApsaywhBHbUlBHkjtCJX0hJMd1MQsXn4RkdnYZmklTlmfcnQK5EVdJd0V9IMlB+BQbXOqJFMPQGtj2YEQR1EPAgBdDU4q6Nr6FuOZ4tYTvDSbJt4WVDT00aObAMaUnMb0HPwslxCnA6xZkAGAlQukvBNiqhIAc14hAs5pQiU9ITuPppQfM4PGY7xeolYIeKxmoFGA7uOY+Eihln7o26m+o7mrCJR2AqAtFObVy0FDr6iJaklXAwUvVMvl8S1JDUU5IkW8LXZKk6DJHHaGExX7dn8VE84w0d7St30C2iI4Gu/13S3oLvUyc0Qvw5B97B9PEUvjvbYwMDAwMDAwMDAwcY04HvkvlvqTYuT0n99rBlj79hx0zy3NST8lRy+557wSwTnsTtntjDBMWJADckAOyAE5IAfk2OXd0s+N49ULrw2+evH119544+Kr0XO8+YtLQ5cu/XJPHG9dfvPS279KMI6Lbw1dHrzyzptXf33htb1wDA0NXRvaG8fVd6++NZhgHO8N/mZo8LWhi28MvvF69BzvXaa2j8u/3RPHu+BXbw+9m2AcsCuFHJADckAOyAE5flKOQ/v3xnG8YM8cRE3CcgxXtI9QRenRQ6NRcegqapRUYRYepv5uJe+AkHGxjBxVBzOt9CvU5tqoIu9AOuOax4XD6Gg/2TZGNve0Z57pj4JD3lPTkiUFnIqe0yyQU5FZ01MaKUdOVkV7jxEQdU0VbVXg8Hh+VkfCcNRUkBOOUpKfTzqpInKOmlTAduSBGj5CPeE6MJAtiJRD6LCA0+3gKB+IsxpB1nHQPd6bKBwH21zk5Nj1niKSrDseBUduGwE4UqXjcGGjGTT2SEBpHdNsTByEo1mcJAMCyq+jprenEeT0dCYKx9QpR6uLHHMcIckzJVFwJJ12CAigcWRmZ50C7J4iVr5DGSEHKOzh09/lbTNYMpvA6Vap0dGQKBwkKa8Ynx5wNFAcuVEdWbpTx0Vyh5Xa9jmgMOtMah3TTMxHFnd2z2GgbB+vOFMGFC3jrY7kBOG4/js5OTBeS7aVUFtIUeQc4gPdgFV3WNnDBcUOgvrbWadaI+U41kx1PSepEaWlh/7GsZI3LksQDrK1YqbUkUG284ePOzxRbB2CVIPRcQ40CVT5fAD2dZX1VEfMMZ6M8Y8CgDSk8s0AWGvP5DI1jQvHjVZH24HrpLfFMd5MRsFRLHC0lYgBwXdkyQHQtJ1m/iI1E4ekpM4h0AJQkllGdzf8Fh5j0zj1HYKup33qdTIaDgDauTuucHgOAApC3zZ+dtV5p4vPceKYnSLDZwcOWyTfGWbmqNJH0BSewkEOyAE5IMfPjmPUN0P6/L656zdmAk4yMB8YDjipkcg4uCpcj+uAzoIbNDqdsguxGSLlwBQcBUduLld0S+RS3EBoDIxNY81RcCyjv7NwtnC4IGh0kaWTpQWl86XzEXLs1xrtRiHobuiTy8+lS7nmI/JIOZLxenl9+j5zc3N9ty49w643HksEjpGREWdwYmBhJEguLpBBMjjhXfQuRsiBAosFrQJoEipFULQcFScx7hco4zQWxqrKEXNkQC9Gq3JYKGNT2HdADsiRWBz9wVCxQL6/baUXfoSwwMjBLn82ItnyOwSSl0Z24CivYphJApibx4jDNTM97PdUZkz6532Li/7Zm/23fJ45pyvgWXR65gJBTyBwMzB8M8DIYbTbDBarxmLDDWkGm5UgUjic+mS2hqVR2xR6QqVJwTBd1U4cdo0BUxpwrB6zYml2LV6vwThpeBWOI3YbZlVh8eDwLLoCM95b/vmAc/iW3zPTOTA/50me9Xk8nll/8uxYpafU4wn4hhk57BbMgvSluE0mt5swJLt1tmKLQp9SLSUwvUKlcruthBvfcl18OwfCwjRit9GmU+jcblWK0eZOK3Zr3UbMklJs0GHbfwgkln3HWGi4+P7YtqkTP95jfqK+wxLJvcmwK40Lx8ioMzg74JkfnZxdovaJUe/Skmt+2tcvd3qWpqZ9E7PzS/PeCWYOGcem52iReq0MRfRJuIyTorXUq1G3oarqrEylQ90pMtuOHHYEV1fq7Ho7G1GhHLXFbk9ClHoZgbhRG2JXI2e3bTSx4qicnpsrIJM7ff4C/5xrwb//1jTVvWaMzEzvl3tmhl1yecZcxhgzh1WjMIkKCINJZ5NzCdxKiApEmFBjFBmquNYTGlOXlTBuPUBs4+juwquFIq7J0NVn0JyrlJsIvcbExQlCkazoM2n6sG3X12LFsfR8OLDwn14k0p2F/gSAvf1p2ES6s8jYL10yhX0H5IAcicNxPcps5djTjY7oXpqKY8XxSpS5/oLDnBNdzFs4omyaI44RB9xZIAfkiJzj+n/BEf2N4Ojem8aE44MPSXJqmhybGF0KTkTJcTsJAFwmkaj3IRYksh9OfM7x0cfU6b2tGpFIkBw1G4nkhvIYcIzd/oTeOobJQKdLmBEdx+3bH1FDkZqw9p3TaNIi+RD+Ocenn92mC2sxRhBp3X04hkXQNBZbx+9D+0qQ9Hm9k0vvR8XB+oAeas2IWtXLQdW9ES322dbxeWiYlGKWqtTSFBRhR9AUdqWQA3JAjoTl+MMfQwdaz8Lo4mj//Fhwcja4uLDonZya8t4a2IXjT1IAbCo1hug5iBVNsmBspcXCliIIoUR24fjzx3RTpQRXqyWYWi2tZqmlbA5ikXDS1PHjGPvikz+QoQPtEb/fL5+W36osGPG7Aq7GZJdrLvzW8afP/kINrVZcqKvEu3QKHaHTWHGrnKuxduuJsByf/vVDMd2UwJK5ZzGFoo/Q6DUKgiCE52S6vh22oFhsHV+ep4dB0jg1GfRO+YJBr/e8fCrocU1MeIILYTn+9nt6aJeibhRVqtnsKn0SjqB6g5JDxRKWA3xJvylF1SjKkVGNkRS22q5DWXqVW6pGVOXMTWHfATkgB+RIbI4XNwGGes/5/on+l7/R8DLH36nzFPt/ztRDnxFZLGL98/FwHF99CUD5i0NqaP5illYcpmnMOKaSPaM3fH7XYuX54Ruj87f8YzdcNwPc2fnhypnKHTm++Mtn1JBbXKkxNJ7FuQg3zQo6z+nYfY06rkJnVGRwGd58PDvQ/u3Dr6iT4UqrvfJsBhfHc7oVdsyUrOwTph3jijCuEGe4zzJmHKMTs0vOxYlFr49cdI7MOz0Do6NTt2a9M6PeEd+OHJ9T/8DArNISWptOrVOpbXoDMFXbc/QqTKQy4RyLiuEN1bMr6X+kNIDNoFcTWouK0AEVgWAiQmKvt3BVmM5eL2P4YXXYd0AOyAE5EppjbLJ/5Pl10qUXd5ov7MbxuQQATKJ/fn7Su+VEZafD5XMO8d8B0GsBdaTOqdpaH+aOqZhxnJ/3ePzBG3P+maVK15jH5fTdvOG8EfCHvwf/rx/R13/1xXLcxmk8K7d1duuShBgmzzARVvlO/6XIUw7ZVx/+GVCHobMahckk12BaHOvj4ibcIA/zX5HEjGPJOeEdXRr1Tk5O+jwDSx7XjNO15PRNhL/e8cXH9FCh1tjtvSq73U4dZCW4QSfsE9kNdlVYDvM/KA1gB3Y7UWyx4UpER/QpcFG9fsd2seR4KQPkQJja8H2HNOwdgkx9R+hDFkn5bncWwq4UckAOyAE5IAfk+HlzvPd6dHn/Bccv344uv9jCEWXTt2P1Vbmvl6PL6y84LkXZ9M4WjiibLv8TckCOhOK4+/XKvXur979ZebD27YOHa4+W1759+Pjhnbv3dudYe/zo/oPVu9+s31leebCxub66vPLd/Qcr99Z359ikF0gt9vHK5tq39757+Hj54cO739y9t/IgzhxXHj7ZfHfj6tqT5SePrl17MkgVVy5ceTz4ze4c69+v3b32w+C1ldXNyxsb319d37x89+r6O08e7c7x4MLqk++GHj5f7JULy9Qirw2uXV6NL8fmtccbj9dX1r/eWN5YfvT9xsYmNXJ/5c6TCLaO+ysPHn+/snH/zurmo9Vra+t3Nh99t37nh/X7EXC8s7qxsXLn6WLX1zfuL9OLfXLvnXhvHZHk/6jvgByQYzvHxSiz5QYO8T+jy7+2cETZNKQBz1m2B3JADsgBORKOQwI5tkaMSveaJKlkz0H33jSy+4dgYGBgYGBgYGBgYGBgYGBgYGBgYGBgYCLIvwH8jW/ukTdZOwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wMS0zMFQxNDo0NTozNiswMzowMHxIEz8AAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDEtMzBUMTQ6NDU6MzYrMDM6MDANFauDAAAAAElFTkSuQmCC" /></svg>',
        'keywords'          => array( 'pricing', 'builder' ),
    ));

		acf_register_block_type(array(
				'name'              => 'pricing_2',
				'title'             => __('Pricing 2'),
				'description'       => __('A custom pricing block.'),
				'render_template'   => 'template-parts/blocks/pricing/pricing_2.php',
				'category'          => 'pricing',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="145px" viewBox="0 0 270 145" enable-background="new 0 0 270 145" xml:space="preserve">  <image id="image0" width="270" height="145" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'pricing', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'pricing_3',
				'title'             => __('Pricing 3'),
				'description'       => __('A custom pricing block.'),
				'render_template'   => 'template-parts/blocks/pricing/pricing_3.php',
				'category'          => 'pricing',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="324px" viewBox="0 0 270 324" enable-background="new 0 0 270 324" xml:space="preserve">  <image id="image0" width="270" height="324" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'pricing', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'pricing_4',
				'title'             => __('Pricing 4'),
				'description'       => __('A custom pricing block.'),
				'render_template'   => 'template-parts/blocks/pricing/pricing_4.php',
				'category'          => 'pricing',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="161px" viewBox="0 0 270 161" enable-background="new 0 0 270 161" xml:space="preserve">  <image id="image0" width="270" height="161" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'pricing', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'portfolio_1',
				'title'             => __('Portfolio 1'),
				'description'       => __('A custom portfolio block.'),
				'render_template'   => 'template-parts/blocks/portfolio/portfolio_1.php',
				'category'          => 'portfolio',
				'icon'              => '',
				'keywords'          => array( 'portfolio', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'portfolio_2',
				'title'             => __('Portfolio 2'),
				'description'       => __('A custom portfolio block.'),
				'render_template'   => 'template-parts/blocks/portfolio/portfolio_2.php',
				'category'          => 'portfolio',
				'icon'              => '',
				'keywords'          => array( 'portfolio', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'gallery_1',
				'title'             => __('Gallery 1'),
				'description'       => __('A custom gallery block.'),
				'render_template'   => 'template-parts/blocks/gallery/gallery_1.php',
				'category'          => 'gallery',
				'icon'              => '',
				'keywords'          => array( 'gallery', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'gallery_2',
				'title'             => __('Gallery 2'),
				'description'       => __('A custom gallery block.'),
				'render_template'   => 'template-parts/blocks/gallery/gallery_2.php',
				'category'          => 'gallery',
				'icon'              => '',
				'keywords'          => array( 'gallery', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'form_1',
				'title'             => __('Form 1'),
				'description'       => __('A custom form block.'),
				'render_template'   => 'template-parts/blocks/forms/form_1.php',
				'category'          => 'forms',
				'icon'              => '',
				'keywords'          => array( 'form', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'form_2',
				'title'             => __('Form 2'),
				'description'       => __('A custom form block.'),
				'render_template'   => 'template-parts/blocks/forms/form_2.php',
				'category'          => 'forms',
				'icon'              => '',
				'keywords'          => array( 'form', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'form_3',
				'title'             => __('Form 3'),
				'description'       => __('A custom form block.'),
				'render_template'   => 'template-parts/blocks/forms/form_3.php',
				'category'          => 'forms',
				'icon'              => '',
				'keywords'          => array( 'form', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'form_4',
				'title'             => __('Form 4'),
				'description'       => __('A custom form block.'),
				'render_template'   => 'template-parts/blocks/forms/form_4.php',
				'category'          => 'forms',
				'icon'              => '',
				'keywords'          => array( 'form', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'form_5',
				'title'             => __('Form 5'),
				'description'       => __('A custom form block.'),
				'render_template'   => 'template-parts/blocks/forms/form_5.php',
				'category'          => 'forms',
				'icon'              => '',
				'keywords'          => array( 'form', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'contact_1',
				'title'             => __('Contact 1'),
				'description'       => __('A custom contact block.'),
				'render_template'   => 'template-parts/blocks/forms/contact_1.php',
				'category'          => 'contact',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="169px" viewBox="0 0 270 169" enable-background="new 0 0 270 169" xml:space="preserve">  <image id="image0" width="270" height="169" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'contact', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'contact_2',
				'title'             => __('Contact 2'),
				'description'       => __('A custom contact block.'),
				'render_template'   => 'template-parts/blocks/forms/contact_2.php',
				'category'          => 'contact',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="163px" viewBox="0 0 270 163" enable-background="new 0 0 270 163" xml:space="preserve">  <image id="image0" width="270" height="163" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'contact', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'contact_4',
				'title'             => __('Contact 4'),
				'description'       => __('A custom contact block.'),
				'render_template'   => 'template-parts/blocks/forms/contact_4.php',
				'category'          => 'contact',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="157px" viewBox="0 0 270 157" enable-background="new 0 0 270 157" xml:space="preserve">  <image id="image0" width="270" height="157" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'contact', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'contact_5',
				'title'             => __('Contact 5'),
				'description'       => __('A custom contact block.'),
				'render_template'   => 'template-parts/blocks/forms/contact_5.php',
				'category'          => 'contact',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="239px" viewBox="0 0 270 239" enable-background="new 0 0 270 239" xml:space="preserve">  <image id="image0" width="270" height="239" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'contact', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'blog_1',
				'title'             => __('Blog 1'),
				'description'       => __('A custom blog block.'),
				'render_template'   => 'template-parts/blocks/blog/blog_1.php',
				'category'          => 'blog',
				'icon'              => '',
				'keywords'          => array( 'blog', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'blog_2',
				'title'             => __('Blog 2'),
				'description'       => __('A custom blog block.'),
				'render_template'   => 'template-parts/blocks/blog/blog_2.php',
				'category'          => 'blog',
				'icon'              => '',
				'keywords'          => array( 'blog', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'team_1',
				'title'             => __('Team 1'),
				'description'       => __('A custom team block.'),
				'render_template'   => 'template-parts/blocks/teams/team_1.php',
				'category'          => 'team',
				'icon'              => '',
				'keywords'          => array( 'team', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'team_2',
				'title'             => __('Team 2'),
				'description'       => __('A custom team block.'),
				'render_template'   => 'template-parts/blocks/teams/team_2.php',
				'category'          => 'team',
				'icon'              => '',
				'keywords'          => array( 'team', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'team_3',
				'title'             => __('Team 3'),
				'description'       => __('A custom team block.'),
				'render_template'   => 'template-parts/blocks/teams/team_3.php',
				'category'          => 'team',
				'icon'              => '',
				'keywords'          => array( 'team', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'cta_1',
				'title'             => __('Call to action 1'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/cta_1.php',
				'category'          => 'call-to-action',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="84px" viewBox="0 0 270 84" enable-background="new 0 0 270 84" xml:space="preserve">  <image id="image0" width="270" height="84" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'cta_3',
				'title'             => __('Call to action 3'),
				'description'       => __('A custom header block.'),
				'render_template'   => 'template-parts/blocks/headers/cta_3.php',
				'category'          => 'call-to-action',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="155px" viewBox="0 0 270 155" enable-background="new 0 0 270 155" xml:space="preserve">  <image id="image0" width="270" height="155" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'header', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'social_proof_1',
				'title'             => __('Social proof 1'),
				'description'       => __('A custom social proof block.'),
				'render_template'   => 'template-parts/blocks/social_proof/social_proof_1.php',
				'category'          => 'social-proof',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="115px" viewBox="0 0 270 115" enable-background="new 0 0 270 115" xml:space="preserve">  <image id="image0" width="270" height="115" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'social', 'proof', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'social_proof_2',
				'title'             => __('Social proof 2'),
				'description'       => __('A custom social proof block.'),
				'render_template'   => 'template-parts/blocks/social_proof/social_proof_2.php',
				'category'          => 'social-proof',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="118px" viewBox="0 0 270 118" enable-background="new 0 0 270 118" xml:space="preserve">  <image id="image0" width="270" height="118" x="0" y="0"    xlink:href="data:image/png;base64,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" /></svg>',
				'keywords'          => array( 'social', 'proof', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'social_proof_3',
				'title'             => __('Social proof 3'),
				'description'       => __('A custom social proof block.'),
				'render_template'   => 'template-parts/blocks/social_proof/social_proof_3.php',
				'category'          => 'social-proof',
				'icon'              => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="270px" height="140px" viewBox="0 0 270 140" enable-background="new 0 0 270 140" xml:space="preserve">  <image id="image0" width="270" height="140" x="0" y="0"    xlink:href="data:image/png;base64,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e7hQ/iOC40zIETonL3O+4DhHsnCYZOEwycJhkoXDJAuHSRYOkywcJlk4TLJwmGThMKlOHDJ9BSsUHXV2Ii9mWFjvCM3h/fiIOFTnsLc+HL915br1G6667Or2egZY3mtGL9t47XWburx1mITaN1+/ZWvfVTf89vTh+MTvrLtx/SdvuvlTt/yur2aTka2j1966bfsnd2y6jajZxHHN1tt33nHndXdt2XX3dOFYc8unb/y9e37/MzdtvP3ez9ZqIl0yunH35/7gvj+8f1ffbXStLnffedfOBx586OGH9uy98/PTgwO75ZZHbvyjR7/w2A1X3XX9zR+v0WXJ6OjGO/Y9vv2xx57Y1PfFGk2ueGLnhgf2P/nkl556YMOeTxemBccfP735y3/ylWceu//hO656ttbDY3B0dPTa3fsOHDz01Yd39m0arM3la09s2PDc81968vnDj976p3/2mWnB8edPv7D9K39x4AtfP7hn07Obr67NZGgMx19+46++uf9bD13V1+evzeWJF/bsXnf40IuHXnp827e/ff+04Pjrp//m5W3f+NtXDty4d+fmzZ+q7RQXNnBs3LPvyP5vbt+1sa+vtqVw8o4dR9c//tRThw8ffuXxRx65aXpw3PKdl7+7btsrL63bu+v2zX9XGw7NwDG6d99Lz9/38t+Pbtwo1Ybj1aN3PnBg//OH97944MEXXvjetOD4xNXf+e6X1z135Ptbjh7dNNpXmwlu0Oi7bve2H9z3w85rXtsYqM1lx4ZNWx84cujgkcMP/sNrty+YFhyfv/Mff7TvmX/a98zuV7fctanGk0Lotpkzl92255kffPWKH7/+kwU1XlR+b++mrdffc2j/iwdvXvza5ty04Ajd8M/r99x663OP7j664crW2g5zANp+uvzCeTt+tP1ffvbznx37cY0m/7r33ntvfuieI99fv3nz5ivruESu5zJs6I2v/eLBX979xi+37N3VX6vJ4Ju/+reffvGmu//92H8ce73mEccb122ddf8965+74dldr/5nHW+prot0es2cOaveeqvtF3e8UbtJ9O0333zzJ2//+tix1+sYCl76zjt3f+vgU19f/I69nndU3xAuGnz33Xfffuu/rqjHRP7vX4/BOPbzukajmf9Z/sMnX/zfX9UzDqx/vkMedAzWfy85NDhY/01HX9RR921ta/rHJAuHSRYOkywc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" /></svg>',
				'keywords'          => array( 'social', 'proof', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'social_proof_4',
				'title'             => __('Social proof 4'),
				'description'       => __('A custom social proof block.'),
				'render_template'   => 'template-parts/blocks/social_proof/social_proof_4.php',
				'category'          => 'social-proof',
				'icon'              => '',
				'keywords'          => array( 'social', 'proof', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'social_proof_5',
				'title'             => __('Social proof 5'),
				'description'       => __('A custom social proof block.'),
				'render_template'   => 'template-parts/blocks/social_proof/social_proof_5.php',
				'category'          => 'social-proof',
				'icon'              => '',
				'keywords'          => array( 'social', 'proof', 'builder' ),
		));

		acf_register_block_type(array(
				'name'              => 'social_proof_6',
				'title'             => __('Social proof 6'),
				'description'       => __('A custom social proof block.'),
				'render_template'   => 'template-parts/blocks/social_proof/social_proof_6.php',
				'category'          => 'social-proof',
				'icon'              => '',
				'keywords'          => array( 'social', 'proof', 'builder' ),
		));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types');
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

register_nav_menus( array(
  'learn-menu' => esc_html__( 'Learn menu', 'Storefront' ),
) );

add_action( 'wp_footer', 'bbloomer_add_cart_quantity_plus_minus' );

function bbloomer_add_cart_quantity_plus_minus() {
   // Only run this on the single product page
   ?>
      <script type="text/javascript">

      jQuery(document).ready(function($){

         $('.quantity-inputs-wrapper').on( 'click', 'button.plus, button.minus', function() {
            var qty = $( this ).parent().find( '.qty' );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));

            if ( $( this ).is( '.plus' ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            }

            $('.qty').trigger('change');

         });

         $('.qty').on('change', function(){
           console.log("teste");
           $("[name='update_cart']").prop('disabled', false).trigger("click");
         });

         $('#coupon_code').on('keyup', function(e) {
           if (e.keyCode == 13) {
             $('[name="apply_coupon"]').trigger('click');
           }
         });

      });

      </script>
   <?php
}

function post_like_table_create() {

global $wpdb;
$table_name = $wpdb->prefix. "post_like_table";
global $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
global $db_version;

if( $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name)
{ $create_sql = "CREATE TABLE " . $table_name . " (
id INT(11) NOT NULL auto_increment,
postid INT(11) NOT NULL ,

clientip VARCHAR(40) NOT NULL ,

PRIMARY KEY (id))$charset_collate;";
require_once(ABSPATH . "wp-admin/includes/upgrade.php");
dbDelta( $create_sql );
}



//register the new table with the wpdb object
if (!isset($wpdb->post_like_table)) {
  $wpdb->post_like_table = $table_name;
  //add the shortcut so you can use $wpdb->stats
  $wpdb->tables[] = str_replace($wpdb->prefix, '', $table_name);
}

}
add_action( 'init', 'post_like_table_create');

function get_client_ip() {
  $ip = $_SERVER['REMOTE_ADDR'];

  return $ip;
}

function my_action_callback() {
  check_ajax_referer( 'my-special-string', 'security' );
  $postid = intval( $_POST['postid'] );
  $clientip = get_client_ip();
  $like = 0;
  $dislike = 0;
  $like_count = 0;

  global $wpdb;
  $row = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid' AND clientip = '$clientip'");

  if( empty( $row ) ){
    $wpdb->insert( $wpdb->post_like_table, array( 'postid' => $postid, 'clientip' => $clientip ), array( '%d', '%s' ) );
    $like = 1;
  }

  if( ! empty( $row ) ){
    //delete row
    $wpdb->delete( $wpdb->post_like_table, array( 'postid' => $postid, 'clientip'=> $clientip ), array( '%d','%s' ) );
    $dislike = 1;
  }

  //calculate like count from db.
  $totalrow = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
  $total_like = $wpdb->num_rows;
  $data = array( 'postid'=>$postid,'likecount'=>$total_like,'clientip'=>$clientip,'like'=>$like,'dislike'=>$dislike);
  echo json_encode($data);
  //echo $clientip;
  die(); // this is required to return a proper result
}

function apply_coupon() {
  $coupon_code = $_GET['coupon_code'];

  if ( WC()->cart->add_discount( sanitize_text_field( $coupon_code )) ) {
    $discount = WC()->cart->discount_cart;
    $output = array(
      'discount' => '<p class="subtitle small">Discount</p><p class="subtitle small">' . $discount . '</p>',
      'total'    => WC()->cart->get_cart_total()
    );

    echo json_encode( $output );
  } else {
    echo false;
  }

  die();
}

function update_checkout_totals() {
  $discount = WC()->cart->discount_cart;
  if ( $discount > 0 ) {
    $output = array(
      'discount' => '<p class="subtitle small">Discount</p><p class="subtitle small">' . $discount . '</p>',
      'total'    => WC()->cart->get_cart_total()
    );

    echo json_encode( $output );
  } else {
    return false;
  }

  die();
}

add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );

add_action( 'admin_footer', 'blocks_editor_styles' );
function blocks_editor_styles() {
  ?>
  <style>
		.edit-post-sidebar .block-editor-block-icon {
			height: 100%;
		}

		.edit-post-sidebar td.acf-row-handle {
    	padding-left: 0;
    	padding-right: 0;
		}

		.edit-post-sidebar td.acf-row-handle {
    	padding-left: 0 !important;
    	padding-right: 0 !important;
		}

		.edit-post-sidebar .block-editor-block-icon svg {
			width: 100% !important;
			max-width: 100%;
			height: auto !important;
			max-height: 100%;
		}

    [class*="editor-block-list-item-acf"] .block-editor-block-icon svg {
      max-height: 100% !important;
      max-width: 100% !important;
      height: auto !important;
    }

    .editor-block-icon, .editor-block-icon div, .editor-block-icon svg {
        width: 100% !important;
    }

    .block-editor-block-types-list__list-item {
        width: 100% !important;
    }

    [class*="editor-block-list-item-acf"] .block-editor-block-icon {
        height: 100% !important;
    }
  </style>

  <?php
}

add_filter( 'acf/load_value/name=buttons',  'afc_load_buttons', 10, 3 );
function afc_load_buttons( $value, $post_id, $field ) {

  if ($value === false) {
    $value = array(
      array(),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db52c489dfe5',  'afc_load_field_5db52c489dfe5', 10, 3);
function afc_load_field_5db52c489dfe5($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db52c48b5d29' => 'Quick setup', // Title
        'field_5db52c48b5d32' => 'See instantly which companies have visited your website.', // Description
      ),
      array(
        'field_5db52c48b5d29' => 'Automatic Reporting', // Title
        'field_5db52c48b5d32' => 'Receive sales leads visit data to your CRM and email inbox.', // Description
      ),
      array(
        'field_5db52c48b5d29' => 'Generate leads', // Title
        'field_5db52c48b5d32' => 'Get new online sales leads throughout the day.', // Description
      ),
      array(
        'field_5db52c48b5d29' => 'Quick relevant data', // Title
        'field_5db52c48b5d32' => 'Use our lead scoring to know which company to sell next.', // Description
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db711e686e09',  'afc_load_field_5db711e686e09', 10, 3);
function afc_load_field_5db711e686e09($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
      ),
      array(
      )
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db517b298108',  'afc_load_field_5db517b298108', 10, 3);
function afc_load_field_5db517b298108($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db518139810a' => 'Increase Conversions', // Title
        'field_5db5181b9810b' => 'Whether you’re focused on product sales or product adoption, understand what’s working (or not) to increase performance.', // Description
      ),
			array(
        'field_5db518139810a' => 'Drive Engagement', // Title
        'field_5db5181b9810b' => 'Send automated behavioral engagements at the perfect time to get people happily headed in the right direction.', // Description
      ),
			array(
        'field_5db518139810a' => 'Grow Retention', // Title
        'field_5db5181b9810b' => 'Customers become loyal when they get what they want and expect. Understand the value drivers that matter most to grow retention.', // Description
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db52cf1f0c9d',  'afc_load_field_5db52cf1f0c9d', 10, 3);
function afc_load_field_5db52cf1f0c9d($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db52cf21aee1' => 'Acquire customers', // Title
        'field_5db52cf21aef6' => 'Use bots and live chat to automatically qualify, route and convert more leads faster.', // Description
      ),
			array(
        'field_5db52cf21aee1' => 'Engage customers', // Title
        'field_5db52cf21aef6' => 'Send targeted email, in-app and push messages to turn more signups into customers.', // Description
      ),
			array(
        'field_5db52cf21aee1' => 'Support customers', // Title
        'field_5db52cf21aef6' => 'Get an integrated help desk and knowledge base to solve custumer problems faster.', // Description
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db52d62048c7',  'afc_load_field_5db52d62048c7', 10, 3);
function afc_load_field_5db52d62048c7($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db52d62203ec' => 'Sign up for our Affiliate Program', // Title
        'field_5db52d62203f3' => 'Our program is free to join and it only takes a few minutes to setup an account. Refer new customers and you’ll receive 30% from each sale.', // Description
      ),
			array(
        'field_5db52d62203ec' => 'Share your link and make money', // Title
        'field_5db52d62203f3' => 'After applying, you will get a unique referral link. Share your link with your network and earn start earning money from every product purchased.', // Description
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db52dd05e3a4',  'afc_load_field_5db52dd05e3a4', 10, 3);
function afc_load_field_5db52dd05e3a4($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db52dd074032' => 'Main Headline', // Title
        'field_5db52dd07403d' => 'Headlines are the most influential element of any copy.', // Description
      ),
			array(
				'field_5db52dd074032' => 'Compelling Copy', // Title
				'field_5db52dd07403d' => 'Craft a copy that will hook your visitors and drive them into action.', // Description
			),
			array(
				'field_5db52dd074032' => 'Call-to-Action', // Title
				'field_5db52dd07403d' => 'Give an imperative instruction to provoke an immediate response.', // Description
			),
			array(
				'field_5db52dd074032' => 'Social Proof', // Title
				'field_5db52dd07403d' => 'Consumers trust the word of their peers over that of brands.', // Description
			),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db52df6b0c09',  'afc_load_field_5db52df6b0c09', 10, 3);
function afc_load_field_5db52df6b0c09($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db52f2bad894' => 'break;-the-pattern', // Id
				'field_5db52fcc6a595' => 'Surprise your customer', // title
				'field_5db52ff66a596' => 'People are already in a mentally guarded state that involves some amount of resistance to what you are selling. They expect you to do what everyone else does because it fits in with their preconceived notions of social norms and is comfortable to them. However, if you do something uniquely non-traditional you have an opportunity to bypass their high guard.', // Content
				'field_5db52f74ad895' => 'break; the pattern', // Label
      ),
			array(
        'field_5db52f2bad894' => 'tell-a-story', // Id
				'field_5db52fcc6a595' => 'Surprise your customer', // title
				'field_5db52ff66a596' => 'People are already in a mentally guarded state that involves some amount of resistance to what you are selling. They expect you to do what everyone else does because it fits in with their preconceived notions of social norms and is comfortable to them. However, if you do something uniquely non-traditional you have an opportunity to bypass their high guard.', // Content
				'field_5db52f74ad895' => 'tell a story', // Label
      ),
			array(
        'field_5db52f2bad894' => 'distort-time', // Id
				'field_5db52fcc6a595' => 'Surprise your customer', // title
				'field_5db52ff66a596' => 'People are already in a mentally guarded state that involves some amount of resistance to what you are selling. They expect you to do what everyone else does because it fits in with their preconceived notions of social norms and is comfortable to them. However, if you do something uniquely non-traditional you have an opportunity to bypass their high guard.', // Content
				'field_5db52f74ad895' => 'Distort time', // Label
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db5308a2fa1d',  'afc_load_field_5db5308a2fa1d', 10, 3);
function afc_load_field_5db5308a2fa1d($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db5308a45ea9' => 'We’re a tad different.', // Title
				'field_5db5308a45eb0' => 'We like to listen, question, push boundaries and seek out new possibilities giving you the best results for your project.', // Description
      ),
			array(
        'field_5db5308a45ea9' => 'No half measures.', // Title
				'field_5db5308a45eb0' => 'When we say we go the extra mile for your project, we actually mean it. Perfection is a goal we strive for every single time.', // Description
      ),
			array(
        'field_5db5308a45ea9' => 'We\'re honest.', // Title
				'field_5db5308a45eb0' => 'We tell it like it is and are transparent with our clients. We believe this fosters great working relationships that lead to incredible results.', // Description
      ),
			array(
        'field_5db5308a45ea9' => 'We\'re always learning.', // Title
				'field_5db5308a45eb0' => 'We consistently stay on top of the latest trends and standards. Learning about new ways to refine our process means you always get our best work.', // Description
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db532388bc04',  'afc_load_field_5db532388bc04', 10, 3);
function afc_load_field_5db532388bc04($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db53238a4c4e' => 'Innovate', // Title
				'field_5db53238a4c66' => 'We take time to understand your pain points, identify opportunities and workshop solutions. Whether you need product prototypes or marcoms ideas, we work with you to define and optimise your digital strategy for today’s challenges.', // Description
      ),
			array(
				'field_5db53238a4c4e' => 'Create', // Title
				'field_5db53238a4c66' => 'With the idea in place we’ll help to realise the vision. From design to development, MVP to full campaign execution, we work with companies of all sizes and sectors to build powerful, considered, user tested solutions that cut through.', // Description
			),
			array(
				'field_5db53238a4c4e' => 'Scale', // Title
				'field_5db53238a4c66' => 'Marketing your product needs to start from the moment of conception not launch. Having built, scaled and executed on our own products we are experienced in developing the strategies content and campaigns that will help your business reach its full value potential.', // Description
			),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db5328ab3b52',  'afc_load_field_5db5328ab3b52', 10, 3);
function afc_load_field_5db5328ab3b52($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db5328ac08f1' => '150+', // Title
				'field_5db5328ac08fc' => 'People', // Description
      ),
			array(
        'field_5db5328ac08f1' => '200+', // Title
				'field_5db5328ac08fc' => 'Webs developed', // Description
      ),
			array(
        'field_5db5328ac08f1' => '17', // Title
				'field_5db5328ac08fc' => 'Nationalities', // Description
      ),
			array(
        'field_5db5328ac08f1' => '5', // Title
				'field_5db5328ac08fc' => 'Offices', // Description
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5dbca425750ef',  'afc_load_field_5dbca425750ef', 10, 3);
function afc_load_field_5dbca425750ef($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5dbca42590700' => 'Design', // Title
				'field_5dbca42590f95' => 'Communicate your brand values', // Description
				'field_5dbca4491247d' => 'Branding & Logo<br>Web Design<br>Publications<br>Campaigns', // Content
      ),
			array(
        'field_5dbca42590700' => 'Digital', // Title
				'field_5dbca42590f95' => 'Bringing ideas to life', // Description
				'field_5dbca4491247d' => 'Development<br>Email Marketing<br>Social Media<br>SEO/PPC', // Content
      ),
			array(
        'field_5dbca42590700' => 'Content', // Title
				'field_5dbca42590f95' => 'Engage with your audience', // Description
				'field_5dbca4491247d' => 'Photography<br>Video<br>Copywriting<br>Infographics', // Content
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5db534079892f',  'afc_load_field_5db534079892f', 10, 3);
function afc_load_field_5db534079892f($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5db5341598930' => 'What is the payment process?', // Title
				'field_5db5342a98931' => 'When you approve the quote, we will send you an invoice. Once the invoice is paid we will send your project to production.', // Content
      ),
			array(
				'field_5db5341598930' => 'What currencies do you accept?', // Title
				'field_5db5342a98931' => 'Our primary currency we deal with is USD dollars, and unless stated otherwise. In general, all amounts listed on our websites is in USD. If you require us to bill you in a certain currency please let us know.', // Content
			),
			array(
				'field_5db5341598930' => 'What payment methods do you accept?', // Title
				'field_5db5342a98931' => 'We will provide you with payment instructions once you approve your quote. We accept the following payment methods: Credit Cards, PayPal and Bank wire. If you prefer to pay with a method different than those above, please contact us and we’ll work out an alternative method.', // Content
			),
			array(
				'field_5db5341598930' => 'Do you accept Purchase Orders?', // Title
				'field_5db5342a98931' => 'Yes! We do accept Purchase Orders. It’s an effective way to work together over longer periods of time.', // Content
			),
			array(
				'field_5db5341598930' => 'My designs are confidential as are the business ideas behind them.
Can you keep them private?', // Title
				'field_5db5342a98931' => 'Absolutely. We pride ourselves on our professionalism and our discretion and strictly adhere to our Privacy Policy and/or a Non-Disclosure Agreement. Read our privacy policy.', // Content
			),
			array(
				'field_5db5341598930' => 'Will we be able to have access to all of the code/CSS for future changes?', // Title
				'field_5db5342a98931' => 'Yes. The rights and ownership of all code (HTML/CSS/images/JavaScript/WordPress Theme) are transferred to you upon payment
in full.', // Content
			),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5e3bd0ccyyb9f70',  'afc_load_field_5e3bd0ccyyb9f70', 10, 3);
function afc_load_field_5e3bd0ccyyb9f70($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5e3yybd0e3b9f71' => 'Starter', // Package name
				'field_5e3yybd0f2b9f72' => 'Free', // Price
				'field_5e3yybd15bb9f73' => 'Everything you need to get started your project, and it\'s free forever.', // Description
				'field_5e3byyd165b9f74' => array(
					array(
						'field_yy5e3bd183b9f75' => '1 user' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => '1 personal project' // Item
					),
				), // Package includes
				'field_5yye3bd1a0b9f76' => array(
					array(
						'field_5e3bdyy1afb9f77' => 'Access to all features' // Item
					),
					array(
						'field_5e3bdyy1afb9f77' => '24h email support' // Item
					),

				), // Package excludes
				'field_5e3hhbe962677bb' => 'Always free'
      ),
			array(
        'field_5e3yybd0e3b9f71' => 'Lite', // Package name
				'field_5e3yybd0f2b9f72' => '$69', // Price
				'field_5e3yybd15bb9f73' => 'For small teams who need more projects and premium features.', // Description
				'field_5e3byyd165b9f74' => array(
					array(
						'field_yy5e3bd183b9f75' => '3 users' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => 'Unlimited projects' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => 'Access to all features' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => '24h email support' // Item
					),
				), // Package includes
				'field_5yye3bd1a0b9f76' => array(
				), // Package excludes
				'field_5e3hhbe962677bb' => 'Per month'
      ),
			array(
        'field_5e3yybd0e3b9f71' => 'Pro', // Package name
				'field_5e3yybd0f2b9f72' => '$99', // Price
				'field_5e3yybd15bb9f73' => 'For larger teams that need additional users and support.', // Description
				'field_5e3byyd165b9f74' => array(
					array(
						'field_yy5e3bd183b9f75' => '10 users' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => 'Unlimited projects' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => 'Access to all features' // Item
					),
					array(
						'field_yy5e3bd183b9f75' => 'Priority support' // Item
					),
				), // Package includes
				'field_5yye3bd1a0b9f76' => array(
					'field_5e3bdyy1afb9f77' => '' // Item
				), // Package excludes
				'field_5e3hhbe962677bb' => 'Per month'
      ),
    );
  }
  return $value;
}

add_filter('acf/load_value/key=field_5e3000ccyyb9f70',  'afc_load_field_5e3000ccyyb9f70', 10, 3);
function afc_load_field_5e3000ccyyb9f70($value, $post_id, $field) {
  if ($value === false) {
    $value = array(
      array(
        'field_5e3yybdde3b9f71' => 'Startup', // Package name
				'field_5eddybd0f2b9f72' => '$9', // Price
				'field_5e3yddd15bb9f73' => 'Per person, per month. <br>Billed annually.', // Description
      ),
			array(
        'field_5e3yybdde3b9f71' => 'Scale', // Package name
				'field_5eddybd0f2b9f72' => 'Let\'s talk', // Price
				'field_5e3yddd15bb9f73' => 'We\'ll tailor the right solution for your organization.', // Description
      ),
    );
  }
  return $value;
}

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

	return $has_availabe_credits;
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
