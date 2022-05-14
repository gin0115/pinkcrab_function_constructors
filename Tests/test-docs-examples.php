<?php

declare(strict_types=1);

require_once dirname( __FILE__, 2 ) . '/FunctionsLoader.php';

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

/**
 * Tests for Examples used in docs (wiki, readme etc)
 */
class DocsExampleTest extends TestCase {

	public function setup(): void {
		FunctionsLoader::include();
	}
	/** @testdox README : Pipe Example -- Remove all odd numbers, sort in an acceding order and double the value. */
	public function testReadmePipeArrayOfInts(): void {
		$data = array( 0, 3, 4, 5, 6, 8, 4, 6, 8, 1, 3, 4 );

		// Remove all odd numbers, sort in an acceding order and double the value.
		$newData = F\pipe(
			$data,
			Arr\filter( Num\isFactorOf( 2 ) ), // Remove odd numbers
			Arr\natsort(),                // Sort the remaining values
			Arr\map( Num\multiply( 2 ) )      // Double the values.
		);

        $expected = [
            2 => 8,
            6 => 8,
            11 => 8,
            4 => 12,
            7 => 12,
            5 => 16,
            8 => 16,
        ];

        $this->assertSame( $expected, $newData );


        dump($newData);
	}
}
