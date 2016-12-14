<?php
/**
 * This file contains all font families used and included in an array that builds a fonts url dynamically.
 *
 * @package Utility_Pro customized for gingercoolidge.com
 * @author Ginger Coolidge
 * @license GPL-2.0+
 */

add_action( 'wp_enqueue_scripts', 'utility_pro_enqueue_fonts' );

function utility_pro_enqueue_fonts() {
	wp_enqueue_style( 'utility-pro-fonts', utility_pro_fonts_url(), array(), null );
}

/**
 * Build Google fonts URL - listing each font family separately as we build an array.
 */

function utility_pro_fonts_url() {
	$fonts_url = '';

	$font_families[] = 'Roboto:400,700';

	$font_families[] = 'Lato:400,700';

	$font_families[] = 'Open Sans:400,700';

	$font_families[] = 'Rye:400';

	$font_families[] = 'Oswald:300,400,700';

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );


	return $fonts_url;
}