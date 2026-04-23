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
 // One encoder step: the 'displayName' output field is computed from the source by upper-casing its 'name'.

 $encodeName = GeneralFunctions\encodeProperty(
   'displayName',
   fn($src) => strtoupper($src['name'])
 );


 // On its own encodeProperty does nothing — it records the intent. The work happens inside recordEncoder.

 $toViewModel = GeneralFunctions\recordEncoder([])($encodeName);


 print_r($toViewModel(['name' => 'Ada']));  // ['displayName' => 'ADA']

---

## What it does (and what it doesn't)

`encodeProperty` doesn't touch any data by itself. It **bundles a key with a way to compute its value** — nothing more. The bundle is useful only inside [`recordEncoder`](/general/recordEncoder.html), which collects many of these bundles and runs them over a source record to build an output record.

Think of it as declaring one row of a transformation table:

{% highlight text %}
 output key       |  computed from source via
 -----------------+---------------------------------------
 'id'             |  getProperty('id')
 'displayName'    |  fn($u) => ucfirst($u['first']) . ' ' . ucfirst($u['last'])
 'isAdmin'        |  propertyEquals('role', 'admin')
 'country'        |  pluckProperty('profile', 'country')
{% endhighlight %}

Each row is one `encodeProperty` call. The value callable can be anything — [`getProperty`](/general/getProperty.html), [`pluckProperty`](/general/pluckProperty.html), a closure, a composed pipeline from [`compose`](/general/compose.html), a conditional from [`ifElse`](/general/ifElse.html). All that matters is that it takes the source record and returns the value for that output field.

### Why this indirection is useful

If you just wanted `$output['displayName'] = strtoupper($source['name'])` you could write exactly that. The separation pays off once you have several fields:

- Each encoder is a first-class callable — test it, log it, reuse it across encoders.
- The transformation is **data**, not control flow. You can filter or reorder your encoders based on configuration, permission rules, or anything else you like before `recordEncoder` runs them.
- Swapping array output for object output means changing the seed record passed to `recordEncoder` — the `encodeProperty` calls don't change.

### Full walked example

See **[Transforming complex objects](/examples/complex-objects.html)** for the whole pattern — building a view model from a list of API records with `encodeProperty` for every output field plus `recordEncoder` to assemble them.
