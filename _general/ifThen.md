---
title: GeneralFunctions\ifThen()
description: >
 Creates a Closure that applies a transformation only when a predicate is true; otherwise returns the input unchanged.

layout: composable_function
group: general
subgroup: combinators
categories: [general, combinator, conditional]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L388
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, returns-closure, pure]

typeSignature: "<T> ((T → bool), (T → T)) → (T → T)"
typeSignatureEn: >
 Given a predicate and a transformer, returns a Closure that runs the transformer only when the predicate is true — otherwise returns its input unchanged.

atGlance: >
 Conditional transformation without a full if/else. Use when you want to modify values that match some condition and leave the rest alone.

definition: >
 /**
   * @param callable(mixed):bool  $condition
   * @param callable(mixed):mixed $then
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\ifThen(callable $condition, callable $then): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed
   */
 $function ($value)

examplePartial: >
 // Upper-case only strings; leave everything else alone.

 $shoutStrings = GeneralFunctions\ifThen('is_string', 'strtoupper');


 var_dump($shoutStrings('foo')); // 'FOO'

 var_dump($shoutStrings(42));    // 42 (unchanged)

---
