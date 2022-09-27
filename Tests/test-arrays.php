<?php

declare(strict_types=1);

require_once dirname(__FILE__, 2) . '/FunctionsLoader.php';

/**
 * Tests for the Array functions class.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 */

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\throwException;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;

use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

/**
 * ArrayFunction class.
 */
class ArrayFunctionTests extends TestCase
{
    /**
     * Random pollyfills
     */
    public function __call($method, $params)
    {
        switch ($method) {
            case 'assertIsArray':
                $this->assertTrue(is_array($params));
                break;
        }
    }

    public function setup(): void
    {
        FunctionsLoader::include();
    }

    public function testCanPushToHead(): void
    {
        $pushToHead = Arr\pushHead(array( 3, 4, 5, 6 ));
        $added2     = $pushToHead(2);
        $this->assertEquals(2, $added2[0]);

        $pushToHead = Arr\pushHead($added2);
        $added1     = $pushToHead(1);
        $this->assertEquals(1, $added1[0]);

        // As curried.
        $curried = Arr\pushHead(array( 3, 4, 5, 6 ))(2);
        $this->assertEquals(2, $curried[0]);
    }

    public function testCanPushToTail(): void
    {
        $pushToTail = Arr\pushTail(array( 1, 2, 3, 4 ));
        $added2     = $pushToTail(5);
        $this->assertEquals(5, $added2[4]);

        $pushToTail = Arr\pushTail($added2);
        $added1     = $pushToTail(6);
        $this->assertEquals(6, $added1[5]);

        // As curried.
        $curried = Arr\pushTail(array( 1, 2, 3, 4 ))(5);
        $this->assertEquals(5, $curried[4]);
    }

    public function testCanUseTail()
    {
        $names = array( 'Sam Smith', 'Barry Smith', 'Sam Power', 'Rebecca Smith' );
        $this->assertEquals('Rebecca Smith', Arr\tail($names));
        // Check returns null if empty.
        $this->assertNull(Arr\tail(array()));
    }

    public function testCanUseHead()
    {
        $names = array( 'Sam Smith', 'Barry Smith', 'Sam Power', 'Rebecca Smith' );
        $this->assertEquals('Sam Smith', Arr\head($names));
        // Check returns null if empty.
        $this->assertNull(Arr\head(array()));
    }

    public function testCanCompileArray(): void
    {
        $arrayCompiler = Arr\arrayCompiler();
        $arrayCompiler = $arrayCompiler('Hello');
        $arrayCompiler = $arrayCompiler('ERROR');
        $this->assertEquals('Hello', $arrayCompiler()[0]);
        $this->assertEquals('ERROR', $arrayCompiler()[1]);

        // As curried
        $arrayCompiler = $arrayCompiler('NO PLEASE GOD NO')('what')('more');
        $this->assertEquals('NO PLEASE GOD NO', $arrayCompiler()[2]);
        $this->assertEquals('what', $arrayCompiler()[3]);
        $this->assertEquals('more', $arrayCompiler()[4]);

        // Test can output on invoke.
        $this->assertTrue(is_array($arrayCompiler()));
    }

    public function testCanCompileArrayTyped()
    {
        $arrayCompiler = Arr\arrayCompilerTyped('is_string');
        $arrayCompiler = $arrayCompiler('Hello');
        $arrayCompiler = $arrayCompiler('ERROR');
        $arrayCompiler = $arrayCompiler(array( 'ERROR' ));
        $this->assertCount(2, $arrayCompiler());

        $arrayCompiler = $arrayCompiler('Hello')(1)(NAN)('so 4?');
        $this->assertCount(4, $arrayCompiler());
    }

    public function testCanGroupByArray(): void
    {
        $groupByPerfectNumbers = Arr\groupBy(
            function ($e) {
                return in_array($e, array( 1, 2, 3, 6, 12 )) ? 'Perfect' : 'Not Perfect';
            }
        );

        $grouped = $groupByPerfectNumbers(range(1, 12));

        $this->assertArrayHasKey('Perfect', $grouped);
        $this->assertArrayHasKey('Not Perfect', $grouped);
        $this->assertContains(1, $grouped['Perfect']);
        $this->assertContains(2, $grouped['Perfect']);
        $this->assertContains(3, $grouped['Perfect']);
        $this->assertContains(5, $grouped['Not Perfect']);
        $this->assertContains(7, $grouped['Not Perfect']);
        $this->assertContains(9, $grouped['Not Perfect']);
    }

