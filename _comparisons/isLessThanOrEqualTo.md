---
title: Comparisons\isLessThanOrEqualTo()
description: >
 Creates a predicate Closure that is true when the passed number is less than or equal to the bound number.

layout: composable_function
group: comparisons
subgroup: ordering
categories: [comparison, predicate, ordering]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L136
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "number → (number → bool)"
typeSignatureEn: >
 Given a threshold, returns a predicate that is true when the argument is less than or equal to the threshold.

atGlance: >
 <code>value &lt;= threshold</code> as a reusable predicate.

definition: >
 /**
   * @param int|float $a
   * @return Closure(int|float):bool
   */
 Comparisons\isLessThanOrEqualTo($a): Closure

closure: >
 /**
   * @param int|float $b
   * @return bool
   */
 $function ($b): bool

examplePartial: >
 $max100 = Comparisons\isLessThanOrEqualTo(100);


 var_dump($max100(100)); // true

 var_dump($max100(101)); // false


 $inRange = array_filter([50, 100, 150], $max100);

 print_r($inRange); // [50, 100]

---
