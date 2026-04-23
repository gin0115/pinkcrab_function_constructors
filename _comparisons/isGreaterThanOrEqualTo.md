---
title: Comparisons\isGreaterThanOrEqualTo()
description: >
 Creates a predicate Closure that is true when the passed number is greater than or equal to the bound number.

layout: composable_function
group: comparisons
subgroup: ordering
categories: [comparison, predicate, ordering]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L154
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "number → (number → bool)"
typeSignatureEn: >
 Given a threshold, returns a predicate that is true when the argument is greater than or equal to the threshold.

atGlance: >
 <code>value &gt;= threshold</code> as a reusable predicate.

definition: >
 /**
   * @param int|float $a
   * @return Closure(int|float):bool
   */
 Comparisons\isGreaterThanOrEqualTo($a): Closure

closure: >
 /**
   * @param int|float $b
   * @return bool
   */
 $function ($b): bool

examplePartial: >
 $adult = Comparisons\isGreaterThanOrEqualTo(18);


 var_dump($adult(18)); // true

 var_dump($adult(17)); // false


 $adults = array_filter([15, 18, 21], $adult);

 print_r($adults); // [18, 21]

---
