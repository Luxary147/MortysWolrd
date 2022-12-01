<?php
/**
 * Core traits, shared with other classes.
 *
 * Name:    Neve Pro Addon
 * Author:  Bogdan Preda <bogdan.preda@themeisle.com>
 *
 * @version 1.0.0
 * @package Neve_Pro
 */

namespace Neve_Pro\Traits;

use Neve_Pro\Core\Abstract_Module;

/**
 * Trait Core
 *
 * @package Neve_Pro\Traits
 */
trait Core {

	/**
	 * License tier map.
	 *
	 * @var array
	 */
	public $tier_map = [
		1 => 1,
		2 => 1,
		3 => 2,
		4 => 2,
		5 => 3,
		6 => 3,
		7 => 1,
		8 => 2,
		9 => 3,
	];

	/**
	 * Recursive wp_parse_args.
	 * Extends parse args for nested arrays.
	 *
	 * @param array $target The target array.
	 * @param array $default The defaults array.
	 *
	 * @return array
	 */
	public function rec_wp_parse_args( &$target, $default ) {
		$target  = (array) $target;
		$default = (array) $default;
		$result  = $default;
		foreach ( $target as $key => &$value ) {
			if ( is_array( $value ) && isset( $result[ $key ] ) ) {
				$result[ $key ] = $this->rec_wp_parse_args( $value, $result[ $key ] );
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}

	/**
	 * License type.
	 *
	 * @return int
	 */
	public function get_license_type() {
		$status = $this->get_license_data();
		if ( $status === false ) {
			return -1;
		}

		if ( ! isset( $status->price_id ) ) {
			return -1;
		}

		if ( isset( $status->license ) && ( $status->license !== 'valid' && $status->license !== 'active_expired' ) ) {
			return - 1;
		}

		if ( ! array_key_exists( $status->price_id, $this->tier_map ) ) {
			return -1;
		}

		return (int) $this->tier_map[ $status->price_id ];
	}

	/**
	 * Get the license data.
	 *
	 * @return bool|\stdClass
	 */
	public function get_license_data() {
		$option_name = basename( dirname( NEVE_PRO_BASEFILE ) );
		$option_name = str_replace( '-', '_', strtolower( trim( $option_name ) ) );
		return get_option( $option_name . '_license_data' );
	}

	/**
	 * Enqueue with RTL support.
	 *
	 * @param string $handle style handle.
	 * @param string $src style src.
	 * @param array  $dependencies dependencies.
	 * @param string $version version.
	 */
	public function rtl_enqueue_style( $handle, $src, $dependencies, $version ) {
		wp_register_style( $handle, $src, $dependencies, $version );
		wp_style_add_data( $handle, 'rtl', 'replace' );
		wp_style_add_data( $handle, 'suffix', '.min' );
		wp_enqueue_style( $handle );
	}

	/**
	 * Wrapper for wp_remote_get.
	 *
	 * Usage: for available $args, look WP_Http::request doc (https://developer.wordpress.org/reference/classes/wp_http/request/)
	 */
	public function remote_get( $url, $args = array() ) {
		$vip_default_fallback  = '';
		$vip_default_threshold = 3;
		$vip_default_timeout   = 1;
		$vip_default_retry     = 20;

		return function_exists( 'vip_safe_wp_remote_get' )
			? vip_safe_wp_remote_get(
				$url,
				$vip_default_fallback,
				$vip_default_threshold,
				array_key_exists( 'timeout', $args ) ? $args['timeout'] : $vip_default_timeout, // The timeout argument was overwritten because it was in the intersection set of vip and default request args
				$vip_default_retry,
				$args
			) : wp_remote_get( $url, $args ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_remote_get_wp_remote_get
	}

	/**
	 * Wrapper for attachment_url_to_postid.
	 */
	public function attachment_url_to_postid( $url ) {
		return function_exists( 'wpcom_vip_attachment_url_to_postid' )
			? wpcom_vip_attachment_url_to_postid( $url )
			: attachment_url_to_postid( $url ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.attachment_url_to_postid_attachment_url_to_postid
	}

	/**
	 * Get the license expiration date.
	 *
	 * @param string $format format of the date.
	 * @return false|string
	 */
	private function get_license_expiration_date( $format = 'F Y' ) {
		$data = $this->get_license_data();
		if ( isset( $data->expires ) ) {
			$parsed = date_parse( $data->expires );
			$time   = mktime( $parsed['hour'], $parsed['minute'], $parsed['second'], $parsed['month'], $parsed['day'], $parsed['year'] );
			return gmdate( $format, $time );
		}
		return false;
	}

	/**
	 * Helper method to flush rules on particular actions.
	 *
	 * @param string $key Key action.
	 */
	private function maybe_flush_rules( $key ) {
		$option = 'nv_' . $key . '_rules_flushed';
		if ( get_option( $option ) === 'yes' ) {
			return;
		}
		update_option( $option, 'yes' );
		flush_rewrite_rules(); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules
	}

	/**
	 * Wrapper to add additional filter for block processing.
	 * Based on https://core.trac.wordpress.org/ticket/51612
	 *
	 * This method is invoked from the inside Inside_Layout class for custom layouts and from the Performance\Module.
	 *
	 * @param array          $parsed_block The block being rendered.
	 * @param array          $source_block An un-modified copy of $parsed_block, as it appeared in the source content.
	 * @param \WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
	 *
	 * @retun array
	 */
	public function process_content_blocks( $parsed_block, $source_block, $parent_block = null ) {
		if ( $parent_block !== null ) {
			return $parsed_block;
		}

		$parsed_block[ Abstract_Module::TOP_LEVEL_BLOCK_FLAG ] = true;

		return $parsed_block;
	}
}
