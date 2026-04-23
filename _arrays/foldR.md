---
title: Arrays\foldR()
description: >
 Creates a Closure that reduces an array or iterable right-to-left, starting from an initial accumulator.

layout: composable_function
group: arrays
subgroup: array_fold
categories: [array, fold, reduce]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1434
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T, A> ((A, T) → A, A) → (Iterable<T> → A)"
typeSignatureEn: >
 Given a reducer and an initial accumulator, returns a function that folds every element of an iterable from right to left into a single result.

atGlance: >
 The right fold — useful when ordering affects accumulation. Terminal and must materialise a Generator to iterate backwards.

definition: >
 /**
   * @param callable(mixed $carry, mixed $value): mixed $callable
   * @param mixed $initial
   * @return Closure(iterable<int|string, mixed>):mixed
   */
 Arrays\foldR(callable $callable, $initial = []): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed
   */
 $function (iterable $source)

examplePartial: >
 $joinReversed = Arrays\foldR(fn($acc, $v) => $acc . $v, '');


 echo $joinReversed(['a', 'b', 'c']); // cba


exampleCurried: >
 echo Arrays\foldR(fn($acc, $n) => $acc - $n, 100)([1, 2, 3]); // 100 - 3 - 2 - 1 = 94

---
