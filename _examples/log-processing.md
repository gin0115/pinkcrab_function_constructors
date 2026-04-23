---
layout: example
title: Streaming log processing
summary: >
 Parse, filter, enrich, and format log lines as a lazy Generator pipeline — you can feed it a multi-gigabyte log file and it only holds a handful of lines in memory at once. Rearrange the stages by reordering the pipeline.

functions:
  - name: Arrays\map
    url: /arrays/map.html
  - name: Arrays\filter
    url: /arrays/filter.html
  - name: Arrays\takeUntil
    url: /arrays/takeUntil.html
  - name: Arrays\takeWhile
    url: /arrays/takeWhile.html
  - name: compose
    url: /general/compose.html
  - name: sideEffect
    url: /general/sideEffect.html
---

## The scenario

Process a server log file: parse each line into a structured record, drop the noise (health-checks, static-asset requests), enrich with GeoIP, and output a CSV. The file is too big to `file_get_contents()`. You want one pass, memory-stable.

## A Generator source

{% highlight php %}
$lines = function (string $path) {
    $fh = fopen($path, 'r');
    while (($line = fgets($fh)) !== false) {
        yield trim($line);
    }
    fclose($fh);
};
{% endhighlight %}

This yields one line at a time. Nothing is materialised.

## Build the pipeline

Every Arrays function in this library accepts an iterable and — for the lazy variants — returns a Generator. Composing them produces one big lazy pipeline.

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Arrays as A;
use PinkCrab\FunctionConstructors\Comparisons as C;

$parse = fn(string $line) => json_decode($line, true) ?? null;

$isNoise = fn(array $r) => in_array($r['path'] ?? '', ['/health', '/metrics'], true)
                       || str_starts_with($r['path'] ?? '', '/assets/');

$enrich = fn(array $r) => $r + ['country' => GeoIp::lookup($r['ip'])];

$pipeline = F\compose(
    A\map($parse),                 // string → array|null
    A\filter(C\not('is_null')),    // drop unparseable lines
    A\filter(C\not($isNoise)),     // drop health-checks / assets
    A\map($enrich)
);
{% endhighlight %}

## Consume — one line at a time

{% highlight php %}
foreach ($pipeline($lines('/var/log/access.log')) as $record) {
    echo CsvRow::from($record) . "\n";
}
{% endhighlight %}

Peak memory: roughly one line's worth of data, regardless of file size.

## Stop early — take elements while a condition holds

Processing only events from today, sorted chronologically?

{% highlight php %}
$todaysCutoff = strtotime('tomorrow');

$firstPageOfToday = F\compose(
    $pipeline,
    A\takeWhile(fn($r) => strtotime($r['time']) < $todaysCutoff),
    A\take(100)                // only the first 100 of today
);

foreach ($firstPageOfToday($lines('/var/log/access.log')) as $r) {
    // ...
}
{% endhighlight %}

`takeWhile` stops pulling from the source as soon as it hits tomorrow's first line. `take(100)` caps the output. Neither forces a full file scan.

## Sprinkle observability without breaking the flow

Drop a `sideEffect` in to count records, send metrics, or sample logs — the pipeline is unchanged:

{% highlight php %}
$meter = F\sideEffect(fn($r) => Metrics::increment('log.processed'));

$observed = F\compose($pipeline, $meter);
{% endhighlight %}

## Rearranging the flow

Because each step is a first-class callable, you can reorder or swap parts freely:

{% highlight php %}
// Cheaper: filter BEFORE enriching so we don't do a GeoIP lookup for noise.
$efficient = F\compose(
    A\map($parse),
    A\filter(fn($r) => $r !== null),
    A\filter(fn($r) => ! $isNoise($r)),
    A\map($enrich)              // only runs on what made it through
);

// Or: enrich before filtering, if some filters need enriched data.
$alternate = F\compose(
    A\map($parse),
    A\filter(C\not('is_null')),
    A\map($enrich),
    A\filter(C\not(F\propertyEquals('country', 'RU')))
);
{% endhighlight %}

Same steps, different orders, different tradeoffs — no code duplication, no rewrite.
