---
title: Numbers\isMultipleOf()
description: >
 Creates a predicate Closure that returns true when the passed value is a whole multiple of the pre-defined number. Zero is treated as a non-multiple and always returns false — that is a deliberate behaviour of this constructor.

layout: composable_function
group: numbers
subgroup: number_predicate
categories: [numbers, predicate, modulus]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L242
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $multiple The fixed multiple to test against.
   * @return Closure(int|float):bool
   * @throws InvalidArgumentException If $multiple is not int or float.
   */
 Numbers\isMultipleOf($multiple): Closure

closure: >
 /**
   * @param int|float $value
   * @return bool  True when ($value % $multiple === 0) and $value !== 0.
   * @throws InvalidArgumentException If $value is not int or float.
   */
 $function ($value): bool

examplePartial: >
 // Create a predicate that checks for multiples of 3.

 $isMultipleOf3 = Numbers\isMultipleOf(3);


 // Called as a function.

 var_dump($isMultipleOf3(12));  // true

 var_dump($isMultipleOf3(13));  // false

 var_dump($isMultipleOf3(0));   // false — zero is never a multiple here


 // Used in a higher order function.

 $onlyMultiples = array_filter([1, 3, 5, 6, 7, 9, 11, 12], $isMultipleOf3);

 print_r($onlyMultiples); // [3, 6, 9, 12]


exampleCurried: >
 var_dump(Numbers\isMultipleOf(2)(12)); // true


exampleInline: >
 $evens = array_filter([1, 2, 3, 4, 5, 6], Numbers\isMultipleOf(2));

 print_r($evens); // [2, 4, 6]

---
