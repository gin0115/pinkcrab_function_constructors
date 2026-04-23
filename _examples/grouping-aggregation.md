---
layout: example
title: Grouping and aggregation
summary: >
 Build reports — totals per category, user activity summaries, lists bucketed by status — by composing groupBy, map, and fold. Replace multi-pass code with one declarative pipeline.

functions:
  - name: Arrays\groupBy
    url: /arrays/groupBy.html
  - name: Arrays\map
    url: /arrays/map.html
  - name: Arrays\fold
    url: /arrays/fold.html
  - name: Arrays\sumWhere
    url: /arrays/sumWhere.html
  - name: Arrays\partition
    url: /arrays/partition.html
  - name: compose
    url: /general/compose.html
  - name: getProperty
    url: /general/getProperty.html
---

## The scenario

A list of payment records. We want three reports from the same data:

1. Total revenue per currency.
2. Count of payments per status, per customer.
3. Payments split into "refunded" vs "settled".

{% highlight php %}
$payments = [
    ['customer' => 'A', 'currency' => 'GBP', 'amount' => 100, 'status' => 'settled'],
    ['customer' => 'A', 'currency' => 'EUR', 'amount' => 50,  'status' => 'settled'],
    ['customer' => 'B', 'currency' => 'GBP', 'amount' => 75,  'status' => 'settled'],
    ['customer' => 'A', 'currency' => 'GBP', 'amount' => 25,  'status' => 'refunded'],
    ['customer' => 'B', 'currency' => 'EUR', 'amount' => 40,  'status' => 'settled'],
];
{% endhighlight %}

## 1. Revenue per currency — groupBy + sumWhere

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Arrays as A;

$byCurrency = A\groupBy(F\getProperty('currency'))($payments);
// ['GBP' => [payment, payment, payment], 'EUR' => [payment, payment]]

$totalInGroup = A\sumWhere(F\getProperty('amount'));

$revenueByCurrency = array_map($totalInGroup, $byCurrency);
// ['GBP' => 200, 'EUR' => 90]
{% endhighlight %}

`groupBy` buckets, `sumWhere` does "map to amount + sum" in one pass per bucket.

## 2. Payment counts per status, per customer — nested groupBy

{% highlight php %}
$byCustomer = A\groupBy(F\getProperty('customer'))($payments);

$statusCountsFor = fn(array $rows) =>
    array_map('count', A\groupBy(F\getProperty('status'))($rows));

$summary = array_map($statusCountsFor, $byCustomer);
/*
[
    'A' => ['settled' => 2, 'refunded' => 1],
    'B' => ['settled' => 2],
]
*/
{% endhighlight %}

`$statusCountsFor` is a reusable callable — "for a list of payments, return count per status". Apply it to every customer's bucket.

## 3. Refunded vs settled — partition

{% highlight php %}
[$settled, $refunded] = A\partition(
    fn($p) => $p['status'] === 'refunded'
)($payments);

// $settled  — truthy bucket (index 1)
// $refunded — falsy bucket (index 0)
{% endhighlight %}

Wait — `partition` puts truthy matches at index 1, falsy at 0. So unpacking is `[$falsy, $truthy]`. Rename to match:

{% highlight php %}
[$notRefunded, $refunded] = A\partition(
    fn($p) => $p['status'] === 'refunded'
)($payments);
{% endhighlight %}

One traversal, two buckets.

## Custom aggregator — fold

For anything `sumWhere` doesn't cover, drop to `fold`:

{% highlight php %}
$stats = A\fold(
    fn($acc, $p) => [
        'count' => $acc['count'] + 1,
        'total' => $acc['total'] + $p['amount'],
        'max'   => max($acc['max'], $p['amount']),
    ],
    ['count' => 0, 'total' => 0, 'max' => 0]
);

print_r($stats($payments));
// ['count' => 5, 'total' => 290, 'max' => 100]
{% endhighlight %}

## The pattern

- `groupBy` buckets by key.
- `map` over the buckets to summarise each.
- `fold` / `sumWhere` produces the summary for one bucket.
- `partition` is a special-case `groupBy` with a boolean key.

Compose these and you've replaced every "two foreach loops and a running total" pattern.
