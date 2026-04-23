---
title: Arrays\natcasesort()
description: >
 Creates a Closure that sorts an array or iterable with a case-insensitive natural order algorithm.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [natcasesort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1245
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "() → (Iterable<string> → string[])"
typeSignatureEn: >
 Returns a function that sorts an iterable of strings by case-insensitive natural ordering, preserving keys.

atGlance: >
 Case-insensitive natural-order sort. Keys preserved. Terminal.

definition: >
 /**
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\natcasesort(): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $nat = Arrays\natcasesort();

 print_r($nat(['IMG10', 'img2', 'IMG1']));

 // ['IMG1', 'img2', 'IMG10']

---
