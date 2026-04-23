---
title: Arrays\takeLast()
description: >
 Creates a Closure that takes the last N elements of an array or iterable. Terminal — the last N are only knowable once the source has been fully consumed.

layout: composable_function
group: arrays
subgroup: array_take
categories: [array, take]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1519
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure, throws]

typeSignature: "<T> int → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a count, returns a function that produces an array of the last <code>count</code> elements of any iterable.

atGlance: >
 Terminal — consumes the whole source. Do not use with infinite Generators. Throws on negative counts.

definition: >
 /**
   * @param int $count
   * @return Closure(iterable<int|string, mixed>):mixed[]
   * @throws \InvalidArgumentException if count is negative.
   */
 Arrays\takeLast(int $count = 1): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $last3 = Arrays\takeLast(3);

 print_r($last3([1, 2, 3, 4, 5])); // [3, 4, 5]

---
