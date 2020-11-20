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

        $pushToHead = Arr\pushHead(array(3, 4, 5, 6));
        $added2     = $pushToHead(2);
        $this->assertEquals(2, $added2[0]);

        $pushToHead = Arr\pushHead($added2);
        $added1     = $pushToHead(1);
        $this->assertEquals(1, $added1[0]);

        // As curried.
        $curried = Arr\pushHead(array(3, 4, 5, 6))(2);
        $this->assertEquals(2, $curried[0]);
    }

    public function testCanPushToTail(): void
    {

        $pushToTail = Arr\pushTail(array(1, 2, 3, 4));
        $added2     = $pushToTail(5);
        $this->assertEquals(5, $added2[4]);

        $pushToTail = Arr\pushTail($added2);
        $added1     = $pushToTail(6);
        $this->assertEquals(6, $added1[5]);

        // As curried.
        $curried = Arr\pushTail(array(1, 2, 3, 4))(5);
        $this->assertEquals(5, $curried[4]);
    }

    public function testCanUseTail()
    {
        $names = ["Sam Smith", "Barry Smith", "Sam Power", "Rebecca Smith"];
        $this->assertEquals('Rebecca Smith', Arr\tail($names));
        // Check returns null if empty.
        $this->assertNull(Arr\tail([]));
    }

    public function testCanUseHead()
    {
        $names = ["Sam Smith", "Barry Smith", "Sam Power", "Rebecca Smith"];
        $this->assertEquals('Sam Smith', Arr\head($names));
        // Check returns null if empty.
        $this->assertNull(Arr\head([]));
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
        $arrayCompiler = $arrayCompiler(['ERROR']);
        $this->assertCount(2, $arrayCompiler());

        $arrayCompiler = $arrayCompiler('Hello')(1)(NAN)("so 4?");
        $this->assertCount(4, $arrayCompiler());
    }

    public function testCanGroupByArray(): void
    {

        $groupByPerfectNumbers = Arr\groupBy(
            function ($e) {
                return in_array($e, array(1, 2, 3, 6, 12)) ? 'Perfect' : 'Not Perfect';
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
        $chunkedNames = $chunkInPairs(array('Jim', 'Bob', 'Gem', 'Fay'));
        $this->assertCount(2, $chunkedNames);
        $this->assertEquals('Bob', $chunkedNames[0][1]);
        $this->assertEquals('Fay', $chunkedNames[1][3]);
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
            array(3, 4),
            array(
                5,
                6,
                7,
                8,
                array(
                    9,
                    10,
                    array(11, 12, 13),
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
        $base = array("orange", "banana", "apple", "raspberry");
        $replacements = array(0 => "pineapple", 4 => "cherry");
        $replacements2 = array(0 => "grape");

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
            'citrus'  => array('orange'),
            'berries' => array('apple', 'raspberry'),
        );

        $replacements = array(
            'citrus'  => array('pineapple'),
            'berries' => array('blueberry'),
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
        $data = [
            (object)[
                'id' => 1,
                'cost' => 12.55
            ],
            (object)[
                'id' => 3,
                'cost' => 2.45
            ],
            (object)[
                'id' => 34,
                'cost' => 99.99
            ],
            (object)[
                'id' => 12,
                'cost' => 100.01
            ],
        ];

        $costSum = Arr\sumWhere(function ($e) {
            return $e->cost;
        });

        $this->assertEquals(215.00, $costSum($data));
    }



    public function testCanSortArray(): void
    {
        $array         = array('b', 'c', 'a', 'f', 'd', 'z', 'g');
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
        $array = array(3, 2, 5, 6, 1);

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

        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $sorted = $sortByOddEven($data);
        $this->assertCount(5, $sorted[0]);
        $this->assertCount(5, $sorted[1]);

        $this->assertContains(2, $sorted[1]);
        $this->assertContains(4, $sorted[1]);
        $this->assertContains(8, $sorted[1]);
        $this->assertContains(3, $sorted[0]);
        $this->assertContains(7, $sorted[0]);


    }
}
