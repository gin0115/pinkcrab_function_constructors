---
title: GeneralFunctions\composeTypeSafe()
description: >
 Like compose() but guards each intermediate value with a validator callable. If the validator fails on a value, the chain aborts and returns null.

layout: composable_function
group: general
subgroup: composition
categories: [general, composition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L113
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, composer, variadic, returns-closure, pure]

typeSignature: "<T> ((T → bool), ...(T → T)) → (T → T | null)"
typeSignatureEn: >
 Given a validator predicate and any number of callables, returns a Closure that threads a value through each callable and bails to null the moment the validator returns false.

atGlance: >
 Composition with a type gate between every step. Useful when you want stronger guarantees than <code>composeSafe</code>'s null-only check — e.g. "every step must still be a string".

definition: >
 /**
   * @param callable(mixed):bool $validator
   * @param callable(mixed):mixed ...$callables
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\composeTypeSafe(callable $validator, callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed|null
   */
 $function ($value)

examplePartial: >
 $stringPipeline = GeneralFunctions\composeTypeSafe(
   'is_string',
   'trim',
   'strtolower',
   Strings\replaceWith(' ', '-')
 );


 echo $stringPipeline('  Hello World '); // 'hello-world'


 var_dump($stringPipeline(42)); // NULL — 42 is not a string, chain halted

---
