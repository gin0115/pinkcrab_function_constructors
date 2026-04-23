---
title: Arrays\usort()
description: >
 Creates a Closure that sorts an array or iterable by value using a custom comparator. Keys are NOT maintained.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [usort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1306
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> ((T, T) → int) → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a comparator on <code>T</code> values, returns a function that sorts the source by the comparator and discards the original keys.

atGlance: >
 Custom value sort with re-indexed output. Terminal.

definition: >
 /**
   * @param callable(mixed $a, mixed $b): int $function
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\usort(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byLen = Arrays\usort(fn($a, $b) => strlen($a) - strlen($b));


 print_r($byLen(['banana', 'a', 'to']));

 // ['a', 'to', 'banana']

---
