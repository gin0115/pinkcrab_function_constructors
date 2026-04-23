---
title: Objects\isInstanceOf()
description: >
 Creates a predicate Closure that is true when the passed class or object is an instance of the bound class.

layout: composable_function
group: objects
subgroup: type_check
categories: [objects, predicate, type]
coreFunctions:
    - is_a()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/objects.php#L47
namespace: PinkCrab\FunctionConstructors\Objects
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "<C> (C | class-string<C>) → ((C | class-string<C>) → bool)"
typeSignatureEn: >
 Given a class (object or class-string), returns a predicate that is true when the argument is an instance of that class, or a class-string naming it (or a subclass).

atGlance: >
 Bind a class up front; the returned Closure answers "is this an instance of it?" for any object or class-string passed in.

definition: >
 /**
   * @param object|class-string $class
   * @return Closure(object|class-string):bool
   */
 Objects\isInstanceOf($class): Closure

closure: >
 /**
   * @param object|class-string $target
   * @return bool
   */
 $function ($target): bool

examplePartial: >
 $isException = Objects\isInstanceOf(\Exception::class);


 var_dump($isException(new \RuntimeException()));  // true

 var_dump($isException(new \stdClass()));          // false


 // As a filter predicate over a mixed list.

 $exceptions = array_filter(
   [new \RuntimeException(), new \stdClass(), new \LogicException()],
   $isException
 );


 count($exceptions); // 2


exampleCurried: >
 var_dump(Objects\isInstanceOf(\Countable::class)(new \ArrayObject())); // true

---
