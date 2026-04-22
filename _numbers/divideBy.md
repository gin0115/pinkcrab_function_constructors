---
title: Numbers\divideBy()
description: >
 Creates a Closure that divides any number it receives by a pre-defined divisor. Result is `value / divisor` and is always returned as a float. Use `divideInto()` if you want the pre-defined value to be the dividend instead.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, divide]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L154
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
 Numbers\divideBy($divisor = 1): Closure

closure: >
 /**
   * @param int|float $value
   * @return float  Result of ($value / $divisor).
   */
 $function ($value): float

examplePartial: >
 // Create a function that halves every number it receives.

 $half = Numbers\divideBy(2);


 // Called as a function.

 echo $half(10); // 5.0

 echo $half(7);  // 3.5


 // Used in a higher order function.

 $array = array_map($half, [10, 20, 30]);

 print_r($array); // [5.0, 10.0, 15.0]


exampleCurried: >
 echo Numbers\divideBy(3)(12); // 4.0


exampleInline: >
 $array = array_map(Numbers\divideBy(10), [100, 200, 300]);

 print_r($array); // [10.0, 20.0, 30.0]

---
