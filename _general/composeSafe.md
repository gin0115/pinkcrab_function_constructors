---
title: GeneralFunctions\composeSafe()
description: >
 Like compose() but halts the chain and returns null if any callable produces a null value. Prevents passing null into callables that can't handle it.

layout: composable_function
group: general
subgroup: composition
categories: [general, composition]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L88
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, composer, variadic, returns-closure, pure]

typeSignature: "<T> ...(T → T | null) → (T → T | null)"
typeSignatureEn: >
 Given any number of callables, returns a Closure that threads a value through them left-to-right but short-circuits to null the moment any step produces null.

atGlance: >
 Null-safe composition. If your chain includes lookups or conversions that may fail to null, this variant guards every step without needing explicit checks.

definition: >
 /**
   * @param callable(mixed):mixed ...$callables
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\composeSafe(callable ...$callables): Closure

closure: >
 /**
   * @param mixed $value
   * @return mixed|null
   */
 $function ($value)

examplePartial: >
 $nameOfAdmin = GeneralFunctions\composeSafe(
   GeneralFunctions\getProperty('admin'),
   GeneralFunctions\getProperty('name')
 );


 echo $nameOfAdmin(['admin' => ['name' => 'Ada']]); // 'Ada'


 var_dump($nameOfAdmin(['admin' => null])); // NULL (chain halted)

---
