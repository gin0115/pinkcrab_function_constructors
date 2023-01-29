---
layout: function
group: strings
subgroup: string_manipulation

title: Strings\vSprintf()
subtitle: Allows you to create a function which allows for creating a Closure which is populated with a sprintf template. Which accepts the array of args to be used to populate the template. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L118
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $template The sprintf template to use.
   * @return Closure(array):string
   */
  Strings\vSprintf(string $template): Closure
closure: >
 /**
   * @param mixed[] $values  The values to be used to populate the sprintf template.
   * @return string          The formatted string
   * @psalm-pure
   */ 
 $function(array $values): string

examplePartial: >
 // Creates the Closure.

 $nameAndAge = Strings\vSprintf('Hello %s you are %d years old.');


 // Called as a function.

 echo $nameAndAge(['Dave', 12]); // Hello Dave you are 12 years old.


 // Used in a higher order function.

 $array = array_map( $nameAndAge, [['Dave', 12], ['Jane', 11]]);

 print_r($array); // [Hello Dave you are 12 years old., Hello Jane you are 11 years old.]

exampleCurried: >
 echo Strings\vSprintf('%s-H')(['Bar']); // Bar-H
exampleInline: >
 $array = array_map(
    Strings\vSprintf('Hello %s you are %d years old.'), 
    [['Dave', 12], ['Jane', 11]]
 );

 print_r($array); // [Hello Dave you are 12 years old., Hello Jane you are 11 years old.]


---
