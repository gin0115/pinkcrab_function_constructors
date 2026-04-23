---
title: Arrays\rsort()
description: >
 Creates a Closure that sorts an array or iterable in reverse (descending) order. Keys are NOT maintained.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [rsort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1126
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "int → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a sort flag, returns a function that produces a new array sorted in descending order. Keys are discarded.

atGlance: >
 Terminal — fully materialises the source. Immutable alternative to PHP's in-place <code>rsort()</code>.

definition: >
 /**
   * @param int $flag PHP sort flag constant.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\rsort(int $flag = SORT_REGULAR): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $desc = Arrays\rsort();

 print_r($desc([1, 3, 2])); // [3, 2, 1]


exampleCurried: >
 print_r(Arrays\rsort()([1, 3, 2])); // [3, 2, 1]

---
