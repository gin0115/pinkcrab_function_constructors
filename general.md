---
layout: base
title: General
description: >
 Archive of all functions in the General namespace — the foundational pieces of this library: function composition, piping, property accessors, and combinators.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{page.title}}</a>
</div>

> The structural backbone of the library. `compose()` and `pipe()` stitch smaller functions into bigger ones; the property accessors bridge arrays and objects with a single API; the combinators (`always`, `ifThen`, `ifElse`, `sideEffect`) handle common higher-order control flow.

#### Composition and Piping

Two sides of the same coin. `pipe()` takes a value and threads it through a list of callables immediately. `compose()` returns a Closure you can reuse across many inputs — ideal as a callback for `array_map` or inside another constructor.

{% highlight php %}
// pipe — immediate. Value in, value out.
$result = GeneralFunctions\pipe(
    '  Hello World  ',
    'trim',
    'strtolower',
    Strings\replaceWith(' ', '-')
); // 'hello-world'

// compose — deferred. Build once, reuse.
$slugify = GeneralFunctions\compose(
    'trim',
    'strtolower',
    Strings\replaceWith(' ', '-')
);

array_map($slugify, ['  Hello World  ', 'FOO Bar']);
// ['hello-world', 'foo-bar']
{% endhighlight %}

> `composeR()` / `pipeR()` run the callables in reverse order. `composeSafe()` halts at the first `null`. `composeTypeSafe()` takes a validator callable and halts if any step's output fails it.

#### Working with Records (arrays & objects)

The property accessors work the same way whether the record is an array or an object — set a property once, use it anywhere.

{% highlight php %}
$getName = GeneralFunctions\getProperty('name');

$isAdult = GeneralFunctions\propertyEquals('adult', true);

$users = [
    ['name' => 'Ada', 'adult' => true],
    ['name' => 'Bea', 'adult' => false],
];

array_map($getName, $users);  // ['Ada', 'Bea']
array_filter($users, $isAdult); // [['name' => 'Ada', 'adult' => true]]
{% endhighlight %}

> `pluckProperty()` traverses nested paths. `setProperty()` is the curried setter. `encodeProperty()` + `recordEncoder()` let you build a record from scratch using composable setters.

#### Combinators

`always()` returns a Closure that ignores its input and returns a fixed value — useful as a default value supplier. `ifThen()` / `ifElse()` lift conditional logic into composable callables. `sideEffect()` runs a callable for its effect and returns its input unchanged — great for logging inside a pipe.

## General Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.general %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
