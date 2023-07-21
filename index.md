---
layout: base
title: Home
description: >
 This is where I will tell my friends way too much about me
---
At its core, the Function Constructors library is designed to make using PHP easier to use in a functional manor. With the use of functions `compose()` and `pipe()` its possible to construct complex functions, from simpler ones.

### Function Composition and Piping

#### pipe()

> PLEASE NOTE THIS HAS CHANGED IN VERSION 2.0.0, using `compose()` is now the preferred method.

Using `pipe(mixed $value, callable ...$callables)` and [ `pipeR()` *](#pipe "Same as pipe(), but callables in reverse order"), allows you to pass a value through a chain of callables. The result of the 1st function, is passed as the input the 2nd and so on, until the end when the final result is returned.

> The rest of this library makes it easier to use standard php functions as callables, by defining some of the parameters up front.

{% highlight php %}
$data = [0,3,4,5,6,8,4,6,8,1,3,4];

// Remove all odd numbers, sort in an acceding order and double the value.
$newData = F\pipe(
    $data,
    Arr\filter(Num\isMultipleOf(2)), // Remove odd numbers
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
{% endhighlight %}

#### compose()

Piping is ideal when you are working with a single value, but when it comes to working with Arrays or writing callbacks, compose() is much more useful.

`compose(callable ...$callables)` , `composeR(callable ...$callables)` , `composeSafe(callable ...$callables)` and `composeTypeSafe(callable $validator, callable ...$callables)` all allow you to create custom Closures.

{% highlight php %}

$data = [
    ['details'=>['description' => '    This is some description ']],
    ['details'=>['description' => '        This is some other description    ']],
];

$callback = F\compose(
   F\pluckProperty('details','description'), // Plucks the description
   'trim',                                   // Remove all whitespace
   Str\slice(0, 20),                         // Remove all but first 20 chars          
   'ucfirst',                                // Uppercase each word
   Str\append('...')                        // End the string with ...
);

$results = array_map($callback, $data);

$results = [
    'This Is Some Descrip...',
    'This Is Some Other D...'
]
{% endhighlight %}

> You can use `composeTypeSafe()` if you want to pass the return of each callable through a validator before being passed to the next. If the validator fails, the rest of the chain will be skipped and null will be returned.

*****

### Working with Records

It is possible to work with the properties of *Records* (arrays and objects). Indexes or Properties can be checked, fetched and set using some of the `GeneralFunctions` . 

#### Reading Properties

You can check if a property exists, get its value or compare it an defined value.

{% highlight php %}
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
{% endhighlight %}

> `pluckProperty()` can also be used if you need to traverse nested properties/indexes of either **arrays** or **objects** *also handles `ArrayAccess` objects, set with array syntax* [see example on `compose()` ](#compose)

#### Writing Properties

Its also possible to write properties of objects and set values to indexes in arrays using the `setProperty()` function. More complex structures can also be created using the [Record Encoder](../../../../pinkcrab_function_constructors/wiki/Record_Encoder)

{% highlight php %}
// Set object property.
$object = new class(){ public $key = 'default'};

// Create a custom setter function.
$setKeyOfObject = F\setProperty($object, 'key');
$object = $setKeyOfObject('new value');
// {"key":"new value"}

// Can be used with arrays too
$array = ['key' => 'default'];

// Create a custom setter function.
$setKeyOfSArray = F\setProperty($array, 'key');
$array = $setKeyOfSArray('new value');
// [key => "new value"]
{% endhighlight %}


*****

### Number Functions

Much of the number functions found in this library act as wrappers for common standard (PHP) library functions, but curried to allow them to be easier composed with.

#### Basic Arithmetic 

You can do some basic arithmetic using composable functions. This allows for the creation of a base value, then work using the passed value.

> All these functions allow the use of `INT` or `FLOAT` only, all numerical strings must be cast before being used. Will throw `TypeError` otherwise.

{% highlight php %}
// Add
$addTo5 = Num\sum(5);

$addTo5(15.5); // 20.5
$addTo5(-2); // 3

// Subtract
$subtractFrom10 = Num\subtract(10);
$subtractFrom10(3)  // 7
$subtractFrom10(20) // -10

// Multiply 
$multiplyBy10 = Num\multiply(10)
$multiplyBy10(5);   // 50 
$multiplyBy10(2.5); // 25.0

// Divide By
$divideBy3 = Num\divideBy(3);
$divideBy3(12); // 4 = 12/3
$divideBy3(10); // 3.333333333333 

// Divide Into
$divideInto12 = Num\divideInto(12);
$divideInto12(4); // 3 = 12/4
{% endhighlight %}

#### Multiple and Modulus

It is possible to do basic modulus operations and working out if a number has a whole factor of another.

{% highlight php %}
// Factor of 
$isMultipleOf2 = Num\isMultipleOf(2);
$isMultipleOf2(12); // true
$isMultipleOf2(13); // false

// Getting the remainder
$remainderBy2 = Num\remainderBy(2);
$remainderBy2(10); // 0 = (5 * 2) - 10
$remainderBy2(9);  // 1 = (4 * 2) - 9
{% endhighlight %}


<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/strings.html">
        <em>String</em> Functions
    </a></h3>
    <ul>
        {% for related in site.strings %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/arrays.html">
        <em>Array</em> Functions
    </a></h3>
    <ul>
        {% for related in site.arrays %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>