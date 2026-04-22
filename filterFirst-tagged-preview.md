---
layout: base
title: "PREVIEW — Arrays\\filterFirst() with tags"
description: Mock-up of a tagged doc page. Compare against /arrays/filterFirst.html.
---

<style>
.preview-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin: 1em 0 1.5em;
}
.preview-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.78em;
    padding: 3px 10px;
    border-radius: 999px;
    border: 1px solid #ccc;
    background: #f6f6f6;
    color: #333;
    text-decoration: none;
    line-height: 1.4;
    font-weight: 600;
    letter-spacing: 0.02em;
}
.preview-tag::before {
    content: "";
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.6;
}
.preview-tag--role         { color: #1565c0; border-color: #90caf9; background: #e3f2fd; }
.preview-tag--iteration    { color: #ef6c00; border-color: #ffcc80; background: #fff3e0; }
.preview-tag--input        { color: #4e342e; border-color: #bcaaa4; background: #efebe9; }
.preview-tag--return       { color: #6a1b9a; border-color: #ce93d8; background: #f3e5f5; }
.preview-tag--purity       { color: #2e7d32; border-color: #a5d6a7; background: #e8f5e9; }

.preview-tag-explain {
    margin: 1em 0 2em;
    padding: 0.8em 1.2em;
    background: #fafafa;
    border: 1px solid #eee;
    border-radius: 4px;
    font-size: 0.92em;
}
.preview-tag-explain summary {
    cursor: pointer;
    font-weight: 600;
    color: #555;
}
.preview-tag-explain dl {
    margin: 0.6em 0 0;
}
.preview-tag-explain dt {
    font-weight: 700;
    margin-top: 0.7em;
    color: #222;
}
.preview-tag-explain dt small {
    font-weight: 500;
    color: #777;
    margin-left: 0.5em;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.75em;
}
.preview-tag-explain dd {
    margin: 0.15em 0 0 0;
    color: #444;
}
.preview-tag-explain dd em {
    display: block;
    margin-top: 0.2em;
    color: #666;
    font-size: 0.88em;
}
</style>

<h1 class="page-title">Arrays\filterFirst()</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  &raquo; <a href="{{ site.url | absolute_url }}/arrays.html">Arrays</a>
  &raquo; Arrays\filterFirst()
</div>

<div class="preview-tags">
  <a href="#" class="preview-tag preview-tag--role">Higher-order function</a>
  <a href="#" class="preview-tag preview-tag--role">Reducer</a>
  <a href="#" class="preview-tag preview-tag--iteration">Short-circuit</a>
  <a href="#" class="preview-tag preview-tag--input">Accepts iterable</a>
  <a href="#" class="preview-tag preview-tag--return">Returns Closure</a>
  <a href="#" class="preview-tag preview-tag--purity">Pure</a>
</div>

<details class="preview-tag-explain" open>
<summary>What these mean</summary>
<dl>
  <dt>Higher-order function <small>Role</small></dt>
  <dd>
    Takes one or more callables as arguments. In this case the predicate you pass in decides whether a value matches.
    <em>Example: <code>Arrays\filter</code>, <code>Arrays\map</code> — anything that takes a callable.</em>
  </dd>

  <dt>Reducer <small>Role</small></dt>
  <dd>
    Collapses a whole collection (array or Generator) down to a single result. Unlike a transformer, the output is not "another collection of the same shape".
    <em>filterFirst reduces a list of many values to exactly one value (or null).</em>
  </dd>

  <dt>Short-circuit <small>Iteration</small></dt>
  <dd>
    Stops consuming the input source the moment it has enough to answer. Any values past the first match are never read. Safe to use with infinite Generators.
    <em>Contrast with <strong>Lazy</strong> (streams the whole source through) and <strong>Terminal</strong> (must consume the whole source).</em>
  </dd>

  <dt>Accepts iterable <small>Input</small></dt>
  <dd>
    The resulting Closure works with arrays, Iterators, or Generators interchangeably — you do not need to convert a Generator to an array first.
  </dd>

  <dt>Returns Closure <small>Return</small></dt>
  <dd>
    The outer call does not compute an answer on its own — it binds the predicate and returns a reusable Closure. Pass that Closure a source to actually get a value.
  </dd>

  <dt>Pure <small>Purity</small></dt>
  <dd>
    No side effects — same input, same output, assuming the predicate you pass in is itself pure. Safe to cache, safe to reorder, safe in parallel.
  </dd>
</dl>
</details>

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
        <p>Accepts a Generator or any <code class="inline">Traversable</code>. Because this function is tagged <strong>Short-circuit</strong>, only the values leading up to the first match are ever pulled from the source.</p>
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

---

> **This is a preview page.** Compare side-by-side with the live [Arrays\filterFirst()](/pinkcrab_function_constructors/arrays/filterFirst.html) to see the delta. Tag chips, explanation panel, and iterable example are all inline mock markup in this file — nothing shared, no layout or data changes, nothing that affects the rest of the site.
