---
title: Arrays\natsort()
description: >
 Creates a Closure that sorts an array or iterable with a "natural order" algorithm — e.g. "img10" comes after "img2" instead of before it.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [natsort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1226
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "() → (Iterable<string> → string[])"
typeSignatureEn: >
 Returns a function that sorts an iterable of strings by natural ordering (human-readable number ordering), preserving keys.

atGlance: >
 Natural-order sort. Keys preserved. Terminal.

definition: >
 /**
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\natsort(): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $nat = Arrays\natsort();

 print_r($nat(['img10', 'img2', 'img1']));

 // ['img1', 'img2', 'img10']

---
