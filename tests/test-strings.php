<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;

/**
 * StringFunction class.
 */
class StringFunctionTest extends TestCase
{

    public function setup(): void
    {
        FunctionsLoader::include();
    }

    public function testCanWrapStringWithHTMLTags(): void
    {

        $asDiv = Str\tagWrap('div class="test"', 'div');
        $this->assertEquals('<div class="test">HI</div>', $asDiv('HI'));
        $this->assertEquals('<div class="test">123</div>', $asDiv('123'));

        $asLi = Str\tagWrap('li');
        $this->assertEquals('<li>HI</li>', $asLi('HI'));
        $this->assertEquals('<li>123</li>', $asLi('123'));
    }

    public function testCanWrapString(): void
    {
        $foo = Str\wrap('--', '++');
        $this->assertEquals('--HI++', $foo('HI'));
        $this->assertEquals('--123++', $foo('123'));

        $bar = Str\wrap('\/');
        $this->assertEquals('\/HI\/', $bar('HI'));
        $this->assertEquals('\/123\/', $bar('123'));
    }

    public function testCanMakeUrl(): void
    {
        $makeUrl = Str\asUrl('http://test.com');
        $this->assertEquals(
            "<a href='http://test.com'>test</a>",
            $makeUrl('test')
        );

        $makeUrlBlank = Str\asUrl('http://test.com', '_blank');
        $this->assertEquals(
            "<a href='http://test.com' target='_blank'>test</a>",
            $makeUrlBlank('test')
        );
    }

    public function testCanPrependString(): void
    {
        $prep10 = Str\prepend('10');
        $this->assertEquals('10HI', $prep10('HI'));
        $this->assertEquals('1077', $prep10('77'));
    }

    public function testCanAppendString(): void
    {
        $append10 = Str\append('10');
        $this->assertEquals('HI10', $append10('HI'));
        $this->assertEquals('7710', $append10('77'));
    }

    public function testCanCurryReplace(): void
    {
        $find_to_mask = Str\findToReplace('to mask');

        // Mask with XX
        $maskWithXX = $find_to_mask('xx');
        $string     = 'This has some test to mask and some more to mask';
        $this->assertEquals(
            'This has some test xx and some more xx',
            $maskWithXX($string)
        );

        // Mask with YY
        $maskWithYY = $find_to_mask('yy');
        $string     = 'This has some test to mask and some more to mask';
        $this->assertEquals(
            'This has some test yy and some more yy',
            $maskWithYY($string)
        );

        // Inlined.
        $this->assertEquals(
            'This has some test xx and some more xx',
            Str\findToReplace('to mask')('xx')($string)
        );
    }

    public function testCanReplaceInString(): void
    {
        $replaceGlynnWithHa = Str\replaceWith('glynn', 'ha');
        $this->assertEquals('Hi ha', $replaceGlynnWithHa('Hi glynn'));
        $this->assertEquals('ha ha ha', $replaceGlynnWithHa('glynn glynn glynn'));
    }

    public function testStringContains(): void
    {
        $contains = Str\contains('--');
        $this->assertTrue($contains('--True'));
        $this->assertFalse($contains('++False'));
    }

    public function testStringStartWith(): void
    {
        $startsWithA = Str\startsWith('--');
        $this->assertTrue($startsWithA('--True'));
        $this->assertFalse($startsWithA('++False'));
    }

    public function testStringEndWith(): void
    {
        $endsWith = Str\endsWith('--');
        $this->assertTrue($endsWith('--True--'));
        $this->assertFalse($endsWith('++False++'));
    }

    public function testCanComposeWithSafeStrings(): void
    {
        $reutrnsArray = function ($e) {
            return array();
        };

        $function = Str\composeSafeStringFunc(
            Str\replaceWith('3344', '*\/*'),
            Str\replaceWith('5566', '=/\='),
            $reutrnsArray,
            Str\prepend('00'),
            Str\append('99')
        );
        $this->assertNull($function('1122334455667788'));
    }

    public function testStringCompilerCanBeUsedAsAJournal(): void
    {
        $journal = Str\stringCompiler('');
        $journal = $journal('11');
        $this->assertEquals('11', $journal());
        $journal = $journal('22');
        $this->assertEquals('1122', $journal());
        $journal = $journal('33');
        $this->assertEquals('112233', $journal());
    }

    public function testComposedWithArrayMap(): void
    {
        $function = Str\composeSafeStringFunc(
            Str\replaceWith('a', '_a_'),
            Str\replaceWith('t', '-t-'),
            Str\prepend('00'),
            Str\append('99')
        );

        $results = array_map($function, array( '1a2', '1b3', '1t4' ));
        $this->assertEquals('001_a_299', $results[0]);
        $this->assertEquals('001b399', $results[1]);
        $this->assertEquals('001-t-499', $results[2]);
    }

