---
title: Comparisons\isEqualTo()
description: >
 Creates a predicate Closure that is true when the passed value is loosely equal (==) to the bound value.

layout: composable_function
group: comparisons
subgroup: equality
categories: [comparison, predicate, equality]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L42
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "<T> T → (mixed → bool)"
typeSignatureEn: >
 Given a target value, returns a predicate that is true when the argument is loosely equal (<code>==</code>) to the target.

atGlance: >
 Bind a value once; the returned Closure compares with <code>==</code>. Use <code>isScalar</code> or type predicates if you need strict equality plus type-matching.

definition: >
 /**
   * @param mixed $a
   * @return Closure(mixed):bool
   */
 Comparisons\isEqualTo($a): Closure

closure: >
 /**
   * @param mixed $b
   * @return bool
   */
 $function ($b): bool

examplePartial: >
 $isFoo = Comparisons\isEqualTo('foo');


 var_dump($isFoo('foo'));  // true

 var_dump($isFoo('bar'));  // false


 $foos = array_filter(['foo', 'bar', 'foo', 'baz'], $isFoo);

 count($foos); // 2


exampleCurried: >
 var_dump(Comparisons\isEqualTo(1)('1')); // true (loose ==)

---
