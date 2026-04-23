---
title: Comparisons\groupAnd()
description: >
 Creates a predicate Closure that is true only when every bound predicate returns true for the input value.

layout: composable_function
group: comparisons
subgroup: combinators
categories: [comparison, predicate, combinator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L218
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, variadic, returns-closure, returns-bool, pure]

typeSignature: "<T> ...(T → bool) → (T → bool)"
typeSignatureEn: >
 Given any number of predicates, returns a predicate that is true only when every one of them is true for the same input value.

atGlance: >
 AND-combinator for predicates. See also <code>all</code> (alias).

definition: >
 /**
   * @param callable(mixed):bool ...$callables
   * @return Closure(mixed):bool
   */
 Comparisons\groupAnd(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return bool
   */
 $function ($value): bool

examplePartial: >
 $adultString = Comparisons\groupAnd(
   'is_string',
   fn($s) => strlen($s) >= 18
 );


 var_dump($adultString('hello world world world')); // true

 var_dump($adultString('short'));                    // false

 var_dump($adultString(12345678901234567890));       // false  (not string)

---
