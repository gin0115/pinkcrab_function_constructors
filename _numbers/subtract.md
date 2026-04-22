---
title: Numbers\subtract()
description: >
 Creates a Closure that subtracts a pre-defined amount from any number passed to it. The bound value is the amount to remove — the passed value is the operand. Result is `value - initial`.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, subtract]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L107
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $initial Defaults to 0. The amount to subtract.
   * @return Closure(int|float):(int|float)
   * @throws InvalidArgumentException If $initial is not int or float.
   */
 Numbers\subtract($initial = 0): Closure

closure: >
 /**
   * @param int|float $value
   * @return int|float  Result of ($value - $initial).
   */
 $function (int|float $value): int|float

examplePartial: >
 // Create a function that subtracts 10 from whatever it receives.

 $lessTen = Numbers\subtract(10);


 // Called as a function.

 echo $lessTen(25); // 15

 echo $lessTen(3);  // -7


 // Used in a higher order function.

 $array = array_map($lessTen, [10, 20, 30]);

 print_r($array); // [0, 10, 20]


exampleCurried: >
 echo Numbers\subtract(10)(25); // 15


exampleInline: >
 $array = array_map(Numbers\subtract(1), [10, 20, 30]);

 print_r($array); // [9, 19, 29]

---
