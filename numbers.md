---
layout: base
title: Numbers
description: >
 Archive of all functions in the Numbers namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url  }}">Home</a>
  >> <a href="{{ page.url | absolute_url }}">{{page.title}}</a>
</div>

> A collection of functions for composing numeric operations. Every constructor here is partially applied — supply a fixed operand up front and receive a reusable Closure that accepts the other operand later.

> All these functions accept `int` or `float` only. Numeric strings must be cast first — passing anything else throws `InvalidArgumentException`.

#### Basic Arithmetic

You can do some basic arithmetic using composable functions. This allows for the creation of a base value, then work using the passed value.

{% highlight php %}
// Add
$addTo5 = Num\sum(5);
$addTo5(15.5); // 20.5
$addTo5(-2);   // 3

// Subtract (value - initial)
$subtractFrom10 = Num\subtract(10);
$subtractFrom10(3);  // -7
$subtractFrom10(20); // 10

// Multiply
$multiplyBy10 = Num\multiply(10);
$multiplyBy10(5);   // 50
$multiplyBy10(2.5); // 25.0

// Divide By (value / divisor)
$divideBy3 = Num\divideBy(3);
$divideBy3(12); // 4
$divideBy3(10); // 3.3333333333333

// Divide Into (dividend / value)
$divideInto12 = Num\divideInto(12);
$divideInto12(4); // 3
{% endhighlight %}

#### Multiples, Factors and Remainders

Basic modulus operations and whole-factor checks — everything you need to bucket numbers.

{% highlight php %}
// Is value a multiple of the pre-defined number?
$isEven = Num\isMultipleOf(2);
$isEven(12); // true
$isEven(13); // false

// Is value a factor of the pre-defined number?
$factorOf12 = Num\isFactorOf(12);
$factorOf12(3); // true   — 12 / 3 is a whole number
$factorOf12(5); // false

// Remainder (value % divisor)
$remainderBy2 = Num\remainderBy(2);
$remainderBy2(10); // 0
$remainderBy2(9);  // 1

// Remainder (dividend % value)
$remainderInto10 = Num\remainderInto(10);
$remainderInto10(3); // 1   — 10 % 3
{% endhighlight %}

#### Rounding, Powers and Roots

{% highlight php %}
// Round to N decimal places
$round2dp = Num\round(2);
$round2dp(3.14159); // 3.14

// Raise to a fixed power
$squared = Num\power(2);
$squared(5);   // 25
$squared(1.5); // 2.25

// Take the nth root
$sqrt = Num\root(2);
$sqrt(16); // 4.0
$sqrt(2);  // 1.4142135623731
{% endhighlight %}

#### Accumulators

Running totals across successive calls. Each call with a value appends; call with `null` (or no argument) to read the running total out.

{% highlight php %}
// Integer accumulator
$total = Num\accumulatorInt();
$total = $total(5);
$total = $total(10);
$total = $total(2);
echo $total(); // 17

// Float accumulator — same shape, float-typed
$running = Num\accumulatorFloat(0.0);
echo $running(1.5)(2.25)(0.25)(); // 4.0
{% endhighlight %}

## Number Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.numbers %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
