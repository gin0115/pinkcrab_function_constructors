---
title: Numbers\multiply()
description: >
 Creates a Closure that multiplies any number it receives by a pre-defined factor. Ideal for scaling values inside map/pipe chains.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, multiply]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L130
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $initial Defaults to 1.
   * @return Closure(int|float):(int|float)
   * @throws InvalidArgumentException If $initial is not int or float.
   */
 Numbers\multiply($initial = 1): Closure

closure: >
 /**
   * @param int|float $value
   * @return int|float  Result of ($value * $initial).
   */
 $function ($value)

examplePartial: >
 // Create a function that doubles anything it receives.

 $double = Numbers\multiply(2);


 // Called as a function.

 echo $double(5);    // 10

 echo $double(2.5);  // 5


 // Used in a higher order function.

 $array = array_map($double, [1, 2, 3, 4]);

 print_r($array); // [2, 4, 6, 8]


exampleCurried: >
 echo Numbers\multiply(10)(2.5); // 25


exampleInline: >
 $array = array_map(Numbers\multiply(3), [1, 2, 3]);

 print_r($array); // [3, 6, 9]

---