    public function testCanChunk(): void
    {
        $chunkIn5     = Arr\chunk(5);
        $chunkedRange = $chunkIn5(range(1, 500));
        $this->assertCount(100, $chunkedRange);
        $this->assertCount(5, $chunkedRange[5]);
        $this->assertCount(5, $chunkedRange[78]);

        // Check that keys are retained.
        $chunkInPairs = Arr\chunk(2, true);
        $chunkedNames = $chunkInPairs(array( 'Jim', 'Bob', 'Gem', 'Fay' ));
        $this->assertCount(2, $chunkedNames);
        $this->assertEquals('Bob', $chunkedNames[0][1]);
        $this->assertEquals('Fay', $chunkedNames[1][3]);
    }

    public function testCanUseZip()
    {
        $array = array( 'a', 'b', 'c' );

        // Missing Key.
        $arrayMissing    = array( 'A', 'B' );
        $expectedMissing = array( array( 'a', 'A' ), array( 'b', 'B' ), array( 'c', 'FALLBACK' ) );
        $resultMissing   = Arr\zip($arrayMissing, 'FALLBACK')($array);
        $this->assertSame($resultMissing, $expectedMissing);

        // Matching length.
        $arrayFull    = array( 'A', 'B', 'C' );
        $expectedFull = array( array( 'a', 'A' ), array( 'b', 'B' ), array( 'c', 'C' ) );
        $resultFull   = Arr\zip($arrayFull, 'FALLBACK')($array);
        $this->assertSame($resultFull, $expectedFull);
    }

    public function testCanUseColumn(): void
    {
        $data = array(
            array(
                'id'   => 41,
                'name' => 'Bob',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 26,
                'name' => 'Jane',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 53,
                'name' => 'Sam',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 64,
                'name' => 'Bev',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 55,
                'name' => 'Joan',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 644,
                'name' => 'Bazza',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 66667,
                'name' => 'Duke',
                'foo'  => rand(1, 7),
            ),
            array(
                'id'   => 666668,
                'name' => 'Guybrush',
                'foo'  => rand(1, 7),
            ),
        );

        $getUsersNames = Arr\column('name', 'id');
        $this->assertCount(8, $getUsersNames($data));
        $this->assertEquals('Bob', $getUsersNames($data)[41]);
        $this->assertEquals('Bev', $getUsersNames($data)[64]);
        $this->assertEquals('Guybrush', $getUsersNames($data)[666668]);

        $getUsersRandoms = Arr\column('foo', 'name');
        $this->assertCount(8, $getUsersRandoms($data));
        $this->assertArrayHasKey('Bev', $getUsersRandoms($data));
        $this->assertArrayHasKey('Duke', $getUsersRandoms($data));
        $this->assertArrayNotHasKey(2, $getUsersRandoms($data));
        $this->assertArrayHasKey('Bazza', $getUsersRandoms($data));
    }

