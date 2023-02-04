---
layout: function

title: Strings\replaceWith()
subtitle: Creates a function that can be used to replace any instance of a sub string, with a defined value. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L159
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

definition: >
 /**
   * @param string  $find
   * @param string  $replace
   * @return Closure(string):string
   */
 Strings\replaceWith(string $find, string $replace): Closure

closure: >
 /**
   * @param string $source
   * @return string
   */
 $function ($source): string

examplePartial: >
 // Creates the Closure.

 $fooToBar = Strings\replaceWith('foo', 'bar');  


 // Called as a function.  

 echo $fooToBar('This is foo'); // This is bar  


 // Used in a higher order function.  

 $array = array_map( $fooToBar, ['Its foo', 'The foo is']);  

 print_r($array); // ['Its bar', 'The bar is']  

exampleCurried: >
 echo Strings\replaceWith('Hi', 'Hello')('Hi im an example'); // Hello im an example
exampleInline: >
 $array = array_map( Strings\replaceWith('foo', 'bar'), ['Its foo', 'The foo is'] );

 print_r($array); // ['Its bar', 'The bar is'] 


---
