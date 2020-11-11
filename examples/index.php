<?php

include_once 'vendor/autoload.php';

use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

// $test = Arr\filterAnd(
// 	Str\contains( 'john' ),
// 	Str\startsWith( 'HI' )
// );

var_dump( Str\contains( 'john' )( 'john' ) );
var_dump( Str\contains( 'john' )( 'bill' ) );
