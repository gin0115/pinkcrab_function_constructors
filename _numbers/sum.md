---
title: Numbers\sum()
description: >
 Creates a Closure that adds a pre-defined amount to any number passed to it. Useful wherever you want a reusable "add N" function for piping, mapping or composition.

layout: composable_function
group: numbers
subgroup: number_arithmetic
categories: [numbers, arithmetic, add]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L84
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param int|float $initial Defaults to 0.
   * @return Closure(int|float):(int|float)
   * @throws InvalidArgumentException If $initial is not int or float.
   */
 Numbers\sum($initial = 0): Closure

closure: >
 /**
   * @param int|float $value
   * @return int|float
   */
 $function ($value)

examplePartial: >
 // Create a function that adds 5 to whatever it receives.

 $addFive = Numbers\sum(5);


 // Called as a function.

 echo $addFive(15.5); // 20.5

 echo $addFive(-2);   // 3


 // Used in a higher order function.

 $array = array_map($addFive, [1, 2, 3, 4]);

 print_r($array); // [6, 7, 8, 9]


exampleCurried: >
 echo Numbers\sum(5)(10); // 15


exampleInline: >
 $array = array_map(Numbers\sum(100), [1, 2, 3]);

 print_r($array); // [101, 102, 103]

---
