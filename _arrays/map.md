---
title: Arrays\map()
description: >
 Creates a Closure that applies a callback to every element of an array or iterable, yielding a new collection of transformed values. Keys are preserved.

layout: composable_function
group: arrays
subgroup: array_map
categories: [array, array map]
coreFunctions: [array_map()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L583
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T, U> (T → U) → (Iterable<T> → Iterable<U>)"
typeSignatureEn: >
 Given a mapper from <code>T</code> to <code>U</code>, returns a function that transforms every element of an iterable of <code>T</code> into an iterable of <code>U</code>.

atGlance: >
 The canonical map. Lazy — Generator in, Generator out, keys preserved.

definition: >
 /**
   * @param callable(mixed):mixed $func
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\map(callable $func): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $double = Arrays\map(fn($n) => $n * 2);


 print_r($double([1, 2, 3])); // [2, 4, 6]


exampleCurried: >
 print_r(Arrays\map('strtoupper')(['a', 'b'])); // ['A', 'B']


exampleInline: >
 $upper = array_map('strtoupper', ['a', 'b']); // vanilla PHP
---
