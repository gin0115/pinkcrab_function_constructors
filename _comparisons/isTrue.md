---
title: Comparisons\isTrue()
description: >
 Direct predicate — returns true when the value is loosely truthy (== true).

layout: composable_function
group: comparisons
subgroup: truthiness
categories: [comparison, predicate, truthiness]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L341
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-bool, pure]

typeSignature: "mixed → bool"
typeSignatureEn: >
 Returns true when the value is loosely equal to true (non-empty string, non-zero number, true, non-empty array, etc.).

atGlance: >
 Direct call — no curry. Loose truthiness check via <code>==</code>, not strict <code>===</code>.

definition: >
 /**
   * @param mixed $value
   * @return bool
   */
 Comparisons\isTrue($value): bool

examplePartial: >
 var_dump(Comparisons\isTrue(true));   // true

 var_dump(Comparisons\isTrue(1));      // true

 var_dump(Comparisons\isTrue('hi'));   // true

 var_dump(Comparisons\isTrue(''));     // false

 var_dump(Comparisons\isTrue(0));      // false

---
