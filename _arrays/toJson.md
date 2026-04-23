---
title: Arrays\toJson()
description: >
 Creates a Closure that JSON-encodes an array or iterable with pre-bound flags and depth.

layout: composable_function
group: arrays
subgroup: array_cast
categories: [array, cast, json]
coreFunctions: [json_encode()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1080
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "(int, int) → (mixed → string | null)"
typeSignatureEn: >
 Given JSON-encode flags and a depth limit, returns a function that encodes any value as a JSON string (or returns null on failure).

atGlance: >
 Wraps <code>json_encode()</code>. Bind flags once (e.g. <code>JSON_PRETTY_PRINT</code>) for consistent output.

definition: >
 /**
   * @param int $flags json_encode flags.
   * @param int $depth Nodes deep to encode.
   * @return Closure(mixed):?string
   */
 Arrays\toJson(int $flags = 0, int $depth = 512): Closure

closure: >
 /**
   * @param mixed $value
   * @return string|null
   */
 $function ($value): ?string

examplePartial: >
 $pretty = Arrays\toJson(JSON_PRETTY_PRINT);


 echo $pretty(['name' => 'Ada', 'age' => 42]);

 /*

 {

     "name": "Ada",

     "age": 42

 }

 */

---
