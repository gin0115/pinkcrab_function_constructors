<?php

/**
 * Various compilation functions.
 */

require_once 'vendor/autoload.php';

use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

$headerFormatter = Str\tagWrap('h2 style="color: navy; font-size: 16px;"', 'h2');

// String Compiler.
print($headerFormatter('Strings\stringCompiler()'));

$logger = Str\stringCompiler('Log Begins:');
$logger = $logger(' Something happened last night, im not sure what exactly....');
$logger = $logger(' I told you something happened last night.....');
$logger = $logger(':Log Ends<br>');

print($logger());
// Outputs : Log Begins: Something happened last night, im not sure what exactly.... I told you something happened last night..... :Log Ends

$logger = $logger('<hr>');
$logger = $logger('We can keep adding more.');
$logger = $logger(' So long as use the new returned logger');
print($logger());

// Array Compiler
print($headerFormatter('Arrays\arrayCompiler()'));

$collection = Arr\arrayCompiler();
$collection = $collection('Like before we can use this to create a log');
$collection = $collection('Obviously we can put anything in this version');
$collection = $collection((object)['key' => [1,23]]);
print_r($collection());
// Output : Array ( [0] => Like before we can use this to create a log [1] => Obviously we can put anything in this version [2] => stdClass Object ( [key] => Array ( [0] => 1 [1] => 23 ) ) )

print($headerFormatter('Arrays\arrayCompilerTyped()'));

$arrayCompiler = Arr\arrayCompilerTyped('is_string');
$arrayCompiler = $arrayCompiler('Hello');
$arrayCompiler = $arrayCompiler('ERROR');
$arrayCompiler = $arrayCompiler(['ERROR']);
print_r($arrayCompiler());


$arrayCompiler = $arrayCompiler('Hello')(1)(false)([null])(NAN)("so 4?");
var_dump($arrayCompiler());
