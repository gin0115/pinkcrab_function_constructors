---
title: GeneralFunctions\pipe()
description: >
 Immediately threads a value through a sequence of callables left-to-right and returns the final result. The imperative cousin of compose().

layout: composable_function
group: general
subgroup: composition
categories: [general, composition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L145
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, variadic, returns-value, pure]

typeSignature: "<T> (T, ...(T → T)) → T"
typeSignatureEn: >
 Given an initial value and any number of callables, threads the value through each callable and returns the final result directly — no Closure is created.

atGlance: >
 Direct call — not a Closure constructor. Use when you have a specific value you want to transform right now; use <code>compose</code> when you want a reusable Closure.

definition: >
 /**
   * @param mixed $value
   * @param callable(mixed):mixed ...$callables
   * @return mixed
   */
 GeneralFunctions\pipe($value, callable ...$callables)

examplePartial: >
 $slug = GeneralFunctions\pipe(
   '  Hello World  ',
   'trim',
   'strtolower',
   Strings\replaceWith(' ', '-')
 );


 echo $slug; // 'hello-world'

---
