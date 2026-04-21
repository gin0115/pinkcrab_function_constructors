<?php

declare(strict_types=1);

require_once dirname(__FILE__, 3) . '/FunctionsLoader.php';

/**
 * Tests for all array filter based functions.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 */
use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

/**
 * ArrayFunction class.
 */
class ArrayFilterAndMapTests extends TestCase
{
    public function setup(): void
    {
        FunctionsLoader::include();
    }

    /**
     * Helper: wraps an array in a one-shot Generator so tests can exercise the
     * iterable branch of the Arrays\* fns.
     *
     * @param array<int|string, mixed> $data
     * @return \Generator<int|string, mixed>
     */
    private static function gen(array $data): \Generator
    {
        foreach ($data as $k => $v) {
            yield $k => $v;
        }
    }

    /**
     * Helper: Generator that throws the moment the consumer asks for the
     * element at index $throwOn. Used to prove a lazy fn does NOT consume
     * past its short-circuit point.
     *
     * @param array<int|string, mixed> $data
     */
    private static function genThrowAt(array $data, int $throwOn): \Generator
    {
        $i = 0;
        foreach ($data as $k => $v) {
            if ($i++ === $throwOn) {
                throw new \RuntimeException('Generator consumed past the short-circuit point');
            }
            yield $k => $v;
        }
    }

    public function testCanUseFilter()
    {
        $names = array( 'James Smith', 'Betty Jones', 'Sam Power', 'Rebecca Smith' );

        $isASmith = Arr\filter(Str\contains('Smith'));

        $this->assertContains('James Smith', $isASmith($names));
        $this->assertContains('Rebecca Smith', $isASmith($names));
        $this->assertNotContains('Betty Jones', $isASmith($names));
        $this->assertNotContains('Sam Power', $isASmith($names));
    }

    public function testCanUseFilterKey()
    {
        $names = array(
            'name10' => 'James Smith',
            'name20' => 'Betty Jones',
            'name21' => 'Sam Power',
            'name38' => 'Rebecca Smith',
        );

        $isASmith = Arr\filterKey(Str\contains('name2'));

        $this->assertNotContains('James Smith', $isASmith($names));
        $this->assertNotContains('Rebecca Smith', $isASmith($names));
        $this->assertContains('Betty Jones', $isASmith($names));
        $this->assertContains('Sam Power', $isASmith($names));
    }

    public function testCanFilterOr()
    {
        $names = array( 'James Smith', 'Betty Jones', 'Sam Power', 'Rebecca Smith' );

        $isSmithOrJones = Arr\filterOr(
            Str\contains('Smith'),
            Str\contains('Jones')
        );

        $this->assertContains('James Smith', $isSmithOrJones($names));
        $this->assertContains('Rebecca Smith', $isSmithOrJones($names));
        $this->assertContains('Betty Jones', $isSmithOrJones($names));
        $this->assertNotContains('Sam Power', $isSmithOrJones($names));
    }

    public function testCanFilterAnd()
    {
        $names = array( 'James Smith', 'Betty Jones', 'Sam Power', 'Rebecca Smith' );

        $isSamAndPower = Arr\filterAnd(
            Str\contains('Power'),
            Str\contains('Sam')
        );

        $this->assertNotContains('James Smith', $isSamAndPower($names));
        $this->assertNotContains('Rebecca Smith', $isSamAndPower($names));
        $this->assertNotContains('Betty Jones', $isSamAndPower($names));
        $this->assertContains('Sam Power', $isSamAndPower($names));
    }

    public function testCanFilterLast(): void
    {
        $lastEven = Arr\filterLast(
            function ($e) {
                return $e % 2 === 0;
            }
        );
        $this->assertEquals(6, $lastEven(array( 1, 3, 4, 6 )));
        $this->assertEquals(8, $lastEven(array( 1, 3, 5, 7, 9, 6, 8 )));
        $this->assertNull($lastEven(array( 1, 3, 3 )));
    }

    public function testCanFilterFirst(): void
    {
        $firstEven = Arr\filterFirst(
            function ($e) {
                return $e % 2 === 0;
            }
        );
        $this->assertEquals(6, $firstEven(array( 1, 3, 6 )));
        $this->assertEquals(8, $firstEven(array( 1, 3, 5, 7, 9, 8 )));
        $this->assertNull($firstEven(array( 1, 3, 3 )));
    }

