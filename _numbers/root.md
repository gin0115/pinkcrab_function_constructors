---
title: Numbers\root()
description: >
 Creates a Closure that takes the pre-defined nth root of any number passed to it. Implemented as `pow($value, 1 / $root)` — root of 2 gives you the square root, root of 3 the cube root, and so on.

layout: composable_function
group: numbers
subgroup: number_transform
categories: [numbers, transform, root]
coreFunctions:
    - pow()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L350
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, returns-closure, pure, throws]

typeSignature: "number → (number → number)"
typeSignatureEn: >
 Given a root index n, returns a function that takes the nth root of any number.

atGlance: >
 Bind a root index (2 for square root, 3 for cube root, etc.); the returned Closure computes <code>pow(value, 1/root)</code>. Throws <code>InvalidArgumentException</code> on non-number input.

definition: >
 /**
   * @param int|float $root The root index — 2 for square root, 3 for cube root, etc.
   * @return Closure(int|float):(int|float)
   * @throws InvalidArgumentException If $root is not int or float.
   */
 Numbers\root($root): Closure

closure: >
 /**
   * @param int|float $value
   * @return int|float  Result of pow($value, 1 / $root).
   * @throws InvalidArgumentException If $value is not int or float.
   */
 $function (int|float $value): int|float

examplePartial: >
 // Create a square root function.

 $sqrt = Numbers\root(2);


 // Called as a function.

 echo $sqrt(16); // 4.0

 echo $sqrt(25); // 5.0

 echo $sqrt(2);  // 1.4142135623731


 // Used in a higher order function.

 $array = array_map($sqrt, [1, 4, 9, 16, 25]);

 print_r($array); // [1.0, 2.0, 3.0, 4.0, 5.0]


exampleCurried: >
 echo Numbers\root(3)(27); // 3.0


exampleInline: >
 $cubeRoots = array_map(Numbers\root(3), [1, 8, 27, 64]);

 print_r($cubeRoots); // [1.0, 2.0, 3.0, 4.0]

---
