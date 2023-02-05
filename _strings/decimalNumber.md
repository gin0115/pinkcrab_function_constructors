---
title: Strings\decimalNumber() 
subtitle: <strong >deprecated in v0.3.0</strong> <br>

 Creates a function which allows for the casting of a string to a decimal number. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_transform
categories: [strings, string transform, numbers]
coreFunctions: 
    - number_format()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L287
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: true
alternative: strings/digit.html

definition: >
 /**
   * @param string|int|float $precision Number of decimal places
   * @param string $point The decimal separator
   * @param string $thousands The thousand separator.
   * @return Closure(string|int|float):string
   */
 Strings\decimalNumber($precision = 2, $point = '.', $thousands = ''): Closure
closure: >
 /**
  * @param string|int|float $number
  * @return string
  */
 $function (string|int|float $string): string

examplePartial: >
 // Create the closure that will format a number to 2 decimal places with , as 1000 separator.

 $format = Strings\decimalNumber(2, '.', ',');


 // Called as a function.

 echo $format(1234.56); // 1,234.56

 echo $format(1234); // 1,234.00


 // Used in a higher order function.

 $array = array_map($format, [1234.56, 1234]);

 print_r($array); /// ['1,234.56', '1,234.00']

 
 // By default the precision is 2, "." is used for the decimal point and no thousands separator is used.

 echo $format(1234.56); // 1,234.56


exampleCurried: >
 // With decimal full stop and comma as thousands separator.

 echo Strings\decimalNumber(2, '.', ',')(1234.56); // 1,234.56


 // With decimal comma and no thousands separator.

 echo Strings\decimalNumber(2, ',', '.')(1234); // 1.234,00


---