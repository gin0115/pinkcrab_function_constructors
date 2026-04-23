---
title: Arrays\replaceRecursive()
description: >
 Creates a Closure that recursively replaces values in an array or iterable based on matching keys — like array_replace_recursive() but curried.

layout: composable_function
group: arrays
subgroup: array_manipulation
categories: [array, replace]
coreFunctions: [array_replace_recursive()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L976
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, variadic, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> ...T[] → (Iterable<T> → T[])"
typeSignatureEn: >
 Given one or more replacement arrays, returns a function that recursively merges them into the source — later replacements win, nested arrays are merged too.

atGlance: >
 Wraps <code>array_replace_recursive()</code>. Terminal on Generator input.

definition: >
 /**
   * @param mixed[] ...$with
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\replaceRecursive(array ...$with): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $defaults = ['theme' => ['font' => 'Arial', 'size' => 12]];


 $setFont = Arrays\replaceRecursive(['theme' => ['font' => 'Comic Sans']]);


 print_r($setFont($defaults));

 // ['theme' => ['font' => 'Comic Sans', 'size' => 12]]

---
