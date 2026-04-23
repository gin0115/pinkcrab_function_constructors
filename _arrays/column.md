---
title: Arrays\column()
description: >
 Creates a Closure that extracts a single column value from each row of an array or iterable of rows (arrays or objects). Optionally re-keys the result by another column's value.

layout: composable_function
group: arrays
subgroup: array_access
categories: [array, column]
coreFunctions: [array_column()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L875
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "(string, string?) → (Iterable<Row> → Iterable<mixed>)"
typeSignatureEn: >
 Given a column name and an optional key-column, returns a function that plucks a single column value from every row. If a key-column is supplied, the resulting entries are <code>rowKey =&gt; value</code>; otherwise they use sequential integer keys.

atGlance: >
 The functional equivalent of <code>array_column()</code>. Lazy — yields one column value per row on demand.

definition: >
 /**
   * @param string $column Column to retrieve.
   * @param string|null $key Column to use as the key (null = sequential ints).
   * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
   */
 Arrays\column(string $column, ?string $key = null): Closure

closure: >
 /**
   * @param iterable<int|string, mixed> $source
   * @return array<int|string, mixed>|\Generator<int|string, mixed>
   */
 $function (iterable $source): array|\Generator

examplePartial: >
 $names = Arrays\column('name');


 $rows = [
   ['id' => 1, 'name' => 'Ada'],
   ['id' => 2, 'name' => 'Bea'],
 ];


 print_r($names($rows)); // ['Ada', 'Bea']


exampleCurried: >
 print_r(Arrays\column('name', 'id')([
   ['id' => 1, 'name' => 'Ada'],
   ['id' => 2, 'name' => 'Bea'],
 ]));

 // [1 => 'Ada', 2 => 'Bea']

---
