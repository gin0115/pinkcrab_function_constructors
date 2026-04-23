---
title: Arrays\replace()
description: >
 Creates a Closure that replaces values in an array or iterable based on matching keys — like array_replace() but curried.

layout: composable_function
group: arrays
subgroup: array_manipulation
categories: [array, replace]
coreFunctions: [array_replace()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L995
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, variadic, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> ...T[] → (Iterable<T> → T[])"
typeSignatureEn: >
 Given one or more replacement arrays, returns a function that overrides the source's values at matching keys — later replacements win.

atGlance: >
 Wraps <code>array_replace()</code>. Terminal — Generator input is materialised first.

definition: >
 /**
   * @param mixed[] ...$with Arrays whose values override the source at matching keys.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\replace(array ...$with): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $setXY = Arrays\replace(['x' => 1, 'y' => 2]);


 print_r($setXY(['x' => 0, 'y' => 0, 'z' => 0]));

 // ['x' => 1, 'y' => 2, 'z' => 0]

---
