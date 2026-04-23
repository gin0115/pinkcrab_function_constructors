---
layout: base
title: Comparisons
description: >
 Archive of all functions in the Comparisons namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

> Predicate factories for filter chains and control flow. Bind a comparison once, reuse it against many values. Combine predicates with AND / OR / NOT to build richer conditions without repeating yourself.

#### Equality and ordering

{% highlight php %}
$isFoo    = C\isEqualTo('foo');
$isFoo('foo');     // true
$isFoo('bar');     // false

$over18   = C\isGreaterThanOrEqualTo(18);
$over18(21);       // true
$over18(17);       // false

$inPalette = C\isEqualIn(['red', 'green', 'blue']);
$inPalette('red');    // true
$inPalette('yellow'); // false
{% endhighlight %}

Also: `isNotEqualTo`, `isGreaterThan`, `isLessThan`, `isLessThanOrEqualTo`.

#### Type and truthiness

{% highlight php %}
$isString = C\isScalar('string');     // curried — binds the gettype() name
$isString('hello');   // true
$isString(42);        // false

C\isNumber(3.14);     // true     — direct call (int or float only)
C\isNumber('3.14');   // false    — stricter than is_numeric()
C\notEmpty([]);       // false
C\notEmpty('hello');  // true
{% endhighlight %}

Also: `isTrue`, `isFalse`, `sameScalar`, `allTrue`, `anyTrue`.

#### Combining predicates

{% highlight php %}
$isStringLongEnough = C\groupAnd('is_string', fn($s) => strlen($s) >= 3);
$isStringLongEnough('ok');    // false
$isStringLongEnough('hello'); // true

$isNotZero = C\not(C\isEqualTo(0));
$isNotZero(0);   // false
$isNotZero(5);   // true
{% endhighlight %}

`any` / `all` are aliases of `groupOr` / `groupAnd` with a more natural reading.

### Deep-dive examples

- [Preconfigured filters]({{ site.url }}/examples/preconfigured-filters.html) — "active users", "high-value orders" as named composed predicates.
- [Validation chains]({{ site.url }}/examples/validation-chains.html) — predicates as rules in a validator.
- [Using library functions instead of fn() lambdas]({{ site.url }}/examples/library-over-lambdas.html) — common predicate patterns, before and after.
- [All worked examples]({{ site.url }}/examples.html) →

## Comparisons Functions

<div class="container">
    <div class="grid all-functions">
    {% for function in site.comparisons %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url }}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
