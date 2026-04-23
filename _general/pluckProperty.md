---
title: GeneralFunctions\pluckProperty()
description: >
 Creates a Closure that traverses a nested path of properties/indexes across arrays and objects. Works with any mix of the two — even ArrayAccess objects using array syntax.

layout: composable_function
group: general
subgroup: property_access
categories: [general, property, nested]

source: https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/general.php#L194
namespace: PinkCrab\FunctionConstructors\GeneralFunctions
since: 0.1.0

deprecated: false
alternative: false

tags: [transformer, variadic, returns-closure, pure]

typeSignature: "...string → (Record → mixed)"
typeSignatureEn: >
 Given a path of property names, returns a Closure that follows the path through arrays and objects and returns the final value.

atGlance: >
 Deep <code>getProperty</code> — walks a nested path. Returns <code>null</code> if any step is missing along the way.

definition: >
 /**
   * @param string ...$nodes
   * @return Closure(mixed[]|object):mixed
   */
 GeneralFunctions\pluckProperty(string ...$nodes): Closure

closure: >
 /**
   * @param array|object $record
   * @return mixed
   */
 $function ($record)

examplePartial: >
 $getAuthorName = GeneralFunctions\pluckProperty('details', 'author', 'name');


 $book = [
   'details' => [
     'author' => (object) ['name' => 'Ada'],
   ],
 ];


 echo $getAuthorName($book); // 'Ada'


 var_dump($getAuthorName(['details' => []])); // NULL (short path)

---
