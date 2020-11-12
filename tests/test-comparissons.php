<?php

declare(strict_types=1);

require_once(dirname(__FILE__) . '/ComparissonCases.php');
require_once dirname(__FILE__, 2) . '/FunctionsLoader.php';

use TestStub\ComparissonCases;
use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\Comparisons as Comp;

/**
 * Tests for general purpose functions.
 */
class ComparissonFunctionTest extends TestCase
{

    public function setup(): void
    {
        FunctionsLoader::include();
    }

    public function testCanFindEqualToString(): void
    {
        foreach (ComparissonCases::stringComparisson('pass') as $condition) {
            $this->assertTrue(
                Comp\isEqualTo($condition['expected'])($condition['test']),
                "Failed on {$condition['expected']} = {$condition['test']}"
            );
        }
        foreach (ComparissonCases::stringComparisson('fail') as $condition) {
            $this->assertFalse(
                Comp\isEqualTo($condition['expected'])($condition['test']),
                "Failed on {$condition['expected']} != {$condition['test']}"
            );
        }
    }

    public function testCanFindEqualToInteger(): void
    {
        foreach (ComparissonCases::integerComparisons('pass') as $condition) {
            $this->assertTrue(
                Comp\isEqualTo($condition['expected'])($condition['test']),
                "Failed on {$condition['expected']} = {$condition['test']}"
            );
        }
        foreach (ComparissonCases::integerComparisons('fail') as $condition) {
            $this->assertFalse(
                Comp\isEqualTo($condition['expected'])($condition['test']),
                "Failed on {$condition['expected']} != {$condition['test']}"
            );
        }
    }

    public function testCanFindEqualToFloat(): void
    {
        foreach (ComparissonCases::floatComparisons('pass') as $condition) {
            $this->assertTrue(
                Comp\isEqualTo($condition['expected'])($condition['test']),
                "Failed on {$condition['expected']} = {$condition['test']}"
            );
        }
        foreach (ComparissonCases::floatComparisons('fail') as $condition) {
            $this->assertFalse(
                Comp\isEqualTo($condition['expected'])($condition['test']),
                "Failed on {$condition['expected']} != {$condition['test']}"
            );
        }
    }

    public function testCanFindEqualToArray(): void
    {
        foreach (ComparissonCases::arrayComparisons('pass') as $condition) {
            $this->assertTrue(
                Comp\isEqualTo($condition['expected'])($condition['test'])
            );
        }
        foreach (ComparissonCases::arrayComparisons('fail') as $condition) {
            $this->assertFalse(
                Comp\isEqualTo($condition['expected'])($condition['test'])
            );
        }
    }

    public function testCanFindEqualToObject(): void
    {
        foreach (ComparissonCases::objectComparisons('pass') as $condition) {
            $this->assertTrue(
                Comp\isEqualTo($condition['expected'])($condition['test'])
            );
        }
        foreach (ComparissonCases::objectComparisons('fail') as $condition) {
            $this->assertFalse(
                Comp\isEqualTo($condition['expected'])($condition['test'])
            );
        }
    }

    // Test notEqual with just 1 set, its just !isEqualTo()()
    public function testCanNotFindEqualToObject(): void
    {
        foreach (ComparissonCases::objectComparisons('fail') as $condition) {
            $this->assertTrue(
                Comp\isNotEqualTo($condition['expected'])($condition['test'])
            );
        }
        foreach (ComparissonCases::objectComparisons('pass') as $condition) {
            $this->assertFalse(
                Comp\isNotEqualTo($condition['expected'])($condition['test'])
            );
        }
    }

    public function testCanDoGreaterThan(): void
    {
        $this->assertTrue(Comp\isGreaterThan(12)(10));
        $this->assertTrue(Comp\isGreaterThan(99.99)(98));
        $this->assertFalse(Comp\isGreaterThan(99.99)(100));
        $this->assertFalse(Comp\isGreaterThan(1)(1.0000001));
    }

    public function testCanDoLessThan(): void
    {
        $this->assertFalse(Comp\isLessThan(12)(10));
        $this->assertFalse(Comp\isLessThan(99.99)(98));
        $this->assertTrue(Comp\isLessThan(99.99)(100));
        $this->assertTrue(Comp\isLessThan(1)(1.0000001));
    }

