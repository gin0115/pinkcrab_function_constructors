<?php

declare(strict_types=1);

/**
 * Tests for all procedural based functions
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 */

require_once dirname(__FILE__, 2) . '/FunctionsLoader.php';
require_once dirname(__FILE__) . '/Providers/ObjectFactory.php';

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\GeneralFunctions as Func;
use PinkCrab\FunctionConstructors\Tests\Providers\ObjectFactory;

class ProceduralFunctionsTest extends TestCase
{

    public function testCanFlattenArray()
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
        $this->assertArrayHasKey(2, arrayFlatten($array, 2));
        $this->assertIsArray(arrayFlatten($array, 1)[8]);

        $this->assertArrayHasKey(9, arrayFlatten($array, 2));
        $this->assertIsArray(arrayFlatten($array, 2)[10]);

        $this->assertArrayHasKey(12, arrayFlatten($array, 3));
        $this->assertEquals(13, arrayFlatten($array, 3)[12]);

        // Check will fully flatten if no depth defined.
        $this->assertArrayHasKey(12, arrayFlatten($array));
        $this->assertEquals(13, arrayFlatten($array)[12]);
    }

    public function testCanUsestr_contains()
    {
        $this->assertTrue(stringContains('--True', '--'));
        $this->assertFalse(stringContains('++False', '--'));
    }
}
