---
layout: base
title: Numbers
description: >
 Archive of all functions in the Numbers namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

> Composable numeric operations. Each constructor binds a fixed operand up front and returns a reusable Closure that accepts the other operand later. All functions accept `int` or `float` only — passing anything else throws `InvalidArgumentException`.

#### Arithmetic

{% highlight php %}
$addTo5      = Num\sum(5);
$addTo5(15.5);        // 20.5
$addTo5(-2);          // 3

$divideBy3   = Num\divideBy(3);
$divideBy3(12);       // 4.0
$divideBy3(10);       // 3.3333333333333

// Note the argument order: subtract(X)(Y) computes Y − X
$minusTen    = Num\subtract(10);
$minusTen(25);        // 15
{% endhighlight %}

Also: `multiply`, `divideInto`, `remainderBy`, `remainderInto`, `power`, `root`, `round`.

#### Predicates

{% highlight php %}
$isEven      = Num\isMultipleOf(2);
$isEven(12);          // true
$isEven(13);          // false
$isEven(0);           // false   — zero is never a multiple here

$factorOf12  = Num\isFactorOf(12);
$factorOf12(3);       // true    — 12 / 3 has no remainder
$factorOf12(5);       // false
{% endhighlight %}

#### Accumulators

{% highlight php %}
// Each call returns a fresh accumulator; call with null (or no arg) to finalise.
$total = Num\accumulatorInt(0);

$total = $total(5);
$total = $total(10);
$total = $total(-3);

echo $total();        // 12
{% endhighlight %}

`accumulatorFloat` follows the same pattern for floats.

### Deep-dive examples

- [Currency and pricing pipelines]({{ site.url }}/examples/currency-pricing.html) — multiply + VAT + round composed into one pipeline.
- [Grouping and aggregation]({{ site.url }}/examples/grouping-aggregation.html) — combining Number predicates with `Arr\filter` and `Arr\sumWhere`.
- [All worked examples]({{ site.url }}/examples.html) →

## Number Functions

<div class="container">
    <div class="grid all-functions">
    {% for function in site.numbers %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url }}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
