---
title: GeneralFunctions\recordEncoder()
description: >
 Creates a Closure that builds a fresh record (array or object) from a source value by applying a series of encodeProperty() steps.

layout: composable_function
group: general
subgroup: record_encoder
categories: [general, encoder]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L320
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, composer, variadic, returns-closure]

typeSignature: "Record → (...(source → Record) → Record)"
typeSignatureEn: >
 Given a target record shape (array or object), returns a Closure that accepts any number of <code>encodeProperty</code> steps and produces a factory — feed it source data and you get the populated record back.

atGlance: >
 Declarative record construction. Compose <code>encodeProperty</code> steps to describe how each field is computed from source data.

definition: >
 /**
   * @param array<string,mixed>|ArrayObject<string,mixed>|object $dataType
   * @return Closure(Closure ...):(array|object)
   */
 GeneralFunctions\recordEncoder($dataType): Closure

examplePartial: >
 $toViewModel = GeneralFunctions\recordEncoder([])(
   GeneralFunctions\encodeProperty('id',    GeneralFunctions\getProperty('id')),
   GeneralFunctions\encodeProperty('title', fn($u) => strtoupper($u['name'])),
   GeneralFunctions\encodeProperty('admin', GeneralFunctions\propertyEquals('role', 'admin'))
 );


 print_r($toViewModel(['id' => 1, 'name' => 'Ada', 'role' => 'admin']));

 // ['id' => 1, 'title' => 'ADA', 'admin' => true]

---
