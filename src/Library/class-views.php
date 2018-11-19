<?php
/**
 * Views Library
 *
 * @package BPCUT\Library
 */

namespace BPCUT\Library;

/**
 * Class Views
 *
 * @package BPCUT\Library
 */
class Views {

	/**
	 * Simple helper to render views. Might be extended to include view vars.
	 *
	 * @param string $filename - view filename.
	 */
	public static function render( $filename ) {
		include BPCUT_PLUGIN_VIEWS_DIR . $filename . '.php';
	}
}
