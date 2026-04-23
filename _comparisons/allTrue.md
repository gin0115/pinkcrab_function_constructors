---
title: Comparisons\allTrue()
description: >
 Direct predicate — returns true when every passed boolean argument is strictly true.

layout: composable_function
group: comparisons
subgroup: boolean
categories: [comparison, predicate, boolean]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L298
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, variadic, returns-bool, pure]

typeSignature: "...bool → bool"
typeSignatureEn: >
 Takes any number of booleans directly and returns true only when all of them are true.

atGlance: >
 Variadic AND over booleans. For predicate combination use <code>groupAnd</code> / <code>all</code>.

definition: >
 /**
   * @param bool ...$variables
   * @return bool
   */
 Comparisons\allTrue(bool ...$variables): bool

examplePartial: >
 var_dump(Comparisons\allTrue(true, true, true));  // true

 var_dump(Comparisons\allTrue(true, false, true)); // false


 // Great for summarising a batch of bool results.

 $checks = [
   Comparisons\isNumber($n),
   Comparisons\isGreaterThan(0)($n),
   Comparisons\isLessThan(100)($n),
 ];

 var_dump(Comparisons\allTrue(...$checks));

---
