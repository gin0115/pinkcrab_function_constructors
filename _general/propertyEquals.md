---
title: GeneralFunctions\propertyEquals()
description: >
 Creates a predicate Closure that is true when a given property/index on a record is equal to the expected value.

layout: composable_function
group: general
subgroup: property_access
categories: [general, property, predicate]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L244
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "(string, mixed) → (Record → bool)"
typeSignatureEn: >
 Given a property name and an expected value, returns a predicate that is true when the record's property equals the expected value.

atGlance: >
 Equality-by-property check. Perfect for filtering a list of records by a single field.

definition: >
 /**
   * @param string $property
   * @param mixed $value
   * @return Closure(mixed[]|object):bool
   */
 GeneralFunctions\propertyEquals(string $property, $value): Closure

closure: >
 /**
   * @param array|object $record
   * @return bool
   */
 $function ($record): bool

examplePartial: >
 $isAdmin = GeneralFunctions\propertyEquals('role', 'admin');


 $users = [
   ['name' => 'Ada', 'role' => 'admin'],
   ['name' => 'Bea', 'role' => 'user'],
   ['name' => 'Cal', 'role' => 'admin'],
 ];


 print_r(array_filter($users, $isAdmin));

 // [Ada, Cal]

---
