---
title: GeneralFunctions\setProperty()
description: >
 Creates a Closure that writes a value into a named property/index on a record. Works with both arrays and objects.

layout: composable_function
group: general
subgroup: property_access
categories: [general, property, setter]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L271
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, returns-closure]

typeSignature: "(Record, string) → (mixed → Record)"
typeSignatureEn: >
 Given a target record (array or object) and a property name, returns a Closure that writes any value into that property and returns the record.

atGlance: >
 Curried setter. Bind the record + property up front, then feed values in. <strong>Mutates the target when an object is passed by reference.</strong>

definition: >
 /**
   * @param array<string,mixed>|ArrayObject<string,mixed>|object $store
   * @param string $property
   * @return Closure(mixed):(array<string,mixed>|ArrayObject<string,mixed>|object)
   */
 GeneralFunctions\setProperty($store, string $property): Closure

closure: >
 /**
   * @param mixed $value
   * @return array|object
   */
 $function ($value)

examplePartial: >
 $user = (object) ['name' => 'Ada', 'role' => 'user'];


 $setRole = GeneralFunctions\setProperty($user, 'role');


 $promoted = $setRole('admin');

 echo $promoted->role; // 'admin'

---
