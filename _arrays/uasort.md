---
title: Arrays\uasort()
description: >
 Creates a Closure that sorts an array or iterable by value using a custom comparator, preserving keys.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [uasort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1285
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T> ((T, T) → int) → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a comparator on <code>T</code> values, returns a function that sorts the source by the comparator's verdict while keeping each value bound to its original key.

atGlance: >
 Custom value sort. Keys preserved. Terminal.

definition: >
 /**
   * @param callable(mixed $a, mixed $b): int $function
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\uasort(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byAuthor = Arrays\uasort(fn($a, $b) => strcmp($a['author'], $b['author']));


 $books = [
   'bk1' => ['author' => 'Carter'],
   'bk2' => ['author' => 'Adams'],
   'bk3' => ['author' => 'Baker'],
 ];


 print_r($byAuthor($books));

 // ['bk2' => ..., 'bk3' => ..., 'bk1' => ...]

---