    public function testCanFilterMap()
    {
        $nums               = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
        $doubledEvenNumbers = Arr\filterMap(
            function ($a) {
                // is even
                return $a % 2 === 0;
            },
            function ($b) {
                // double it
                return $b * 2;
            }
        );

        $this->assertEquals(4, $doubledEvenNumbers($nums)[1]);
        $this->assertEquals(8, $doubledEvenNumbers($nums)[3]);
        $this->assertEquals(12, $doubledEvenNumbers($nums)[5]);
        $this->assertEquals(16, $doubledEvenNumbers($nums)[7]);
        $this->assertEquals(20, $doubledEvenNumbers($nums)[9]);

        $this->assertArrayNotHasKey(0, $doubledEvenNumbers($nums));
        $this->assertArrayNotHasKey(2, $doubledEvenNumbers($nums));
        $this->assertArrayNotHasKey(4, $doubledEvenNumbers($nums));
        $this->assertArrayNotHasKey(6, $doubledEvenNumbers($nums));
        $this->assertArrayNotHasKey(8, $doubledEvenNumbers($nums));
    }

    /** @testdox It should be possible to check if all values of an array pass a filter */
    public function testCanFilterAll()
    {
        $nums = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
        $this->assertTrue(Arr\filterAll('is_numeric')($nums));
        $this->assertFalse(
            Arr\filterAll(
                function ($a) {
                    return $a !== 2;
                }
            )($nums)
        );
    }

    /** @testdox It should be possible to check if any value of an array passes a filter */
    public function testCanFilterAny()
    {
        $nums = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
        $this->assertTrue(Arr\filterAny('is_numeric')($nums));
        $this->assertTrue(
            Arr\filterAny(
                function ($a) {
                    return $a === 2;
                }
            )($nums)
        );
        $this->assertFalse(
            Arr\filterAny(
                function ($a) {
                    return $a === 20;
                }
            )($nums)
        );
    }

    /** @testdox filterFirst() should accept a Generator and return the first match without consuming the source further. */
    public function testFilterFirstAcceptsGeneratorAndShortCircuits(): void
    {
        // First match is 'b'. Source throws at index 2 — filterFirst must not reach it.
        $src = self::genThrowAt(array('a', 'b', 'c'), 2);
        $this->assertSame('b', Arr\filterFirst(function ($v) {
            return $v === 'b';
        })($src));
    }

    /** @testdox filterAll() should accept a Generator and short-circuit on the first non-matching value. */
    public function testFilterAllAcceptsGeneratorAndShortCircuitsOnFalse(): void
    {
        // Values 1, 2 are all truthy; value at index 2 (-1) is negative.
        // Source throws at index 3 — filterAll returns false at index 2 and never advances.
        $src = self::genThrowAt(array(1, 2, -1, 3), 3);
        $this->assertFalse(Arr\filterAll(function ($v) {
            return $v > 0;
        })($src));
    }

    /** @testdox filterAny() should accept a Generator and short-circuit on the first matching value. */
    public function testFilterAnyAcceptsGeneratorAndShortCircuitsOnTrue(): void
    {
        // Value at index 1 matches. Source throws at index 2 — filterAny returns
        // true at index 1 and never advances.
        $src = self::genThrowAt(array(1, 2, 3), 2);
        $this->assertTrue(Arr\filterAny(function ($v) {
            return $v === 2;
        })($src));
    }

    public function testCanMapArrayKeys(): void
    {
        $origArray = array(
            'a' => 'aa',
            'b' => 'bb',
            'c' => 'cc',
        );

        $capitaliseKeys = Arr\mapKey('strtoupper');
        $capArray       = $capitaliseKeys($origArray);
        $this->assertArrayHasKey('A', $capArray);
        $this->assertArrayNotHasKey('a', $capArray);
        // Check inital array the same.
        $this->assertArrayHasKey('a', $origArray);
        $this->assertArrayNotHasKey('A', $origArray);
    }

