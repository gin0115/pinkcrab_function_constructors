---
title: GeneralFunctions\invoker()
description: >
 Creates a Closure that invokes a bound callable with whatever arguments you pass to the Closure. Useful as a value-level representation of calling something.

layout: composable_function
group: general
subgroup: combinators
categories: [general, combinator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L352
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, returns-closure, pure]

typeSignature: "<A, R> ((A) → R) → ((...A) → R)"
typeSignatureEn: >
 Given a callable, returns a Closure that invokes it with whatever arguments are passed.

atGlance: >
 Wraps a callable so it can be called uniformly. Mostly useful for adapting PHP's callable-ness into a consistent Closure shape.

definition: >
 /**
   * @param callable(mixed):mixed $fn
   * @return Closure(mixed ...):mixed
   */
 GeneralFunctions\invoker(callable $fn): Closure

examplePartial: >
 $trim = GeneralFunctions\invoker('trim');


 echo $trim('  foo  '); // 'foo'

---
