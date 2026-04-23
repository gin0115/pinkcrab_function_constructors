---
title: Arrays\last()
description: >
 Returns the last value of an array or iterable, or null if the source is empty. For a Generator the whole stream is consumed (there is no way to know the last value without doing so).

layout: composable_function
group: arrays
subgroup: array_access
categories: [array, array access]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L122
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [reducer, terminal, accepts-iterable, returns-value, pure]

typeSignature: "<T> Iterable<T> → T | null"
typeSignatureEn: >
 Takes an iterable of <code>T</code> directly and returns the last <code>T</code>, or <code>null</code> if the source is empty.

atGlance: >
 Direct call — not a Closure constructor. Terminal — must consume the entire source. Do not use with infinite Generators.

definition: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed The last value, or null if empty.
   */
 Arrays\last(iterable $source)

examplePartial: >
 var_dump(Arrays\last(['a', 'b', 'c'])); // 'c'

 var_dump(Arrays\last([]));              // NULL

---
