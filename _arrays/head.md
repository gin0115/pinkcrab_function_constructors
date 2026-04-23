---
title: Arrays\head()
description: >
 Returns the first value of an array or iterable, or null if the source is empty. For Generators this is a genuine early-exit — the rest of the stream is not consumed.

layout: composable_function
group: arrays
subgroup: array_access
categories: [array, array access]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L104
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [reducer, short-circuit, accepts-iterable, returns-value, pure]

typeSignature: "<T> Iterable<T> → T | null"
typeSignatureEn: >
 Takes an iterable of <code>T</code> directly and returns the first <code>T</code>, or <code>null</code> if the source is empty.

atGlance: >
 Direct call — not a Closure constructor. Pulls one value from the source, then stops. Safe with infinite Generators.

definition: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed The first value, or null if empty.
   */
 Arrays\head(iterable $source)

examplePartial: >
 // Called directly with an array.

 var_dump(Arrays\head(['a', 'b', 'c'])); // 'a'

 var_dump(Arrays\head([]));              // NULL


exampleIterable: >
 // A Generator source — head stops pulling after the first value.

 $numbers = (function () {
     echo "yielded 1\n"; yield 1;
     echo "yielded 2\n"; yield 2;
     echo "yielded 3\n"; yield 3;
 })();


 echo Arrays\head($numbers);


 // Output:

 // yielded 1

 // 1


 // Values 2 and 3 are never produced.

---
