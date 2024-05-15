<?php

//namespace prosys_gut;

if( ! function_exists('fusion_blocks_editor_assets')):

add_action( 'enqueue_block_editor_assets', 'fusion_blocks_editor_assets' );
/**
 * Enqueue block editor only JavaScript and CSS.
 */
function fusion_blocks_editor_assets() {
	// Make paths variables so we don't write em twice ;)
	$block_path = '/assets/js/editor.blocks.js';
	$style_path = '/assets/css/blocks.editor.css';

	// Enqueue the bundled block JS file
	wp_enqueue_script( 'fusion-blocks-js', PROSYS_GUT_BASE . $block_path, [ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ],
		'123123123123'
	);

	// Enqueue optional editor only styles
	wp_enqueue_style( 'prosys-blocks-editor-css', PROSYS_GUT_BASE . $style_path, [ ], '20160120' );
}
endif;

if( ! function_exists( 'psenqueue_assets')):
/**
 * Enqueue front end and editor JavaScript and CSS assets.
 */
function psenqueue_assets() {
	$style_path = '/assets/css/blocks.style.css';
	wp_enqueue_style( 'prosys-blocks', PROSYS_GUT_BASE . $style_path, null, '20101211'	);
}
add_action( 'enqueue_block_assets', 'psenqueue_assets' );
endif;

if( ! function_exists('psenqueue_frontend_assets') ):
/**
 * Enqueue frontend JavaScript and CSS assets.
 */
function psenqueue_frontend_assets() {

	// If in the backend, bail out.
	if ( is_admin() ) {
		return;
	}

	$block_path = '/assets/js/psfrontend.blocks.js';
	wp_enqueue_script( 'prosys-blocks-frontend', PROSYS_GUT_BASE . $block_path, [], '2012121');
}

add_action( 'enqueue_block_assets', 'psenqueue_frontend_assets' );
endif;
