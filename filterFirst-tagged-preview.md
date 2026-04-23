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
.v-chip:focus { outline: 2px solid #1565c0; outline-offset: 2px; }

/* ---------- JS tooltip popup ---------- */
.v-tip-popup {
    position: absolute;
    top: 0;
    left: 0;
    max-width: 280px;
    padding: 0.55em 0.8em;
    background: #263238;
    color: #fff;
    font-size: 0.82em;
    line-height: 1.45;
    border-radius: 4px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.18);
    pointer-events: none;
    opacity: 0;
    transform: translateY(4px);
    transition: opacity 120ms ease, transform 120ms ease;
    z-index: 9999;
}
.v-tip-popup::after {
    content: "";
    position: absolute;
    top: 100%;
    left: var(--arrow-left, 50%);
    margin-left: -6px;
    border: 6px solid transparent;
    border-top-color: #263238;
}
.v-tip-popup--visible {
    opacity: 1;
    transform: translateY(0);
}
.v-tip-popup__heading {
    display: block;
    font-weight: 700;
    color: #c3e88d;
    margin-bottom: 0.2em;
    font-size: 0.98em;
}

.v-typesig {
    display: flex;
    align-items: center;
    gap: 0.75em;
    background: #263238;
    color: #c3e88d;
    padding: 0.55em 0.6em 0.55em 0.9em;
    border-radius: 3px;
    font-family: monospace;
    font-size: 0.98em;
    margin: 0.4em 0 0;
    overflow-x: auto;
}
.v-typesig[data-open="true"] { border-radius: 3px 3px 0 0; }
.v-typesig__sig { flex: 1; min-width: 0; }
.v-typesig .v-generic { color: #82b1ff; font-weight: 700; }
.v-typesig .v-arrow   { color: #ff9e80; }
.v-typesig .v-builtin { color: #f07178; }

.v-typesig__trigger {
    flex-shrink: 0;
    width: 22px;
    height: 22px;
    padding: 0;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 50%;
    color: #b0bec5;
    font-family: sans-serif;
    font-size: 0.85em;
    font-weight: 700;
    line-height: 1;
    cursor: pointer;
    user-select: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background 160ms ease, color 160ms ease, border-color 160ms ease;
}
.v-typesig__trigger:hover,
.v-typesig__trigger:focus {
    color: #fff;
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.38);
    outline: none;
}
.v-typesig[data-open="true"] .v-typesig__trigger {
    color: #263238;
    background: #c3e88d;
    border-color: #c3e88d;
}

.v-typesig__reveal {
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    margin: 0 0 1em;
    padding: 0 0.9em;
    background: #37474f;
    color: #eceff1;
    border-radius: 0 0 3px 3px;
    font-size: 0.9em;
    line-height: 1.5;
    transition: max-height 260ms ease, opacity 200ms ease, padding 200ms ease;
}
.v-typesig__reveal--open {
    max-height: 400px;
    opacity: 1;
    padding: 0.7em 0.9em;
}
.v-typesig__reveal code {
    background: rgba(255,255,255,0.08);
    padding: 1px 5px;
    border-radius: 3px;
    color: #c3e88d;
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
  <a class="v-chip" href="#"
     data-tip-heading="Higher-order function"
     data-tip="Takes one or more callables (predicates, mappers, comparators) as arguments.">higher-order</a>
  <a class="v-chip" href="#"
     data-tip-heading="Reducer"
     data-tip="Collapses a whole collection down to a single result.">reducer</a>
  <a class="v-chip" href="#"
     data-tip-heading="Short-circuit"
     data-tip="Stops consuming the source the moment it has enough to answer. Safe with infinite Generators.">short-circuit</a>
  <a class="v-chip" href="#"
     data-tip-heading="Accepts iterable"
     data-tip="Works with arrays, Iterators, or Generators interchangeably — no need to convert first.">accepts iterable</a>
  <a class="v-chip" href="#"
     data-tip-heading="Returns Closure"
     data-tip="The outer call binds arguments and hands back a reusable Closure — no answer is computed yet.">returns Closure</a>
  <a class="v-chip" href="#"
     data-tip-heading="Pure"
     data-tip="No side effects — same input always produces the same output (given any callables passed in are themselves pure).">pure</a>
</div>

<div id="v-tip-popup" class="v-tip-popup" role="tooltip" aria-hidden="true">
    <span class="v-tip-popup__heading"></span>
    <span class="v-tip-popup__body"></span>
</div>

<div class="v-typesig" data-open="false">
    <span class="v-typesig__sig"><span class="v-generic">&lt;T&gt;</span> (<span class="v-generic">T</span> <span class="v-arrow">→</span> <span class="v-builtin">bool</span>) <span class="v-arrow">→</span> (<span class="v-builtin">Iterable</span>&lt;<span class="v-generic">T</span>&gt; <span class="v-arrow">→</span> <span class="v-generic">T</span> | <span class="v-builtin">null</span>)</span>
    <button type="button" class="v-typesig__trigger" aria-expanded="false" aria-controls="v-typesig-reveal" aria-label="Show plain-English translation" title="Plain-English translation">?</button>
</div>
<div id="v-typesig-reveal" class="v-typesig__reveal" aria-hidden="true">
    Given a predicate on <code>T</code>, returns a function that consumes an iterable of <code>T</code> and returns either a <code>T</code> (the first match) or <code>null</code> (no match).
</div>

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

<script>
(() => {
    const popup = document.getElementById('v-tip-popup');
    if (!popup) return;
    const headingEl = popup.querySelector('.v-tip-popup__heading');
    const bodyEl    = popup.querySelector('.v-tip-popup__body');
    const isTouch   = window.matchMedia('(hover: none)').matches;
    let active = null;

    const show = (chip) => {
        const body = chip.getAttribute('data-tip') || '';
        if (!body) return;
        headingEl.textContent = chip.getAttribute('data-tip-heading') || '';
        bodyEl.textContent    = body;
        popup.classList.add('v-tip-popup--visible');
        popup.setAttribute('aria-hidden', 'false');

        requestAnimationFrame(() => {
            const chipRect  = chip.getBoundingClientRect();
            const popupRect = popup.getBoundingClientRect();
            const margin = 8;
            const top = chipRect.top + scrollY - popupRect.height - 10;
            let left = chipRect.left + scrollX + chipRect.width / 2 - popupRect.width / 2;
            const min = scrollX + margin;
            const max = scrollX + document.documentElement.clientWidth - popupRect.width - margin;
            left = Math.min(Math.max(left, min), max);
            popup.style.top  = `${top}px`;
            popup.style.left = `${left}px`;
            const chipCentre = chipRect.left + scrollX + chipRect.width / 2;
            popup.style.setProperty('--arrow-left', `${chipCentre - left}px`);
        });

        active = chip;
    };

    const hide = () => {
        popup.classList.remove('v-tip-popup--visible');
        popup.setAttribute('aria-hidden', 'true');
        active = null;
    };

    document.querySelectorAll('.v-chip').forEach((chip) => {
        chip.addEventListener('mouseenter', () => show(chip));
        chip.addEventListener('mouseleave', hide);
        chip.addEventListener('focus',      () => show(chip));
        chip.addEventListener('blur',       hide);
        chip.addEventListener('click', (e) => {
            if (isTouch && active !== chip) { e.preventDefault(); show(chip); }
        });
    });

    document.addEventListener('click', (e) => {
        if (active && !e.target.closest('.v-chip')) hide();
    });
    addEventListener('scroll', hide, { passive: true });
    addEventListener('resize', hide);
})();

(() => {
    document.querySelectorAll('.v-typesig__trigger').forEach((trigger) => {
        const container = trigger.closest('.v-typesig');
        const panelId   = trigger.getAttribute('aria-controls');
        const panel     = panelId ? document.getElementById(panelId) : null;
        if (!container || !panel) return;

        trigger.addEventListener('click', () => {
            const open = container.dataset.open !== 'true';
            container.dataset.open = open ? 'true' : 'false';
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
            panel.setAttribute('aria-hidden', open ? 'false' : 'true');
            panel.classList.toggle('v-typesig__reveal--open', open);
        });
    });
})();
</script>
