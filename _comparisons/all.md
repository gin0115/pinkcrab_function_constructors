---
title: Comparisons\all()
description: >
 Creates a predicate Closure that is true only when every bound predicate returns true for the input value. Alias of groupAnd.

layout: composable_function
group: comparisons
subgroup: combinators
categories: [comparison, predicate, combinator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L374
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, variadic, returns-closure, returns-bool, pure]

typeSignature: "<T> ...(T → bool) → (T → bool)"
typeSignatureEn: >
 Given any number of predicates, returns a predicate that is true only when every one is true for the input — short, readable alias of <code>groupAnd</code>.

atGlance: >
 Alias of <code>groupAnd</code>. Reads naturally: "all of these predicates".

definition: >
 /**
   * @param callable(mixed):bool ...$callables
   * @return Closure(mixed):bool
   */
 Comparisons\all(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return bool
   */
 $function ($value): bool

examplePartial: >
 $adultString = Comparisons\all(
   'is_string',
   fn($s) => strlen($s) >= 18
 );


 var_dump($adultString('a full length name here')); // true

 var_dump($adultString('short'));                   // false

---
