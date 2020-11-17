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
            Num\sum(12),
            Num\multiply(4),
            Num\subtract(7)
        )(7);
        $this->assertEquals(69, $results);
    }

    public function testCanUsePipeR()
    {
        $results = Func\pipeR(
            Num\subtract(7),
            Num\multiply(4),
            Num\sum(12)
        )(7);
        $this->assertEquals(69, $results);
    }

    public function testCanUsePluckProperty()
    {
        $data = (object)[
            'alpha' => [
                'bravo' => (object)[
                    'charlie' => [
                        'delta' => 'SPOONS'
                    ]
                ]
            ]
        ];

        $getSpoons = Func\pluckProperty('alpha', 'bravo', 'charlie', 'delta');
        $getDelta = Func\pluckProperty('alpha', 'bravo', 'charlie');
        $this->assertEquals('SPOONS', $getSpoons($data));
        $this->assertArrayHasKey('delta', $getDelta($data));
        $this->assertContains('SPOONS', $getDelta($data));


        // $encoder = Func\setProperty((object)['tree' => 42]);
        // $return = $encoder('test', 1);
        // var_dump($return->test);
        // $encoder = Func\setProperty($return);
        // $return = $encoder('ddddd', 1789789);
        // var_dump($return->ddddd);


        // $recordEncoder = Func\recordEncoder(new ArrayObject());
        // $return = $recordEncoder(
        //     Func\encodeProperty('one', Func\pluckProperty('alpha', 'bravo', 'charlie', 'delta')($data)),
        //     Func\encodeProperty('two', Func\pluckProperty('alpha', 'bravo')($data)),
        //     Func\encodeProperty('three', 3),
        // );



        $arrayEndoder = Func\recordEncoder((object)['tree' => 'OLD']);
        
        
        $res = $arrayEndoder(
            Func\encodeProperty('one', Func\pluckProperty('alpha', 'bravo', 'charlie', 'delta')),
            Func\encodeProperty('two', Func\pluckProperty('alpha', 'bravo')),
            Func\encodeProperty('three', Func\always(45456465)),
        );

        $res2 = $arrayEndoder(
            Func\encodeProperty('one', Func\always('ONE')),
            Func\encodeProperty('two', Func\pluckProperty('alpha', 'bravo')),
            Func\encodeProperty('three', Func\always(45456465)),
        );

        // var_dump($res($data)->one);
        // var_dump($res2($data)->tree);

        $arrayEndoder = Func\recordEncoder((object)['tree' => 'OLD'])(
            Func\encodeProperty('one', Func\pluckProperty('alpha', 'bravo', 'charlie', 'delta')),
            Func\encodeProperty('two', Func\getProperty('alpha')),
            Func\encodeProperty('three', Func\always(45456465)),
        );
        // var_dump($arrayEndoder($data)->two);

        var_dump(
            Func\pipe(
                Func\recordEncoder((object)['tree' => 'SPPON'])(
                    Func\encodeProperty('one', Func\always('ONE')),
                    Func\encodeProperty('two', Func\pluckProperty('alpha', 'bravo')),
                    Func\encodeProperty('three', Func\always(45456465))
                )
            )($data)
        );
    }
}
