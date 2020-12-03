<?php

declare(strict_types=1);

/**
 * Tests for the StrictMap class.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 */

require_once dirname(__FILE__, 2) . '/FunctionsLoader.php';

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

class ToArrayFixtureClass
{
    private $propA = 1;
    protected $propB = 2;
    public $propC = 3;
}


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
    }

    public function testCanUseRecordEncoder()
    {
        $data = (object)[
            'post' => (object)[
                'id' => 123,
                'title' => 'Lorem ipsum dolor',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique iste voluptatum sequi. Officia dignissimos minus ipsum odit, facilis voluptatibus veniam enim molestiae ipsam quae temporibus porro necessitatibus quia non mollitia!',
                'date' => (new DateTime())->format('d/m/yy H:m'),
                'author' => (object)[
                    'userName' => 'someUser12',
                    'displayName' => 'Sam Smith'
                ],
                'url' => 'https://www.url.tld/post/123/lorem-ipsum-dolor'
            ],
            'comments' => [
                (object)[
                    'post' => 123,
                    'author' => (object)[
                    'userName' => 'someUser2',
                    'displayName' => 'Jane Jameson',
                    'comment' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, illo tempore repudiandae quos vero, vitae aut ullam tenetur officiis accusantium dolor animi ipsa omnis impedit, saepe est harum quisquam sit.',
                    'date' => (new DateTime('yesterday'))->format('d/m/yy H:m'),
                    ]
                ],
                (object)[
                    'post' => 123,
                    'author' => (object)[
                    'userName' => 'someUser22',
                    'displayName' => 'Barry Burton',
                    'comment' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic, illo tempore repudiandae quos vero, vitae aut ullam tenetur officiis accusantium dolor animi ipsa omnis impedit, saepe est harum quisquam sit.',
                    'date' => (new DateTime('yesterday'))->format('d/m/yy H:m'),
                    ]
                ]
            ],
            'shares' => [
                'facebook' => 125,
                'twitter' => 1458,
                'instagram' => 8
            ]
        ];

        // Simplified post encoder
        $encoder = array(
            Func\encodeProperty('id', Func\pluckProperty('post', 'id')),
            Func\encodeProperty('title', Func\pluckProperty('post', 'title')),
            Func\encodeProperty('url', Func\pluckProperty('post', 'url')),
            Func\encodeProperty('author', Func\pluckProperty('post', 'author', 'displayName')),
            Func\encodeProperty('comments', Func\pipeR('count', Func\getProperty('comments'))),
            Func\encodeProperty('totalShares', Func\pipeR('array_sum', Func\getProperty('shares'))),
            Func\encodeProperty('fakeValue', Func\pluckProperty('i', 'do', 'not', 'exist')),
        );

        // Create a generic stdClass encoder.
        $objectBuilder = Func\recordEncoder(new stdClass());
        $arrayBuilder = Func\recordEncoder([]);


        // Populte builders with the encoder.
        $simplePostCreatorObject = $objectBuilder(...$encoder);
        $simplePostCreatorArray = $arrayBuilder(...$encoder);

        // Build the final array/object
        $simpleObject = $simplePostCreatorObject($data);
        $simpleArray = $simplePostCreatorArray($data);

        $this->assertEquals(123, $simpleObject->id);
        $this->assertEquals(123, $simpleArray['id']);

        $this->assertEquals('Lorem ipsum dolor', $simpleObject->title);
        $this->assertEquals('Lorem ipsum dolor', $simpleArray['title']);

        $this->assertEquals('https://www.url.tld/post/123/lorem-ipsum-dolor', $simpleObject->url);
        $this->assertEquals('https://www.url.tld/post/123/lorem-ipsum-dolor', $simpleArray['url']);

        $this->assertEquals('Sam Smith', $simpleObject->author);
        $this->assertEquals('Sam Smith', $simpleArray['author']);

        $this->assertEquals(2, $simpleObject->comments);
        $this->assertEquals(2, $simpleArray['comments']);

        $this->assertEquals(1591, $simpleObject->totalShares);
        $this->assertEquals(1591, $simpleArray['totalShares']);

        $this->assertNull($simpleObject->fakeValue);
        $this->assertNull($simpleArray['fakeValue']);
    }

    /**
     * Test that the invoker can be called.
     *
     * @return void
     */
    public function testCanInvokeCallables()
    {
        $doubleAnyNumber = Func\invoker(Func\pipe(
            Num\sum(12),
            Num\multiply(4),
            Num\subtract(7)
        ));

        $this->assertEquals(69, $doubleAnyNumber(7));
    }

    public function testCanUseToArrayForObjects()
    {
        // Create the simple to array wrapper.
        $toArrray = Func\toArray();

        // Test with valid stdClass.
        $obj = new stdClass();
        $obj->propA = 1;
        $obj->propB = 2;
        $this->assertArrayHasKey('propA', $toArrray($obj));
        $this->assertEquals(1, $toArrray($obj)['propA']);
        $this->assertArrayHasKey('propB', $toArrray($obj));
        $this->assertEquals(2, $toArrray($obj)['propB']);

        // Test only valid public properties.
        $obj = new ToArrayFixtureClass();
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
