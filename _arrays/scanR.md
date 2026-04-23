---
title: Arrays\scanR()
description: >
 Creates a Closure that emits each intermediate accumulation of a right-fold over an array or iterable, ending with the initial value.

layout: composable_function
group: arrays
subgroup: array_fold
categories: [array, scan, fold]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1370
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, accepts-iterable, returns-closure, pure]

typeSignature: "<T, A> ((A, T) → A, A) → (Iterable<T> → Iterable<A>)"
typeSignatureEn: >
 Given a reducer and an initial accumulator, returns a function that emits each running accumulation from right to left, ending with the initial value.

atGlance: >
 Reverse running-fold. Requires materialisation of a Generator source (reverse iteration can't be lazy), but the result is re-yielded for API consistency.

definition: >
 /**
   * @param callable(mixed $carry, mixed $value):mixed $function
   * @param mixed $initialValue
   * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
   */
 Arrays\scanR(callable $function, $initialValue): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int, mixed>|\Generator<int, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $fromRight = Arrays\scanR(fn($acc, $v) => $acc . $v, '');


 print_r($fromRight(['a', 'b', 'c']));

 // ['cba', 'cb', 'c', '']

---
