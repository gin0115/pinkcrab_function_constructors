---
layout: base
title: "PREVIEW — filterFirst() with I + D + B combined"
description: Mock of the proposed shared doc layout — type signature, at-a-glance call-out, and small chip row.
---

<style>
/* ---------- chips (variant B) ---------- */
.v-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin: 0.4em 0 1em;
}
.v-chip {
    display: inline-block;
    font-size: 0.72em;
    padding: 2px 9px;
    border-radius: 999px;
    border: 1px solid #cfd8dc;
    background: #eceff1;
    color: #37474f;
    text-decoration: none;
    line-height: 1.6;
    font-weight: 600;
    letter-spacing: 0.02em;
}
.v-chip:hover { background: #cfd8dc; }

/* ---------- type signature (variant I with <T>) ---------- */
.v-typesig {
    background: #263238;
    color: #c3e88d;
    padding: 0.55em 0.9em;
    border-radius: 3px;
    font-family: monospace;
    font-size: 0.98em;
    margin: 0.4em 0 0.35em;
    overflow-x: auto;
}
.v-typesig .v-generic { color: #82b1ff; font-weight: 700; }
.v-typesig .v-arrow   { color: #ff9e80; }
.v-typesig .v-builtin { color: #f07178; }
.v-typesig-en {
    color: #607d8b;
    font-style: italic;
    font-size: 0.9em;
    margin: 0 0 1em;
}

/* ---------- at-a-glance (variant D) ---------- */
.v-glance {
    background: #f1f8e9;
    border-left: 4px solid #8bc34a;
    padding: 0.7em 1em;
    border-radius: 0 4px 4px 0;
    margin: 1em 0;
    font-size: 0.95em;
}
.v-glance strong { color: #33691e; }

.preview-banner {
    padding: 0.6em 1em;
    background: #fff3e0;
    border-left: 4px solid #ff9800;
    border-radius: 0 3px 3px 0;
    margin: 0 0 1.5em;
    font-size: 0.9em;
}
</style>

<div class="preview-banner">
<strong>PREVIEW</strong> — mock of the shared layout applied to <code>Arrays\filterFirst()</code>. Combines chips (B), type signature with <code>&lt;T&gt;</code> (I), and at-a-glance call-out (D). Nothing else is live yet.
</div>

<h1 class="page-title">Arrays\filterFirst()</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  &raquo; <a href="{{ site.url | absolute_url }}/arrays.html">Arrays</a>
  &raquo; Arrays\filterFirst()
</div>

<div class="v-chips">
  <a class="v-chip" href="#" title="Higher-order function — takes one or more callables as arguments.">higher-order</a>
  <a class="v-chip" href="#" title="Reducer — collapses a collection down to a single result.">reducer</a>
  <a class="v-chip" href="#" title="Short-circuit — stops consuming the source at the first match. Safe with infinite Generators.">short-circuit</a>
  <a class="v-chip" href="#" title="Accepts arrays, Iterators, or Generators interchangeably.">accepts iterable</a>
  <a class="v-chip" href="#" title="The outer call binds the predicate and hands back a reusable Closure.">returns Closure</a>
  <a class="v-chip" href="#" title="No side effects given a pure predicate.">pure</a>
</div>

<div class="v-typesig">
  <span class="v-generic">&lt;T&gt;</span> (<span class="v-generic">T</span> <span class="v-arrow">→</span> <span class="v-builtin">bool</span>) <span class="v-arrow">→</span> (<span class="v-builtin">Iterable</span>&lt;<span class="v-generic">T</span>&gt; <span class="v-arrow">→</span> <span class="v-generic">T</span> | <span class="v-builtin">null</span>)
</div>
<p class="v-typesig-en">Given a predicate on <code>T</code>, returns a function that consumes an iterable of <code>T</code> and returns either a <code>T</code> (the first match) or <code>null</code> (no match).</p>

<div class="v-glance">
    <strong>At a glance —</strong> A higher-order function that takes a predicate and returns a Closure. The Closure pulls values from an iterable until the predicate matches, then stops. Safe with infinite Generators; returns <code>null</code> when nothing matches. Pure, given a pure predicate.
</div>

<div class="function__subtitle">
<p>Creates a Closure that returns the first value of an array or iterable that matches the predicate, or <code>null</code> if nothing matches. Short-circuits — the source is consumed only up to (and including) the first match.</p>
</div>

<div class="function__definition">
{% highlight php %}
/**
 * @param callable(mixed):bool $func Predicate — the first value returning true is returned.
 * @return Closure(iterable<int|string, mixed>):?mixed
 */
Arrays\filterFirst(callable $func): Closure
{% endhighlight %}
</div>

<div class="panel">
    <h3 class="panel__title">Returned Closure</h3>
    <div class="panel__content">
        <p class="small-desciption">When <code class="inline">Arrays\filterFirst()</code> is called, it returns the following Closure which can be used like a regular function.</p>
{% highlight php %}
/**
 * @param iterable<int|string, mixed> $source Array or iterable to scan.
 * @return mixed|null The first matching value, or null if nothing matches.
 */
$function (iterable $source)
{% endhighlight %}
    </div>
</div>

<h3 id="examples">Examples</h3>

<div class="panel">
    <h4 class="panel__title">Partial Application</h4>
    <div class="panel__content">
        <p>This can be used to create a simple closure which can be used as a regular function.</p>
{% highlight php %}
// Create a function that returns the first string value found.
$firstString = Arrays\filterFirst('is_string');

// Called as a function.
var_dump($firstString([null, 1, 'b', 2, 'c'])); // 'b'
var_dump($firstString([null, 1, 2]));           // NULL
{% endhighlight %}
    </div>
</div>

<div class="panel">
    <h4 class="panel__title">Curried</h4>
    <div class="panel__content">
        <p>This can be called inline using currying.</p>
{% highlight php %}
// Return the first multiple of 15.
var_dump(Arrays\filterFirst(fn($v) => $v % 15 === 0)([1, 2, 3, 15, 30])); // 15
{% endhighlight %}
    </div>
</div>

<div class="panel">
    <h4 class="panel__title">Inlined with Higher Order Function</h4>
    <div class="panel__content">
        <p>If you are not planning on reusing the Closure created, you can just call it inline with a higher order function as its callable.</p>
{% highlight php %}
$firstNegative = Arrays\filterFirst(fn($n) => $n < 0)([3, 1, 4, -1, 5, -9]);
var_dump($firstNegative); // -1
{% endhighlight %}
    </div>
</div>

<div class="panel">
    <h4 class="panel__title">Works with Iterables &amp; Generators</h4>
    <div class="panel__content">
        <p>Accepts a Generator or any <code class="inline">Traversable</code>. Because this function is <strong>short-circuit</strong>, only the values leading up to the first match are ever pulled from the source.</p>
{% highlight php %}
// Step 1 — a Generator that announces each value as it yields it.
$words = (function () {
    echo "yielded apple\n";    yield 'apple';
    echo "yielded ANT\n";      yield 'ANT';
    echo "yielded banana\n";   yield 'banana';
    echo "yielded BEE\n";      yield 'BEE';
})();

// Step 2 — build a reusable "first lowercase word" finder.
$firstLowercase = Arrays\filterFirst('ctype_lower');

// Step 3 — call it. The Generator is advanced only until the first match is found.
echo $firstLowercase($words);

// Output:
// yielded apple
// apple

// "yielded ANT", "yielded banana", "yielded BEE" never printed — the source was never asked for them.
{% endhighlight %}
    </div>
</div>

<hr>

<div class="function__details">
    <h3>Details</h3>
    <ul>
        <li><strong>Group:</strong> Arrays</li>
        <li><strong>Subgroup:</strong> Array filter</li>
        <li><strong>Core Functions:</strong> array_filter()</li>
        <li><strong>Since:</strong> 0.1.0</li>
        <li><strong>Source:</strong> <a href="https://github.com/gin0115/pinkcrab_function_constructors/blob/master/src/arrays.php#L390" target="_blank">GitHub</a></li>
    </ul>
</div>
