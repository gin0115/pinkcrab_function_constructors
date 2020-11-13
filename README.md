# The PinkCrab FunctionConstructors library.

This libary provides a small selection of functions for making functional programming a little cleaner and easier in php.

To include this packge please add the following to your composer.json

```json
{
    "repositories": [{
        "type": "vcs",
        "url": "https://gin0115@bitbucket.org/pinkcrab/function_constructors.git"
    },
    {......}
    ],
    "require": {
        "pinkcrab/function-constructors": "dev-master",
        ...........
    },
    "minimum-stability": "dev"
}

```

## Annotaions
Throughout the docs and the codebase we use elm style annotaions. These should hopefully make it easier for you to see how the functions can all fit together.

On the whole they are pretty straight forward, they just take a little getting used to.

```php
<?php

Int -> Int 
// This denotes a expression of takes an Int and returns an Int
function addFive(int $num):int {...}


( Int -> Int ) -> a 
// This denotes a function, that takes another function and returns some different type.
// The function passed in takes an Int and returns an Int
function add(callable $function): mixed {...}
add( fn(int $a) => $a + 1 );
```
The easiest way to read them is start at the end (that the return) and work your way back. Every set of **(BRACKETS)** denotes a function. Looking at the type signatures inside these functions helps understand what fits together.