    public function testCanAddCSlashes()
    {
        $slashA = Str\addCSlashes('a');
        $this->assertEquals('h\appy d\ays', $slashA('happy days'));

        $slashAD = Str\addCSlashes('ad');
        $this->assertEquals('h\appy \d\ays', $slashAD('happy days'));
    }

    public function testCanSplitString()
    {
        $splitIntoFours = Str\split(4);

        $split = $splitIntoFours('AAAABBBBCCCCDDDD');
        $this->assertEquals('AAAA', $split[0]);
        $this->assertEquals('BBBB', $split[1]);
        $this->assertEquals('CCCC', $split[2]);
        $this->assertEquals('DDDD', $split[3]);
    }

    public function testCanSplitChunkString()
    {
        $in5s = Str\chunkSplit(5, '-');
        $this->assertEquals('aaaaa-bbbbb-ccccc-', $in5s('aaaaabbbbbccccc'));
    }

    public function testCanCountCharsInString()
    {
        $getOccurances = Str\countChars();
        $this->assertCount(4, $getOccurances('Hello'));
        $this->assertCount(1, $getOccurances('a'));
        $this->assertCount(8, $getOccurances('asfetwafgh'));
    }

    public function testCanDoTrim()
    {
        $trimAB = Str\lTrim("AB");
        $this->assertEquals('STD', $trimAB("ABSTD"));
        $this->assertEquals('HFJKGHDJKGHFJKFGJKFGJK', $trimAB("ABHFJKGHDJKGHFJKFGJKFGJK"));

        $trimYZ = Str\rTrim("YZ");
        $this->assertEquals('STD', $trimYZ("STDYZ"));
        $this->assertEquals('ABHFJKGHDJKGHFJKFGJKFGJK', $trimYZ("ABHFJKGHDJKGHFJKFGJKFGJKYZ"));
    }

    public function testCanDoSimilarTextAsBase()
    {
        $compareTheBaseAsChars = Str\similarTextAsBase("THE BASE");
        $compareTheBaseAsPC = Str\similarTextAsBase("THE BASE", true);
        $this->assertEquals(4, $compareTheBaseAsChars('BASE'));
        $this->assertEquals((6 / 9) * 100, $compareTheBaseAsPC('BASE'));
    }

    public function testCanDoSimilarTextAsComparisson()
    {
        $compareTheBaseAsChars = Str\similarTextAsComparisson("BASE");
        $compareTheBaseAsPC = Str\similarTextAsComparisson("BASE", true);
        $this->assertEquals(4, $compareTheBaseAsChars('THE BASE'));
        $this->assertEquals((6 / 9) * 100, $compareTheBaseAsPC('THE BASE'));
    }

    public function testCanPadStrings()
    {
        $padLeft10 = Str\pad(10, '.', STR_PAD_LEFT);
        $padRight10 = Str\pad(10, '_', STR_PAD_RIGHT);
        $padBoth10 = Str\pad(10, '\'', STR_PAD_BOTH);

        $this->assertEquals('........HI', $padLeft10('HI'));
        $this->assertEquals('HI________', $padRight10('HI'));
        $this->assertEquals("''''HI''''", $padBoth10('HI'));
    }

    public function testCanRepeatString()
    {
        $sayItTrice = Str\repeat(3);
        $this->assertEquals('HIHIHI', $sayItTrice('HI'));
    }

    public function testCanDoWordCounts()
    {
        // Check can count words and reutrn count.
        $WordCount = Str\wordCount(WORD_COUNT_NUMBER_OF_WORDS);
        $this->assertEquals(3, $WordCount('HI HI HI'));

        // Test can return array of word counts.
        $wordList = Str\wordCount(WORD_COUNT_ARRAY)('HI BYE MAYBE');
        $this->assertEquals('HI', $wordList[0]);
        $this->assertEquals('BYE', $wordList[1]);
        $this->assertEquals('MAYBE', $wordList[2]);

        // Test can return ass array of word counts with positions.
        $wordListPositions = Str\wordCount(WORD_COUNT_ASSOCIATIVE_ARRAY)('HI BYE MAYBE');
        $this->assertEquals('HI', $wordListPositions[0]);
        $this->assertEquals('BYE', $wordListPositions[3]);
        $this->assertEquals('MAYBE', $wordListPositions[7]);
    }

    public function testCanStripTags()
    {
        $allTags = Str\stripTags();
        $allowPTags = Str\stripTags('<p><a>');

        $this->assertEquals('1Stuff', $allTags('1<p>Stuff</p>'));
        $this->assertEquals('1<p>Stuff</p>', $allowPTags('1<p>Stuff</p>'));
    }

    public function testCanFindFirstPosition()
    {
        $findApple = Str\fistPosistion('Apple');
        $this->assertEquals(0, $findApple('Apple are tasty'));
        $this->assertEquals(19, $findApple('I really dont like Apples'));
    }
}
