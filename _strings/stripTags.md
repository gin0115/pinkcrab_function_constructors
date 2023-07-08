---
layout: function
group: strings
subgroup: string_manipulation


title: Strings\stripTags()
description: >
 Allows you to create a function which can be used to strip tags from a string. Optional section of allowed tags can be defined. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L592
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string manipulation]
coreFunctions: 
    - strip_tags()

deprecated: false
alternative: false

definition: >
 /**
   * @param string|string[]|null $allowedTags The allowed tags, pass null or leave blank for none.
 * @return Closure(string):string
   */
  Strings\stripTags($allowedTags = null): Closure

closure: >
 /**
   * @param string $string The string to strip tags from.
   * @return string
   * @psalm-pure
   */ 
 $function(string $string): string

examplePartial: >
 // Create a function that strips all tags from a string except <p> and <a>

 $stripTags = Strings\stripTags(['p', 'a']); 

 // OR  
 
 $stripTags = Strings\stripTags('<p><a>'); 


 // Called as a function.

 echo $stripTags('<p><span>Hello</span></p> <a href="#"><span>World</span></a>'); 
 
 // <p>Hello</p> <a href="#">World</a>


 // Used in a higher order function.

 $array = array_map( $stripTags, [
    '<p><span>Hello</span></p> <a href="#"><span>World</span></a>'
    '<div><h1><a href="#">Hello</a></h1></div>'
 ]);

  print_r($array); // [<p>Hello</p> <a href="#">World</a>, <a href="#">Hello</a>]
exampleCurried: >
 echo Strings\stripTags('<p><a>')('<p><span>Hello</span></p> <a href="#"><span>World</span></a>'); 
 
 // <p>Hello</p> <a href="#">World</a>

exampleInline: >
 $array = array_map( Strings\stripTags(['p', 'a']), [
    '<p><span>Hello</span></p> <a href="#"><span>World</span></a>'
    '<div><h1><a href="#">Hello</a></h1></div>'
 ]);

 print_r($array); // [<p>Hello</p> <a href="#">World</a>, <a href="#">Hello</a>]

---



