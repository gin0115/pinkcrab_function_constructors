---
title: Arrays\toObject()
description: >
 Creates a Closure that casts an array or iterable into an object — assigns each key/value pair as a property on the target. Defaults to stdClass when no target is supplied.

layout: composable_function
group: arrays
subgroup: array_cast
categories: [array, cast, object]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L1036
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, terminal, accepts-iterable, returns-closure, throws]

typeSignature: "object? → (Iterable<mixed> → object)"
typeSignatureEn: >
 Given an optional target object (null for stdClass), returns a function that assigns each key/value of an iterable as a property on the target.

atGlance: >
 Terminal — consumes the whole source. Throws if a target property does not exist or is not public.

definition: >
 /**
   * @param object|null $object Target object; null = stdClass.
   * @return Closure(iterable<int|string, mixed>):object
   * @throws \InvalidArgumentException If a property does not exist or is not public.
   */
 Arrays\toObject($object = null): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return object
   */
 $function (iterable $source): object

examplePartial: >
 $toStd = Arrays\toObject();

 $obj = $toStd(['name' => 'Ada', 'age' => 42]);


 echo $obj->name; // Ada

---
