---
title: GeneralFunctions\hasProperty()
description: >
 Creates a predicate Closure that is true when a given property/index exists on an array or object.

layout: composable_function
group: general
subgroup: property_access
categories: [general, property, predicate]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L219
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "string → (Record → bool)"
typeSignatureEn: >
 Given a property name, returns a predicate that is true when the record has that property.

atGlance: >
 Existence check — cares whether the key is set, not whether the value is truthy.

definition: >
 /**
   * @param string $property
   * @return Closure(mixed[]|object):bool
   */
 GeneralFunctions\hasProperty(string $property): Closure

closure: >
 /**
   * @param array|object $record
   * @return bool
   */
 $function ($record): bool

examplePartial: >
 $hasEmail = GeneralFunctions\hasProperty('email');


 $users = [
   ['name' => 'Ada', 'email' => 'a@x'],
   ['name' => 'Bea'],
 ];


 $withEmail = array_filter($users, $hasEmail);

 print_r($withEmail); // [['name' => 'Ada', 'email' => 'a@x']]

---
