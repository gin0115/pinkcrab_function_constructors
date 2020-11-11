<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PinkCrab\Modules\FunctionConstructors\Strings as Str;
use PinkCrab\Modules\FunctionConstructors\FunctionsLoader;

/**
 * StringFunction class.
 */
class StringFunctionTest extends TestCase {

	public function setup() {
		FunctionsLoader::include();

	}

	public function testCanWrapStringWithHTMLTags() {

		$asDiv = Str\tagWrap( 'div class="test"', 'div' );
		$this->assertEquals( '<div class="test">HI</div>', $asDiv( 'HI' ) );
		$this->assertEquals( '<div class="test">123</div>', $asDiv( '123' ) );

		$asLi = Str\tagWrap( 'li' );
		$this->assertEquals( '<li>HI</li>', $asLi( 'HI' ) );
		$this->assertEquals( '<li>123</li>', $asLi( '123' ) );
	}

	public function testCanWrapString() {
		$foo = Str\wrap( '--', '++' );
		$this->assertEquals( '--HI++', $foo( 'HI' ) );
		$this->assertEquals( '--123++', $foo( '123' ) );

		$bar = Str\wrap( '\/' );
		$this->assertEquals( '\/HI\/', $bar( 'HI' ) );
		$this->assertEquals( '\/123\/', $bar( '123' ) );
	}

	public function testCanMakeUrl() {
		$makeUrl = Str\asUrl( 'http://test.com' );
		$this->assertEquals(
			"<a href='http://test.com'>test</a>",
			$makeUrl( 'test' )
		);

		$makeUrlBlank = Str\asUrl( 'http://test.com', '_blank' );
		$this->assertEquals(
			"<a href='http://test.com' target='_blank'>test</a>",
			$makeUrlBlank( 'test' )
		);
	}

	public function testCanPrependString() {
		$prep10 = Str\prepend( '10' );
		$this->assertEquals( '10HI', $prep10( 'HI' ) );
		$this->assertEquals( '1077', $prep10( '77' ) );
	}

	public function testCanAppendString() {
		$append10 = Str\append( '10' );
		$this->assertEquals( 'HI10', $append10( 'HI' ) );
		$this->assertEquals( '7710', $append10( '77' ) );
	}

	public function testCanCurryReplace() {
		$find_to_mask = Str\findToReplace( 'to mask' );

		// Mask with XX
		$maskWithXX = $find_to_mask( 'xx' );
		$string     = 'This has some test to mask and some more to mask';
		$this->assertEquals(
			'This has some test xx and some more xx',
			$maskWithXX( $string )
		);

		// Mask with YY
		$maskWithYY = $find_to_mask( 'yy' );
		$string     = 'This has some test to mask and some more to mask';
		$this->assertEquals(
			'This has some test yy and some more yy',
			$maskWithYY( $string )
		);

		// Inlined.
		$this->assertEquals(
			'This has some test xx and some more xx',
			Str\findToReplace( 'to mask' )( 'xx' )( $string )
		);

	}

	public function testCanReplaceInString() {
		$replaceGlynnWithHa = Str\replaceWith( 'glynn', 'ha' );
		$this->assertEquals( 'Hi ha', $replaceGlynnWithHa( 'Hi glynn' ) );
		$this->assertEquals( 'ha ha ha', $replaceGlynnWithHa( 'glynn glynn glynn' ) );
	}

	public function testStringContains() {
		$contains = Str\contains( '--' );
		$this->assertTrue( $contains( '--True' ) );
		$this->assertFalse( $contains( '++False' ) );
	}

	public function testStringStartWith() {
		$startsWithA = Str\startsWith( '--' );
		$this->assertTrue( $startsWithA( '--True' ) );
		$this->assertFalse( $startsWithA( '++False' ) );
	}

	public function testStringEndWith() {
		$endsWith = Str\endsWith( '--' );
		$this->assertTrue( $endsWith( '--True--' ) );
		$this->assertFalse( $endsWith( '++False++' ) );
	}

	public function testCanComposeWithSafeStrings() {
		$reutrnsArray = function( $e ) {
			return array();
		};

		$function = Str\composeSafeStringFunc(
			Str\replaceWith( '3344', '*\/*' ),
			Str\replaceWith( '5566', '=/\=' ),
			$reutrnsArray,
			Str\prepend( '00' ),
			Str\append( '99' )
		);
		$this->assertNull( $function( '1122334455667788' ) );
	}

	public function testStringCompilerCanBeUsedAsAJournal() {
		$journal = Str\stringCompiler( '' );
		$journal = $journal( '11' );
		$this->assertEquals( '11', $journal() );
		$journal = $journal( '22' );
		$this->assertEquals( '1122', $journal() );
		$journal = $journal( '33' );
		$this->assertEquals( '112233', $journal() );
	}

	public function testComposedWithArrayMap() {
		$function = Str\composeSafeStringFunc(
			Str\replaceWith( 'a', '_a_' ),
			Str\replaceWith( 't', '-t-' ),
			Str\prepend( '00' ),
			Str\append( '99' )
		);

		$results = array_map( $function, array( '1a2', '1b3', '1t4' ) );
		$this->assertEquals( '001_a_299', $results[0] );
		$this->assertEquals( '001b399', $results[1] );
		$this->assertEquals( '001-t-499', $results[2] );
	}
}


