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

tags: [predicate, returns-bool, pure]

typeSignature: "mixed → bool"
typeSignatureEn: >
 Returns true when the value is a string of length zero; any non-string value returns false.

atGlance: >
 A direct predicate — no curry, no Closure. True only for an empty string; whitespace, null, zero, and empty arrays all return false.

definition: >
 /**
   * @param mixed $value
   * @return bool
   */
 Strings\isBlank($value): bool

examplePartial: >
 // isBlank is called directly with the value under test — it is not a partially applied constructor like the rest of the Strings namespace.

 var_dump(Strings\isBlank(''));     // true

 var_dump(Strings\isBlank('foo'));  // false


 // Only a zero-length string is considered blank. Any non-string value returns false.

 var_dump(Strings\isBlank(null));   // false

 var_dump(Strings\isBlank(0));      // false

 var_dump(Strings\isBlank([]));     // false


 // A string of whitespace is NOT blank — trim the input first if you need that behaviour.

 var_dump(Strings\isBlank(' '));                 // false

 var_dump(Strings\isBlank(Strings\trim(' ')(' '))); // true


exampleInline: >
 // Pass the fully qualified name as a string callable to any higher order function.

 $values = ['', 'foo', '', 'bar', ''];


 $blanks = array_filter($values, 'PinkCrab\FunctionConstructors\Strings\isBlank');

 print_r($blanks); // ['', '', '']


 // Or use it as a negated predicate to strip blanks out.

 $nonBlanks = array_filter($values, fn($v) => ! Strings\isBlank($v));

 print_r($nonBlanks); // ['foo', 'bar']

---
