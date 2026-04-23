---
title: Comparisons\isFalse()
description: >
 Direct predicate — returns true when the value is loosely falsy (== false).

layout: composable_function
group: comparisons
subgroup: truthiness
categories: [comparison, predicate, truthiness]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L330
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-bool, pure]

typeSignature: "mixed → bool"
typeSignatureEn: >
 Returns true when the value is loosely equal to false (false, 0, '', null, [], '0').

atGlance: >
 Direct call — no curry. Loose truthiness check via <code>==</code>, not strict <code>===</code>.

definition: >
 /**
   * @param mixed $value
   * @return bool
   */
 Comparisons\isFalse($value): bool

examplePartial: >
 var_dump(Comparisons\isFalse(false));  // true

 var_dump(Comparisons\isFalse(0));      // true

 var_dump(Comparisons\isFalse(''));     // true

 var_dump(Comparisons\isFalse('hello')); // false

---
