---
layout: function
group: strings
subgroup: string_analysis


title: Strings\similar()
subtitle: >
 Allows you to create a function which can be used to compute a metric of similarity between two strings. The metric is based on the number of characters that are the same in the two strings. The metric is either returned as numerical value of matching chars or as a percentage. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L496
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0
categories: [strings, string analysis]
coreFunctions: 
    - similar_text()

deprecated: false
alternative: false

definition: >
 /**
   * @param string $comparisonString The string to compare against base.
   * @param bool $asPc If set to true will return the percentage match, rather than char count.
   * @return Closure(string):int|float
   */
  Strings\similar(string $base, bool $asPc = false): Closure

closure: >
 /**
   * @param string $string 
   * @return int|float
   * @psalm-pure
   */ 
 $function(string $string): int|float

examplePartial: >
 // Create a closure which will look for matches.

 $similarCount = Strings\similar('apple');

 $similarPc = Strings\similar('apple', true);


  // Called as a function.

  echo $similarCount('I like them there apples'); // 5

  echo $similarPc('I like them there apples'); // 34.48275862068966


  // Called as a Higher Order Function.

  $array = array_map( $similarCount, ['I like them there apples', 'I like them there pears']);

  print_r($array); // [5, 0]


exampleCurried: >
 echo Strings\similar('apple', true)('I like them there apples'); // 34.48275862068966

exampleInline: >
 $array = array_map( 
    Strings\similar('apple'), 
    ['I like them there apples', 'I like them there pears']
 );

 print_r($array); // [5, 0]



---

This function replaced both <code class="inline">Strings\similarAsBase()</code> and <code class="inline">Strings\similarAsComparison()</code> as they were both very similar and could be combined into a single function.