    public function testCanMapWithData(): void
    {
        $array         = range(1, 10);
        $mapWithCheese = Arr\mapWith(
            function ($e, $cheese) {
                return "$e loves $cheese";
            },
            'CHEESE!!!!!'
        );
        $this->assertEquals('3 loves CHEESE!!!!!', $mapWithCheese($array)[2]);
        $this->assertEquals('6 loves CHEESE!!!!!', $mapWithCheese($array)[5]);
        $this->assertEquals('9 loves CHEESE!!!!!', $mapWithCheese($array)[8]);

        $mapWithMORECheese = Arr\mapWith(
            function ($e, $cheese, $more) {
                return "$e loves $cheese.......$more";
            },
            'CHEESE!!!!!',
            'YOU HEAR ME!'
        );
        $this->assertEquals('3 loves CHEESE!!!!!.......YOU HEAR ME!', $mapWithMORECheese($array)[2]);
        $this->assertEquals('6 loves CHEESE!!!!!.......YOU HEAR ME!', $mapWithMORECheese($array)[5]);
        $this->assertEquals('9 loves CHEESE!!!!!.......YOU HEAR ME!', $mapWithMORECheese($array)[8]);
    }

    public function testCanMapArray(): void
    {
        $origArray = array(
            'a' => 'aa',
            'b' => 'bb',
            'c' => 'cc',
        );

        $capitaliseVals = Arr\map('strtoupper');
        $capArray       = $capitaliseVals($origArray);
        $this->assertEquals('AA', $capArray['a']);
        $this->assertNotEquals('aa', $capArray['a']);
        // Check inital array the same.
        $this->assertEquals('aa', $origArray['a']);
        $this->assertNotEquals('AA', $origArray['a']);
    }

    /** @testdox map() should still return an array when the input is an array (back-compat). */
    public function testMapReturnsArrayForArrayInput(): void
    {
        $result = Arr\map(function ($x) {
            return $x * 2;
        })(array(1, 2, 3));
        $this->assertIsArray($result);
        $this->assertSame(array(2, 4, 6), $result);
    }

