---
title: Arrays\sumWhere()
description: >
 Creates a Closure that sums the result of applying a callback to each element of an array or iterable — like mapping-then-summing in a single pass.

layout: composable_function
group: arrays
subgroup: array_fold
categories: [array, sum, reduce]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1014
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → number) → (Iterable<T> → number)"
typeSignatureEn: >
 Given a function from <code>T</code> to a number, returns a function that sums those numbers over every element of an iterable of <code>T</code>.

atGlance: >
 Map + sum in one pass. Terminal — consumes the whole source.

definition: >
 /**
   * @param callable(mixed):(int|float) $function Applied to each value before summing.
   * @return Closure(iterable<int|string, mixed>):(int|float)
   */
 Arrays\sumWhere(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return int|float
   */
 $function (iterable $source)

examplePartial: >
 $totalAge = Arrays\sumWhere(fn($p) => $p['age']);


 echo $totalAge([['age' => 20], ['age' => 30], ['age' => 25]]); // 75


exampleCurried: >
 echo Arrays\sumWhere(fn($n) => $n * 2)([1, 2, 3]); // 12

---
