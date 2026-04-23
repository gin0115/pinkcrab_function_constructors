---
title: Arrays\uksort()
description: >
 Creates a Closure that sorts an array or iterable by key using a custom comparator function.

layout: composable_function
group: arrays
subgroup: array_sort
categories: [array, sort]
coreFunctions: [uksort()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1265
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "((int|string, int|string) → int) → (Iterable<T> → T[])"
typeSignatureEn: >
 Given a comparator that compares two keys, returns a function that sorts the source by the comparator's verdict.

atGlance: >
 Custom key sort — comparator returns negative / zero / positive like any standard comparator. Keys preserved. Terminal.

definition: >
 /**
   * @param callable(mixed $a, mixed $b): int $function
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\uksort(callable $function): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $byKeyLen = Arrays\uksort(fn($a, $b) => strlen($a) - strlen($b));


 print_r($byKeyLen(['bbb' => 1, 'a' => 2, 'cc' => 3]));

 // ['a' => 2, 'cc' => 3, 'bbb' => 1]

---
