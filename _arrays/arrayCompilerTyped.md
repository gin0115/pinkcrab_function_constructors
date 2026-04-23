---
title: Arrays\arrayCompilerTyped()
description: >
 Like arrayCompiler() but guarded by a validator — values that fail the validator are silently dropped rather than appended.

layout: composable_function
group: arrays
subgroup: array_compiler
categories: [array, accumulator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L268
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, accumulator, returns-closure, pure]

typeSignature: "<T> ((mixed → bool), T[]) → (mixed → Closure | T[])"
typeSignatureEn: >
 Given a validator predicate and an optional starting array, returns a callable that appends only values passing the predicate, and returns the accumulated array when called with no argument.

atGlance: >
 Self-returning array builder with a type gate — values that fail the validator are dropped. Useful for safely collecting items of a single expected type.

definition: >
 /**
   * @param callable(mixed):bool $validator Applied before each append.
   * @param mixed[] $inital Initial array contents.
   * @return Closure
   */
 Arrays\arrayCompilerTyped(callable $validator, array $inital = []): Closure

examplePartial: >
 $compile = Arrays\arrayCompilerTyped('is_int');


 $compile = $compile(1);

 $compile = $compile('two');  // dropped — not int

 $compile = $compile(3);


 var_dump($compile()); // [1, 3]


exampleCurried: >
 var_dump(Arrays\arrayCompilerTyped('is_string')('a')(1)('b')()); // ['a', 'b']

---
