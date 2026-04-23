---
title: Comparisons\not()
description: >
 Negates a predicate. Takes a callable returning bool and returns a Closure that returns the opposite bool for any input.

layout: composable_function
group: comparisons
subgroup: combinators
categories: [comparison, predicate, combinator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L385
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, predicate, returns-closure, returns-bool, pure]

typeSignature: "<T> (T → bool) → (T → bool)"
typeSignatureEn: >
 Given a predicate, returns its negation — a Closure that returns the opposite bool for every input.

atGlance: >
 Flip a predicate without writing a new one. Especially handy for turning library predicates into "not-x" filters.

definition: >
 /**
   * @param callable(mixed):bool $callable
   * @return Closure(mixed):bool
   */
 Comparisons\not(callable $callable): Closure

closure: >
 /**
   * @param mixed $value
   * @return bool
   */
 $function ($value): bool

examplePartial: >
 $isNotEmpty = Comparisons\not('empty');

 $isNotString = Comparisons\not('is_string');

 $isNotZero = Comparisons\not(Comparisons\isEqualTo(0));


 var_dump($isNotZero(0)); // false

 var_dump($isNotZero(1)); // true


 $nonStrings = array_filter([1, 'a', 2, 'b'], $isNotString);

 print_r($nonStrings); // [1, 2]

---
