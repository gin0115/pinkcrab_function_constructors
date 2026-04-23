---
title: Arrays\flatMap()
description: >
 Creates a Closure that flattens nested arrays up to a given depth and applies a callback to each leaf element along the way.

layout: composable_function
group: arrays
subgroup: array_map
categories: [array, array map, flatten]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L740
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T, U> ((T → U), int?) → (Iterable<T | T[]> → Iterable<U>)"
typeSignatureEn: >
 Given a mapper and an optional depth, returns a function that recursively flattens nested arrays in the source up to that depth, applying the mapper to each leaf value.

atGlance: >
 Map + flatten in one operation. Null depth means flatten fully.

definition: >
 /**
   * @param callable(mixed):mixed $function Applied to leaf values.
   * @param int|null $n Recursion depth; null flattens fully.
   * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
   */
 Arrays\flatMap(callable $function, ?int $n = null): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int, mixed>|\Generator<int, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $doubleFlat = Arrays\flatMap(fn($n) => $n * 2);


 print_r($doubleFlat([1, [2, [3, 4]], 5]));

 // [2, 4, 6, 8, 10]


exampleCurried: >
 print_r(Arrays\flatMap('strtoupper', 1)([['a'], ['b', ['c']]]));

 // ['A', 'B', ['C']]   // only one level flattened

---
