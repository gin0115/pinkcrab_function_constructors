---
title: GeneralFunctions\getProperty()
description: >
 Creates a Closure that reads a named property/index from any array or object. Works transparently across both — `['name' => 'Ada']` and `(object)['name' => 'Ada']` both yield 'Ada'.

layout: composable_function
group: general
subgroup: property_access
categories: [general, property]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L169
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, returns-closure, pure]

typeSignature: "string → (Record → mixed)"
typeSignatureEn: >
 Given a property name, returns a Closure that reads that property from any array or object.

atGlance: >
 One getter works on both arrays and objects. Returns <code>null</code> if the property is missing.

definition: >
 /**
   * @param string $property
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\getProperty(string $property): Closure

closure: >
 /**
   * @param array|object $record
   * @return mixed
   */
 $function ($record)

examplePartial: >
 $getName = GeneralFunctions\getProperty('name');


 echo $getName(['name' => 'Ada']);  // 'Ada'

 echo $getName((object) ['name' => 'Bea']); // 'Bea'


 // As a callback:

 $names = array_map($getName, [
   ['name' => 'Ada'],
   ['name' => 'Bea'],
 ]);


 print_r($names); // ['Ada', 'Bea']

---
