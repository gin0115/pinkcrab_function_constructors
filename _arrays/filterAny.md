---
title: Arrays\filterAny()
description: >
 Creates a Closure that returns true when at least one element of an array or iterable passes the predicate. Short-circuits on the first match.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter, predicate]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L547
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, short-circuit, accepts-iterable, returns-closure, returns-bool, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → bool)"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that returns true as soon as any element of an iterable satisfies the predicate.

atGlance: >
 Bind a predicate; the returned Closure asks "does any element match?". Stops at the first match — safe with infinite Generators (if a match exists).

definition: >
 /**
   * @param callable(mixed):bool $function
   * @return Closure(iterable<int|string, mixed>):bool
   */
 Arrays\filterAny(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return bool
   */
 $function (iterable $source): bool

examplePartial: >
 $anyNegative = Arrays\filterAny(fn($v) => $v < 0);


 var_dump($anyNegative([1, 2, 3]));     // false

 var_dump($anyNegative([1, -2, 3]));    // true


exampleCurried: >
 var_dump(Arrays\filterAny('is_string')([1, 2, 'three'])); // true

---
