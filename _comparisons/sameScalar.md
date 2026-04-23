---
title: Comparisons\sameScalar()
description: >
 Direct predicate — returns true when every argument has the same PHP type.

layout: composable_function
group: comparisons
subgroup: type_check
categories: [comparison, predicate, type]
coreFunctions:
    - gettype()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L283
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, variadic, returns-bool, pure]

typeSignature: "...mixed → bool"
typeSignatureEn: >
 Takes any number of values directly and returns true when all of them share the same PHP type (as reported by <code>gettype()</code>).

atGlance: >
 Direct variadic call — no curry. Useful for asserting type-homogeneity before processing a batch of values.

definition: >
 /**
   * @param mixed ...$variables
   * @return bool
   */
 Comparisons\sameScalar(...$variables): bool

examplePartial: >
 var_dump(Comparisons\sameScalar(1, 2, 3));          // true  (all ints)

 var_dump(Comparisons\sameScalar('a', 'b', 'c'));    // true  (all strings)

 var_dump(Comparisons\sameScalar(1, '2', 3));        // false (int + string + int)

---
