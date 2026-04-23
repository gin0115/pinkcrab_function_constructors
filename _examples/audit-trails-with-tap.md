---
layout: example
title: Audit trails with tap / sideEffect
summary: >
 Add logging, audit records, or debug output to a pipeline without breaking the data flow. `sideEffect` runs a callable for its effect and passes the value through unchanged — drop it anywhere in a compose or pipe.

functions:
  - name: sideEffect
    url: /general/sideEffect.html
  - name: compose
    url: /general/compose.html
  - name: pipe
    url: /general/pipe.html
  - name: getProperty
    url: /general/getProperty.html
---

## The problem

You've got a nice pipeline that transforms data. Now you need to **observe** what's going through it — log intermediate values, record an audit trail, count how often a step matches — without destroying the pipeline shape.

{% highlight php %}
// Before — clean.
$transform = F\compose(
    $shape,
    $enrich,
    $persist
);
{% endhighlight %}

The imperative option is to break the chain, assign to a temporary, log, pass along. That defeats the point of the pipeline.

## Drop in a sideEffect

`sideEffect($fn)` wraps any callable into a new callable that calls `$fn($value)` for the side effect, then returns `$value` unchanged. Invisible to the pipeline, visible to you.

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

$logger   = F\sideEffect(fn($v) => error_log('after shape: ' . json_encode($v)));
$auditor  = F\sideEffect(fn($v) => AuditLog::record('order.transformed', $v));

$transform = F\compose(
    $shape,
    $logger,          // fires during the pipeline, value untouched
    $enrich,
    $auditor,         // records into your audit table
    $persist
);
{% endhighlight %}

Exactly the same output as before. The logger and auditor are pure side channels.

## Use cases

### Debug a single run

{% highlight php %}
$debug = F\sideEffect(function ($v) {
    dump($v);     // or var_dump, or whatever your debug helper is
});

$result = F\pipe(
    $rawData,
    $clean,
    $debug,        // shows what $clean produced
    $enrich,
    $debug         // shows what $enrich produced
);
{% endhighlight %}

Add, rerun, remove. The rest of the pipeline never knows.

### Metrics

{% highlight php %}
$tickStats = F\sideEffect(fn($row) => Metrics::increment('orders.processed'));

$transform = F\compose($shape, $tickStats, $persist);
{% endhighlight %}

### Audit record on every successful transform

{% highlight php %}
$auditTransformed = F\sideEffect(function ($order) {
    AuditLog::write([
        'action'   => 'order.transformed',
        'order_id' => $order['id'],
        'at'       => now(),
    ]);
});

$process = F\compose($shape, $validate, $enrich, $auditTransformed, $persist);
{% endhighlight %}

## Why this is cleaner than inline logging

- **No branching.** No `if ($logEnabled) { error_log(...) }` scattered around.
- **Turn on and off by composing.** Hot-swap the logger for a no-op in production by using `F\always(null)` or skip it entirely.
- **Testable.** Verify the auditor was called by injecting a spy — your pipeline's output doesn't change, so all your other tests stay green.

## A note on purity

`sideEffect` is the ONE place this library explicitly endorses impurity. The callable you pass in can do anything — write to disk, call an API, mutate state. Use it knowingly; everything else in a pipeline should stay pure.
