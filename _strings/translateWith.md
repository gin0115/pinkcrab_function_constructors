---
layout: function

title: Strings\translateWith()
description: >
 Creates a function that can be used to replace pairs of characters in a string. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L725
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

definition: >
 /**
   * @param array<string, mixed> $dictionary
   * @return Closure(string):string
   */
 Strings\translateWith(array $dictionary): Closure

closure: >
 /**
   * @param string $haystack
   * @return string
   */
 $function ($haystack): string

examplePartial: >
 // Creates the Closure to replace foo with bar and hi with hello

 $replace = Strings\translateWith(['foo' => 'bar', 'hi' => 'hello']);


 // Called as a function.

 echo $replace('foo is foo'); // bar is bar

 echo $replace('hi im an example'); // hello im an example


 // Used in a higher order function.

 $array = array_map($replace, ['Its foo', 'hi you']);

 print_r($array); // ['Its bar', 'hello you']
 

exampleCurried: >
 echo Strings\translateWith(['foo' => 'bar])( 'foo is foo'); // bar is bar

exampleInline: >
 $array = array_map(
  Strings\translateWith(['foo' => 'bar', 'hi' => 'hello']), 
  ['Its foo', 'hi you', 'hi foo']
 );

 print_r($array); // ['Its bar', 'hello you', 'hello bar']


---
