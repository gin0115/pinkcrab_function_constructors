---
title: Comparisons\isNumber()
description: >
 Direct predicate — returns true when the value is an int or a float.

layout: composable_function
group: comparisons
subgroup: type_check
categories: [comparison, predicate, type]
coreFunctions:
    - is_int()
    - is_float()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L352
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-bool, pure]

typeSignature: "mixed → bool"
typeSignatureEn: >
 Returns true when the value is an int or a float. Numeric strings are NOT considered numbers by this predicate.

atGlance: >
 Direct call — no curry. Tests strictly for int or float — stricter than <code>is_numeric()</code>.

definition: >
 /**
   * @param mixed $value
   * @return bool
   */
 Comparisons\isNumber($value): bool

examplePartial: >
 var_dump(Comparisons\isNumber(42));    // true

 var_dump(Comparisons\isNumber(3.14));  // true

 var_dump(Comparisons\isNumber('42'));  // false  (string, not number)

 var_dump(Comparisons\isNumber(null));  // false


 $numbers = array_filter(
   [1, '2', 3.5, 'four', 5],
   'PinkCrab\FunctionConstructors\Comparisons\isNumber'
 );

 print_r($numbers); // [1, 3.5, 5]

---
