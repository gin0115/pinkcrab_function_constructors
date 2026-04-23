---
title: GeneralFunctions\ifElse()
description: >
 Creates a Closure that branches on a predicate — applies one transformation when the predicate is true, another when it's false.

layout: composable_function
group: general
subgroup: combinators
categories: [general, combinator, conditional]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L411
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, returns-closure, pure]

typeSignature: "<T, U> ((T → bool), (T → U), (T → U)) → (T → U)"
typeSignatureEn: >
 Given a predicate, a "then" transformer, and an "else" transformer, returns a Closure that picks the right branch based on the predicate and applies it to its input.

atGlance: >
 The functional equivalent of an <code>if/else</code> expression. Works well with <code>always()</code> as the else branch for default values.

definition: >
 /**
   * @param callable(mixed):bool  $condition
   * @param callable(mixed):mixed $then
   * @param callable(mixed):mixed $else
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\ifElse(callable $condition, callable $then, callable $else): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed
   */
 $function ($value)

examplePartial: >
 $bucket = GeneralFunctions\ifElse(
   fn($n) => $n >= 0,
   GeneralFunctions\always('positive'),
   GeneralFunctions\always('negative')
 );


 echo $bucket(42);  // 'positive'

 echo $bucket(-7);  // 'negative'

---
