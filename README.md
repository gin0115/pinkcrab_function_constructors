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


( Int -> Int ) -> String 
// This denotes a function, that takes another function and returns a string.
// The function passed in takes an Int and returns an Int
function add(callable $function): string {
    return to_string($function(2));
}
add( fn(int $a): int => $a + 1 ); // 3
```
The easiest way to read them is start at the end (that the return) and work your way back. Every set of **(BRACKETS)** denotes a function. Looking at the type signatures inside these functions helps understand what fits together.

You will notice a lot of the functions have annotaions like this
> (Int -> Int) -> (Int -> String)

What we have here is a funtion that takes a function as a parmeter and returns another function. The function we pass in must take a single Int and return an Int, the function we get back will then take and Int and return a string.

```php
<?php

// This function reutrns a function which is preloaded with some matmatical operation.
// The function we pass to doMathsAsString holds all the logic, the function it returns
// will allow you to pass in a value to be operated on.
function doMathsAsString(callable $mathsThing): callable
{
    return function (int $modifier) use ($mathsThing): string {
        return strval($mathsThing($modifier));
    };
}

// This is our custom mathsThnig function.
// Is is preloaded with the value whos sqaure root we want.
// Then when this function is passed into doMathsAsString(), it is used as 
// $mathsThing().
$squareRootToPower = function (int $num): callable {
    return function (int $powerOf) use ($num) {
        return pow(sqrt($num), $powerOf);
    };
};

// We can then create a custom function for doing this with the square root of 144
$squareRootOf144ToThePowerOf = doMathsAsString($squareRootToPower(144));
// Then call whenever we want.
print $squareRootOf144ToThePowerOf(3); // 1728
print $squareRootOf144ToThePowerOf(4); // 20736

// Under the hood, the above function just does the following. 
function squareRootOf144ToThePowerOf($powerOf): string{
    return strval( pow( sqrt( 144 ), $powerOf ) );
}

// The exmaple above may look longer and more complex, But it is much more flexible.
$squareRootOf100ToThePowerOf = doMathsAsString($squareRootToPower(100));
print $squareRootOf144ToThePowerOf(3); // 1000
print $squareRootOf144ToThePowerOf(4); // 10000

// Not only that, becuase we have use partial application on all step, we can use these functions when contsructing more complex ones. And we have only created 1 named function (doMathsAsString()), all the rest can be created as needed.