---
title: Arrays\pick()
description: >
 Creates a Closure that selects only the specified indexes/keys from an array or iterable.

layout: composable_function
group: arrays
subgroup: array_access
categories: [array, pick]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1628
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, variadic, terminal, accepts-iterable, returns-closure, pure]

typeSignature: "...string → (Iterable<mixed> → mixed[])"
typeSignatureEn: >
 Given one or more key names, returns a function that produces an array containing only the entries whose keys match.

atGlance: >
 Pluck a subset of keys out of a structure. Terminal on Generator input.

definition: >
 /**
   * @param string ...$indexes The keys to keep.
   * @return Closure(iterable<int|string, mixed>):mixed[]
   */
 Arrays\pick(string ...$indexes): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return mixed[]
   */
 $function (iterable $source): array

examplePartial: >
 $idAndName = Arrays\pick('id', 'name');


 print_r($idAndName(['id' => 1, 'name' => 'Ada', 'secret' => 'xxx']));

 // ['id' => 1, 'name' => 'Ada']

---