    public function testCanFlattenArray(): void
    {
        $array = array(
            1,
            2,
            array( 3, 4 ),
            array(
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
        $this->assertArrayHasKey(2, Arr\flattenByN(2)($array));
        $this->assertIsArray(Arr\flattenByN(1)($array)[8]);

        $this->assertArrayHasKey(9, Arr\flattenByN(2)($array));
        $this->assertIsArray(Arr\flattenByN(2)($array)[10]);

        $this->assertArrayHasKey(12, Arr\flattenByN(3)($array));
        $this->assertEquals(13, Arr\flattenByN(3)($array)[12]);

        // Check will fully flatten if no depth defined.
        $this->assertArrayHasKey(12, Arr\flattenByN()($array));
        $this->assertEquals(13, Arr\flattenByN()($array)[12]);
    }

    public function testCanUseReplace()
    {
        $base          = array( 'orange', 'banana', 'apple', 'raspberry' );
        $replacements  = array(
            0 => 'pineapple',
            4 => 'cherry',
        );
        $replacements2 = array( 0 => 'grape' );

        $replaceItems = Arr\replace($replacements, $replacements2);

        $this->assertIsArray($replaceItems($base));
        $this->assertEquals('grape', $replaceItems($base)[0]);
        $this->assertEquals('banana', $replaceItems($base)[1]);
        $this->assertEquals('apple', $replaceItems($base)[2]);
        $this->assertEquals('raspberry', $replaceItems($base)[3]);
        $this->assertEquals('cherry', $replaceItems($base)[4]);
    }
    public function testCanUseReplaceRecursive(): void
    {
        $base = array(
            'citrus'  => array( 'orange' ),
            'berries' => array( 'apple', 'raspberry' ),
        );

        $replacements = array(
            'citrus'  => array( 'pineapple' ),
            'berries' => array( 'blueberry' ),
        );

        $replaceItems = Arr\replaceRecursive($replacements);

        $this->assertIsArray($replaceItems($base));
        $this->assertArrayHasKey('citrus', $replaceItems($base));
        $this->assertArrayHasKey('berries', $replaceItems($base));
        $this->assertEquals('pineapple', $replaceItems($base)['citrus'][0]);
        $this->assertEquals('raspberry', $replaceItems($base)['berries'][1]);
    }

    public function testCanUseSumWhere()
    {
        $data = array(
            (object) array(
                'id'   => 1,
                'cost' => 12.55,
            ),
            (object) array(
                'id'   => 3,
                'cost' => 2.45,
            ),
            (object) array(
                'id'   => 34,
                'cost' => 99.99,
            ),
            (object) array(
                'id'   => 12,
                'cost' => 100.01,
            ),
        );

        $costSum = Arr\sumWhere(
            function ($e) {
                return $e->cost;
            }
        );

        $this->assertEquals(215.00, $costSum($data));
    }



    public function testCanSortArray(): void
    {
        $array         = array( 'b', 'c', 'a', 'f', 'd', 'z', 'g' );
        $sortAsStrings = Arr\sort(SORT_STRING);

        $sortedArray = $sortAsStrings($array);
        $this->assertEquals('a', $sortedArray[0]);
        $this->assertEquals('b', $sortedArray[1]);
        $this->assertEquals('c', $sortedArray[2]);
        $this->assertEquals('z', $sortedArray[6]);

        // Check hasnt changed inital array.
        $this->assertEquals('c', $array[1]);
        $this->assertEquals('a', $array[2]);
    }

    public function testCanDoUasortOnArray(): void
    {
        $array = array(
            'a' => 4,
            'b' => 8,
            'c' => -1,
            'd' => -9,
            'e' => 2,
            'f' => 5,
            'g' => 3,
            'h' => -4,
        );

        $lowestFirstCallback = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        };

        $sortByLowest = Arr\uasort($lowestFirstCallback);

        // Still retains the key.
        $sortedArray = $sortByLowest($array);

        $this->assertEquals(-9, $sortedArray['d']);
        $this->assertEquals(-9, array_values($sortedArray)[0]);

        $this->assertEquals(2, $sortedArray['e']);
        $this->assertEquals(2, array_values($sortedArray)[3]);

        $this->assertEquals(8, $sortedArray['b']);
        $this->assertEquals(8, array_values($sortedArray)[7]);
    }


    public function testCanDoUsortOnArray(): void
    {
        $array = array( 3, 2, 5, 6, 1 );

        $lowestFirstCallback = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        };

        $sortByLowest = Arr\usort($lowestFirstCallback);

        // Still retains the key.
        $sortedArray = $sortByLowest($array);

        $this->assertEquals(1, $sortedArray[0]);
        $this->assertEquals(2, $sortedArray[1]);
        $this->assertEquals(5, $sortedArray[3]);
        $this->assertEquals(6, $sortedArray[4]);
    }

    public function testCanPartitionTable()
    {
        $isEven = function ($e) {
            return $e % 2 === 0;
        };

        $sortByOddEven = Arr\partition($isEven);

        $data = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

        $sorted = $sortByOddEven($data);
        $this->assertCount(5, $sorted[0]);
        $this->assertCount(5, $sorted[1]);

        $this->assertContains(2, $sorted[1]);
        $this->assertContains(4, $sorted[1]);
        $this->assertContains(8, $sorted[1]);
        $this->assertContains(3, $sorted[0]);
        $this->assertContains(7, $sorted[0]);
    }

    public function testCanDoToString(): void
    {
        $source = array(
            'hi',
            'there',
            'how',
            'are',
            'you',
            3,
            12.7,
            true,
            null,
        );

        $noSpacing   = Arr\toString();
        $withSpacing = Arr\toString(' ');

        $this->assertEquals('hitherehowareyou312.71', $noSpacing($source));
        $this->assertEquals('hi there how are you 3 12.7 1 ', $withSpacing($source));
    }

    /** @testdox It should be possible to create a function which allows for calling scan on a passed array */
    public function testScanL(): void
    {
        $initial  = array( 1, 2, 3, 4, 5 );
        $expected = array( 0, 1, 3, 6, 10, 15 );

        $scan = Arr\scan(
            function ($carry, $item) {
                return $carry + $item;
            },
            0
        );

        $this->assertEquals($expected, $scan($initial));

        // Get a ruuning max value using scan.
        $max = Arr\scan(
            function ($carry, $item) {
                return max($carry, $item);
            },
            0
        );

        $data = [1,3,4,1,5,9,2,6,5,3,5,8,9,7,9];
        $expected = [0,1,3,4,4,5,9,9,9,9,9,9,9,9,9,9];
        $this->assertEquals($expected, $max($data));
    }

    /** @testdox It should be possible to create a function which allows for calling scanr on a passed array.     */
    public function testScanR(): void
    {
        $initial  = array( 1, 2, 3 );
        $expected = array( 6, 5, 3, 0 );

        $scanR = Arr\scanR(
            function ($carry, $item) {
                return $carry + $item;
            },
            0
        );

        $this->assertEquals($expected, $scanR($initial));
    }

