---
title: Strings\isBlank()
description: >
 Checks whether a value is a string of zero length. Returns true only if the value is a string and its multibyte length is 0; any non-string value (null, int, array, etc.) returns false.

layout: composable_function
group: strings
subgroup: string_predicate
categories: [strings, string_predicate, predicate]
coreFunctions:
    - mb_strlen()
    - is_string()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L770
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

definition: >
 /**
   * @param mixed $value
   * @return bool
   */
 Strings\isBlank($value): bool

exampleInline: >
 // Called directly — this is a predicate, not a partially applied function.

 var_dump(Strings\isBlank(''));     // true

 var_dump(Strings\isBlank('foo'));  // false

 var_dump(Strings\isBlank(null));   // false

 var_dump(Strings\isBlank(0));      // false

 var_dump(Strings\isBlank([]));     // false


 // Used directly as a callable in a higher order function.

 $values = ['', 'foo', '', 'bar', ''];

 $blanks = array_filter($values, 'PinkCrab\FunctionConstructors\Strings\isBlank');

 print_r($blanks); // ['', '', '']

---
