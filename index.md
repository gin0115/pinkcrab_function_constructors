---
layout: base
title: Home
description: >
 A PHP library of composable function constructors — partial application + pipelining for PHP's standard library and beyond.
---

At its core, **Function Constructors** is a library for building bigger functions out of smaller ones. Every helper here either partially applies a standard operation (so you can bind its configuration up front and reuse the resulting Closure) or it stitches callables together with `compose` / `pipe`.

### Compose or pipe — build once, reuse everywhere

`compose` returns a Closure you can pass anywhere a callable is expected. `pipe` takes a value and runs it through the chain immediately.

{% highlight php %}
// Build once.
$slugify = F\compose('trim', 'strtolower', Str\replaceWith(' ', '-'));

array_map($slugify, ['  Hello World  ', 'FOO Bar']);
// ['hello-world', 'foo-bar']

// Or run immediately.
F\pipe(
    [0, 3, 4, 5, 6, 8],
    Arr\filter(Num\isMultipleOf(2)),
    Arr\map(Num\multiply(2))
);
// [8, 8, 12, 16]
{% endhighlight %}

`composeR` / `pipeR` run callables in reverse order. `composeSafe` halts on the first `null`. `composeTypeSafe` halts on a custom type check.

### Records — one API for arrays and objects

`getProperty`, `hasProperty`, `propertyEquals`, `setProperty`, `pluckProperty` all work uniformly on arrays AND objects. Partially apply them and they become named, reusable concepts.

{% highlight php %}
$users = [
    ['id' => 1, 'name' => 'Ada', 'role' => 'admin'],
    ['id' => 2, 'name' => 'Bea', 'role' => 'user'],
    ['id' => 3, 'name' => 'Cal', 'role' => 'admin'],
];

$isAdmin = F\propertyEquals('role', 'admin');

array_filter($users, $isAdmin);
// [ ['id' => 1, ...], ['id' => 3, ...] ]

array_map(F\getProperty('name'), $users);
// ['Ada', 'Bea', 'Cal']
{% endhighlight %}

For building a fresh record from scratch, see `recordEncoder` + `encodeProperty` — walked through in the [complex objects example]({{ site.url }}/examples/complex-objects.html).

### Every Array function accepts iterables

The Arrays namespace functions all accept `array`, `Iterator`, or `Generator` interchangeably. Lazy functions (`map`, `filter`, `take`, `takeWhile`, ...) stream through a Generator without materialising it. Short-circuit ones (`filterFirst`, `filterAny`, `head`) stop at the answer. Terminal ones (sorts, `foldR`, `takeLast`) consume everything — so **never** run them against an infinite source.

{% highlight php %}
$naturals = function () { $i = 1; while (true) yield $i++; };

// Safe — take pulls only 5 values from the infinite generator.
foreach (Arr\take(5)($naturals()) as $n) echo "$n ";   // 1 2 3 4 5
{% endhighlight %}

### Where next

- [**Examples**]({{ site.url }}/examples.html) — 14 worked walkthroughs: normalising API payloads, form sanitisation, pricing pipelines, log streaming, validation chains, infinite generators, and more.
- [**Tags**]({{ site.url }}/tags.html) — browse every function by role (predicate / transformer / reducer), iteration behaviour (lazy / short-circuit / terminal), purity, and more.
- Per-namespace indices: [Arrays]({{ site.url }}/arrays.html) · [Strings]({{ site.url }}/strings.html) · [Numbers]({{ site.url }}/numbers.html) · [General]({{ site.url }}/general.html) · [Objects]({{ site.url }}/objects.html) · [Comparisons]({{ site.url }}/comparisons.html).

*****

<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/strings.html"><em>String</em> Functions</a></h3>
    <ul>
        {% for related in site.strings %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/arrays.html"><em>Array</em> Functions</a></h3>
    <ul>
        {% for related in site.arrays %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/numbers.html"><em>Number</em> Functions</a></h3>
    <ul>
        {% for related in site.numbers %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/general.html"><em>General</em> Functions</a></h3>
    <ul>
        {% for related in site.general %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/objects.html"><em>Object</em> Functions</a></h3>
    <ul>
        {% for related in site.objects %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/comparisons.html"><em>Comparison</em> Functions</a></h3>
    <ul>
        {% for related in site.comparisons %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>
