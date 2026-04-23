---
title: Objects\toArray()
description: >
 Returns a Closure that converts any object into an associative array of its public properties. Non-public properties and methods are not included.

layout: composable_function
group: objects
subgroup: conversion
categories: [objects, conversion, cast]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/objects.php#L100
namespace: PinkCrab\FunctionConstructors\Objects
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, returns-closure, pure]

typeSignature: "() → (object → map<string, mixed>)"
typeSignatureEn: >
 Takes no arguments. Returns a Closure that shallow-copies an object's public properties into an associative array keyed by property name.

atGlance: >
 No-argument constructor — just call <code>toArray()</code> and you get the Closure. Useful as a mapper across a list of objects to produce plain arrays.

definition: >
 /**
   * @return Closure(object):array<string, mixed>
   */
 Objects\toArray(): Closure

closure: >
 /**
   * @param object $obj
   * @return array<string, mixed>
   */
 $function (object $obj): array

examplePartial: >
 $toArr = Objects\toArray();


 $user = new class {
   public $name = 'Ada';
   public $role = 'admin';
   private $secret = 'hidden';
 };


 print_r($toArr($user)); // ['name' => 'Ada', 'role' => 'admin']

 // $secret is private, so it's not included.


 // Map a list of objects to arrays.

 $rows = array_map(Objects\toArray(), [$user1, $user2, $user3]);

---
