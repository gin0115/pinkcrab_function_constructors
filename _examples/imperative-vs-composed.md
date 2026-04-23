---
layout: example
title: Imperative vs composed — same job, two shapes
summary: >
 Side-by-side comparison of the same workflow written two ways. Imperative code on the left, composed pipeline on the right — highlighting fewer temporary variables, clearer data flow, and individual pieces you can reuse and test.
---

## The job

Given a list of orders, produce a shortlist of customers who:

1. Placed at least one order over £100
2. Are verified
3. Formatted as `"Ada Lovelace <ada@example.com>"` strings, deduped and alphabetised.

## The imperative version

{% highlight php %}
$shortlist = [];

foreach ($orders as $order) {
    if (empty($order['customer']['verified'])) {
        continue;
    }
    if ($order['total'] < 100) {
        continue;
    }
    $c = $order['customer'];
    $name = ucfirst($c['first']) . ' ' . ucfirst($c['last']);
    $row  = $name . ' <' . strtolower($c['email']) . '>';
    if (! in_array($row, $shortlist, true)) {
        $shortlist[] = $row;
    }
}

sort($shortlist);
{% endhighlight %}

Works. But it's a single 12-line block that does five different things. If you want to add a filter, log a record, test "the formatting part" in isolation, or reuse "high-value" as a concept elsewhere, you're staring at a rewrite.

## The composed version

Each concept becomes its own named callable. The pipeline reads top-to-bottom like a specification.

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\Arrays as A;

// --- named concepts ---

$isVerified     = fn($order) => ! empty($order['customer']['verified']);
$isHighValue    = fn($order) => $order['total'] >= 100;

$getCustomer    = F\getProperty('customer');

$formatCustomer = fn($c) =>
    ucfirst($c['first']) . ' ' . ucfirst($c['last'])
  . ' <' . strtolower($c['email']) . '>';

// --- the pipeline ---

$shortlist = F\compose(
    A\filter(C\groupAnd($isVerified, $isHighValue)),
    A\map($getCustomer),
    A\map($formatCustomer),
    'array_unique',
    function ($a) { sort($a); return $a; }
)($orders);
{% endhighlight %}

## What changed

| | Imperative | Composed |
|---|---|---|
| Temporary variables | `$c`, `$name`, `$row`, `$shortlist` | — |
| Concepts named | 0 | `$isVerified`, `$isHighValue`, `$formatCustomer` |
| Can reuse "high-value" as a predicate elsewhere | No | Yes — just reference `$isHighValue` |
| Can unit-test "formatCustomer" in isolation | No | Yes — it's a pure one-arg function |
| Adding a new filter | Wedge an `if` into the loop | Add one more `A\filter(...)` step |
| Order of operations | Implicit in nesting | Explicit, linear, top-to-bottom |

## When imperative wins

If the transformation really is one-off, confined to a single place, and no concept ("verified", "high value") needs reuse — imperative is fine and often shorter. The composed form's payoff grows with:

- Number of named concepts you'd otherwise restate inline
- Number of places those concepts are used
- Whether pieces need to be tested separately
- Whether the pipeline's steps need to be swapped, extended, or reordered

This library exists for the cases where that payoff is real.
