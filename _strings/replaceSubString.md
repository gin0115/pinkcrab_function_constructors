---
title: Strings\replaceSubString()
subtitle: Creates a function which allows for the replacing of part of string with defined replacement. The created function can then reused over any string, or used as part of a Higher Order Function such as array_map().

layout: function
group: strings
subgroup: string_manipulation
coreFunctions: 
    - substr_replace()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L178
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param string $replace The value to replace in passed string
   * @param int $offset The offset to start, negative numbers count back from end.
   * @param int|null $length Number of chars to stop replacing at end of replacement.
   * @return Closure(string):string
   */
 Strings\replaceSubString(string $replace, int $offset = 0, ?int $length = null): Closure
closure: >
 /**
  * @param string $string
  * @return string
  */
 $function (string $string): string

examplePartial: >
 // Create the closure that will add ... to a string after the 3rd char.

 $splice = Strings\replaceSubString('...', 3);


 // Called as a function.

 echo $splice('This is an example'); // Thi...


 // Used in a higher order function.

 $array = array_map( $splice, ['This is an example', 'Another example'] );

 print_r($array); // ['Thi...', 'Ano...']

 
 // Passing the offset as a negative number will count back from the end of the string.

 $spliceBackwards = Strings\replaceSubString('...', -3);

 echo $spliceBackwards('This is an example'); // This is an ex...
 
 
 // The length of the replacement can be defined, this will replace the chars after the offset with the replacement.

 $splice = Strings\replaceSubString('...', 5, 2);

 echo $splice('This is an example'); // This ... an example
 
 // Replaced is with ... after (5th char along and replaced 2 chars)


 // Passing 0 to the 3rd augment will just insert the sub string at the offset.

 $splice = Strings\replaceSubString('...', 5, 0);

 echo $splice('This is an example'); // This ... is an example



exampleCurried: >
 echo Strings\replaceSubString('...', 3)('This is an example'); // Thi...
 
 echo Strings\replaceSubString('...', -3)('This is an example'); // This is an ex...
 
 echo Strings\replaceSubString('...', 5, 2)('This is an example'); // This ... an example
 
 echo Strings\replaceSubString('...', 5, 0)('This is an example'); // This ... is an example



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