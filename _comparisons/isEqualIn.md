---
title: Comparisons\isEqualIn()
description: >
 Creates a predicate Closure that is true when the passed value is loosely equal to any element of a bound set.

layout: composable_function
group: comparisons
subgroup: equality
categories: [comparison, predicate, set]
coreFunctions:
    - in_array()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L171
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "<T> T[] → (mixed → bool)"
typeSignatureEn: >
 Given a set of candidate values, returns a predicate that is true when the argument loosely matches any of them.

atGlance: >
 Bind a set once; the returned Closure asks "is this value in the set?". Equivalent to a curried <code>in_array()</code>.

definition: >
 /**
   * @param mixed[] $a
   * @return Closure(mixed):?bool
   */
 Comparisons\isEqualIn(array $a): Closure

closure: >
 /**
   * @param mixed $b
   * @return bool|null
   */
 $function ($b)

examplePartial: >
 $isColour = Comparisons\isEqualIn(['red', 'green', 'blue']);


 var_dump($isColour('red'));    // true

 var_dump($isColour('yellow')); // false


 $colours = array_filter(['red', 'yellow', 'blue', 'pink'], $isColour);

 print_r($colours); // ['red', 'blue']

---
