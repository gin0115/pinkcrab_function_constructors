---
title: Arrays\ksort()
description: >
 Creates a Closure that sorts an array or iterable by key in ascending order, preserving key-value associations.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [ksort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1147
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "int → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a sort flag, returns a function that produces a new array sorted by key ascending. Values stay bound to their original keys.

atGlance: >
 Sort by key, keep keys. Terminal on Generator input.

definition: >
 /**
   * @param int $flag PHP sort flag constant.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\ksort(int $flag = SORT_REGULAR): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byKey = Arrays\ksort();

 print_r($byKey(['b' => 2, 'a' => 1]));

 // ['a' => 1, 'b' => 2]

---
