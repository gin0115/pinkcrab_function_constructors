---
title: Arrays\filterKey()
description: >
 Create a function which filters an arrays keys using the defined predicate.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filterKey() <i>(with ARRAY_FILTER_USE_KEY option)</i>]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L268
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
  * Returns a Closure for filtering the passed arrays keys
  *
  * @param callable(mixed): bool $callable The predicate function that determines if the value should be kept.
  * @return Closure(array<int|string, mixed>): array<int|string, mixed>
  */
 Arrays\filterKey(callable $callback): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return array<int|string, mixed>
   */
 $function (array $data): array

examplePartial: >
 // Create a function that will filter out all values that are not strings.

 $filter = Arrays\filterKey(fn($v) => $v % 2 === 0);  


 // Called as a function.

 var_dump($filterKey([1 => 'a', 2 => 'b' ])); // ['b']


exampleCurried: >
 // Filter an array for all even numbers.

 var_dump(Arrays\filterKey(fn($v) => $v % 2 === 0)([1 => 'a', 2 => 'b' ])); // ['b']

---