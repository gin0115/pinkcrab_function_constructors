---
layout: function
title: Strings\prepend()
subtitle: >
 Allows you to create a function which can be used to prepend a sub string to a passed string. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

group: strings
subgroup: string_manipulation
categories: [strings, string manipulation]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L84
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: null

definition: >
 /**
   * @param string $prepend
   * @return Closure(string):string
   */
  Strings\prepend(string $prepend): Closure

closure: >
 /**
   * @param string $toPrependOnto  The string to have the sub string added to
   * @return string                The sliced string
   * @psalm-pure
   */ 
 $function(string $toPrependOnto): string


examplePartial: >
 // Creates the Closure.

 $prependFoo = Strings\prepend('foo');  


 // Called as a function.  

 echo $prependFoo('Hello'); // fooHello  


 // Used in a higher order function.  

 $array = array_map( $prependFoo, ['Hello', 'World']);  

 print_r($array); // [fooHello, fooWorld]  

exampleCurried: >
 echo Strings\prepend('foo')('Bar'); // fooBar
exampleInline: >
 $array = array_map( Strings\prepend('--'), ['foo', 'bar'] );

 print_r($array); // ['--foo', '--bar']  


---
