---
title: Comparisons\isScalar()
description: >
 Creates a predicate Closure that is true when the passed value's type matches the bound type-name string.

layout: composable_function
group: comparisons
subgroup: type_check
categories: [comparison, predicate, type]
coreFunctions:
    - gettype()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/comparisons.php#L264
namespace: PinkCrab\FunctionConstructors\Comparisons
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "string → (mixed → bool)"
typeSignatureEn: >
 Given a PHP type name as a string ("integer", "string", "boolean", "object", etc.), returns a predicate that is true when <code>gettype()</code> of the argument matches the bound name.

atGlance: >
 Curried type-check. Bind a PHP <code>gettype()</code> name; the returned Closure answers "is this of that type?".

definition: >
 /**
   * @param string $source Type name (bool, boolean, integer, object, ...).
   * @return Closure(mixed):bool
   */
 Comparisons\isScalar(string $source): Closure

closure: >
 /**
   * @param mixed $value
   * @return bool
   */
 $function ($value): bool

examplePartial: >
 $isString = Comparisons\isScalar('string');

 var_dump($isString('hello')); // true

 var_dump($isString(42));      // false


 $isInt = Comparisons\isScalar('integer');

 array_filter([1, '2', 3, 4.5, 5], $isInt); // [1, 3, 5]

---
