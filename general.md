---
layout: base
title: General
description: >
 Archive of all functions in the General namespace — function composition, piping, property accessors, and combinators.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

> The structural backbone of the library. `compose()` and `pipe()` stitch smaller functions into bigger ones; the property accessors bridge arrays and objects with a single API; the combinators (`always`, `ifThen`, `ifElse`, `sideEffect`) handle common higher-order control flow.

#### Compose vs pipe

`compose` returns a Closure you can reuse. `pipe` takes a value and threads it through immediately.

{% highlight php %}
// Build once, reuse.
$slugify = F\compose('trim', 'strtolower', Str\replaceWith(' ', '-'));
$slugify('  Hello World  ');           // 'hello-world'

// Immediate — value in, value out.
F\pipe(
    '  Hello World  ',
    'trim',
    'strtolower',
    Str\replaceWith(' ', '-')
);                                     // 'hello-world'
{% endhighlight %}

`composeR` / `pipeR` run callables in reverse order. `composeSafe` halts on the first `null`; `composeTypeSafe` halts on a custom type-check failure.

#### Property access — arrays or objects, one API

{% highlight php %}
$users = [
    ['name' => 'Ada', 'role' => 'admin'],
    ['name' => 'Bea', 'role' => 'user'],
];

$getName  = F\getProperty('name');
$isAdmin  = F\propertyEquals('role', 'admin');

array_map($getName,  $users);          // ['Ada', 'Bea']
array_filter($users, $isAdmin);        // [ ['name' => 'Ada', ...] ]
{% endhighlight %}

`pluckProperty` follows a nested path. `hasProperty` is the existence predicate. `setProperty` is the curried setter. `encodeProperty` + `recordEncoder` build a new record from scratch.

#### Combinators

{% highlight php %}
$toIntOrZero = F\ifElse(
    'is_numeric',
    'intval',
    F\always(0)
);

$toIntOrZero('42');                    // 42
$toIntOrZero('nope');                  // 0
{% endhighlight %}

Also: `ifThen` (apply a transform only when a predicate matches), `sideEffect` (run a callable for its side effect and return the input unchanged — great for logging inside a pipeline), `invoker` (wrap a callable into a uniform Closure).

### Deep-dive examples

- [Transforming complex objects]({{ site.url }}/examples/complex-objects.html) — `recordEncoder` + `encodeProperty` building view models from API payloads.
- [Null-safe pipelines]({{ site.url }}/examples/null-safe-pipelines.html) — `composeSafe`, `composeTypeSafe`, and `ifElse` defaults.
- [Audit trails with tap / sideEffect]({{ site.url }}/examples/audit-trails-with-tap.html) — observability inside a pipeline without breaking it.
- [All worked examples]({{ site.url }}/examples.html) →

## General Functions

<div class="container">
    <div class="grid all-functions">
    {% for function in site.general %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url }}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
