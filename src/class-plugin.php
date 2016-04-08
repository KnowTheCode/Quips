<?php
/**
 * Quips Plugin - Let's have fun some!
 *
 * @package     QUIPS
 * @since       1.0.1
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */

namespace Quips;

use Fulcrum\Addon\Addon;

class Plugin extends Addon {

	/**
	 * The plugin's version
	 *
	 * @var string
	 */
	const VERSION = '1.0.1';

	/**
	 * The plugin's minimum WordPress requirement
	 *
	 * @var string
	 */
	const MIN_WP_VERSION = '3.5';

	protected function init_addon() {
		parent::init_addon();

		add_filter( 'content_adder', array( $this, 'add_quips_to_content' ), 10, 2 );
		add_action( 'init', array( $this, 'init_separate_concretes' ) );
	}

	/**
	 * Register the separate concretes, when registered.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_separate_concretes() {
		if ( ! $this->has_concrete_to_register() ) {
			return;
		}

		foreach( $this->config->register_concrete as $unique_id => $concrete ) {
			$this->fulcrum->register_concrete( $concrete, $unique_id );
		}
	}

	/**
	 * Checks if any concretes need to be registered.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function has_concrete_to_register() {
		return $this->config->has( 'register_concrete' ) && is_array( $this->config->register_concrete );
	}

	/**
	 * Description.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content
	 * @param array $attributes
	 *
	 * @return mixed
	 */
	public function add_quips_to_content( $content, $attributes ) {
		if ( $content || $attributes['mid'] != 1 ) {
			return $content;
		}

		return $this->fulcrum['quip_handler']->render();
	}
}