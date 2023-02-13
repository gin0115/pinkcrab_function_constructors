---
layout: function
group: strings
subgroup: string_manipulation


title: Strings\slice()
subtitle: >
 Allows you to create a function which can be used to split a string with a defined starting and ending char index. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L65
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string transform]
coreFunctions: 
    - mb_substr()

deprecated: false
alternative: false

definition: >
 /**
   * @param int      $start   start position (offset)
   * @param int|null $finish  end position (length)
   * @return Closure(string):string
   */
  Strings\slice(int $start, ?int $finish = null ): Closure

closure: >
 /**
   * @param string $toSlice  The string to be sliced
   * @return string          The sliced string
   * @psalm-pure
   */ 
 $function(string $toSlice): string

examplePartial: >
 // Create a closure which will take the first 2 characters of a string.

 $sliceFirst2 = Strings\slice(0,2);  


 // Called as a function.

 echo $sliceFirst2('Hello'); // He
  
 // Used in a higher order function.  

 $array = array_map( $sliceFirst2, ['Hello', 'World']);  

 print_r($array); // [He, Wo]  
  
 // You can also use slice() to skip the first 5 characters of a string.  

 $skipFirst5 = Strings\slice(5);
  
 // Called as a function.  

 echo $skipFirst5('HelloWorldBar'); // WorldBar  

exampleCurried: >
 echo Strings\slice(0,2)('Hello'); // He  

exampleInline: >
 $array = array_map( Strings\slice(0,2), ['Hello', 'World']);  

 print_r($array); // [He, Wo]  
---
