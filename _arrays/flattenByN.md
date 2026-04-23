---
title: Arrays\flattenByN()
description: >
 Creates a Closure that flattens nested arrays up to a specified depth. Empty nested arrays are dropped.

layout: composable_function
group: arrays
subgroup: array_manipulation
categories: [array, flatten]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L919
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "int? → (Iterable<mixed> → Iterable<mixed>)"
typeSignatureEn: >
 Given an optional depth, returns a function that flattens nested arrays up to that depth; null means flatten completely.

atGlance: >
 Depth-limited flatten. Pass null (or no argument) to flatten fully. Lazy on Generator input.

definition: >
 /**
   * @param int|null $n Depth to flatten. Null = fully.
   * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
   */
 Arrays\flattenByN(?int $n = null): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int, mixed>|\Generator<int, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $flatOne = Arrays\flattenByN(1);


 print_r($flatOne([1, [2, [3, 4]], 5]));

 // [1, 2, [3, 4], 5]


 $flatAll = Arrays\flattenByN();

 print_r($flatAll([1, [2, [3, 4]], 5]));

 // [1, 2, 3, 4, 5]


exampleCurried: >
 print_r(Arrays\flattenByN(2)([[[1]], [[2], [3]]]));

 // [1, [2], [3]]    // wait — 2 levels deep

---