    /** @testdox map() should return a lazy Generator when the input is a Generator, yielding transformed values with keys preserved. */
    public function testMapReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array('a' => 1, 'b' => 2, 'c' => 3));
        $result = Arr\map(function ($x) {
            return $x * 10;
        })($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array('a' => 10, 'b' => 20, 'c' => 30), iterator_to_array($result));
    }

    /** @testdox map() over an empty Generator should yield nothing (empty Generator returned). */
    public function testMapEmptyGeneratorYieldsNothing(): void
    {
        $empty  = self::gen(array());
        $result = Arr\map(function ($x) {
            return $x;
        })($empty);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array(), iterator_to_array($result));
    }

    /** @testdox map() over a Generator must stay lazy \u2014 elements past the consumer's demand should not be pulled from the source. */
    public function testMapIsLazyOverGenerator(): void
    {
        // Generator throws the moment index 2 is requested. If map() were eager
        // it would materialise the whole thing and throw during the initial call.
        $src    = self::genThrowAt(array('a', 'b', 'c', 'd'), 2);
        $result = Arr\map('strtoupper')($src);

        // Pulling only the first two items must not trip the throw at index 2.
        $first  = null;
        $second = null;
        foreach ($result as $i => $v) {
            if ($first === null) {
                $first = $v;
                continue;
            }
            $second = $v;
            break; // consumer stops here; source should NOT be advanced further
        }
        $this->assertSame('A', $first);
        $this->assertSame('B', $second);
    }

    /** @testdox filter() should return a lazy Generator preserving keys when given a Generator. */
    public function testFilterReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4));
        $result = Arr\filter(function ($x) {
            return $x % 2 === 0;
        })($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array('b' => 2, 'd' => 4), iterator_to_array($result));
    }

    /** @testdox filterKey() should return a lazy Generator filtering on keys when given a Generator. */
    public function testFilterKeyReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array('keep_a' => 1, 'drop_b' => 2, 'keep_c' => 3));
        $result = Arr\filterKey(function ($k) {
            return strpos($k, 'keep_') === 0;
        })($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array('keep_a' => 1, 'keep_c' => 3), iterator_to_array($result));
    }

    /** @testdox filterAnd() should return a lazy Generator applying an AND group of predicates to a Generator source. */
    public function testFilterAndReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array(1, 2, 3, 4, 5, 6));
        $result = Arr\filterAnd(
            function ($x) {
                return $x > 2;
            },
            function ($x) {
                return $x % 2 === 0;
            }
        )($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array(3 => 4, 5 => 6), iterator_to_array($result));
    }

    /** @testdox filterOr() should return a lazy Generator applying an OR group of predicates to a Generator source. */
    public function testFilterOrReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array(1, 2, 3, 4, 5));
        $result = Arr\filterOr(
            function ($x) {
                return $x === 1;
            },
            function ($x) {
                return $x === 5;
            }
        )($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array(0 => 1, 4 => 5), iterator_to_array($result));
    }

    /** @testdox filterMap() should return a lazy Generator filter-then-mapping over a Generator source. */
    public function testFilterMapReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array(1, 2, 3, 4, 5));
        $result = Arr\filterMap(
            function ($x) {
                return $x % 2 === 0;
            },
            function ($x) {
                return $x * 10;
            }
        )($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array(1 => 20, 3 => 40), iterator_to_array($result));
    }

    /** @testdox mapKey() should return a lazy Generator transforming keys when given a Generator. */
    public function testMapKeyReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array('a' => 1, 'b' => 2));
        $result = Arr\mapKey('strtoupper')($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array('A' => 1, 'B' => 2), iterator_to_array($result));
    }

    /** @testdox mapWith() should return a lazy Generator applying the callback with extra data when given a Generator. */
    public function testMapWithReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array('a' => 1, 'b' => 2));
        $result = Arr\mapWith(function ($v, $suffix) {
            return "{$v}{$suffix}";
        }, '!')($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array('a' => '1!', 'b' => '2!'), iterator_to_array($result));
    }

    /** @testdox mapWithKey() should return a lazy Generator supplying (value, key) to the callback; keys re-index to match the array path. */
    public function testMapWithKeyReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array('a' => 1, 'b' => 2));
        $result = Arr\mapWithKey(function ($v, $k) {
            return "{$k}:{$v}";
        })($src);

        $this->assertInstanceOf(\Generator::class, $result);
        // array path returns [0 => 'a:1', 1 => 'b:2'] because array_map with
        // multiple arrays re-indexes — Generator path matches that shape.
        $this->assertSame(array(0 => 'a:1', 1 => 'b:2'), iterator_to_array($result));
    }

    public function testCanUseFlatMap(): void
    {
        $array = array(
            0,
            1,
            2,
            array( 3, 4 ),
            array(
                array(),
                5,
                6,
                7,
                8,
                array(
                    9,
                    10,
                    array( 11, 12, 13 ),
                ),
            ),
        );

        $doubleNFlattenIt = Arr\flatMap(
            function ($e) {
                return $e * 2;
            }
        );
        $this->assertEquals(24, $doubleNFlattenIt($array)[12]);
        $this->assertEquals(20, $doubleNFlattenIt($array)[10]);
        $this->assertEquals(10, $doubleNFlattenIt($array)[5]);
        $this->assertEquals(16, $doubleNFlattenIt($array)[8]);
        $this->assertEquals(4, $doubleNFlattenIt($array)[2]);
    }

    /** @testdox flatMap() should return a lazy Generator that recursively flattens nested arrays in a Generator source, applying the callback to leaf values. */
    public function testFlatMapReturnsGeneratorForGeneratorInput(): void
    {
        $src    = self::gen(array(1, array(2, array(3, 4)), 5));
        $result = Arr\flatMap(function ($x) {
            return $x * 10;
        })($src);

        $this->assertInstanceOf(\Generator::class, $result);
        $this->assertSame(array(10, 20, 30, 40, 50), iterator_to_array($result, false));
    }

    /** @testdox flatMap() with a depth limit should respect it when recursing into a Generator source. */
    public function testFlatMapRespectsDepthLimitOverGenerator(): void
    {
        // Depth 1: top-level nested arrays flatten one level; deeper arrays stay as arrays.
        $src    = self::gen(array(1, array(2, array(3, 4)), 5));
        $result = Arr\flatMap(function ($x) {
            return $x * 10;
        }, 1)($src);

        $this->assertSame(array(10, 20, array(3, 4), 50), iterator_to_array($result, false));
    }
}
