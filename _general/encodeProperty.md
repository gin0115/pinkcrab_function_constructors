---
title: GeneralFunctions\encodeProperty()
description: >
 Creates a Closure for use inside a recordEncoder() — pairs a property key with a function that produces its value from the input data.

layout: composable_function
group: general
subgroup: record_encoder
categories: [general, encoder]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L302
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, returns-closure, pure]

typeSignature: "<T, U> (string, (T → U)) → ((T, Record) → Record)"
typeSignatureEn: >
 Given a property name and a value-producing callable, returns a Closure that writes the callable's result into the named property of a record.

atGlance: >
 Building block for <code>recordEncoder</code>. Each encoder step knows which key it writes and how to compute its value from the source data.

definition: >
 /**
   * @param string $key
   * @param callable(mixed):mixed $value
   * @return Closure(mixed):mixed
   */
 GeneralFunctions\encodeProperty(string $key, callable $value): Closure

examplePartial: >
 // Usually used inside recordEncoder() — see that page for full usage.

 $encodeName = GeneralFunctions\encodeProperty(
   'displayName',
   fn($src) => strtoupper($src['name'])
 );

---
