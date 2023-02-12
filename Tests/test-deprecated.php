<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;

class DeprecatedTest extends TestCase
{
    public function setup(): void
    {
        FunctionsLoader::include();
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
        $result = @Str\decimialNumber(2, '.', '|');
        $this->assertEquals('123|456|789.12', $result(123456789.123456));
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
        $result = @Str\decimalNumber(2, '.', '|');
        $this->assertEquals('123|456|789.12', $result(123456789.123456));
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
        $compareTheBaseAsChars = @Str\similarAsComparisson('BASE');
        $this->assertEquals(4, $compareTheBaseAsChars('THE BASE'));
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
        $findAppleCaseSense = @Str\firstPosistion('Apple');
        $this->assertEquals(0, $findAppleCaseSense('Apple are tasty'));
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
        $findAppleCaseSense = @Str\lastPosistion('Apple');
        $this->assertEquals(23, $findAppleCaseSense('Apple are tasty i like Apples'));
    }
}
