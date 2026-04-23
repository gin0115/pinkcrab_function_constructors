---
title: Numbers\accumulatorInt()
description: >
 Creates a self-returning integer accumulator. Each call with an int returns a new accumulator Closure with that value added to the running total. Call with null (or no argument) to read the accumulated int out.

layout: composable_function
group: numbers
subgroup: number_accumulator
categories: [numbers, accumulator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L43
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

tags: [accumulator, returns-closure, pure]

typeSignature: "int → (int | null → Closure | int)"
typeSignatureEn: >
 Seeded with a starting int, returns a callable that either appends another int and hands back a fresh accumulator, or returns the final int when called with null.

atGlance: >
 An integer accumulator: each call with an int appends to the running total and returns a fresh accumulator; call with null (or no argument) to finalise and read the total.

definition: >
 /**
   * @param int $initial Optional seed value. Defaults to 0.
   * @return Closure(int|null):(Closure|int)
   */
 Numbers\accumulatorInt(int $initial = 0): Closure

closure: >
 /**
   * @param int|null $value  Value to add, or null to finalise.
   * @return Closure|int     Closure while still accumulating, int once finalised.
   */
 $function (?int $value = null): Closure|int

examplePartial: >
 // Seed the accumulator with a starting value — each call returns a new accumulator.

 $total = Numbers\accumulatorInt(100);


 // Add values step by step. Every add returns a fresh accumulator.

 $total = $total(5);

 $total = $total(10);

 $total = $total(-3);


 // Call with no argument (or null) to read the running total.

 echo $total(); // 112


exampleCurried: >
 // Chain the calls inline — every () adds; the final empty () finalises.

 echo Numbers\accumulatorInt()(1)(2)(3)(4)(); // 10


exampleInline: >
 // Fold an array of integers into a single total.

 $nums = [5, 10, 15, 20, 25];


 $acc = array_reduce(
   $nums,
   fn($acc, $n) => $acc($n),
   Numbers\accumulatorInt()
 );


 echo $acc(); // 75

---
