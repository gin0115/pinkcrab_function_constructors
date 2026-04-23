---
title: Objects\createWith()
description: >
 Creates a factory Closure that instantiates a class with a merged set of base properties and per-call overrides. Works well as a fixture builder or prototype factory.

layout: composable_function
group: objects
subgroup: construction
categories: [objects, factory, construction]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/objects.php#L161
namespace: PinkCrab\FunctionConstructors\Objects
since: 0.1.0

deprecated: false
alternative: false

tags: [hof, transformer, returns-closure]

typeSignature: "<C> (class-string<C>, map<string, mixed>) → (map<string, mixed> → C)"
typeSignatureEn: >
 Given a class name and a base property map, returns a Closure that takes per-instance overrides and produces a new instance of the class with base + override properties assigned.

atGlance: >
 Partial-application for object construction. The Closure merges your overrides over the base properties every time it is called. Returns a fresh object on every call.

definition: >
 /**
   * @param class-string $class
   * @param array<string, mixed> $baseProperties
   * @return Closure(array<string, mixed>):object
   */
 Objects\createWith(string $class, array $baseProperties = []): Closure

closure: >
 /**
   * @param array<string, mixed> $overrides
   * @return object An instance of the bound class.
   */
 $function (array $overrides): object

examplePartial: >
 class User {
   public string $name = '';
   public string $role = 'user';
   public bool   $active = true;
 }


 // A fixture builder for tests — every User starts active with role 'user'.

 $makeUser = Objects\createWith(User::class, ['role' => 'user', 'active' => true]);


 $admin  = $makeUser(['name' => 'Ada', 'role' => 'admin']);

 $member = $makeUser(['name' => 'Bea']);   // inherits role=user, active=true


 var_dump($admin->role);   // 'admin' — overridden

 var_dump($member->role);  // 'user'  — from base


exampleCurried: >
 $default = Objects\createWith(User::class)(['name' => 'Guest']);

 // new User with name='Guest', other defaults from the class itself.

---
