---
title: Arrays\filterFirst()
description: >
 Creates a Closure that returns the first value of an array or iterable that matches the predicate, or null if nothing matches. Short-circuits — the source is consumed only up to (and including) the first match.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter, short-circuit]
coreFunctions: [array_filter()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L390
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, short-circuit, accepts-iterable, returns-closure, pure]

typeSignature: "<T> (T → bool) → (Iterable<T> → T | null)"
typeSignatureEn: >
 Given a predicate on <code>T</code>, returns a function that consumes an iterable of <code>T</code> and returns either a <code>T</code> (the first match) or <code>null</code> (no match).

atGlance: >
 A higher-order reducer. The returned Closure stops pulling from the source at the first match — safe with infinite Generators. Returns <code>null</code> when nothing matches.

definition: >
 /**
   * @param callable(mixed):bool $func Predicate — the first value returning true is returned.
   * @return Closure(iterable<int|string, mixed>):?mixed
   */
 Arrays\filterFirst(callable $func): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source Array or iterable to scan.
   * @return mixed|null The first matching value, or null if nothing matches.
   */
 $function (iterable $source)

examplePartial: >
 // Create a function that returns the first string value found.

 $firstString = Arrays\filterFirst('is_string');


 // Called as a function.

 var_dump($firstString([null, 1, 'b', 2, 'c'])); // 'b'

 var_dump($firstString([null, 1, 2]));           // NULL


exampleCurried: >
 // Return the first multiple of 15.

 var_dump(Arrays\filterFirst(fn($v) => $v % 15 === 0)([1, 2, 3, 15, 30])); // 15


exampleInline: >
 // Drop the Closure straight into another callable if you never intend to reuse it.

 $firstNegative = Arrays\filterFirst(fn($n) => $n < 0)([3, 1, 4, -1, 5, -9]);

 var_dump($firstNegative); // -1


exampleIterable: >
 // Step 1 — a Generator that announces each value as it yields it.

 $words = (function () {
     echo "yielded apple\n";    yield 'apple';
     echo "yielded ANT\n";      yield 'ANT';
     echo "yielded banana\n";   yield 'banana';
     echo "yielded BEE\n";      yield 'BEE';
 })();


 // Step 2 — build a reusable "first lowercase word" finder.

 $firstLowercase = Arrays\filterFirst('ctype_lower');


 // Step 3 — call it. The Generator is advanced only until the first match is found.

 echo $firstLowercase($words);


 // Output:

 // yielded apple

 // apple


 // "yielded ANT", "yielded banana", "yielded BEE" never printed — the source was never asked for them.

---
