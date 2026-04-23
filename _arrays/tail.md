---
title: Arrays\tail()
description: >
 Returns the remainder of an array or iterable after the first element has been removed. An array returns either a new array (or null if empty). A Generator returns a Generator that lazily yields every element after the first; an empty Generator source yields an empty Generator, not null.

layout: composable_function
group: arrays
subgroup: array_access
categories: [array, array access]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L147
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, lazy, accepts-iterable, returns-value, pure]

typeSignature: "<T> Iterable<T> → Iterable<T> | null"
typeSignatureEn: >
 Takes an iterable of <code>T</code> directly. Returns an array or Generator of every element except the first — or <code>null</code> for an empty array source.

atGlance: >
 Direct call — not a Closure constructor. For Generators it streams lazily; for arrays it returns a new array (or <code>null</code> when empty).

definition: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>|null
   */
 Arrays\tail(iterable $source)

examplePartial: >
 var_dump(Arrays\tail(['a', 'b', 'c'])); // ['b', 'c']

 var_dump(Arrays\tail(['only']));        // []

 var_dump(Arrays\tail([]));              // NULL


exampleIterable: >
 $gen = (function () { yield 'a'; yield 'b'; yield 'c'; })();

 foreach (Arrays\tail($gen) as $v) echo $v; // bc

---
