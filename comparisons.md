---
layout: base
title: Comparisons
description: >
 Archive of all functions in the Comparisons namespace — predicate constructors for equality, ordering, type and truthiness checks, plus boolean combinators that stitch predicates together.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url }}/">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{page.title}}</a>
</div>

> Predicate factories for filter chains and logic. Bind a comparison once, reuse it against many values. Combine predicates with AND / OR / NOT without repeating yourself.

#### Equality and ordering

{% highlight php %}
use PinkCrab\FunctionConstructors\Comparisons as C;

$isFoo    = C\isEqualTo('foo');
$over18   = C\isGreaterThanOrEqualTo(18);
$inSet    = C\isEqualIn(['red', 'green', 'blue']);

array_filter($users, fn($u) => $over18($u['age']));
{% endhighlight %}

#### Type and truthiness

A mix of curried constructors and direct predicates. `isScalar('string')` returns a Closure; `isNumber`, `isTrue`, `isFalse`, `notEmpty` take the value directly.

{% highlight php %}
$isIntLike = C\isScalar('integer');
$isIntLike(42);  // true

C\isNumber(3.14);       // true  (direct call)
C\isTrue('yes');        // true  (loose true-ish)
C\notEmpty([]);         // false (direct call)
{% endhighlight %}

#### Combining predicates

`groupAnd` / `groupOr` (aliases `all` / `any`) and `not` let you build complex predicates without spelling them out.

{% highlight php %}
$isAdultString = C\groupAnd('is_string', fn($s) => strlen($s) >= 18);
$isNotZero     = C\not(C\isEqualTo(0));
$positiveOrZero = C\any(C\isGreaterThan(0), C\isEqualTo(0));
{% endhighlight %}

## Comparisons Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.comparisons %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
