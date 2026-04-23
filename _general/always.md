---
title: GeneralFunctions\always()
description: >
 Creates a Closure that always returns the same bound value, ignoring whatever argument it receives. Known in FP as the "K combinator" or "constant function".

layout: composable_function
group: general
subgroup: combinators
categories: [general, combinator, constant]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L369
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [returns-closure, pure]

typeSignature: "<T> T → (any → T)"
typeSignatureEn: >
 Given a value of type <code>T</code>, returns a Closure that ignores any argument it is given and always returns that <code>T</code>.

atGlance: >
 Constant-value supplier. Handy as a default inside <code>ifElse</code> or as a stub callback that should just return a known value.

definition: >
 /**
   * @param mixed $value The value you always want to return.
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\always($value): Closure

closure: >
 /**
   * @param mixed $ignored
   * @return mixed
   */
 $function ($ignored)

examplePartial: >
 $alwaysTrue = GeneralFunctions\always(true);


 var_dump($alwaysTrue(123));   // true

 var_dump($alwaysTrue(null));  // true


 // Useful as the "else" branch of ifElse:

 $toIntOrZero = GeneralFunctions\ifElse('is_numeric', 'intval', GeneralFunctions\always(0));

 echo $toIntOrZero('42');   // 42

 echo $toIntOrZero('nope'); // 0

---
