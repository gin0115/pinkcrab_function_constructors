---
title: Numbers\accumulatorFloat()
description: >
 Creates a self-returning float accumulator. Each call with a float returns a new accumulator Closure with that value added to the running total. Call with null (or no argument) to read the accumulated float out.

layout: composable_function
group: numbers
subgroup: number_accumulator
categories: [numbers, accumulator]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/numbers.php#L63
namespace: PinkCrab\FunctionConstructors\Numbers
since: 0.1.0

deprecated: false
alternative: false

tags: [accumulator, returns-closure, pure]

typeSignature: "float → (float | null → Closure | float)"
typeSignatureEn: >
 Seeded with a starting float, returns a callable that either appends another float and hands back a fresh accumulator, or returns the final float when called with null.

atGlance: >
 A float accumulator: each call with a float appends to the running total and returns a fresh accumulator; call with null (or no argument) to finalise and read the total.

definition: >
 /**
   * @param float $initial Optional seed value. Defaults to 0.0.
   * @return Closure(float|null):(Closure|float)
   */
 Numbers\accumulatorFloat(float $initial = 0): Closure

closure: >
 /**
   * @param float|null $value  Value to add, or null to finalise.
   * @return Closure|float     Closure while still accumulating, float once finalised.
   */
 $function (?float $value = null): Closure|float

examplePartial: >
 // Seed the accumulator with a starting value — each call returns a new accumulator.

 $running = Numbers\accumulatorFloat(1.0);


 // Add values step by step. Every add returns a fresh accumulator.

 $running = $running(1.5);

 $running = $running(2.25);

 $running = $running(-0.75);


 // Call with no argument (or null) to read the running total.

 echo $running(); // 4.0


exampleCurried: >
 // Chain the calls inline — every () adds; the final empty () finalises.

 echo Numbers\accumulatorFloat()(1.5)(2.25)(0.25)(); // 4.0


exampleInline: >
 // Fold an array of floats into a single total.

 $prices = [19.99, 4.50, 12.75, 0.99];


 $acc = array_reduce(
   $prices,
   fn($acc, $n) => $acc($n),
   Numbers\accumulatorFloat()
 );


 echo $acc(); // 38.23

---
