---
title: Arrays\sort()
description: >
 Creates a Closure that sorts an array or iterable using the standard PHP sort algorithm. Keys are NOT maintained.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [sort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1106
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "int → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a sort flag, returns a function that produces a new array of the same elements sorted in ascending order. Keys are discarded.

atGlance: >
 Terminal — fully materialises the source. Immutable alternative to PHP's in-place <code>sort()</code>.

definition: >
 /**
   * @param int $flag PHP sort flag constant.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\sort(int $flag = SORT_REGULAR): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $asc = Arrays\sort();

 print_r($asc([3, 1, 2])); // [1, 2, 3]


exampleCurried: >
 print_r(Arrays\sort(SORT_STRING)(['Zoo', 'cat', 'Dog']));

 // ['Dog', 'Zoo', 'cat']

---
