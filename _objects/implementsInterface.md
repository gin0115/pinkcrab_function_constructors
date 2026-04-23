---
title: Objects\implementsInterface()
description: >
 Creates a predicate Closure that is true when the passed object or class-string implements the bound interface.

layout: composable_function
group: objects
subgroup: type_check
categories: [objects, predicate, type, interface]
coreFunctions:
    - class_implements()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/objects.php#L79
namespace: PinkCrab\FunctionConstructors\Objects
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "(class-string | object) → ((class-string | object) → bool)"
typeSignatureEn: >
 Given an interface (as class-string or instance), returns a predicate that is true when the argument implements that interface.

atGlance: >
 Like <code>isInstanceOf</code> but specifically for interfaces. Works with either an object or a class-string.

definition: >
 /**
   * @param object|class-string $interface
   * @return Closure(object|class-string):bool
   */
 Objects\implementsInterface($interface): Closure

closure: >
 /**
   * @param object|class-string $target
   * @return bool
   */
 $function ($target): bool

examplePartial: >
 $isCountable = Objects\implementsInterface(\Countable::class);


 var_dump($isCountable(new \ArrayObject()));  // true

 var_dump($isCountable(new \stdClass()));     // false


 // Filter a mixed list down to just the Iterator-implementing instances.

 $iterables = array_filter(
   $mixed,
   Objects\implementsInterface(\Iterator::class)
 );

---
