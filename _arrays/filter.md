---
title: Arrays\filter()
description: >
 Creates a Closure which filters an array or iterable using the defined predicate. Keys are preserved.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filter()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L303
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → Iterable<T>)"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that consumes an iterable of <code>T</code> and yields a filtered iterable of <code>T</code>. Keys are preserved. A Generator source produces a Generator result — nothing is materialised.

atGlance: >
 A higher-order function that takes a predicate and returns a Closure. The Closure yields only the values for which the predicate returns true, lazily — feed it a Generator and you get a Generator back.

definition: >
 /**
   * @param callable(mixed):bool $callable Predicate — return true to keep the value.
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\filter(callable $callable): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source Array or iterable to filter.
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 // Create a function that filters out all values that are not strings.

 $onlyStrings = Arrays\filter('is_string');


 // Called as a function — array in, array out.

 var_dump($onlyStrings(['a', 1, 'b', 2])); // ['a', 'b']


exampleCurried: >
 // Filter an array for all even numbers.

 var_dump(Arrays\filter(fn($v) => $v % 2 === 0)([1, 2, 3, 4, 5])); // [2, 4]


exampleInline: >
 // Pass the Closure straight into another higher order function.

 $positives = array_filter([-2, -1, 0, 1, 2], Arrays\filter(fn($v) => $v > 0));


exampleIterable: >
 // Step 1 — define a Generator source that yields one word at a time.

 $words = (function () {
     yield 'apple';
     yield 'ANT';
     yield 'banana';
     yield 'BEE';
 })();


 // Step 2 — build a reusable filter from the predicate.

 $lowercaseOnlyFilter = Arrays\filter('ctype_lower');


 // Step 3 — apply the filter to the Generator. Nothing runs yet; this returns a new Generator.

 $lowercaseOnly = $lowercaseOnlyFilter($words);


 // Step 4 — consume with foreach. Each value is pulled from the source on demand and the predicate is checked only when needed.

 foreach ($lowercaseOnly as $word) {
     echo $word . PHP_EOL;
 }


 // apple

 // banana

---