    /** @testdox It should be possible to create a function, pre defined to perform fold/reduce on a given array. */
    public function testFold(): void
    {
        $sumMe = [1,2,3,4,5,6,7,8,9,10];
        $biggest = [1,5,6,7,10,2];

        $findSum = Arr\fold(function (int $carry, int $current) {
            return $current + $carry;
        }, 0);
        $findBiggest = Arr\fold(function (int $carry, int $current) {
            return max($current, $carry);
        }, 0);

        $this->assertEquals(55, $findSum($sumMe));
        $this->assertEquals(10, $findBiggest($biggest));
    }

    /** @testdox  It should be possible to create a function, pre defined to perform fold/reduce on a given array in reverse order. */
    public function testFoldR(): void
    {
        $data = ['a', 'b', 'c', 'd'];
        $joinArray = Arr\foldR(function (string $carry, string $value): string {
            return $carry.$value;
        }, '');
        $this->assertEquals('dcba', $joinArray($data));
    }

    /** @testdox It should be possible to create a function will allows doing fold/reduce with access the array key also. */
    public function testFoldKeys(): void
    {
        $data = [1 => 1, 3 => 3, 2 => 2, 5 => 5, 4 => 4, 0 => 0];
        $expected = ["key-1::value-1", "key-3::value-3", "key-2::value-2", "key-5::value-5", "key-4::value-4", "key-0::value-0"];

        $foldWithKeys = Arr\foldKeys(function (array $carry, int $key, int $value): array {
            $carry[] = "key-{$key}::value-{$value}";
            return $carry;
        });

        $this->assertEquals($expected, $foldWithKeys($data));
    }

    /** @testdox It should be possible to take n number of elements from an array using Arr\take() */
    public function testTake(): void
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $expected = [1, 2, 3, 4, 5];

        $take5 = Arr\take(5);
        $this->assertEquals($expected, $take5($data));

        $take3 = Arr\take(3);
        $this->assertEquals([1, 2, 3], $take3($data));

        $take0 = Arr\take(0);
        $this->assertEquals([], $take0($data));

        $takeAll = Arr\take(count($data));
        $this->assertEquals($data, $takeAll($data));
    }

    /** @testdox Passing a negative number to take should result in an InvalidArgumentException being thrown */
    public function testTakeThrowsExceptionOnNegativeNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $take = Arr\take(-1);
        $take([]);
    }

    /** @testdox It should be possible to take n number of elements from an array using Arr\takeLast() */
    public function testTakeLast(): void
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $expected = [5, 6, 7, 8, 9];

        $take5 = Arr\takeLast(5);
        $this->assertEquals($expected, $take5($data));

        $take3 = Arr\takeLast(3);
        $this->assertEquals([7, 8, 9], $take3($data));

        $take0 = Arr\takeLast(0);
        $this->assertEquals([], $take0($data));

        $takeAll = Arr\takeLast(count($data));
        $this->assertEquals($data, $takeAll($data));
    }

    /** @testdox Passing a negative number to take should result in an InvalidArgumentException being thrown */
    public function testTakeLastThrowsExceptionOnNegativeNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $take = Arr\takeLast(-1);
        $take([]);
    }

    /** @testdox It should be possible return an array which includes all values until the callback returns true using Arr\takeUntil() */
    public function testTakeUntil(): void
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $expected = [1, 2, 3, 4, 5, 6, 7, 8];

        $takeUntil = Arr\takeUntil(function ($value) {
            return $value > 8;
        });
        $this->assertEquals($expected, $takeUntil($data));

        $takeUntil = Arr\takeUntil(function ($value) {
            return $value < 10;
        });
        $this->assertEquals([], $takeUntil($data));

        $takeUntil = Arr\takeUntil(function ($value) {
            return $value > 100;
        });
        $this->assertEquals($data, $takeUntil($data));
    }

    /** @testdox It should be possible to return an array which includes all values until the callback returns false using Arr\takeWhile() */
    public function testTakeWhile(): void
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        $takeWhile = Arr\takeWhile(function ($value) {
            return $value < 10;
        });
        $this->assertEquals($expected, $takeWhile($data));

        $takeWhile = Arr\takeWhile(function ($value) {
            return $value < 5;
        });
        $this->assertEquals([1,2,3,4], $takeWhile($data));

        $takeWhile = Arr\takeWhile(function ($value) {
            return $value < 100;
        });
        $this->assertEquals($data, $takeWhile($data));
    }

    /** @testdox It should be possible to use Map() and have access to key and value. */
    public function testMapWithKeys(): void
    {
        $data = ['a' => 'pple', 'b' => 'anana', 'c' => 'arrot'];
        $expected = ['apple', 'banana', 'carrot'];

        $map = Arr\mapWithKey(function (string $value, string $key) {
            return $key . $value;
        });
        $this->assertEquals($expected, $map($data));
    }
}
