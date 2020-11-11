<?php

declare(strict_types=1);

namespace PinkCrab\Modules\FunctionConstructors\Files;

use PinkCrab\Modules\FunctionConstructors\Arrays as Arr;
use PinkCrab\Modules\FunctionConstructors\Constants as Cn;

/**
 * Creates a callable for opening a file in a defined mode.
 *
 * @flow Str->fn()->stream
 * @param string $find The mode to open the file as.
 * @return callable
 */
function openAs( string $mode ): callable {
	/**
	 * @param string $source String to look in.
	 * @return resource
	 */
	return function ( string $path ) use ( $mode ) {
		return fopen( $path, $mode );
	};
}

/**
 * Creates a callback for compiling an array from CSV file stream
 *
 * @flow stream->fn()->array
 * @param string $deliminator
 */
function csvToArray( string $deliminator = ',' ): callable {
	/**
	 * @param resource $stream
	 * @return array
	 */
	return function ( $stream ) use ( $deliminator ) {
		$rowAccumulator = Arr\arrayCompiler( Cn\EMPTY_ARRAY );
		while ( ( $row = fgetcsv( $stream, null, $deliminator ) ) !== false ) {
			$rowAccumulator = $rowAccumulator( $row );
		};
		fclose( $stream );
		return $rowAccumulator();
	};
};
