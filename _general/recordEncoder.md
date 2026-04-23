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

## How this fits together

`recordEncoder` is the scaffold; [`encodeProperty`](/general/encodeProperty.html) is the brick. Each brick pairs one output key with a callable that produces its value from the source. The scaffold collects the bricks, applies each one to the input, and returns a fresh record.

This pattern separates **what the output record is** from **how each field is computed**:

- Reorder output fields by reordering the arguments — declaration order is output order.
- Add or remove fields without touching anything else.
- Test each encoder piece in isolation — every one is a tiny pure function.
- Swap array output for object output by passing an object to `recordEncoder` instead of `[]`.

### Seed types

The record passed to `recordEncoder` determines the output kind:

- `recordEncoder([])` — output is a fresh array.
- `recordEncoder(new \stdClass)` — output is an object (properties set via [`setProperty`](/general/setProperty.html)).
- `recordEncoder(new MyDto)` — output is your DTO with each field assigned as a public property.

### Composing field values

Each field callable is just a plain callable — use anything that takes the source record and returns a value:

- [`getProperty`](/general/getProperty.html) / [`pluckProperty`](/general/pluckProperty.html) for simple and nested lookups.
- An inline closure for computed fields.
- A composed pipeline from [`compose`](/general/compose.html) for multi-step transforms.
- [`ifElse`](/general/ifElse.html) with [`always`](/general/always.html) for conditionals.

### Full walked example

See **[Transforming complex objects](/examples/complex-objects.html)** for a step-by-step build that turns raw API records into view models using `recordEncoder` alongside `encodeProperty`, `pluckProperty`, `propertyEquals`, `ifElse`, and `always`.
