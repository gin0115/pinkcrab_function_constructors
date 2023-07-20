---
title: Arrays\filterMap()
description: >
 Create a function which filters and then maps an array. This is done by defining both the predicate and the mapping function.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter, array map]
coreFunctions: [array_filter(), array_map()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L385
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Creates a Closure which takes an array, applies a filter, then maps the
  * results of the map.
  *
  *
  * @param callable(mixed):bool $filter Function to of filter contents
  * @param callable(mixed):mixed $map Function to map results of filter function.
  * @return Closure(array<int|string, mixed>):array<int|string, mixed>
  */
 Arrays\filterMap(callable $filter, callable $map): Closure
closure: >
 /**
  * @param array<int|string, mixed> $array The array to filter then map.
  * @return array<int|string, mixed>
  */
 $function (array $data): array

examplePartial: >
 // Create a function that will remove all none integer values and then multiply by 2.

 $filterMap = Arrays\filterMap('is_int', fn($v) => $v * 2);


 // Called as a function.  

 var_dump($filterMap([1, 'Apple', 3.14, '4', 5, 10]));
 // [2, 10, 20] 

exampleCurried: >
 // Filter out all none string values and then convert to uppercase.

 var_dump(
  Arrays\filterMap('is_string', 'strtoupper')
  (['Apple', 1, 'Orange', 2, 'Banana', 3, 'Pear', 4, 'Peach', 5])
 );  

 // ['APPLE', 'ORANGE', 'BANANA', 'PEAR', 'PEACH']

---