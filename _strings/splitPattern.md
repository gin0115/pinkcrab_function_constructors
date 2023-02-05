---
title: Strings\splitPattern()
subtitle: Returns a function which can be used to to split a string into an array of strings. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_transform
categories: [strings, string transform]
coreFunctions: 
    - preg_split()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L268
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $pattern The pattern to look for.
   * @return Closure(string):string[]
   */
  Strings\splitPattern(string $pattern): Closure

closure: >
 /**
   * @param string $source
   * @return string[]
   * @psalm-pure
   */ 
 $function(string $source): array

examplePartial: >
 // Create function to split an array of strings using - as a delimiter.

 $splitOnDashes = Strings\splitPattern('/-/');


 // Called as a function.

 $splitOnDashes('its-foo'); // ['its', 'foo']


 // Used in a higher order function.

 $array = array_map($splitOnDashes, ['its-foo', 'its-bar']);

 print_r($array); // [['its', 'foo'], ['its', 'bar']]




exampleCurried: >
 Strings\splitPattern('/-/')('its-foo');  // ['its', 'foo']


exampleInline: >
  $array = array_map(Strings\splitPattern('/-/'), ['its-foo', 'its-bar']);


  print_r($array); // [['its', 'foo'], ['its', 'bar']]

---
