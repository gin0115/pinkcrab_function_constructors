---
title: Numbers\remainderBy()
description: >
 Creates a Closure that returns the remainder when dividing the passed value by a pre-defined divisor. Result is `value % divisor`. Use `remainderInto()` if you want the pre-defined value to be the dividend instead.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, modulus]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L198
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $divisor Defaults to 1. The fixed divisor.
   * @return Closure(int|float):float
   * @throws InvalidArgumentException If $divisor is not int or float.
   */
 Numbers\remainderBy($divisor = 1): Closure

closure: >
 /**
   * @param int|float $value
   * @return float  Result of ($value % $divisor).
   */
 $function ($value): float

examplePartial: >
 // Create a function that gets the remainder after division by 2.

 $modTwo = Numbers\remainderBy(2);


 // Called as a function.

 echo $modTwo(10); // 0

 echo $modTwo(9);  // 1


 // Used in a higher order function.

 $array = array_map($modTwo, [10, 11, 12, 13, 14]);

 print_r($array); // [0, 1, 0, 1, 0]


exampleCurried: >
 echo Numbers\remainderBy(3)(10); // 1


exampleInline: >
 $array = array_map(Numbers\remainderBy(5), [10, 11, 12, 13, 14]);

 print_r($array); // [0, 1, 2, 3, 4]

---
