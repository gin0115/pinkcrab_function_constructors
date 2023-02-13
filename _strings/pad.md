---
layout: function
group: strings
subgroup: string_manipulation


title: Strings\pad()
subtitle: >
 Allows you to create a function which can be used to pad a string to a defined length, with a defined string. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L518
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string manipulation]
coreFunctions: 
    - str_pad()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $length Max length to make string.
   * @param string $padContent The value to padd the string with (defaults to ' ')
   * @param int $type How to pad, please use these constants. STR_PAD_RIGHT|STR_PAD_LEFT|STR_PAD_BOTH
   * @return Closure(string):string
   */
  Strings\pad(int $length, string $padContent = ' ', int $type = STR_PAD_RIGHT): Closure

closure: >
 /**
   * @param string $string The string to pad out.
   * @return string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which can be used to pad a string to 20 characters, with a - as the pad content.

 $padLeft = Strings\pad(20, '-', STR_PAD_LEFT);
 
 $padRight = Strings\pad(20, '-', STR_PAD_RIGHT);
 
 $padBoth = Strings\pad(20, '-', STR_PAD_BOTH);


 // Called as a function.

 echo $padLeft('Hello World'); // ------------Hello World

 echo $padRight('Hello World'); // Hello World------------

 echo $padBoth('Hello World'); // -----Hello World-----


 // Used in a higher order function.

 $array = array_map( $padLeft, ['Once upon time', 'Find the time']);

 print_r($array); // [------Once upon time, -------Find the time]

exampleCurried: >
 // Padding right is the default, so can be omitted.

 echo Strings\pad(20, '-')('Hello World'); // Hello World---------

exampleInline: >
 $array = array_map( Strings\pad(20, '-', STR_PAD_BOTH), ['Once upon time', 'Find the time']);

 print_r($array); // [---Once upon time---, ---Find the time----]

---



