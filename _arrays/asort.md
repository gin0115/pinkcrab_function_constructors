---
title: Arrays\asort()
description: >
 Creates a Closure that sorts an array or iterable by value in ascending order, preserving key-value associations.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [asort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1187
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "int → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a sort flag, returns a function that produces a new array sorted by value ascending, keeping each value bound to its original key.

atGlance: >
 Sort by value, keep keys. Terminal.

definition: >
 /**
   * @param int $flag PHP sort flag constant.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\asort(int $flag = SORT_REGULAR): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byValue = Arrays\asort();

 print_r($byValue(['b' => 3, 'a' => 1, 'c' => 2]));

 // ['a' => 1, 'c' => 2, 'b' => 3]

---
