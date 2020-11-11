<?php

declare(strict_types=1);

namespace PinkCrab\FunctionConstructors;


class FunctionsLoader {

	/**
	 * Loads all supplimentry function files.
	 *
	 * @author Glynn Quelch <glynn.quelch@gmail.com>
	 * @since 0.1.0
	 */
	public static function include(): void {
		require_once( 'src/comparisons.php' );
		require_once( 'src/general.php' );
		require_once( 'src/arrays.php' );
		require_once( 'src/strings.php' );
	}

}










