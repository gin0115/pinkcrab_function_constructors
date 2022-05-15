# The PinkCrab FunctionConstructors library.

![Unit Tests](https://github.com/gin0115/pinkcrab_function_constructors/workflows/PHP%20Composer/badge.svg?branch=develop) [![codecov](https://codecov.io/gh/gin0115/pinkcrab_function_constructors/branch/develop/graph/badge.svg?token=X4LS5961T1)](https://codecov.io/gh/gin0115/pinkcrab_function_constructors) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gin0115/pinkcrab_function_constructors/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gin0115/pinkcrab_function_constructors/?branch=master) ![Packagist Downloads](https://img.shields.io/packagist/dt/pinkcrab/function-constructors?label=Downloads) ![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/gin0115/pinkcrab_function_constructors?label=Latest)

*******

This library provides a small selection of functions for making functional programming a little cleaner and easier in php.

## Setup

Can be included into your project using either composer or added manually to your codebase.

### Via Composer

`$ composer require pinkcrab/function-constructors`

### Via Manual Loader

If you wish to use this library within WordPress or other PHP codebase where you do not or cannot use composer, you can use the **FunctionsLoader** class. Just clone the repo into your codebase and do the following.

```php
require_once 'path/to/cloned/repo/FunctionsLoader.php';
FunctionsLoader::include(); 
```

All of our functions are namespaced as **PinkCrab\FunctionConstructors\\{lib}**. So the easiest way to use them is to use with an alias. Throughout all the docs on the wiki we use the following aliases.

```php
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\Arrays as Arr;

// Allowing for
Arr\Map('esc_html') or Str\append('foo') or F\pipe($var, 'strtoupper', Str\append('foo'))
```

## Usage

At its core, the Function Constructors library is designed to make using PHP easier to use in a functional manor. With the use of functions `compose()` and `pipe()` its possible to construct complex functions, from simpler ones.

### Function Composition and Piping

#### pipe()

Using `pipe(mixed $value, callable ...$callables)` and [`pipeR()`*](#pipe "Same as pipe(), but callables in reverse order"), allows you to pass a value through a chain of callables. The result of the 1st function, is passed as the input the 2nd and so on, until the end when the final result is returned.

> The rest of this library makes it easier to use standard php functions as callables, by defining some of the parameters up front.

```php
$data = [0,3,4,5,6,8,4,6,8,1,3,4];

// Remove all odd numbers, sort in an acceding order and double the value.
$newData = F\pipe(
    $data,
    Arr\filter(Num\isFactorOf(2)), // Remove odd numbers
    Arr\natsort(),                 // Sort the remaining values
    Arr\map(Num\multiply(2))       // Double the values.
);

// Result
$newData = [
 2 => 8,
 6 => 8,
 11 => 8,
 4 => 12,
 7 => 12,
 5 => 16,
 8 => 16,
];
```

#### compose()

Piping is ideal when you are working with a single value, but when it comes to working with Arrays or writing callbacks, compose() is much more useful.

`compose(callable ...$callables)`, `composeR(callable ...$callables)`, `composeSafe(callable ...$callables)` and `composeTypeSafe(callable $validator, callable ...$callables)` all allow you to create custom Closures.

```php

$data = [
    ['details'=>['description' => '    This is some description ']],
    ['details'=>['description' => '        This is some other description    ']],
];

$callback = F\compose(
   F\pluckProperty('details','description'), // Plucks the description
   'trim',                                   // Remove all whitespace
   Str\slice(0, 20),                         // Remove all but first 20 chars          
   'ucfirst',                                // Uppercase each word
   Str\prepend('...')                        // End the string with ...
);

$results = array_map($callback, $data);

$results = [
    'This Is Some Descrip...',
    'This Is Some Other D...'
]
```

> You can use `composeTypeSafe()` if you want to pass the return of each callable through a validator before being passed to the next. If the validator fails, the rest fo the chain will be skipped and null will be returned.

### Working with Records

It is possible to work with the properties of *Records* (arrays and objects). Indexes or Properties can be checked, fetched and set using some of the `GeneralFunctions`. 

#### Reading Properties

You can check if a property exists, get its value or compare it an defined value.

```php
$data = [
    ['id' => 1, 'name' => 'James', 'timezone' => '+1', 'colour' => 'red'],
    ['id' => 2, 'name' => 'Sam', 'timezone' => '+1', 'colour' => 'red', 'special' => true],
    ['id' => 3, 'name' => 'Sarah', 'timezone' => '+2', 'colour' => 'green'],
    ['id' => 4, 'name' => 'Donna', 'timezone' => '+2', 'colour' => 'blue', 'special' => true],
];

// Filter all users with +2 timezone.
$zonePlus2 = array_filter($data, F\propertyEquals('timezone','+2'));
$results = [['id' => 3, ....],['id' => 4, ...]];

// Filter all user who have the special index.
$special = array_filter($data, F\hasProperty('special'));
$results = [['id' => 2, ....],['id' => 4, ...]];

// Get a list of all colours.
$colours = array_map(F\getProperty('colour'), $data);
$results = ['red', 'red', 'green', 'blue'];
```
> `pluckProperty()` can also be used if you need to traverse nested properties/indexes of either **arrays** or **objects** *also handles `ArrayAccess` objects, set with array syntax* [see example on `compose()`](#compose)

#### Writing Properties

I

> For more details, please read the [wiki](https://github.com/gin0115/pinkcrab_function_constructors/wiki)

## Changes
* 1.0.0 - 
   * **New Functions**
   * Numbers\isFactorOf()
   * Strings\isBlank()
   * GeneralFunctions\composeR()
   * **Breaking Changes**
   * pipe() & pipeR() have now changed and are no longer alias for compose()
   * **Other Changes**
   * Constants added using the functions class name, `Functions::isBlank` can be used as a string for a callable.
* 0.1.2 - Added Arrays\zip() 
* 0.1.3 - Added Arrays\filterKey()

