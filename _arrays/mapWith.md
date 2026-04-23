---
title: Arrays\mapWith()
description: >
 Creates a Closure for mapping an array or iterable where the callback receives each element alongside additional bound arguments.

layout: composable_function
group: arrays
subgroup: array_map
categories: [array, array map]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L647
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, variadic, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T, U> ((T, ...any) → U, ...any) → (Iterable<T> → Iterable<U>)"
typeSignatureEn: >
 Given a mapper that takes extra arguments and a set of values to thread in, returns a function that invokes <code>$func($value, ...$data)</code> for every element of the source.

atGlance: >
 Like <code>map</code> but with extra arguments threaded into every call — useful for mappers that need context beyond the value itself.

definition: >
 /**
   * @param callable(mixed ...):mixed $func
   * @param mixed ...$data Extra args passed after each value.
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\mapWith(callable $func, ...$data): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $join = Arrays\mapWith(fn($v, $sep, $suf) => $v . $sep . $suf, '-', '!');


 print_r($join(['foo', 'bar'])); // ['foo-!', 'bar-!']


exampleCurried: >
 print_r(Arrays\mapWith('str_repeat', 2)(['ab', 'cd'])); // ['abab', 'cdcd']

---
