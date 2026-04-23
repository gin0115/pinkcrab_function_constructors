---
title: GeneralFunctions\sideEffect()
description: >
 Creates a Closure that runs an interceptor callable for its side effect and returns the original input unchanged. Ideal for logging or debugging inside a pipeline without breaking it.

layout: composable_function
group: general
subgroup: combinators
categories: [general, combinator, side-effect]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L433
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 1.0.0

deprecated: false
alternative: false

tags: [hof, returns-closure]

typeSignature: "<T> ((T) → any) → (T → T)"
typeSignatureEn: >
 Given an interceptor callable, returns a Closure that calls the interceptor with its input and then returns the input unchanged.

atGlance: >
 "Tap" into a pipeline. Drop a <code>sideEffect</code> anywhere inside <code>compose</code> or <code>pipe</code> to observe or log the value without altering it.

definition: >
 /**
   * @param mixed $interceptor Any callable — string function name, Closure, array callable, or invokable object.
   * @return Closure
   */
 GeneralFunctions\sideEffect($interceptor): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed The same $value, untouched.
   */
 $function ($value)

examplePartial: >
 $logger = GeneralFunctions\sideEffect(fn($v) => error_log("value: $v"));


 $result = GeneralFunctions\pipe(
   '  Foo  ',
   'trim',
   $logger,          // logs "value: Foo", then passes it on
   'strtolower'
 );


 echo $result; // 'foo'

---
