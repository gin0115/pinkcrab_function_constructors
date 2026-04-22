---
title: Strings\composeSafeStringFunc()
description: >
 Composes a pipeline of callables into a single function, guarding each intermediate value with an is_string check. The composed Closure passes its input through each callable in turn, so the output of one becomes the input of the next. If any step produces a non-string value, the composed function aborts and returns null rather than calling the next callable with bad data.

layout: composable_function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation, compose]
coreFunctions:
    - is_string()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L739
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param callable(mixed):string ...$callable
   * @return Closure(mixed):string
   */
 Strings\composeSafeStringFunc(callable ...$callable): Closure

closure: >
 /**
   * @param mixed $source
   * @return string
   */
 $function ($source): string

examplePartial: >
 // Build a reusable normaliser from several string-returning callables.

 $normalise = Strings\composeSafeStringFunc(
   'trim',
   'strtolower',
   Strings\replaceWith(' ', '-')
 );


 // Called as a function.

 echo $normalise('  Some Title  '); // some-title


 // Used in a higher order function.

 $slugs = array_map($normalise, ['  First Post ', 'SECOND post']);

 print_r($slugs); // ['first-post', 'second-post']


exampleCurried: >
 // Compose and invoke inline.

 echo Strings\composeSafeStringFunc('trim', 'strtoupper')('  hello  '); // HELLO


exampleInline: >
 // Drop straight into array_map without naming the pipeline.

 $shouts = array_map(
   Strings\composeSafeStringFunc('trim', 'strtoupper', Strings\append('!')),
   [' hi ', ' there ']
 );

 print_r($shouts); // ['HI!', 'THERE!']

---
