---
title: Comparisons\anyTrue()
description: >
 Direct predicate — returns true when at least one passed boolean argument is strictly true.

layout: composable_function
group: comparisons
subgroup: boolean
categories: [comparison, predicate, boolean]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L314
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, variadic, returns-bool, pure]

typeSignature: "...bool → bool"
typeSignatureEn: >
 Takes any number of booleans directly and returns true when at least one of them is true.

atGlance: >
 Variadic OR over booleans. For predicate combination use <code>groupOr</code> / <code>any</code>.

definition: >
 /**
   * @param bool ...$variables
   * @return bool
   */
 Comparisons\anyTrue(bool ...$variables): bool

examplePartial: >
 var_dump(Comparisons\anyTrue(false, false, true));  // true

 var_dump(Comparisons\anyTrue(false, false, false)); // false

---
