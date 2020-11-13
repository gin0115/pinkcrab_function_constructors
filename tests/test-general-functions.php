<?php

declare(strict_types=1);

/**
 * Tests for the StrictMap class.
 *
 * @since 1.0.0
 * @author GLynn Quelch <glynn.quelch@gmail.com>
 */

require_once dirname(__FILE__, 2) . '/FunctionsLoader.php';

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\GeneralFunctions as Func;


/**
 * StringFunction class.
 */
class GeneralFunctionTest extends TestCase
{

    public function setup(): void
    {
        FunctionsLoader::include();
    }

    public function testFunctionCompose(): void
    {
        
        $function = Func\compose(
            Str\replaceWith('1122', '*\/*'),
            Str\replaceWith('6677', '=/\='),
            Str\prepend('00'),
            Str\append('99')
        );

        $this->assertEquals(
            '00*\/*334455=/\=8899',
            $function('1122334455667788')
        );

        $function = Func\composeSafe(
            Str\replaceWith('3344', '*\/*'),
            Str\replaceWith('5566', '=/\='),
            Str\prepend('00'),
            Str\append('99')
        );

        $this->assertEquals(
            '001122*\/*=/\=778899',
            $function('1122334455667788')
        );
    }

    public function testFunctionCompseSafeHandlesNull(): void
    {

        $reutrnsNull = function ($e) {
            return null;
        };

        $function = Func\composeSafe(
            Str\replaceWith('3344', '*\/*'),
            Str\replaceWith('5566', '=/\='),
            $reutrnsNull,
            Str\prepend('00'),
            Str\append('99')
        );
        $this->assertNull($function('1122334455667788'));
    }

    public function testTypeSafeFunctionalComposer(): void
    {
        $function = Func\composeTypeSafe(
            'is_string',
            Str\replaceWith('3344', '*\/*'),
            Str\replaceWith('5566', '=/\='),
            Str\prepend('00'),
            Str\append('99')
        );

        $this->assertEquals(
            '001122*\/*=/\=778899',
            $function('1122334455667788')
        );
    }

    public function testAlwaysReturns()
    {
        $alwaysHappy = Func\always('Happy');
        
        $this->assertEquals('Happy', $alwaysHappy('No'));
        $this->assertEquals('Happy', $alwaysHappy(false));
        $this->assertEquals('Happy', $alwaysHappy(null));
        $this->assertEquals('Happy', $alwaysHappy(new DateTime()));
        $this->assertNull(Func\always(null)('NOT NULL'));
    }

    public function testCanUsePipe()
    {
        $results = Func\pipe(
            Num\sumInt(12),
            Num\multiplyInt(4), 
            Num\subtractInt(7) 
        )(7);
        $this->assertEquals(69, $results);
    }
}
