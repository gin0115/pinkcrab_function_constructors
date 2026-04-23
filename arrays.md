---
layout: base
title: Arrays
description: >
 Archive of all functions in the Arrays namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

> Functions for working with arrays and iterables. Every function here accepts a plain array, an `Iterator`, or a `Generator` — lazy where possible, short-circuit where the algorithm allows, terminal only where unavoidable. Each function page carries a badge telling you which category it falls into.

#### Map and filter — lazy by default

{% highlight php %}
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Numbers as Num;

$doubleEvens = F\compose(
    Arr\filter(Num\isMultipleOf(2)),   // keep evens
    Arr\map(Num\multiply(2))           // double them
);

$doubleEvens([1, 2, 3, 4, 5, 6]);   // [4, 8, 12]
{% endhighlight %}

The map family includes `map`, `mapKey`, `mapWith`, `mapWithKey`, `flatMap`, `column`. The filter family: `filter`, `filterKey`, `filterAnd`, `filterOr`, `filterMap`, plus the short-circuit variants `filterFirst`, `filterAny` and the terminal variants `filterLast`, `filterAll`, `filterCount`, `partition`.

#### Sort without mutation

{% highlight php %}
$users = [
    'ada' => ['name' => 'Ada', 'age' => 40],
    'bea' => ['name' => 'Bea', 'age' => 30],
    'cal' => ['name' => 'Cal', 'age' => 50],
];

$sortByAge = Arr\uasort(fn($a, $b) => $a['age'] <=> $b['age']);

$sortByAge($users);
// [
//   'bea' => ['name' => 'Bea', 'age' => 30],
//   'ada' => ['name' => 'Ada', 'age' => 40],
//   'cal' => ['name' => 'Cal', 'age' => 50],
// ]
// — keys preserved, $users unchanged
{% endhighlight %}

Every native PHP sort has a curried, immutable counterpart: `sort`, `rsort`, `ksort`, `krsort`, `asort`, `arsort`, `natsort`, `natcasesort`, `uksort`, `uasort`, `usort`.

#### Group, fold, reduce

{% highlight php %}
$orders = [
    ['id' => 1, 'status' => 'paid',     'amount' => 50],
    ['id' => 2, 'status' => 'paid',     'amount' => 20],
    ['id' => 3, 'status' => 'refunded', 'amount' => 15],
    ['id' => 4, 'status' => 'paid',     'amount' => 35],
];

$byStatus = Arr\groupBy(F\getProperty('status'))($orders);
// [
//   'paid'     => [ <order 1>, <order 2>, <order 4> ],
//   'refunded' => [ <order 3> ],
// ]

$totalPaid = Arr\sumWhere(F\getProperty('amount'))($byStatus['paid']);
// 105   (50 + 20 + 35)
{% endhighlight %}

Also: `fold`, `foldR`, `foldKeys`, `scan`, `scanR`, `partition`, `chunk`.

#### Take, prefix, position

`take`, `takeLast`, `takeUntil`, `takeWhile`, `head`, `last`, `tail` — prefix/suffix slicing and single-value access. Most of these are lazy or short-circuiting, making them safe even with infinite Generators.

#### Structural helpers

`append`, `prepend`, `zip`, `pick`, `replace`, `replaceRecursive`, `flattenByN`, `toObject`, `toJson`, `toString`, `arrayCompiler`, `arrayCompilerTyped`, `each`.

### Deep-dive examples

- [Grouping and aggregation]({{ site.url }}/examples/grouping-aggregation.html) — `groupBy`, `partition`, `sumWhere`, `fold` in action.
- [Streaming log processing]({{ site.url }}/examples/log-processing.html) — lazy pipeline over a huge log file.
- [Working safely with infinite Generators]({{ site.url }}/examples/infinite-generators.html) — which functions are safe with an infinite stream.
- [All worked examples]({{ site.url }}/examples.html) →

## Array Functions

<div class="container">
    <div class="grid all-functions">
    {% for function in site.arrays %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url }}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
