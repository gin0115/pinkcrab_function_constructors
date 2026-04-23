---
title: GeneralFunctions\compose()
description: >
 Creates a Closure that threads a value through a sequence of callables left-to-right — the output of each becomes the input of the next.

layout: composable_function
group: general
subgroup: composition
categories: [general, composition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L46
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, composer, variadic, returns-closure, pure]

typeSignature: "<T> ...(T → T) → (T → T)"
typeSignatureEn: >
 Given any number of callables, returns a Closure that feeds its input through each callable in order and returns the final result.

atGlance: >
 The canonical function composer. Left-to-right by default. Use <code>composeR</code> for right-to-left, <code>composeSafe</code> to halt on null, <code>composeTypeSafe</code> to halt on a custom type check.

definition: >
 /**
   * @param callable(mixed):mixed ...$callables
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\compose(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed
   */
 $function ($value)

examplePartial: >
 $slugify = GeneralFunctions\compose(
   'trim',
   'strtolower',
   Strings\replaceWith(' ', '-')
 );


 echo $slugify('  Hello World  '); // 'hello-world'


exampleCurried: >
 echo GeneralFunctions\compose('trim', 'strtoupper')('  foo  '); // 'FOO'


exampleInline: >
 $cleaned = array_map(
   GeneralFunctions\compose('trim', 'strtolower'),
   ['  Foo  ', '  BAR  ']
 );

 print_r($cleaned); // ['foo', 'bar']

---
