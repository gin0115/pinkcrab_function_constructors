# The PinkCrab FunctionConstructors library.

![Unit Tests](https://github.com/gin0115/pinkcrab_function_constructors/workflows/PHP%20Composer/badge.svg?branch=develop)

**Version 0.1.3**

This library provides a small selection of functions for making functional programming a little cleaner and easier in php.

To include this packge please add the following to your composer.json

> REQUIRES PHP VERSION 7.1 MINIMUM!

To install using composer use **composer require pinkcrab/function-constructors**

If you wish to use this library within WordPress or other PHP codebase where you do not or cannot use composer, you can use the **FunctionsLoader** class. Just clone the repo into your codebase and do the following.

```php
<?php

require_once('path/to/cloned/repo/FunctionsLoader.php');
FunctionsLoader::include(); 
// This will then just include all functions files and you can use them.

```

All of our functions are namespaced as **PinkCrab\FunctionConstructors\\{lib}**. So the easiest way to use them is to use with an alias. Throughout all the docs on the wiki we use the following aliases.

```php
<?php
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\Arrays as Arr;

// Allowing for
Arr\Map('esc_html') or Str\append('foo') or F\pipe(...)

```

> For more details, please read the [wiki](https://github.com/gin0115/pinkcrab_function_constructors/wiki)

## Changes
* 0.1.2 - Added Arrays\zip() 
* 0.1.3 - Added Arrays\filterKey()

