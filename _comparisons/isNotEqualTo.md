---
title: Comparisons\isNotEqualTo()
description: >
 Creates a predicate Closure that is true when the passed value is loosely NOT equal (!=) to the bound value.

layout: composable_function
group: comparisons
subgroup: equality
categories: [comparison, predicate, equality]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L80
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "<T> T → (mixed → bool)"
typeSignatureEn: >
 Given a target value, returns a predicate that is true when the argument is loosely unequal (<code>!=</code>) to the target.

atGlance: >
 Inverse of <code>isEqualTo</code>. Bind a value; the returned Closure returns true for anything that isn't it (loosely).

definition: >
 /**
   * @param mixed $a
   * @return Closure(mixed):bool
   */
 Comparisons\isNotEqualTo($a): Closure

closure: >
 /**
   * @param mixed $b
   * @return bool
   */
 $function ($b): bool

examplePartial: >
 $notFoo = Comparisons\isNotEqualTo('foo');


 $withoutFoo = array_filter(['foo', 'bar', 'foo', 'baz'], $notFoo);

 print_r($withoutFoo); // ['bar', 'baz']

---
