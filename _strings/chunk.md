---
layout: function
group: strings
subgroup: string_manipulation


title: Strings\chunk()
description: >
 Allows you to create a function which can be used to break a string with a defined separator, at a numbered interval. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L363
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string manipulation]
coreFunctions: 
    - chunk_split()

deprecated: false
alternative: false

definition: >
 /**
   * @param int $length The length of each chunk.
   * @param string $end The string to use at the end.
   * @return Closure(string):string
   */
  Strings\chunk(int $length, string $end = "\r\n"):: Closure

closure: >
 /**
   * @param string $string The string to be chunked
   * @return string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will chunk a string at 5 characters, with a - as the end.

 $chunk5Dash = Strings\chunk(5, '-');


 // Called as a function.

 echo $chunk5Dash('When Mark eyed this loot Dale shot Mark Dale owns that gold They dont know that'); 

 // When -Mark -eyed -this -loot -Dale -shot -Mark -Dale -owns -that -gold -They -dont -know -that-


 // Used in a higher order function.

 $array = array_map( $chunk5Dash, ['Once upon time', 'John fell like fish food']);

 print_r($array); // [Once -upon -time-, John -fell -like -fish -food-]




exampleCurried: >
 echo Strings\chunk('2', '*')('Hello World'); // He*ll*o *Wo*rl*d*

exampleInline: >
 $array = array_map( Strings\chunk(2, '_), ['Hello World', 'Foo Bar']);

  print_r($array); // [[He_ll_o _Wo_rl_d_], [Fo_o _Ba_r_]]

---



