---
title: Arrays\fold()
description: >
 Creates a Closure that reduces an array or iterable left-to-right, starting from an initial accumulator. Equivalent to array_reduce but streams Generator input via foreach without materialising it.

layout: composable_function
group: arrays
subgroup: array_fold
categories: [array, fold, reduce]
coreFunctions: [array_reduce()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1408
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T, A> ((A, T) → A, A) → (Iterable<T> → A)"
typeSignatureEn: >
 Given a reducer and an initial accumulator, returns a function that folds every element of an iterable from left to right into a single result of the same type as the accumulator.

atGlance: >
 The canonical left fold / reduce. Terminal — consumes the source fully but streams it (no materialisation).

definition: >
 /**
   * @param callable(mixed $carry, mixed $value): mixed $callable
   * @param mixed $initial
   * @return Closure(iterable<int|string, mixed>):mixed
   */
 Arrays\fold(callable $callable, $initial = []): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed
   */
 $function (iterable $source)

examplePartial: >
 $sum = Arrays\fold(fn($acc, $n) => $acc + $n, 0);


 echo $sum([1, 2, 3, 4]); // 10


exampleCurried: >
 echo Arrays\fold(fn($acc, $n) => $acc * $n, 1)([1, 2, 3, 4]); // 24

---
