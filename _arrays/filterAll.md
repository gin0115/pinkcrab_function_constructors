---
title: Arrays\filterAll()
description: >
 Creates a Closure that returns true when every element of an array or iterable passes the predicate. Short-circuits on the first non-matching value.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter, predicate]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L523
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, short-circuit, accepts-iterable, returns-closure, returns-bool, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → bool)"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that returns true only when every element of an iterable satisfies the predicate.

atGlance: >
 Bind a predicate; the returned Closure asks "do all elements match?". Stops at the first failure — safe with infinite Generators (if a mismatch exists).

definition: >
 /**
   * @param callable(mixed):bool $function
   * @return Closure(iterable<int|string, mixed>):bool
   */
 Arrays\filterAll(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return bool
   */
 $function (iterable $source): bool

examplePartial: >
 $allPositive = Arrays\filterAll(fn($v) => $v > 0);


 var_dump($allPositive([1, 2, 3]));    // true

 var_dump($allPositive([1, -2, 3]));   // false


exampleCurried: >
 var_dump(Arrays\filterAll('is_int')([1, 2, 'three'])); // false

---
