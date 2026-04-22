---
title: Strings\stringCompiler()
description: >
 Creates a self-returning accumulator that builds up a string across successive calls. Each call with a non-empty string returns a new compiler Closure with that value appended; calling the compiler with null (or no argument) returns the final compiled string.

layout: composable_function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation, accumulator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L750
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $initial Optional seed string. Defaults to ''.
   * @return Closure(string|null):(Closure|string)
   */
 Strings\stringCompiler(string $initial = ''): Closure

closure: >
 /**
   * @param string|null $value  Chunk to append, or null to finalise.
   * @return Closure|string     Closure while still accumulating, string once finalised.
   */
 $function (?string $value = null)

examplePartial: >
 // Seed the compiler with a prefix — each call returns a new compiler.

 $compiler = Strings\stringCompiler('Log: ');


 // Append values step by step. Every append returns a fresh compiler.

 $compiler = $compiler('one ');

 $compiler = $compiler('two ');

 $compiler = $compiler('three');


 // Call with no argument (or null) to read the accumulated string.

 echo $compiler(); // Log: one two three


exampleCurried: >
 // Chain the calls inline — every () appends; the final empty () finalises.

 echo Strings\stringCompiler('Hello ')('world')('!')(); // Hello world!


exampleInline: >
 // Fold an array of chunks into a single string.

 $parts = ['The ', 'quick ', 'brown ', 'fox'];


 $compiled = array_reduce(
   $parts,
   fn($acc, $chunk) => $acc($chunk),
   Strings\stringCompiler()
 );


 echo $compiled(); // The quick brown fox

---
