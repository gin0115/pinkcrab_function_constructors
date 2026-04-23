---
title: Arrays\each()
description: >
 Creates a Closure that iterates over an array or iterable, invoking the callback with each (key, value) pair for its side effect. Returns void.

layout: composable_function
group: arrays
subgroup: array_iteration
categories: [array, side-effect]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L716
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, terminal, accepts-iterable, returns-closure]

typeSignature: "<T> ((int|string, T) → void) → (Iterable<T> → void)"
typeSignatureEn: >
 Given a side-effecting callback that receives <code>(key, value)</code>, returns a function that runs it over every element of an iterable, returning nothing.

atGlance: >
 The "for side effects only" iterator — no return value. Terminal; the whole source is consumed.

definition: >
 /**
   * @param callable(int|string $key, mixed $value):void $func
   * @return Closure(iterable<int|string, mixed>):void
   */
 Arrays\each(callable $func): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return void
   */
 $function (iterable $source): void

examplePartial: >
 $log = Arrays\each(function ($key, $value) {
     echo "$key => $value\n";
 });


 $log(['a' => 1, 'b' => 2]);

 // a => 1

 // b => 2

---
