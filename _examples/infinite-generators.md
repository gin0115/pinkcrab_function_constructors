---
layout: example
title: Working safely with infinite Generators
summary: >
 Pipe an infinite Generator through filter / map / take without ever materialising it. Learn which Arrays functions are safe (lazy and short-circuit) and which will hang forever (terminal).

functions:
  - name: Arrays\take
    url: /arrays/take.html
  - name: Arrays\takeWhile
    url: /arrays/takeWhile.html
  - name: Arrays\takeUntil
    url: /arrays/takeUntil.html
  - name: Arrays\filter
    url: /arrays/filter.html
  - name: Arrays\map
    url: /arrays/map.html
  - name: Arrays\filterFirst
    url: /arrays/filterFirst.html
  - name: Arrays\head
    url: /arrays/head.html
---

## An infinite source

{% highlight php %}
// Naturals: 1, 2, 3, 4, ... forever.
$naturals = function () {
    $i = 1;
    while (true) yield $i++;
};
{% endhighlight %}

`$naturals()` is a Generator that never ends. Passing it to anything that wants the "whole list" (array_filter, array_map, sort, count, ...) will hang.

## What's safe — lazy and short-circuit ops

This library's Arrays functions fall into three groups. Check the coloured badge at the top of each function's doc page:

- **Lazy** (green) — stream in, stream out. Safe with infinite sources.
- **Short-circuit** (amber) — stops pulling once it has its answer. Safe.
- **Terminal** (grey) — consumes everything. Will hang on an infinite source.

Use `Tags → [lazy](/tags/lazy.html)` / `[short-circuit](/tags/short-circuit.html)` / `[terminal](/tags/terminal.html)` to browse each group.

## First N values — lazy

{% highlight php %}
use PinkCrab\FunctionConstructors\Arrays;
use PinkCrab\FunctionConstructors\Numbers;
use PinkCrab\FunctionConstructors\Comparisons;

foreach (Arrays\take(5)($naturals()) as $n) {
    echo $n . ' ';
}
// 1 2 3 4 5
{% endhighlight %}

`take(5)` pulls five values, stops asking the source for more. The other 2,147,483,642 integers are never generated.

## Filter then take — still lazy

{% highlight php %}
$first5Evens = F\compose(
    Arrays\filter(Numbers\isMultipleOf(2)),   // Numbers\isMultipleOf gives us a ready-made "is even?" predicate
    Arrays\take(5)
);

foreach ($first5Evens($naturals()) as $n) {
    echo $n . ' ';
}
// 2 4 6 8 10
{% endhighlight %}

The pipeline pulls 1, tests (fail), pulls 2, tests (pass), yields, continues until 5 have yielded. At that point `take(5)` stops and the source stops advancing. No inline `fn()` — the predicate is constructed by another library function.

## Take until a condition — short-circuit

{% highlight php %}
foreach (Arrays\takeUntil(Comparisons\isGreaterThan(100))($naturals()) as $n) {
    echo $n . ' ';
}
// 1 2 3 ... 99 100
{% endhighlight %}

## First match — short-circuit

{% highlight php %}

$firstPrime = Arrays\filterFirst(function (int $n): bool {
    if ($n < 2) return false;
    for ($i = 2; $i * $i <= $n; $i++) if ($n % $i === 0) return false;
    return true;
});

echo $firstPrime($naturals());   // 2
{% endhighlight %}

Pulls 1 (not prime), pulls 2 (prime — match) → returns. Source advanced exactly twice.

## What will hang

Don't mix infinite sources with terminal operations:

{% highlight php %}
// ❌ hangs — sort needs the whole list
Arrays\sort()($naturals());

// ❌ hangs — fold needs to consume everything
Arrays\fold(fn($a, $b) => $a + $b, 0)($naturals());

// ❌ hangs — takeLast needs to know where the end is
Arrays\takeLast(5)($naturals());

// ❌ hangs — count materialises first
iterator_to_array($naturals());
{% endhighlight %}

For these, force a bounded prefix first:

{% highlight php %}
// ✅ sort the first 100 naturals
Arrays\sort()(iterator_to_array(Arrays\take(100)($naturals())));

// ✅ sum the first 100 naturals
Arrays\fold(fn($a, $b) => $a + $b, 0)(Arrays\take(100)($naturals()));
{% endhighlight %}

## A realistic case — poll an API forever, stop on first failure

{% highlight php %}
$poll = function () {
    while (true) {
        yield fetchLatest();
        sleep(5);
    }
};

$firstFailed = Arrays\filterFirst(fn($r) => $r['status'] !== 200);

$failedResponse = $firstFailed($poll());
// Loops fetching every 5 seconds until one fails, returns that response.
{% endhighlight %}

The pipeline is a live stream; `filterFirst` is the exit condition; no memory growth; no outer `while (true)` boilerplate.
