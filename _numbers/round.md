---
title: Numbers\round()
description: >
 Creates a Closure that rounds any number passed to it to a pre-defined number of decimal places. Result is always returned as a float.

layout: composable_function
group: numbers
subgroup: number_transform
categories: [numbers, transform, round]
coreFunctions:
    - round()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L298
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, returns-closure, pure, throws]

typeSignature: "number → (number → float)"
typeSignatureEn: >
 Given a precision, returns a function that rounds any number to that many decimal places.

atGlance: >
 Bind a decimal precision; the returned Closure rounds any number to that many places. Always returns a float. Throws <code>InvalidArgumentException</code> on non-number input.

definition: >
 /**
   * @param int|float $precision Number of decimal places. Defaults to 1.
   * @return Closure(int|float):float
   * @throws InvalidArgumentException If $precision is not int or float.
   */
 Numbers\round($precision = 1): Closure

closure: >
 /**
   * @param int|float $value
   * @return float
   * @throws InvalidArgumentException If $value is not int or float.
   */
 $function (int|float $value): float

examplePartial: >
 // Create a function that rounds to 2 decimal places.

 $round2dp = Numbers\round(2);


 // Called as a function.

 echo $round2dp(3.14159); // 3.14

 echo $round2dp(2.71828); // 2.72

 echo $round2dp(10);      // 10.0


 // Used in a higher order function.

 $array = array_map($round2dp, [1.2345, 6.789, 0.0001]);

 print_r($array); // [1.23, 6.79, 0.0]


exampleCurried: >
 echo Numbers\round(0)(3.7); // 4.0


exampleInline: >
 $array = array_map(Numbers\round(2), [1.2345, 6.789]);

 print_r($array); // [1.23, 6.79]

---
