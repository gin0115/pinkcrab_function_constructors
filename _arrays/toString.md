---
title: Arrays\toString()
description: >
 Creates a function which casts an array to a string using the defined glue.

layout: function
group: arrays
subgroup: array_transformation
categories: [array, array transformation]
coreFunctions: 
    - join()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L168
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for casting an array to a string.
  *
  * @param string|null $glue
  * @return Closure(array<int|string, mixed>): string
  */
 Arrays\toString(?string $glue): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return string
   */
 $function (array $data): string

examplePartial: >
 // Create the closure that casts an array to a string with a comma as the glue.

 $commaSeparated = Arrays\toString(',');


 // Called as a function.

 var_dump($commaSeparated(['b', 'c'])); // b,c



exampleCurried: >
 // Casts to a string with - as the glue

  print Arrays\toString('-')(['b', 'c']); // b-c



exampleInline: >
 $array = array_map( Arrays\toString('---'), [
    ['Once', 'upon', 'time'],
    ['Find', 'the', 'time']
 ]);
 

 print_r($array); // ['Once---upon---time', 'Find---the---time']

---