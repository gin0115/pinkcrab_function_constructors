---
title: Arrays\filter()
description: >
 Create a function which filters an array using the defined predicate.

layout: function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filter()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L268
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for filtering the passed array
  *
  * @param callable(mixed): bool $callable The predicate function that determines if the value should be kept.
  * @return Closure(array<int|string, mixed>): array<int|string, mixed>
  */
 Arrays\filter(callable $callback): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return array<int|string, mixed>
   */
 $function (array $data): array

examplePartial: >
 // Create a function that will filter out all values that are not strings.

 $filter = Arrays\filter('is_string');  


 // Called as a function.

 var_dump($filter(['a', 1, 'b', 2])); // ['a', 'b']


exampleCurried: >
 // Filter an array for all even numbers.

 var_dump(Arrays\filter(fn($v) => $v % 2 === 0)([1, 2, 3, 4, 5])); // [2, 4]

---