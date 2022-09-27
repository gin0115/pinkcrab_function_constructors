<?php

declare(strict_types=1);

require_once dirname(__FILE__, 3) . '/FunctionsLoader.php';

/**
 * Tests for the Object functions class.
 *
 * @since 0.2.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 */

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Objects as Obj;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;

use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

use function PHPUnit\Framework\throwException;

class ToArrayFixtureClassObj
{
    private $propA = 1;
    protected $propB = 2;
    public $propC = 3;
}

/**
 * Object class.
 */
class ObjectTests extends TestCase
{
    /** @testdox It should be possible to create a function that allow for the defining of a class by instance or name which can be used to check if other instances of names are the same. */
    public function testObjectInstanceOf(): void
    {
        // Create the comparisson functions.
        $instance         = new \stdClass();
        $name             = \stdClass::class;
        $isSameAsInstance = Obj\isInstanceOf($instance);
        $isSameAsName     = Obj\isInstanceOf($name);

        // Should work with classes that extend from.
        $extends = new class () extends \stdClass {
        };

        $this->assertTrue($isSameAsInstance(new \stdClass()));
        $this->assertTrue($isSameAsInstance(\stdClass::class));
        $this->assertTrue($isSameAsInstance($extends));

        $this->assertTrue($isSameAsName(new \stdClass()));
        $this->assertTrue($isSameAsName(\stdClass::class));
        $this->assertTrue($isSameAsName($extends));
    }

    /** @testdox It should be possibel to check if a calss implements an interface */
    public function testObjectImplementsInterface(): void
    {
        $classWithCount = new class () implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $classWithoutCount = new class () {
        };

        $this->assertTrue(Obj\implementsInterface(Countable::class)($classWithCount));
        $this->assertFalse(Obj\implementsInterface(Countable::class)($classWithoutCount));
    }

    /** @testdox  */
    public function testToArray(): void
    {

        // Create the simple to array wrapper.
        $toArrray = Obj\toArray();

        // Test with valid stdClass.
        $obj = new stdClass();
        $obj->propA = 1;
        $obj->propB = 2;
        $this->assertArrayHasKey('propA', $toArrray($obj));
        $this->assertEquals(1, $toArrray($obj)['propA']);
        $this->assertArrayHasKey('propB', $toArrray($obj));
        $this->assertEquals(2, $toArrray($obj)['propB']);

        // Test only valid public properties.
        $obj = new ToArrayFixtureClassObj();
        $this->assertArrayNotHasKey('propA', $toArrray($obj));
        $this->assertArrayNotHasKey('propB', $toArrray($obj));
        $this->assertArrayHasKey('propC', $toArrray($obj));
        $this->assertEquals(3, $toArrray($obj)['propC']);

        // Check it returns blank array if any other value passed.
        $this->assertEmpty($toArrray(false));
        $this->assertEmpty($toArrray(null));
        $this->assertEmpty($toArrray([1,2,3,4]));
        $this->assertEmpty($toArrray(1));
        $this->assertEmpty($toArrray(2.5));
        $this->assertEmpty($toArrray('STRING'));
    }
}
