---
title: Comparisons\groupOr()
description: >
 Creates a predicate Closure that is true when at least one of the bound predicates returns true for the input value.

layout: composable_function
group: comparisons
subgroup: combinators
categories: [comparison, predicate, combinator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L241
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, variadic, returns-closure, returns-bool, pure]

typeSignature: "<T> ...(T → bool) → (T → bool)"
typeSignatureEn: >
 Given any number of predicates, returns a predicate that is true when at least one of them is true for the input value.

atGlance: >
 OR-combinator for predicates. See also <code>any</code> (alias).

definition: >
 /**
   * @param callable(mixed):bool ...$callables
   * @return Closure(mixed):bool
   */
 Comparisons\groupOr(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return bool
   */
 $function ($value): bool

examplePartial: >
 $stringOrInt = Comparisons\groupOr('is_string', 'is_int');


 var_dump($stringOrInt('hello')); // true

 var_dump($stringOrInt(42));      // true

 var_dump($stringOrInt(3.14));    // false

---
