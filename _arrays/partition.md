---
title: Arrays\partition()
description: >
 Creates a Closure that splits an array or iterable into two buckets by a predicate. Values where the callable returns truthy go in bucket 1, falsy values go in bucket 0.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter, partition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L489
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → [T[], T[]])"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that consumes an iterable and splits it into a 2-element array — index 0 for falsy, index 1 for truthy.

atGlance: >
 Terminal — fully consumes the source. Handy for a single-pass yes/no split without running two filters.

definition: >
 /**
   * @param callable(mixed):(bool|int) $function
   * @return Closure(iterable<int|string, mixed>):array{0:mixed[], 1:mixed[]}
   */
 Arrays\partition(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array{0: mixed[], 1: mixed[]}
   */
 $function (iterable $source): array

examplePartial: >
 $byEven = Arrays\partition(fn($v) => $v % 2 === 0);


 [$odd, $even] = $byEven([1, 2, 3, 4, 5, 6]);


 print_r($odd);  // [1, 3, 5]

 print_r($even); // [2, 4, 6]


exampleCurried: >
 print_r(Arrays\partition('is_string')([1, 'a', 2, 'b']));

 // [0 => [1, 2], 1 => ['a', 'b']]

---
