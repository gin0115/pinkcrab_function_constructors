---
title: Arrays\foldKeys()
description: >
 Creates a Closure that reduces an array or iterable left-to-right with the callback receiving each (carry, key, value) triple.

layout: composable_function
group: arrays
subgroup: array_fold
categories: [array, fold, reduce]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1455
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, reducer, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "<T, A> ((A, int|string, T) → A, A) → (Iterable<T> → A)"
typeSignatureEn: >
 Given a reducer that receives <code>(carry, key, value)</code> and an initial accumulator, returns a function that folds the source into a single result while giving the reducer access to each key.

atGlance: >
 Like <code>fold</code> but with access to the key at each step. Terminal; streams the source via foreach.

definition: >
 /**
   * @param callable(mixed $carry, int|string $key, mixed $value): mixed $callable
   * @param mixed $initial
   * @return Closure(iterable<int|string, mixed>):mixed
   */
 Arrays\foldKeys(callable $callable, $initial = []): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed
   */
 $function (iterable $source)

examplePartial: >
 $keyValuePairs = Arrays\foldKeys(
   fn($acc, $k, $v) => $acc . "$k=$v; ",
   ''
 );


 echo $keyValuePairs(['a' => 1, 'b' => 2]); // a=1; b=2;

---
