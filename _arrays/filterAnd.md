---
title: Arrays\filterAnd()
description: >
 Create a function which filters an array using multiple predicates, all of which must return true.

layout: composable_function
group: arrays
subgroup: array_filter
categories: [array, array filter]
coreFunctions: [array_filter()]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L303
namespace: PinkCrab\FunctionConstructors\Arrays
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, variadic, lazy, accepts-iterable, returns-closure, pure]

typeSignature: "<T> ...(T → bool) → (Iterable<T> → Iterable<T>)"
typeSignatureEn: >
 Given any number of predicates on <code>T</code>, returns a function that yields only the values of a <code>T</code>-iterable for which <em>every</em> predicate is true.

atGlance: >
 AND-combines multiple predicates into a single filter. Lazy — Generator in, Generator out, keys preserved.

definition: >
 /**
  * Returns a Closure for filtering the passed array using multiple predicates, all of which must return true.
  *
  * @param callable(mixed): bool ...$callable The predicate function that determines if the value should be kept.
  * @return Closure(array<int|string, mixed>): array<int|string, mixed>
  */
 Arrays\filterAnd(callable ...$callback): Closure
closure: >
 /**
   * @param array<int|string, mixed> $array
   * @return array<int|string, mixed>
   */
 $function (array $data): array

examplePartial: >
 // Create a function that will filter out all string that have 4 or more characters.

 $filter = Arrays\filterAnd(
  'is_string',
  fn($v) => strlen($v) >= 4
 );


 // Called as a function.

 var_dump($filter([1 => 'abc', 2 => 3.14, 3 => 'abcd' ])); // ['abcd']


exampleCurried: >
 // Filter an array for all even numbers.


 var_dump(Arrays\filterAnd('is_numeric', fn($v) => $v % 2 === 0)(['Apple', 2, 3, 4, False, 6])); 
 
 
 // [2, 4, 6]

---