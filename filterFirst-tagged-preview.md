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
/* ---------- plain-English reveal: button lives inside the block ---------- */
.v-reveal {
    display: inline-flex;
    align-items: flex-start;
    gap: 0.6em;
    margin: 0.5em 0 1em;
    padding: 4px;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 6px;
    max-width: 100%;
    transition: background 200ms ease, border-color 200ms ease, padding 200ms ease;
}
.v-reveal[data-open="true"] {
    background: #f5f7f8;
    border-color: #cfd8dc;
    padding: 0.55em 0.9em;
}

.v-reveal__trigger {
    flex-shrink: 0;
    width: 22px;
    height: 22px;
    padding: 0;
    background: #eceff1;
    border: 1px solid #cfd8dc;
    border-radius: 50%;
    color: #546e7a;
    font: inherit;
    font-size: 0.85em;
    font-weight: 700;
    line-height: 1;
    cursor: pointer;
    user-select: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background 160ms ease, color 160ms ease, border-color 160ms ease, transform 220ms ease;
}
.v-reveal__trigger:hover,
.v-reveal__trigger:focus {
    color: #fff;
    background: #546e7a;
    border-color: #546e7a;
    outline: none;
}
.v-reveal[data-open="true"] .v-reveal__trigger {
    color: #fff;
    background: #263238;
    border-color: #263238;
    transform: rotate(45deg);
}

.v-reveal__panel {
    flex: 1;
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    color: #37474f;
    font-size: 0.9em;
    line-height: 1.5;
    transition: max-height 260ms ease, opacity 200ms ease;
}
.v-reveal[data-open="true"] .v-reveal__panel {
    max-height: 400px;
    opacity: 1;
}
.v-reveal__panel code {
    background: #eceff1;
    padding: 1px 5px;
    border-radius: 3px;
    font-size: 0.95em;
    color: #1565c0;
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

<div class="v-typesig">
  <span class="v-generic">&lt;T&gt;</span> (<span class="v-generic">T</span> <span class="v-arrow">→</span> <span class="v-builtin">bool</span>) <span class="v-arrow">→</span> (<span class="v-builtin">Iterable</span>&lt;<span class="v-generic">T</span>&gt; <span class="v-arrow">→</span> <span class="v-generic">T</span> | <span class="v-builtin">null</span>)
</div>

<div class="v-reveal" data-open="false">
    <button type="button" class="v-reveal__trigger" aria-expanded="false" aria-controls="v-reveal-typesig" aria-label="Show plain-English translation of the type signature" title="Plain-English translation">?</button>
    <div id="v-reveal-typesig" class="v-reveal__panel" aria-hidden="true">
        Given a predicate on <code>T</code>, returns a function that consumes an iterable of <code>T</code> and returns either a <code>T</code> (the first match) or <code>null</code> (no match).
    </div>
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
// -------- JS tooltip popover on chips --------
(() => {
    const popup = document.getElementById('v-tip-popup');
    if (!popup) return;
    const headingEl = popup.querySelector('.v-tip-popup__heading');
    const bodyEl    = popup.querySelector('.v-tip-popup__body');
    const isTouchDevice = window.matchMedia('(hover: none)').matches;
    let activeChip = null;

    const show = (chip) => {
        const heading = chip.getAttribute('data-tip-heading') || '';
        const body    = chip.getAttribute('data-tip') || '';
        if (!body) return;

        headingEl.textContent = heading;
        bodyEl.textContent = body;
        popup.classList.add('v-tip-popup--visible');
        popup.setAttribute('aria-hidden', 'false');

        window.requestAnimationFrame(() => {
            const chipRect  = chip.getBoundingClientRect();
            const popupRect = popup.getBoundingClientRect();
            const margin = 8;

            const top  = chipRect.top + window.scrollY - popupRect.height - 10;
            let   left = chipRect.left + window.scrollX + (chipRect.width / 2) - (popupRect.width / 2);

            const minLeft = window.scrollX + margin;
            const maxLeft = window.scrollX + document.documentElement.clientWidth - popupRect.width - margin;
            if (left < minLeft) left = minLeft;
            if (left > maxLeft) left = maxLeft;

            popup.style.top  = `${top}px`;
            popup.style.left = `${left}px`;

            const chipCentre = chipRect.left + window.scrollX + (chipRect.width / 2);
            const arrowLeft  = chipCentre - left;
            popup.style.setProperty('--arrow-left', `${arrowLeft}px`);
        });

        activeChip = chip;
    };

    const hide = () => {
        popup.classList.remove('v-tip-popup--visible');
        popup.setAttribute('aria-hidden', 'true');
        activeChip = null;
    };

    document.querySelectorAll('.v-chip').forEach((chip) => {
        chip.addEventListener('mouseenter', () => show(chip));
        chip.addEventListener('mouseleave', hide);
        chip.addEventListener('focus',      () => show(chip));
        chip.addEventListener('blur',       hide);

        chip.addEventListener('click', (e) => {
            if (isTouchDevice && activeChip !== chip) {
                e.preventDefault();
                show(chip);
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (activeChip && !e.target.closest('.v-chip')) hide();
    });

    window.addEventListener('scroll', hide, { passive: true });
    window.addEventListener('resize', hide);
})();

// -------- JS reveal: click ? to expand inline info block --------
(() => {
    document.querySelectorAll('.v-reveal').forEach((container) => {
        const trigger = container.querySelector('.v-reveal__trigger');
        const panel   = container.querySelector('.v-reveal__panel');
        if (!trigger || !panel) return;

        trigger.addEventListener('click', () => {
            const isOpen = container.dataset.open === 'true';
            container.dataset.open = isOpen ? 'false' : 'true';
            trigger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
            panel.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
        });
    });
})();
</script>
