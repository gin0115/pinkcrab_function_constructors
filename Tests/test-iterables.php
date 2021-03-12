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
use PinkCrab\FunctionConstructors\Iterable as Itr;
use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

/**
 * IterableFunction class.
 */
class IterableFunctionTests extends TestCase
{
    public function setup(): void
    {
        FunctionsLoader::include();
    }

    /** @testdox Attmepts to filter a Generator and array using partials from lib. */
    public function test_iterable_filter(): void
    {
        // With generator without keys
        $generatorWithOutKeys = function (): Generator {
            yield  'value1';
            yield  'value2';
            yield  'value3';
            yield  'value4';
        };

        // With generator with keys
        $onlyEndsIn1 = Itr\filter(Str\endsWith('1'));
        $results = $onlyEndsIn1($generatorWithOutKeys());
        $asArray = iterator_to_array($results);

        $this->assertIsIterable($results);
        $this->assertNotEmpty($asArray);
        $this->assertCount(1, $asArray);
        $this->assertEquals('value1', $asArray[0]);
        
        $generatorWithKeys = function (): Generator {
            yield 'key1' => 'value1';
            yield 'key2' => 'value2';
            yield 'key3' => 'value3';
            yield 'key4' => 'value4';
        };

        // With generator with keys
        $onlyEndsIn2 = Itr\filter(Str\endsWith('2'));
        $results = $onlyEndsIn2($generatorWithKeys());
        $asArray = iterator_to_array($results);

        $this->assertIsIterable($results);
        $this->assertNotEmpty($asArray);
        $this->assertCount(1, $asArray);
        $this->assertArrayHasKey('key2', $asArray);

        // With array
        $onlyEndsIn3 = Itr\filter(Str\endsWith('3'));
        $results = $onlyEndsIn3(iterator_to_array($generatorWithKeys()));

        $this->assertNotEmpty($results);
        $this->assertCount(1, $results);
        $this->assertArrayHasKey('key3', $results);
    }

    /** @testdox Can use filterAnd using either generator or iterator. */
    public function test_iterable_filter_and(): void
    {
        $generatorWithOutKeys = function (): Generator {
            yield  'qw__yu';
            yield  'qw__yd';
            yield  'qe__yu';
            yield  'qe__yd';
        };
        $generatorWithKeys = function (): Generator {
            yield 'key1' => 'qw__yu';
            yield 'key2' => 'qw__yd';
            yield 'key3' => 'qe__yu';
            yield 'key4' => 'qe__yd';
        };

        /** ITERATOR WITHOUT KEYS */
        $startWith_qd_endsWith_yd = Itr\filterAnd(Str\startsWith('qw'), Str\endsWith('yd'));
        $results = $startWith_qd_endsWith_yd($generatorWithOutKeys());
        $asArray = iterator_to_array($results);

        $this->assertIsIterable($results);
        $this->assertNotEmpty($asArray);
        $this->assertCount(1, $asArray);
        $this->assertContains('qw__yd', $asArray);

        /** ITERATOR WITH KEYS */
        $startWith_qd_endsWith_yd = Itr\filterAnd(Str\startsWith('qe'), Str\endsWith('yd'));
        $results = $startWith_qd_endsWith_yd($generatorWithKeys());
        $asArray = iterator_to_array($results);

        $this->assertIsIterable($results);
        $this->assertNotEmpty($asArray);
        $this->assertCount(1, $asArray);
        $this->assertContains('qe__yd', $asArray);
        $this->assertArrayHasKey('key4', $asArray);

        /** USING ARRAY */
        $startWith_qd_endsWith_yu = Itr\filterAnd(Str\startsWith('qe'), Str\endsWith('yu'));
        $results = $startWith_qd_endsWith_yu(iterator_to_array($generatorWithKeys()));

        $this->assertNotEmpty($results);
        $this->assertCount(1, $results);
        $this->assertContains('qe__yu', $results);
        $this->assertArrayHasKey('key3', $results);
    }
}
