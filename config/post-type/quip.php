<?php
/**
 * Quips custom post type runtime configuration parameters.
 *
 * @package     Quips
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */

namespace Quips;

return array(
	'autoload'       => true,
	'post_type_name' => 'quips',
	'config'         => array(
		'plural_name'         => 'Quips',
		'singular_name'       => 'Quip',
		'args'                => array(
			'public'              => true,
			'hierarchical'        => false,
			'show_in_rest'        => false,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_in_nav_menus'   => false,
			'menu_icon'           => 'dashicons-smiley',
		),
		'additional_supports' => array(
			'author'          => false,
			'comments'        => false,
			'excerpt'         => false,
			'post-formats'    => false,
			'trackbacks'      => false,
			'page-attributes' => true,
			'revisions'       => false,
		),
	),
);
