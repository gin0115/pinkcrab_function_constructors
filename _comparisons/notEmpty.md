---
title: Comparisons\notEmpty()
description: >
 Direct predicate — returns true when the value is not empty in PHP's empty() sense.

layout: composable_function
group: comparisons
subgroup: truthiness
categories: [comparison, predicate, truthiness]
coreFunctions:
    - empty()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L207
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-bool, pure]

typeSignature: "mixed → bool"
typeSignatureEn: >
 Returns true when the value is not considered empty by PHP's <code>empty()</code> rules (0, '', '0', null, [], false, unset — all return false here).

atGlance: >
 Direct call — no curry. Wraps the inverse of <code>empty()</code> for use as a callback.

definition: >
 /**
   * @param mixed $value
   * @return bool
   */
 Comparisons\notEmpty($value): bool

examplePartial: >
 var_dump(Comparisons\notEmpty('hello'));   // true

 var_dump(Comparisons\notEmpty(''));        // false

 var_dump(Comparisons\notEmpty([]));        // false

 var_dump(Comparisons\notEmpty(0));         // false


 // As a callback.

 $populated = array_filter(
   ['a', '', 'b', 0, 'c'],
   'PinkCrab\FunctionConstructors\Comparisons\notEmpty'
 );


 print_r($populated); // ['a', 'b', 'c']

---
