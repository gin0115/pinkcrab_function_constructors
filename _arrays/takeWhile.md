---
title: Arrays\takeWhile()
description: >
 Creates a Closure that yields elements of an array or iterable while the predicate returns true — stops exclusive at the first falsy element.

layout: composable_function
group: arrays
subgroup: array_take
categories: [array, take]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1593
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, short-circuit, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → Iterable<T>)"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that yields elements of any iterable while the predicate holds; stops at the first falsy result (not included).

atGlance: >
 Lazy prefix — the complement of <code>takeUntil</code>. Safe with infinite Generators.

definition: >
 /**
   * @param callable(mixed): bool $conditional
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\takeWhile(callable $conditional): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $whilePositive = Arrays\takeWhile(fn($n) => $n > 0);

 print_r($whilePositive([1, 2, 3, -1, 4])); // [1, 2, 3]

---
