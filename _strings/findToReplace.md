---
title: Strings\findToReplace()
description: >
 Creates a double-curried find-and-replace. Binding the substring to find returns a Closure awaiting the replacement; binding the replacement returns the Closure that performs the replacement on a subject string. Useful when the same target needs to be swapped for several different values.

layout: composable_function
group: strings
subgroup: string_manipulation
categories: [strings, string manipulation, replace]
coreFunctions:
    - str_replace()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/strings.php#L135
namespace: PinkCrab\FunctionConstructors\Strings
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, returns-closure, pure]

typeSignature: "string → (string → (string → string))"
typeSignatureEn: >
 Given a needle, returns a Closure awaiting a replacement; supplying the replacement yields the final Closure that performs the swap on any subject string.

atGlance: >
 A double curry — bind the needle once, then spawn any number of replacement-bound Closures that share the same target. Wraps <code>str_replace()</code>.

definition: >
 /**
   * @param string $find Value to look for
   * @return Closure(string):Closure
   */
 Strings\findToReplace(string $find): Closure

closure: >
 /**
   * @param string $replace value to replace with
   * @return Closure(string):string
   */
 $function (string $replace): Closure

examplePartial: >
 // First bind the needle — the returned Closure awaits a replacement.

 $replaceFoo = Strings\findToReplace('foo');


 // Now bind any number of replacements, each one is its own reusable string function.

 $fooToBar = $replaceFoo('bar');

 $fooToBaz = $replaceFoo('baz');


 echo $fooToBar('its foo'); // its bar

 echo $fooToBaz('its foo'); // its baz


 // Either of the resulting Closures can be used in a higher order function.

 $array = array_map($fooToBar, ['one foo', 'two foo', 'three foo']);

 print_r($array); // ['one bar', 'two bar', 'three bar']


exampleCurried: >
 // All three arguments supplied inline — find, replace, subject.

 echo Strings\findToReplace('Hi')('Hello')('Hi im an example'); // Hello im an example


exampleInline: >
 // Skip the intermediate variables and drop the callable straight into a HOF.

 $array = array_map(Strings\findToReplace('foo')('bar'), ['Its foo', 'The foo is']);

 print_r($array); // ['Its bar', 'The bar is']

---
