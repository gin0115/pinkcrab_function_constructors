---
title: Arrays\filterCount()
description: >
 Creates a Closure that counts how many elements of an array or iterable pass the predicate.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filter(), count()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L468
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → int)"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that consumes an iterable of <code>T</code> and returns how many elements satisfied the predicate.

atGlance: >
 Terminal — consumes the whole source and returns an int. Equivalent to <code>count(filter(fn)($src))</code> in one step.

definition: >
 /**
   * @param callable(mixed):bool $function
   * @return Closure(iterable<int|string, mixed>):int
   */
 Arrays\filterCount(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return int
   */
 $function (iterable $source): int

examplePartial: >
 $evenCount = Arrays\filterCount(fn($v) => $v % 2 === 0);

 echo $evenCount([1, 2, 3, 4, 5, 6]); // 3


exampleCurried: >
 echo Arrays\filterCount('is_string')([1, 'a', 2, 'b', null]); // 2

---
