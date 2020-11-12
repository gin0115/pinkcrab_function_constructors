<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;

/**
 * NumberFunction class.
 */
class NumberFunctionTest extends TestCase
{

    public function setup(): void
    {
        FunctionsLoader::include();
    }

    public function testCanAccumulateInteger(): void
    {
        $acc = Num\accumulatorInt(0);
        $acc = $acc(11);
        $this->assertEquals(11, $acc());
        $acc = $acc(22);
        $this->assertEquals(33, $acc());
        $acc = $acc(33);
        $this->assertEquals(66, $acc());
    }

    /**
     * @expectedException TypeError
     */
    public function testAccumlatorIntThrowsErrorForNoneIntTypes()
    {
        $acc = Num\accumulatorInt(0);
        $acc = $acc('11');
    }

    public function testCanAccumulateFloat(): void
    {
        $acc = Num\accumulatorFloat(0);
        $acc = $acc(0.5);
        $this->assertEquals(0.5, $acc());
        $acc = $acc(22.2);
        $this->assertEquals(22.7, $acc());
        $acc = $acc(7.3);
        $this->assertEquals(30, $acc());
    }

    /**
     * @expectedException TypeError
     */
    public function testAccumlatorFloatThrowsErrorForNoneFloatTypes()
    {
        $acc = Num\accumulatorFloat(0);
        $acc = $acc([1,2,3,4,5,6]);
    }
}
