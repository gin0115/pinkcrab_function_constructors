---
title: Strings\addSlashes()
description: >
 Creates a function which allows for adding slashes to a string. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]
coreFunctions: 
    - addcslashes()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L287
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $charList The Char list to add slashes too.
   * @return Closure(string):string
   */
 Strings\addSlashes(string $charList): Closure
closure: >
 /**
  * @param string $string The string to have char, slash escaped.
  * @return string
  */
 $function (string $string): string

examplePartial: >
 // Create the closure that add slashes to any A or B.

 $format = Strings\addSlashes('ap');


 // Called as a function.

 echo $format('This is an example'); /// This is \an ex\am\ple


 // Used in a higher order function.  

 $array = array_map( $format, ['This is an example', 'Another example'] );
  
 print_r($array); // ['This is \an ex\am\ple', 'Another ex\am\ple']


exampleCurried: >
 // With decimal full stop and comma as thousands separator.

 echo Strings\addSlashes('al')('Apples are red'); // App\les \are red




exampleInline: >
    $array = array_map( Strings\addSlashes('ap'), ['This is an example', 'Another example'] );

    print_r($array); // ['This is \an ex\am\ple', 'Another ex\am\ple']

---