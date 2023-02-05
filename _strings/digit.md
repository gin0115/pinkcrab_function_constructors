---
title: Strings\digit()
subtitle: Creates a function which allows for the casting of a string to a decimal number. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_transform
categories: [strings, string transform, numbers]
coreFunctions: 
    - number_format()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L287
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.3.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string|int|float $precision Number of decimal places
   * @param string $decimal The decimal separator
   * @param string $thousands The thousand separator.
   * @return Closure(string|int|float):string
   */
 Strings\digit($precision = 2, $decimal = '.', $thousands = ''): Closure
closure: >
 /**
  * @param string|int|float $number
  * @return string
  */
 $function (string|int|float $string): string

examplePartial: >
 // Create the closure that will format a number to 2 decimal places with , as 1000 separator.

 $format = Strings\digit(2, '.', ',');


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

 echo Strings\digit(2, '.', ',')(1234.56); // 1,234.56


 // With decimal comma and no thousands separator.

 echo Strings\digit(2, ',', '.')(1234); // 1.234,00



exampleInline: >
    $array = array_map( Strings\replaceSubString('...', 3), ['This is an example', 'Another example'] );
    
    print_r($array); // ['Thi...', 'Ano...']

    
    $array = array_map( Strings\replaceSubString('...', -3), ['This is an example', 'Another example'] );
    
    print_r($array); // ['This is an ex...', 'Another ex...']

    
    $array = array_map( Strings\replaceSubString('...', 5, 2), ['This is an example', 'Another example'] );
    
    print_r($array); // ['This ... an example', 'Another ... an example']
    
    
    $array = array_map( Strings\replaceSubString('...', 5, 0), ['This is an example', 'Another example'] );
    
    print_r($array); // ['This ... is an example', 'Another ... is an example']

---