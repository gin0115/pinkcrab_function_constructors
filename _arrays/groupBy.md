---
title: Arrays\groupBy()
description: >
 Creates a Closure that groups an array or iterable into buckets keyed by the result of the callback.

layout: composable_function
group: arrays
subgroup: array_grouping
categories: [array, grouping]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L795
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → int|string) → (Iterable<T> → map<int|string, T[]>)"
typeSignatureEn: >
 Given a key-producing function on <code>T</code>, returns a function that collects elements of an iterable into buckets keyed by the function's return value.

atGlance: >
 Group a collection by a key derived from each element. Terminal — consumes the whole source.

definition: >
 /**
   * @param callable(mixed):(string|int) $function
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\groupBy(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byParity = Arrays\groupBy(fn($n) => $n % 2 === 0 ? 'even' : 'odd');


 print_r($byParity([1, 2, 3, 4]));

 // ['odd' => [1, 3], 'even' => [2, 4]]


exampleCurried: >
 print_r(Arrays\groupBy(fn($u) => $u['role'])([
   ['role' => 'admin', 'id' => 1],
   ['role' => 'user',  'id' => 2],
   ['role' => 'admin', 'id' => 3],
 ]));

---
