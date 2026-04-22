---
title: Numbers\remainderInto()
description: >
 Creates a Closure that returns the remainder when a pre-defined dividend is divided by the passed value. Result is `dividend % value`. See `remainderBy()` for the reverse direction.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, modulus]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L220
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $dividend Defaults to 1. The fixed numerator.
   * @return Closure(int|float):float
   * @throws InvalidArgumentException If $dividend is not int or float.
   */
 Numbers\remainderInto($dividend = 1): Closure

closure: >
 /**
   * @param int|float $value
   * @return float  Result of ($dividend % $value).
   */
 $function ($value): float

examplePartial: >
 // Create a function that returns the remainder of 10 divided by whatever it receives.

 $modOfTen = Numbers\remainderInto(10);


 // Called as a function.

 echo $modOfTen(3); // 1

 echo $modOfTen(4); // 2

 echo $modOfTen(5); // 0


 // Used in a higher order function.

 $array = array_map($modOfTen, [3, 4, 5, 6]);

 print_r($array); // [1, 2, 0, 4]


exampleCurried: >
 echo Numbers\remainderInto(100)(7); // 2


exampleInline: >
 $array = array_map(Numbers\remainderInto(10), [1, 2, 3, 4]);

 print_r($array); // [0, 0, 1, 2]

---
