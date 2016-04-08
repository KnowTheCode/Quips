<?php
/**
 * Quips Plugin Runtime Configuration Parameters.
 *
 * @package     Quips
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */

namespace Quips;

use Fulcrum\Config\Config;
use Quips\Foundation\Quip_Handler;

return array(
	'plugin_activation_keys' => array(
		'quips.post_type',
	),

	'service_providers' => array(

		/****************************
		 * Custom Post Types
		 ****************************/
		'quips.post_type' => array(
			'provider' => 'provider.post_type',
			'config'   => QUIPS_PLUGIN_DIR . 'config/post-type/quip.php',
		),
	),

	'register_concrete' => array(
		'quip_handler' => array(
			'autoload' => true,
			'concrete' => function ( $container ) {
				$config = array(
					'defaults' => array(
						'post_type'      => 'quips',
						'posts_per_page' => 1,
						'orderby'        => 'random',
					),
				);

				return new Quip_Handler( new Config( $config ) );
			}
		),
	),
);
