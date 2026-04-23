---
title: Arrays\mapKey()
description: >
 Creates a Closure that transforms the keys of an array or iterable. Setting a key to an existing index overwrites the value already there.

layout: composable_function
group: arrays
subgroup: array_map
categories: [array, array map]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L611
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (int|string → int|string) → (Iterable<T> → Iterable<T>)"
typeSignatureEn: >
 Given a mapper over keys, returns a function that rekeys every entry of an iterable while leaving values untouched.

atGlance: >
 Maps keys, not values. Values stay the same; colliding remapped keys overwrite.

definition: >
 /**
   * @param callable $func
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\mapKey(callable $func): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $prefix = Arrays\mapKey(fn($k) => "__$k");


 print_r($prefix(['a' => 1, 'b' => 2]));

 // ['__a' => 1, '__b' => 2]


exampleCurried: >
 print_r(Arrays\mapKey('strtoupper')(['a' => 1])); // ['A' => 1]

---
