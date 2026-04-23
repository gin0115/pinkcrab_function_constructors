---
title: Arrays\scan()
description: >
 Creates a Closure that emits each intermediate accumulation of a left-fold over an array or iterable — essentially a "running fold". Starts with the initial value.

layout: composable_function
group: arrays
subgroup: array_fold
categories: [array, scan, fold]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1332
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T, A> ((A, T) → A, A) → (Iterable<T> → Iterable<A>)"
typeSignatureEn: >
 Given a reducer and an initial accumulator, returns a function that emits the initial value, then each running accumulation as it folds the source from left to right.

atGlance: >
 Running-fold — every intermediate accumulator value is yielded. Lazy on Generator input.

definition: >
 /**
   * @param callable(mixed $carry, mixed $value):mixed $function
   * @param mixed $initialValue
   * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
   */
 Arrays\scan(callable $function, $initialValue): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int, mixed>|\Generator<int, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $runningTotal = Arrays\scan(fn($acc, $n) => $acc + $n, 0);


 print_r($runningTotal([1, 2, 3, 4]));

 // [0, 1, 3, 6, 10]


exampleCurried: >
 print_r(Arrays\scan(fn($acc, $v) => $acc . $v, '')(['a', 'b', 'c']));

 // ['', 'a', 'ab', 'abc']

---
