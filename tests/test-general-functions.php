<?php declare(strict_types=1);

/**
 * Tests for the StrictMap class.
 *
 * @since 1.0.0
 * @author GLynn Quelch <glynn.quelch@gmail.com>
 */

use PHPUnit\Framework\TestCase;
use PinkCrab\Modules\FunctionConstructors\Strings as Str;
use PinkCrab\Modules\FunctionConstructors\FunctionsLoader;
use PinkCrab\Modules\FunctionConstructors\GeneralFunctions as Func;

/**
 * StringFunction class.
 */
class GeneralFunctionTest extends TestCase {

	public function setup() {
		FunctionsLoader::include();
	}

	public function testFunctionCompose() {
		$function = Func\compose(
			Str\replaceWith( '1122', '*\/*' ),
			Str\replaceWith( '6677', '=/\=' ),
			Str\prepend( '00' ),
			Str\append( '99' )
		);

		$this->assertEquals(
			'00*\/*334455=/\=8899',
			$function( '1122334455667788' )
		);

		$function = Func\composeSafe(
			Str\replaceWith( '3344', '*\/*' ),
			Str\replaceWith( '5566', '=/\=' ),
			Str\prepend( '00' ),
			Str\append( '99' )
		);

		$this->assertEquals(
			'001122*\/*=/\=778899',
			$function( '1122334455667788' )
		);
	}

	public function testFunctionCompseSafeHandlesNull() {

		$reutrnsNull = function( $e ) {
			return null;
		};

		$function = Func\composeSafe(
			Str\replaceWith( '3344', '*\/*' ),
			Str\replaceWith( '5566', '=/\=' ),
			$reutrnsNull,
			Str\prepend( '00' ),
			Str\append( '99' )
		);
		$this->assertNull( $function( '1122334455667788' ) );
	}

	public function testTypeSafeFunctionalComposer() {
		$function = Func\composeTypeSafe(
			'is_string',
			Str\replaceWith( '3344', '*\/*' ),
			Str\replaceWith( '5566', '=/\=' ),
			Str\prepend( '00' ),
			Str\append( '99' )
		);

		$this->assertEquals(
			'001122*\/*=/\=778899',
			$function( '1122334455667788' )
		);
	}
}
