---
title: GeneralFunctions\pipeR()
description: >
 Like pipe() but threads the value through callables right-to-left — the last callable is applied first.

layout: composable_function
group: general
subgroup: composition
categories: [general, composition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L158
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, variadic, returns-value, pure]

typeSignature: "<T> (T, ...(T → T)) → T"
typeSignatureEn: >
 Given an initial value and any number of callables, threads the value through each callable <strong>in reverse order</strong> and returns the final result.

atGlance: >
 Same shape as <code>pipe</code> but right-to-left — matches mathematical function-composition reading order.

definition: >
 /**
   * @param mixed $value
   * @param callable(mixed):mixed ...$callables
   * @return mixed
   */
 GeneralFunctions\pipeR($value, callable ...$callables)

examplePartial: >
 // Equivalent to strtoupper(trim('  foo  '))

 echo GeneralFunctions\pipeR('  foo  ', 'strtoupper', 'trim'); // 'FOO'

---
