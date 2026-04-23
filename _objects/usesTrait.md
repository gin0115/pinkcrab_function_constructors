---
title: Objects\usesTrait()
description: >
 Creates a predicate Closure that is true when the passed object (or its class hierarchy) uses the bound trait.

layout: composable_function
group: objects
subgroup: type_check
categories: [objects, predicate, type, trait]
coreFunctions:
    - class_uses()

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/objects.php#L132
namespace: PinkCrab\FunctionConstructors\Objects
since: 0.1.0

deprecated: false
alternative: false

tags: [predicate, returns-closure, returns-bool, pure]

typeSignature: "(string, bool) → (object → bool)"
typeSignatureEn: >
 Given a trait class-string and an autoload flag, returns a predicate that is true when the object uses that trait (directly or via any parent class).

atGlance: >
 Trait-based counterpart to <code>implementsInterface</code>. Bind a trait up front; the returned Closure tests any object for its presence.

definition: >
 /**
   * @param string $trait Trait class-string.
   * @param bool $autoload Whether to call __autoload by default.
   * @return Closure(object):bool
   */
 Objects\usesTrait(string $trait, bool $autoload = true): Closure

closure: >
 /**
   * @param object $obj
   * @return bool
   */
 $function (object $obj): bool

examplePartial: >
 $hasLoggerTrait = Objects\usesTrait(LoggerAware::class);


 var_dump($hasLoggerTrait($service));  // true/false depending on the service class


 // Filter a list of services down to just those with logging.

 $loggable = array_filter($services, $hasLoggerTrait);

---
