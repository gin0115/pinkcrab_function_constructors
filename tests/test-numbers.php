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
        $this->expectException(TypeError::class);
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
        $this->expectException(TypeError::class);
        $acc = Num\accumulatorFloat(0);
        $acc = $acc([1,2,3,4,5,6]);
        // Throws TypeError.
    }

    public function testCanSumIntFloats()
    {
        $addsFive = Num\sumInt(5);
        $addsTwoAndAHalf = Num\sumFloat(2.5);
        
        $a = 0;
        $b = 1.00;
        
        $a = $addsFive($a);
        $b = $addsTwoAndAHalf($b);

        $this->assertEquals(5, $a);
        $this->assertEquals(3.5, $b);

        $this->assertEquals(10, $addsFive($a));
        $this->assertEquals(6, $addsTwoAndAHalf($b));
    }

    public function testCanSubIntFloats()
    {
        $subsFive = Num\subtractInt(5);
        $subsTwoAndAHalf = Num\subtractFloat(2.5);
        
        $a = 10;
        $b = 7.5;
        
        $a = $subsFive($a);
        $b = $subsTwoAndAHalf($b);

        $this->assertEquals(5, $a);
        $this->assertEquals(5.0, $b);

        $this->assertEquals(0, $subsFive($a));
        $this->assertEquals(2.5, $subsTwoAndAHalf($b));
    }

    public function testCanMultiplyIntFloats()
    {
        $subsFive = Num\multiplyInt(5);
        $subsTwoAndAHalf = Num\multiplyFloat(2.5);
        
        $a = 1;
        $b = 1;
        
        $a = $subsFive($a);
        $b = $subsTwoAndAHalf($b);

        $this->assertEquals(5, $a);
        $this->assertEquals(2.5, $b);

        $this->assertEquals(25, $subsFive($a));
        $this->assertEquals(6.25, $subsTwoAndAHalf($b));
    }

    public function testCanDivideByAndInto()
    {
        $divideBy2 = Num\divideBy(2);
        $divideInto2 = Num\divideInto(2);

        
        $a = 10;
        $b = 10;
        
        $a = $divideBy2($a);
        $b = $divideInto2($b);

        $this->assertEquals(5, $a);
        $this->assertEquals(0.2, $b);

        $this->assertEquals(2.5, $divideBy2($a));
        $this->assertEquals(10, $divideInto2($b));
    }

    public function testCanRemainderByAndInto()
    {
        $remainderBy2 = Num\remainderBy(2);
        $this->assertEquals(0, $remainderBy2(10)); // 10 / 2 = 5 
        $this->assertEquals(1, $remainderBy2(9)); // 9 / 2 = 4.5


        $remainderInto2 = Num\remainderInto(2);
        $this->assertEquals(2, $remainderInto2(10)); // 2 / 10 = 0.2
    }
}
