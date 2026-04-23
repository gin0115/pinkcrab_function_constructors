---
title: Arrays\take()
description: >
 Creates a Closure that takes the first N elements of an array or iterable. For Generators, only those N values are pulled — the source is not advanced past them.

layout: composable_function
group: arrays
subgroup: array_take
categories: [array, take]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1480
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, short-circuit, accepts-iterable, returns-closure, pure, throws]

typeSignature: "<T> int → (Iterable<T> → Iterable<T>)"
typeSignatureEn: >
 Given a count, returns a function that yields the first <code>count</code> elements of any iterable; safe with infinite Generators.

atGlance: >
 Bind a cap; the returned Closure pulls up to that many values and stops. Throws on negative counts.

definition: >
 /**
   * @param int $count
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   * @throws \InvalidArgumentException if count is negative.
   */
 Arrays\take(int $count = 1): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $first3 = Arrays\take(3);

 print_r($first3([1, 2, 3, 4, 5])); // [1, 2, 3]


exampleIterable: >
 $naturals = (function () { $i = 1; while (true) yield $i++; })();


 foreach (Arrays\take(5)($naturals) as $n) echo $n; // 12345

 // Rest of the Generator is never pulled — infinite source is safe here.

---
