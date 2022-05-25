<?php

declare(strict_types=1);

require_once dirname(__FILE__, 3) . '/FunctionsLoader.php';

/**
 * Tests for the Object functions class.
 *
 * @since 1.0.0
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
}
