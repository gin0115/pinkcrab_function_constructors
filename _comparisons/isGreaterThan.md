---
title: Comparisons\isGreaterThan()
description: >
 Creates a predicate Closure that is true when the passed number is strictly greater than the bound number.

layout: composable_function
group: comparisons
subgroup: ordering
categories: [comparison, predicate, ordering]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L98
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "number → (number → bool)"
typeSignatureEn: >
 Given a threshold number, returns a predicate that is true when the argument is strictly greater than the threshold.

atGlance: >
 <code>value &gt; threshold</code> as a reusable predicate. Bind the threshold up front.

definition: >
 /**
   * @param int|float $a
   * @return Closure(int|float):bool
   */
 Comparisons\isGreaterThan($a): Closure

closure: >
 /**
   * @param int|float $b
   * @return bool
   */
 $function ($b): bool

examplePartial: >
 $over18 = Comparisons\isGreaterThan(18);


 var_dump($over18(21)); // true

 var_dump($over18(18)); // false  (strict)

 var_dump($over18(17)); // false


 $adults = array_filter([15, 18, 21, 30], $over18);

 print_r($adults); // [21, 30]

---
