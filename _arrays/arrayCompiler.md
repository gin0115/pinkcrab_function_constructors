---
title: Arrays\arrayCompiler()
description: >
 Creates a self-returning array accumulator. Each call with a value appends it and returns a fresh compiler; calling with no argument returns the accumulated array.

layout: composable_function
group: arrays
subgroup: array_compiler
categories: [array, accumulator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L246
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [accumulator, returns-closure, pure]

typeSignature: "<T> T[] → (T? → Closure | T[])"
typeSignatureEn: >
 Seeded with an optional starting array, returns a callable that either appends a value and hands back a fresh compiler, or returns the accumulated array when called with no argument.

atGlance: >
 Self-returning array builder. Each call with a value adds it and returns a fresh compiler; call with nothing (or null) to read the array out.

definition: >
 /**
   * @param mixed[] $inital Initial array contents.
   * @return Closure
   */
 Arrays\arrayCompiler(array $inital = []): Closure

examplePartial: >
 $compile = Arrays\arrayCompiler();


 $compile = $compile('a');

 $compile = $compile('b');

 $compile = $compile('c');


 var_dump($compile()); // ['a', 'b', 'c']


exampleCurried: >
 var_dump(Arrays\arrayCompiler()('a')('b')('c')()); // ['a', 'b', 'c']

---
