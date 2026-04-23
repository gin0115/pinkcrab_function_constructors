---
title: Arrays\arsort()
description: >
 Creates a Closure that sorts an array or iterable by value in descending order, preserving key-value associations.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [arsort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1207
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "int → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a sort flag, returns a function that produces a new array sorted by value descending, keeping each value bound to its original key.

atGlance: >
 Reverse value sort. Keys preserved. Terminal.

definition: >
 /**
   * @param int $flag PHP sort flag constant.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\arsort(int $flag = SORT_REGULAR): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byValueDesc = Arrays\arsort();

 print_r($byValueDesc(['a' => 1, 'b' => 3, 'c' => 2]));

 // ['b' => 3, 'c' => 2, 'a' => 1]

---