    public function testCanCompareScalarTypeGroup(): void
    {
        foreach (ComparissonCases::scalarComparisons('pass') as $condition) {
            $this->assertTrue(
                call_user_func_array(
                    'PinkCrab\FunctionConstructors\Comparisons\sameScalar',
                    $condition
                )
            );
        }
        foreach (ComparissonCases::scalarComparisons('fail') as $condition) {
            $this->assertFalse(
                call_user_func_array(
                    'PinkCrab\FunctionConstructors\Comparisons\sameScalar',
                    $condition
                )
            );
        }
    }


    public function testIsScala(): void
    {
        foreach (
            array(
            'integer' => 12,
            'double'  => 12.5,
            'boolean' => false,
            'string'  => 'string',
            'array'   => array(),
            'object'  => (object) array(),
            ) as $type => $expression
        ) {
            $callback = Comp\isScalar($type);

            $this->assertTrue(
                $callback($expression)
            );
        }
    }

    /** OR */

    public function testCanFindEqualToOrString(): void
    {
        foreach (ComparissonCases::equalToOrComparisson('pass') as $condition) {
            $this->assertTrue(
                Comp\isEqualIn($condition['needles'])($condition['haystack'])
            );
        }

        foreach (ComparissonCases::equalToOrComparisson('fail') as $condition) {
            $this->assertFalse(
                Comp\isEqualIn($condition['needles'])($condition['haystack'])
            );
        }
    }

    /** AND */

    public function testCanGroupAndConditionalsWithArrays(): void
    {

        foreach (ComparissonCases::groupSingleAndComparisonsArrays('pass') as $condition) {
            $this->assertEquals(
                $condition['expected'],
                array_values(call_user_func($condition['function'], $condition['array']))
            );
        }

        foreach (ComparissonCases::groupSingleAndComparisonsArrays('fail') as $condition) {
            $this->assertNotEquals(
                $condition['expected'],
                array_values(call_user_func($condition['function'], $condition['array']))
            );
        }
    }

    public function testCanGroupAndConditionalsWithString(): void
    {

        foreach (ComparissonCases::groupSingleAndComparisonsStrings('pass') as $condition) {
            foreach ($condition['value'] as $value) {
                $this->assertTrue($condition['function']($value));
            }
        }

        foreach (ComparissonCases::groupSingleAndComparisonsStrings('fail') as $condition) {
            foreach ($condition['value'] as $value) {
                $this->assertFalse($condition['function']($value));
            }
        }
    }

    public function testCanGroupGroupsOfConditionalsComparisonsMixed()
    {

        foreach (ComparissonCases::groupedAndOrComparissonMixed('pass') as $condition) {
            foreach ($condition['value'] as $value) {
                $this->assertTrue($condition['function']($value), $value);
            }
        }

        foreach (ComparissonCases::groupedAndOrComparissonMixed('fail') as $condition) {
            foreach ($condition['value'] as $value) {
                $this->assertFalse($condition['function']($value));
            }
        }
    }

    public function testCanMatchBooleans(): void
    {
        $this->assertTrue(Comp\allTrue(true, true, 1 == 1, 4 === ( 3 + 1 ))); // t
        $this->assertFalse(Comp\allTrue(true, true, 1 == 3, 4 === ( 3 + 1 ))); // f
        $this->assertTrue(Comp\someTrue(true, true, 1 == 3, 4 === ( 3 + 1 ))); //t
        $this->assertTrue(! Comp\allTrue(false, false, 1 == 3, 4 === ( 3 * 1 ))); //t
        $this->assertFalse(Comp\allTrue(false, false, 1 == 3, 4 === ( 3 * 1 ))); //t
        $this->assertFalse(Comp\someTrue(false, false, 1 == 3, 4 === ( 3 * 1 ))); //f
    }

    public function testCanCheckIsTrue(): void
    {
        $this->assertTrue(Comp\isTrue(true));
        $this->assertTrue(Comp\isTrue((bool)1));
        $this->assertFalse(Comp\isTrue(false));
        $this->assertFalse(Comp\isTrue(0));
        $this->assertFalse(Comp\isTrue([0]));
    }

    public function testCanCheckIsFalse(): void
    {
        $this->assertTrue(Comp\isFalse(false));
        $this->assertTrue(Comp\isFalse((bool)0));
        $this->assertFalse(Comp\isFalse(true));
        $this->assertFalse(Comp\isFalse(0));
        $this->assertFalse(Comp\isFalse([0]));
    }
}



// ZZAT00109661
