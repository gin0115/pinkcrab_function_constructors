---
title: Arrays\takeUntil()
description: >
 Creates a Closure that yields elements of an array or iterable until the predicate returns true — stops exclusive (the triggering element is NOT included).

layout: composable_function
group: arrays
subgroup: array_take
categories: [array, take]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1554
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, short-circuit, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → Iterable<T>)"
typeSignatureEn: >
 Given a stop-predicate on <code>T</code>, returns a function that yields elements of any iterable until the predicate returns true; the triggering element is excluded.

atGlance: >
 Lazy prefix — walk forward, stop as soon as the predicate is true. Safe with infinite Generators.

definition: >
 /**
   * @param callable(mixed): bool $conditional
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\takeUntil(callable $conditional): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $untilNegative = Arrays\takeUntil(fn($n) => $n < 0);

 print_r($untilNegative([1, 2, 3, -1, 4])); // [1, 2, 3]

---
