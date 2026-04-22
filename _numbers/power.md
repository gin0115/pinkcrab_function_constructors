---
title: Numbers\power()
description: >
 Creates a Closure that raises any number passed to it to a pre-defined exponent. Wraps `pow($value, $exponent)`.

layout: composable_function
group: numbers
subgroup: number_transform
categories: [numbers, transform, power]
coreFunctions:
    - pow()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L324
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $exponent
   * @return Closure(int|float):(int|float)
   * @throws InvalidArgumentException If $exponent is not int or float.
   */
 Numbers\power($exponent): Closure

closure: >
 /**
   * @param int|float $value
   * @return int|float  Result of pow($value, $exponent).
   * @throws InvalidArgumentException If $value is not int or float.
   */
 $function ($value)

examplePartial: >
 // Create a function that squares every number it receives.

 $squared = Numbers\power(2);


 // Called as a function.

 echo $squared(5);    // 25

 echo $squared(1.5);  // 2.25

 echo $squared(10);   // 100


 // Used in a higher order function.

 $array = array_map($squared, [1, 2, 3, 4, 5]);

 print_r($array); // [1, 4, 9, 16, 25]


exampleCurried: >
 echo Numbers\power(3)(2); // 8


exampleInline: >
 $cubes = array_map(Numbers\power(3), [1, 2, 3, 4]);

 print_r($cubes); // [1, 8, 27, 64]

---
