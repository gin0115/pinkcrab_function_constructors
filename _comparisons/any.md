---
title: Comparisons\any()
description: >
 Creates a predicate Closure that is true when at least one of the bound predicates returns true for the input value. Alias of groupOr.

layout: composable_function
group: comparisons
subgroup: combinators
categories: [comparison, predicate, combinator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L363
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, variadic, returns-closure, returns-bool, pure]

typeSignature: "<T> ...(T → bool) → (T → bool)"
typeSignatureEn: >
 Given any number of predicates, returns a predicate that is true when at least one of them is true for the input — short, readable alias of <code>groupOr</code>.

atGlance: >
 Alias of <code>groupOr</code>. Reads naturally: "any of these predicates".

definition: >
 /**
   * @param callable(mixed):bool ...$callables
   * @return Closure(mixed):bool
   */
 Comparisons\any(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return bool
   */
 $function ($value): bool

examplePartial: >
 $positiveOrZero = Comparisons\any(
   Comparisons\isGreaterThan(0),
   Comparisons\isEqualTo(0)
 );


 var_dump($positiveOrZero(5));  // true

 var_dump($positiveOrZero(0));  // true

 var_dump($positiveOrZero(-1)); // false

---
