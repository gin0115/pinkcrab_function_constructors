---
title: Arrays\chunk()
description: >
 Creates a Closure that splits an array or iterable into batches of up to N elements. The final batch may be smaller if the source size doesn't divide evenly.

layout: composable_function
group: arrays
subgroup: array_manipulation
categories: [array, chunk]
coreFunctions: [array_chunk()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L831
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (int, bool) → (Iterable<T> → Iterable<T[]>)"
typeSignatureEn: >
 Given a chunk size and a preserve-keys flag, returns a function that yields batches of up to N consecutive elements from an iterable.

atGlance: >
 Batch an iterable into groups of N. Lazy — yields each batch as it's filled. Values below 1 for the size are clamped to 1.

definition: >
 /**
   * @param int $count Max size of each chunk.
   * @param bool $preserveKeys Should source keys be kept inside each batch.
   * @return Closure(iterable<int|string, mixed>):(array<int, array<int|string, mixed>>|\Generator<int, array<int|string, mixed>>)
   */
 Arrays\chunk(int $count, bool $preserveKeys = false): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int, array<int|string, mixed>>|\Generator<int, array<int|string, mixed>>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $pairs = Arrays\chunk(2);


 print_r($pairs([1, 2, 3, 4, 5]));

 // [[1, 2], [3, 4], [5]]


exampleCurried: >
 print_r(Arrays\chunk(3)(['a', 'b', 'c', 'd', 'e']));

 // [['a', 'b', 'c'], ['d', 'e']]

---
