<?php
/**
 * COWIDGETS_Codeless_Compat setup
 *
 * @package cowidgets
 */

/**
 * Livecast theme compatibility.
 */
class COWIDGETS_Livecast_Compat {

	/**
	 * Instance of COWIDGETS_Livecast_Compat.
	 *
	 * @var COWIDGETS_Livecast_Compat
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new COWIDGETS_Livecast_Compat();

			add_action( 'wp', [ self::$instance, 'hooks' ] );
		}

		return self::$instance;
	}

	/**
	 * Run all the Actions / Filters.
	 */
	public function hooks() {
		if ( cowidgets_header_enabled() ) {
			add_action( 'template_redirect', [ $this, 'livecast_setup_header' ], 10 );
			add_action( 'codeless_hook_wrapper_begin', 'cowidgets_render_header' );
		}

		if ( cowidgets_footer_enabled() ) {
			add_action( 'template_redirect', [ $this, 'livecast_setup_footer' ], 10 );
			add_action( 'codeless_hook_main_after', 'cowidgets_render_footer', 99 );
		}

		if ( cowidgets_is_before_footer_enabled() ) {
			add_action( 'codeless_hook_main_after', 'cowidgets_render_before_footer', 9 );
		}
	}

	/**
	 * Disable header from the theme.
	 */
	public function livecast_setup_header() {
		remove_action( 'codeless_hook_wrapper_begin', 'codeless_show_header', 0 );
	}

	/**
	 * Disable footer from the theme.
	 */
	public function livecast_setup_footer() {
		remove_action( 'codeless_hook_main_after', 'codeless_show_footer', 0 );
	}

}

COWIDGETS_Livecast_Compat::instance();