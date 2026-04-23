---
title: Arrays\mapWithKey()
description: >
 Creates a Closure for mapping an array or iterable with access to both value and key in the callback. For parity with the underlying array_map(two-arrays) path the result always has sequential integer keys.

layout: composable_function
group: arrays
subgroup: array_map
categories: [array, array map]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L684
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T, U> ((T, int|string) → U) → (Iterable<T> → Iterable<U>)"
typeSignatureEn: >
 Given a mapper that receives <code>(value, key)</code>, returns a function that transforms every element of an iterable into a <code>U</code>, with sequential integer keys in the result.

atGlance: >
 Like <code>map</code> but the callback also sees the key. Output keys are re-indexed numerically — original keys are passed in, not preserved.

definition: >
 /**
   * @param callable(mixed $value, int|string $key):mixed $func
   * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
   */
 Arrays\mapWithKey(callable $func): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int, mixed>|\Generator<int, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $tag = Arrays\mapWithKey(fn($value, $key) => "$key=$value");


 print_r($tag(['a' => 1, 'b' => 2]));

 // [0 => 'a=1', 1 => 'b=2']


exampleCurried: >
 print_r(Arrays\mapWithKey(fn($v, $k) => "$k:$v")(['x' => 10, 'y' => 20]));

 // [0 => 'x:10', 1 => 'y:20']

---
