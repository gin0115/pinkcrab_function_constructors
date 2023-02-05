---
layout: function
group: strings
subgroup: string_transform


title: Strings\split()
subtitle: Allows you to create a function which can be used to split a string with a defined starting and ending char index. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L65
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string transform]
coreFunctions: 
    - explode()

deprecated: false
alternative: false

definition: >
 /**
   * @param non-empty-string $separator The char to split by.
   * @param int $limit The number of groups to split into.
   * @return Closure(string):array<string> The parts
   */
  Strings\split(string $separator, int $limit = PHP_INT_MAX): Closure

closure: >
 /**
   * @param string $string The string to be split
   * @return array<int, string>
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a closure which will take the first 2 characters of a string.

 $splitFirst2 = Strings\split(',', 2);  


 // Called as a function.

 echo $splitFirst2('Hello,World'); // [Hello, World]


 // Used in a higher order function.

 $array = array_map( $splitFirst2, ['Hello,World', 'Foo,Bar']);

 print_r($array); // [[Hello, World], [Foo, Bar]]




exampleCurried: >
 echo Strings\split('-')('Hello-World'); // [Hello, World]

exampleInline: >
 $array = array_map( Strings\split('-'), ['Hello-World', 'Foo-Bar']);

  print_r($array); // [[Hello, World], [Foo, Bar]]

---



