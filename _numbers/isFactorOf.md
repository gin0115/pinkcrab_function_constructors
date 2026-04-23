---
title: Numbers\isFactorOf()
description: >
 Creates a predicate Closure that returns true when the passed value is a whole factor of the pre-defined integer — i.e. when the fixed value divides cleanly by the passed one. Zero is rejected and always returns false.

layout: composable_function
group: numbers
subgroup: number_predicate
categories: [numbers, predicate, factor]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L273
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "int → (int → bool)"
typeSignatureEn: >
 Given an integer, returns a predicate that is true when the value divides the bound integer cleanly.

atGlance: >
 Bind a target integer; the returned predicate is true when the passed value is a factor of the target. Zero always returns false.

definition: >
 /**
   * @param int $factor The fixed number to test factors of.
   * @return Closure(int):bool
   */
 Numbers\isFactorOf(int $factor): Closure

closure: >
 /**
   * @param int $value
   * @return bool  True when ($factor % $value === 0) and $value !== 0.
   */
 $function (int $value): bool

examplePartial: >
 // Create a predicate that asks "is X a factor of 12?".

 $factorOf12 = Numbers\isFactorOf(12);


 // Called as a function.

 var_dump($factorOf12(3)); // true   — 12 / 3 has no remainder

 var_dump($factorOf12(4)); // true

 var_dump($factorOf12(5)); // false

 var_dump($factorOf12(0)); // false  — zero is never a factor here


 // Used in a higher order function.

 $divisorsOf12 = array_filter([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], $factorOf12);

 print_r($divisorsOf12); // [1, 2, 3, 4, 6, 12]


exampleCurried: >
 var_dump(Numbers\isFactorOf(20)(5)); // true


exampleInline: >
 $factors = array_filter(range(1, 10), Numbers\isFactorOf(20));

 print_r($factors); // [1, 2, 4, 5, 10]

---
