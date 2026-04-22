---
title: Numbers\divideInto()
description: >
 Creates a Closure that divides a pre-defined dividend by whatever number it receives. Result is `dividend / value`. Use this when the numerator is the constant and you want to vary the denominator — see `divideBy()` for the reverse.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, divide]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L176
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
 Numbers\divideInto($dividend = 1): Closure

closure: >
 /**
   * @param int|float $value
   * @return float  Result of ($dividend / $value).
   */
 $function ($value): float

examplePartial: >
 // Create a function that divides 12 by whatever it receives.

 $twelveOver = Numbers\divideInto(12);


 // Called as a function.

 echo $twelveOver(4); // 3.0

 echo $twelveOver(2); // 6.0


 // Used in a higher order function.

 $array = array_map($twelveOver, [1, 2, 3, 4]);

 print_r($array); // [12.0, 6.0, 4.0, 3.0]


exampleCurried: >
 echo Numbers\divideInto(100)(4); // 25.0


exampleInline: >
 $array = array_map(Numbers\divideInto(60), [1, 2, 3, 4, 5, 6]);

 print_r($array); // [60.0, 30.0, 20.0, 15.0, 12.0, 10.0]

---
