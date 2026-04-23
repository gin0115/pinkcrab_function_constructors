---
title: Comparisons\isLessThan()
description: >
 Creates a predicate Closure that is true when the passed number is strictly less than the bound number.

layout: composable_function
group: comparisons
subgroup: ordering
categories: [comparison, predicate, ordering]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L117
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "number → (number → bool)"
typeSignatureEn: >
 Given a threshold number, returns a predicate that is true when the argument is strictly less than the threshold.

atGlance: >
 <code>value &lt; threshold</code> as a reusable predicate.

definition: >
 /**
   * @param int|float $a
   * @return Closure(int|float):bool
   */
 Comparisons\isLessThan($a): Closure

closure: >
 /**
   * @param int|float $b
   * @return bool
   */
 $function ($b): bool

examplePartial: >
 $under100 = Comparisons\isLessThan(100);


 var_dump($under100(99));  // true

 var_dump($under100(100)); // false (strict)


 $small = array_filter([50, 100, 150], $under100);

 print_r($small); // [50]

---
