<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;

class DeprecatedTest extends TestCase
{
    public function setup(): void
    {
        FunctionsLoader::include();
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            set_error_handler(
                static function ($errno, $errstr) {
                    // If string contains the word "deprecated" then throw an exception.
                    if (strpos(strtolower($errstr), 'deprecated') !== false) {
                        throw new \PHPUnit\Framework\Error\Deprecated($errstr, $errno, '', 0);
                    }
                    throw new \Exception($errstr, $errno);
                },
                E_ALL
            );
        }

    }

    public function tearDown(): void
    {
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            restore_error_handler();
        }
    }


    /** @testdox Calling decimialNumber should throw a deprecation notice */
    public function testDecimialNumberDeprecation(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        $result = Str\decimialNumber('2');
        $this->assertEquals('2', $result);
    }


    /** @testdox Even though decimialNumber throws a deprecation notice, it should still work. */
    public function testDecimialNumber(): void
    {
        try {
            $result = Str\decimialNumber(2, '.', '|');
            $this->assertEquals('123|456|789.12', $result(123456789.123456));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }


    /** @testdox Calling decimialNumber should throw a deprecation notice */
    public function testDecimalNumberDeprecation(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        $result = Str\decimalNumber('2');
        $this->assertEquals('2', $result);
    }


    /** @testdox Even though decimialNumber throws a deprecation notice, it should still work. */
    public function testDecimalNumber(): void
    {
        try {
            $result = @Str\decimalNumber(2, '.', '|');
            $this->assertEquals('123|456|789.12', $result(123456789.123456));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }

    /** @testdox Calling similarAsComparisson should throw a deprecation notice */
    public function testSimilarAsComparissonDeprecation(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        Str\similarAsComparisson('a');
    }

    /** @testdox similarAsComparisson should still function even though it throws */
    public function testSimilarAsComparisson(): void
    {
        try {
            $compareTheBaseAsChars = @Str\similarAsComparisson('BASE');
            $this->assertEquals(4, $compareTheBaseAsChars('THE BASE'));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }

    /** @testdox Calling firstPosistion should throw a deprecation notice */
    public function testFirstPosistionDeprecation(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        Str\firstPosistion('a');
    }

    /** @testdox firstPosistion should still function even though it throws */
    public function testFirstPosistion(): void
    {
        try {
            $findAppleCaseSense = @Str\firstPosistion('Apple');
            $this->assertEquals(0, $findAppleCaseSense('Apple are tasty'));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }


    /** @testdox Calling lastPosistion should throw a deprecation notice */
    public function testLastPosistionDeprecation(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        Str\lastPosistion('s');
    }

    /** @testdox lastPosistion should still function even though it throws */
    public function testLastPosistion(): void
    {
        try {
            $findAppleCaseSense = @Str\lastPosistion('Apple');
            $this->assertEquals(23, $findAppleCaseSense('Apple are tasty i like Apples'));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }

    /**
     *
     *    Strings\similarAsComparison
     *
     */

    /** @testdox Calling similarAsComparison should throw a deprecation notice */
    public function testSimilarAsComparison(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        Str\similarAsComparison('a');
    }

    /** @testdox similarAsComparison should still function even though it throws */
    public function testSimilarAsComparisonUsage(): void
    {
        try {
            $compareTheBaseAsChars = @Str\similarAsComparison('BASE');
            $this->assertEquals(4, $compareTheBaseAsChars('THE BASE'));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }

    /**
     *
     *    Strings\similarAsBase
     *
     */

    /** @testdox Calling similarAsBase should throw a deprecation notice */
    public function testSimilarAsBase(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        Str\similarAsBase('a');
    }

    /** @testdox similarAsBase should still function even though it throws */
    public function testSimilarAsBaseUsage(): void
    {
        try {
            $compareTheBaseAsChars = @Str\similarAsBase('BASE');
            $this->assertEquals(4, $compareTheBaseAsChars('THE BASE'));
        } catch (\PHPUnit\Framework\Error\Deprecated $e) {
        }
    }

    /** @testdox Calling pushHead should throw a deprecation notice */
    public function testPushHead(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        $pushToHead = Arr\pushHead(array( 3, 4, 5, 6 ));
        $added2     = $pushToHead(2);
        $this->assertEquals(2, $added2[0]);
    }


    /** @testdox Calling pushTail should throw a deprecation notice */
    public function testPushTail(): void
    {
        // If using PHPUnit 9, we need to use the expectDeprecation() method
        if (version_compare(\PHPUnit\Runner\Version::id(), '9.0.0', '>=')) {
            $this->expectDeprecation();
        } else {
            $this->expectException(\PHPUnit\Framework\Error\Deprecated::class);
        }
        $pushToHead = Arr\pushTail(array( 3, 4, 5, 6 ));
        $added2     = $pushToHead(7);
        $this->assertEquals(7, $added2[4]);
    }


    // public function testCanPushToHead(): void {
    // 	try {
    // 	$pushToHead = @Arr\pushHead( array( 3, 4, 5, 6 ) );
    // 	$added2     = $pushToHead( 2 );
    // 	$this->assertEquals( 2, $added2[0] );
    //     } catch (\PHPUnit\Framework\Error\Deprecated $e) {}

    // 	$pushToHead = @Arr\pushHead( $added2 );
    // 	$added1     = $pushToHead( 1 );
    // 	$this->assertEquals( 1, $added1[0] );

    // 	// As curried.
    // 	$curried = @Arr\pushHead( array( 3, 4, 5, 6 ) )( 2 );
    // 	$this->assertEquals( 2, $curried[0] );
    // }

    // public function testCanPushToTail(): void {
    // 	$pushToTail = @Arr\pushTail( array( 1, 2, 3, 4 ) );
    // 	$added2     = $pushToTail( 5 );
    // 	$this->assertEquals( 5, $added2[4] );

    // 	$pushToTail = @Arr\pushTail( $added2 );
    // 	$added1     = $pushToTail( 6 );
    // 	$this->assertEquals( 6, $added1[5] );

    // 	// As curried.
    // 	$curried = @Arr\pushTail( array( 1, 2, 3, 4 ) )( 5 );
    // 	$this->assertEquals( 5, $curried[4] );
    // }
}
