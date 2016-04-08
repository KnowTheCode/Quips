<?php
/**
 * Random Quip Handler
 *
 * It pulls a random quip out of the database and then returns HTML for it.
 *
 * @package     Quips\Foundation
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knownthecode.io
 * @license     GNU General Public License 2.0+
 */

namespace Quips\Foundation;

use Fulcrum\Config\Config_Contract;

class Quip_Handler {

	protected $config;

	/**
	 * Quip_Handler constructor.
	 *
	 * @param Config_Contract $config
	 */
	public function __construct( Config_Contract $config ) {
		$this->config = $config;
	}

	/**
	 * Render the quip.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function render( array $args = [] ) {
		$content = $this->get_content( $args );
		if ( empty( $content ) ) {
			return '';
		}

		$content = esc_html( $content );
		$content = wpautop( $content );

		$class = $this->get_class( $args );

		ob_start();

		include( __DIR__ . '/views/quip.php' );

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Get the content - Runs a custom SQL Query and pulls a random
	 * quip out of the database.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected function get_content( array $args ) {
		$args = $this->build_args( $args );

		global $wpdb;

		$sql_query = $wpdb->prepare(
			"
				SELECT ID, post_content, @rand:= RAND() as rand
				FROM {$wpdb->posts}
				WHERE post_type = %s AND post_status = 'publish'
				ORDER BY rand
				LIMIT 1
			", $args['post_type']
		);

		$result = $wpdb->get_results( $sql_query );

		if ( empty( $result ) ) {
			return '';
		}

		$record = array_shift( $result );

		return $record->post_content;
	}

	/**
	 * Builds the arguments for the query.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args (optional) An array of arguments
	 * @return array
	 */
	protected function build_args( array $args = [] ) {
		return wp_parse_args( $args, $this->config->defaults );
	}

	/**
	 * Get the quip styling class, if one was passed into the handler.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected function get_class( array $args = [] ) {
		if ( array_key_exists( 'class', $args ) ) {
			return ' ' . esc_attr( $args['class'] );
		}

		return '';
	}
}