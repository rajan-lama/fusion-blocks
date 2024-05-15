<?php

namespace fusion_blocks;

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );
/**
 * Enqueue block editor only JavaScript and CSS.
 */
function enqueue_block_editor_assets() {
	// Make paths variables so we don't write em twice ;)
	$block_path = '/assets/js/blocks.editor.js';
	$style_path = '/assets/css/blocks.editor.css';

	// Enqueue the bundled block JS file
	wp_enqueue_script(
		'jsforwp-blocks-js',
		_get_plugin_url() . $block_path,
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ],
		'12321512'
	);

	// Enqueue optional editor only styles
	wp_enqueue_style(
		'jsforwp-blocks-editor-css',
		_get_plugin_url() . $style_path,
		[ ],
		'123456'
	);
}

add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_assets' );
/**
 * Enqueue front end and editor JavaScript and CSS assets.
 */
function enqueue_assets() {
	$style_path = '/assets/css/blocks.style.css';
	wp_enqueue_style(
		'jsforwp-blocks',
		_get_plugin_url() . $style_path,
		null,
		'121214'
	);
}

add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_frontend_assets' );
/**
 * Enqueue frontend JavaScript and CSS assets.
 */
function enqueue_frontend_assets() {

	// If in the backend, bail out.
	if ( is_admin() ) {
		return;
	}

	$block_path = '/assets/js/blocks.frontend.js';
	wp_enqueue_script(
		'jsforwp-blocks-frontend',
		_get_plugin_url() . $block_path,
		[],
		'1234566' 
	);
}
