---
title: GeneralFunctions\composeR()
description: >
 Like compose() but threads the value through callables right-to-left — the last callable is applied first.

layout: composable_function
group: general
subgroup: composition
categories: [general, composition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L67
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, composer, variadic, returns-closure, pure]

typeSignature: "<T> ...(T → T) → (T → T)"
typeSignatureEn: >
 Given any number of callables, returns a Closure that feeds its input through each callable <strong>in reverse order</strong> and returns the final result.

atGlance: >
 Same as <code>compose</code> but right-to-left. Useful when the natural reading order of your callables is the opposite of their execution order (e.g. mathematical function notation).

definition: >
 /**
   * @param callable(mixed):mixed ...$callables
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\composeR(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed
   */
 $function ($value)

examplePartial: >
 $shoutTrimmed = GeneralFunctions\composeR(
   'strtoupper',
   'trim'
 );


 // Equivalent to strtoupper(trim('  foo  '))

 echo $shoutTrimmed('  foo  '); // 'FOO'

---
