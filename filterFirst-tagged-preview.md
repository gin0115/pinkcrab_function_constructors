---
layout: base
title: "PREVIEW — filterFirst() metadata variants"
description: Side-by-side mock-ups of every way we could surface categorical info on a function page. Compare, pick one, bin the rest.
---

<style>
.variant {
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 1.5em 0 2em;
    padding: 0 1.25em 1.25em;
    background: #fff;
}
.variant > h2 {
    margin: 0 -1.25em 1em;
    padding: 0.6em 1.25em;
    background: #263238;
    color: #fff;
    border-radius: 4px 4px 0 0;
    font-size: 1em;
    letter-spacing: 0.03em;
}
.variant > h2 small {
    font-weight: 400;
    color: #b0bec5;
    margin-left: 0.8em;
    font-size: 0.9em;
}
.variant .meta {
    margin-top: 1em;
    font-size: 0.82em;
    color: #555;
    padding: 0.6em 0.9em;
    background: #fafafa;
    border-left: 3px solid #b0bec5;
    border-radius: 0 3px 3px 0;
}
.variant .meta strong { color: #263238; }

.mock-title {
    font-size: 1.4em;
    font-weight: 700;
    margin: 0;
}
.mock-subtitle {
    color: #555;
    margin: 0.5em 0 1em;
}
.mock-signature {
    font-family: monospace;
    background: #263238;
    color: #eeffff;
    padding: 0.6em 0.9em;
    border-radius: 3px;
    font-size: 0.9em;
    margin: 0.7em 0;
    display: block;
    white-space: pre-wrap;
}

/* ---------- Variant B: small chips + tooltips ---------- */
.v-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin: 0.6em 0 1em;
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

/* ---------- Variant C: prose-first ---------- */
.v-prose a { color: #1565c0; border-bottom: 1px dotted #1565c0; text-decoration: none; }

/* ---------- Variant D: at-a-glance ---------- */
.v-glance {
    background: #f1f8e9;
    border-left: 4px solid #8bc34a;
    padding: 0.7em 1em;
    border-radius: 0 4px 4px 0;
    margin: 0.8em 0 1em;
    font-size: 0.95em;
}
.v-glance strong { color: #33691e; }

/* ---------- Variant E: listing-first ---------- */
.v-listing {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 0;
    border: 1px solid #eee;
    border-radius: 4px;
    margin: 0.8em 0 1em;
}
.v-listing dt {
    background: #f5f5f5;
    padding: 0.5em 0.8em;
    font-weight: 700;
    border-bottom: 1px solid #eee;
}
.v-listing dd {
    padding: 0.5em 0.8em;
    border-bottom: 1px solid #eee;
    margin: 0;
    font-family: monospace;
    font-size: 0.9em;
}
.v-listing dt:last-of-type,
.v-listing dd:last-of-type { border-bottom: none; }
.v-listing dd em { color: #2e7d32; font-style: normal; font-weight: bold; }

/* ---------- Variant F: iconography ---------- */
.v-icons { display: inline-flex; gap: 0.35em; margin-left: 0.5em; vertical-align: middle; }
.v-icons span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #eceff1;
    border: 1px solid #cfd8dc;
    font-size: 0.9em;
    cursor: help;
}

/* ---------- Variant G: use-this-when ---------- */
.v-usewhen {
    background: #fff8e1;
    border: 1px solid #ffe082;
    border-radius: 4px;
    padding: 0.6em 0.9em 0.6em 1.2em;
    margin: 0.6em 0 1em;
    font-size: 0.95em;
}
.v-usewhen > strong { display: block; margin-bottom: 0.3em; color: #795548; }
.v-usewhen ul { margin: 0; padding-left: 1em; }

/* ---------- Variant H: compatibility strip ---------- */
.v-compat {
    display: flex;
    gap: 0.6em;
    margin: 0.6em 0 1em;
    font-size: 0.85em;
    flex-wrap: wrap;
}
.v-compat span {
    padding: 3px 10px;
    border-radius: 3px;
    border: 1px solid #e0e0e0;
}
.v-compat .ok    { background: #e8f5e9; color: #2e7d32; border-color: #a5d6a7; }
.v-compat .warn  { background: #fff3e0; color: #ef6c00; border-color: #ffcc80; }
.v-compat .bad   { background: #ffebee; color: #c62828; border-color: #ef9a9a; }

/* ---------- Variant I: Haskell-style ---------- */
.v-hs {
    background: #263238;
    color: #c3e88d;
    padding: 0.5em 0.8em;
    border-radius: 3px;
    font-family: monospace;
    font-size: 0.95em;
    margin: 0.6em 0 0.3em;
}
.v-hs-en { color: #607d8b; font-style: italic; font-size: 0.9em; }

/* ---------- Variant J: see also ---------- */
.v-see {
    margin: 0.8em 0 1em;
    padding: 0.6em 0.9em;
    background: #f3e5f5;
    border-left: 4px solid #ab47bc;
    border-radius: 0 4px 4px 0;
}
.v-see > strong { display: block; color: #4a148c; margin-bottom: 0.3em; }
.v-see ul { margin: 0; padding-left: 1.1em; }
.v-see code { font-weight: 700; }

/* ---------- Current live iterable badge ---------- */
.v-iterable-badge {
    display: flex;
    gap: 0.5em;
    align-items: baseline;
    margin: 0.6em 0 1em;
    padding: 0.5em 0.9em;
    border-left: 4px solid #ff9800;
    background: #fff3e0;
    border-radius: 3px;
    font-size: 0.9em;
}
.v-iterable-badge strong {
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-size: 0.78em;
    padding: 2px 8px;
    border-radius: 3px;
    color: #fff;
    background: #ff9800;
}
</style>

# Metadata / tag concept comparison

Pick one. Each panel below mocks one way the categorical info (role, iteration behaviour, purity, input compatibility, etc.) could be surfaced on a function doc page. They all use `Arrays\filterFirst()` as the test subject so only the presentation varies.

---

<section class="variant">
<h2>0 — CURRENTLY LIVE <small>iterable-behaviour badge (what's on the actual site right now)</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<div class="v-iterable-badge">
    <strong>Short-circuiting</strong>
    <span>Stops iterating at the first matching value — the source is not advanced past it.</span>
</div>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> answers the one categorical question that affects whether your code works.  <strong>Con:</strong> only one dimension (lazy/short-circuit/terminal); jargon-y; only applies to arrays.</div>
</section>

<section class="variant">
<h2>A — Quiet tags in the Details sidebar <small>zero chrome up top</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<p style="margin:0.8em 0 0.3em; font-size:0.9em; color:#999;">…examples and panels as normal…</p>

<div style="margin-top:1.2em; padding:0.8em 1em; background:#fafafa; border:1px solid #eee; border-radius:3px;">
    <strong style="display:block; margin-bottom:0.4em;">Details</strong>
    <ul style="margin:0; padding-left:1.1em; font-size:0.9em;">
        <li><strong>Group:</strong> Arrays</li>
        <li><strong>Subgroup:</strong> Array filter</li>
        <li><strong>Since:</strong> 0.1.0</li>
        <li><strong>Source:</strong> <a href="#">GitHub</a></li>
        <li><strong>Tags:</strong> <a href="#">predicate hof</a> · <a href="#">reducer</a> · <a href="#">short-circuit</a> · <a href="#">accepts-iterable</a> · <a href="#">pure</a></li>
    </ul>
</div>

<div class="meta"><strong>Pro:</strong> function body stays exactly as today. Discoverability exists via archive pages; teaching lives there too. <strong>Con:</strong> nearly invisible — most readers never scroll to the Details.</div>
</section>

<section class="variant">
<h2>B — Small neutral chips under title <small>tooltips; click → archive</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<div class="v-chips">
  <a class="v-chip" href="#" title="Higher-order function — takes callables as arguments.">higher-order</a>
  <a class="v-chip" href="#" title="Reducer — collapses a collection down to a single result.">reducer</a>
  <a class="v-chip" href="#" title="Stops at the first match. Safe with infinite Generators.">short-circuit</a>
  <a class="v-chip" href="#" title="Works with arrays, Iterators, or Generators.">accepts iterable</a>
  <a class="v-chip" href="#" title="Binds arguments and returns a reusable Closure.">returns Closure</a>
  <a class="v-chip" href="#" title="No side effects given a pure predicate.">pure</a>
</div>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> glanceable; doesn't shout. <strong>Con:</strong> still takes a strip above the description; mobile loses the tooltips.</div>
</section>

<section class="variant">
<h2>C — Prose-first with inline glossary links <small>no chips at all</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<p class="mock-subtitle v-prose">
  <code>Arrays\filterFirst()</code> is a <a href="#">short-circuiting</a> <a href="#">reducer</a> that takes a predicate and returns the first matching value from an <a href="#">iterable</a>, or <code>null</code> if nothing matches. Because it short-circuits, it is safe to use with infinite <a href="#">Generators</a>.
</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> reads like prose; teaching happens through linked glossary once. <strong>Con:</strong> every description has to follow a consistent shape; no chip colours for instant skim.</div>
</section>

<section class="variant">
<h2>D — "At a glance" paragraph call-out <small>one prose block, no chips</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<div class="v-glance">
    <strong>At a glance —</strong> A higher-order function that takes a predicate and returns a Closure. Short-circuits on the first match, so it is safe with infinite Generators. Pure, given a pure predicate.
</div>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> teaches in context; no chip system to maintain. <strong>Con:</strong> no click-through to other functions with the same traits.</div>
</section>

<section class="variant">
<h2>E — Listing-first, page stays untouched <small>classification in the TOC, not per-page</small></h2>

<p style="font-size:0.88em; color:#666; margin:0 0 0.8em;">The individual function page looks exactly like today. But the <code>/arrays.html</code> landing page is reorganised into role-based sections:</p>

<dl class="v-listing">
    <dt>Predicates</dt>
    <dd>filter · filterKey · filterAnd · filterOr · filterMap · filterAll · filterAny</dd>
    <dt>Reducers</dt>
    <dd><em>filterFirst</em> · filterLast · filterCount · fold · foldR · foldKeys · sumWhere · head · last</dd>
    <dt>Transformers</dt>
    <dd>map · mapKey · mapWith · mapWithKey · flatMap · flattenByN · column · chunk · zip</dd>
    <dt>Sorts</dt>
    <dd>sort · rsort · ksort · krsort · asort · arsort · natsort · natcasesort · uksort · uasort · usort</dd>
    <dt>Structural</dt>
    <dd>append · prepend · tail · take · takeLast · takeUntil · takeWhile · pick · partition · groupBy</dd>
</dl>

<div class="meta"><strong>Pro:</strong> zero change to function pages; browsable TOC. <strong>Con:</strong> a function can only live in one section — multi-axis classification is lost.</div>
</section>

<section class="variant">
<h2>F — Iconography beside the title <small>legend sits in nav; hover for meaning</small></h2>

<p class="mock-title">Arrays\filterFirst()
    <span class="v-icons">
        <span title="Higher-order function">🪢</span>
        <span title="Short-circuits — safe with infinite Generators">⏱</span>
        <span title="Pure">🔒</span>
    </span>
</p>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> minimum vertical footprint of any option. <strong>Con:</strong> you have to teach the icon language; accessibility work; bikeshed magnet.</div>
</section>

<section class="variant">
<h2>G — "Use this when…" imperative bullets <small>tells the reader when to reach for it</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<div class="v-usewhen">
    <strong>Use <code>filterFirst</code> when you…</strong>
    <ul>
        <li>want the first match and nothing after it</li>
        <li>need to scan a potentially infinite Generator safely</li>
        <li>don't care about the key, only the value</li>
    </ul>
</div>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> teaches by usage intent, not classification. <strong>Con:</strong> harder to write consistently for 150+ functions; no tag archive.</div>
</section>

<section class="variant">
<h2>H — Compatibility strip only <small>the one axis that affects correctness</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<div class="v-compat">
    <span class="ok">✓ array</span>
    <span class="ok">✓ Iterator</span>
    <span class="ok">✓ Generator — safe with infinite</span>
</div>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<p style="font-size:0.85em; color:#999; margin-top:1em;"><em>For reference — a terminal function like <code>sort</code> would show:</em></p>
<div class="v-compat">
    <span class="ok">✓ array</span>
    <span class="ok">✓ Iterator</span>
    <span class="warn">⚠ Generator — materialises whole source</span>
</div>

<div class="meta"><strong>Pro:</strong> answers the one categorical question with correctness consequences. <strong>Con:</strong> abandons everything else (role, purity, return).</div>
</section>

<section class="variant">
<h2>I — Type-signature display <small>Haskell-flavoured teaching</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<div class="v-hs">(a → bool) → (Iterable&lt;a&gt; → ?a)</div>
<div class="v-hs-en">Takes a predicate; returns a function from an iterable to a maybe-value.</div>
<p class="mock-subtitle" style="margin-top:1em;">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<div class="meta"><strong>Pro:</strong> genuinely informative once learned; scales to any function for free. <strong>Con:</strong> loses readers who don't read FP-style type signatures.</div>
</section>

<section class="variant">
<h2>J — "See also" neighbour triad <small>no tags, just pointers to siblings</small></h2>

<p class="mock-title">Arrays\filterFirst()</p>
<p class="mock-subtitle">Creates a Closure that returns the first value of an array or iterable that matches the predicate…</p>
<code class="mock-signature">Arrays\filterFirst(callable $func): Closure</code>

<p style="font-size:0.88em; color:#999; margin-top:1em;"><em>At the bottom of the page:</em></p>
<div class="v-see">
    <strong>Compare</strong>
    <ul>
        <li><code>filter</code> — keeps every value matching the predicate</li>
        <li><code>filterLast</code> — returns the last matching value (terminal — reads the whole source)</li>
        <li><code>filterCount</code> — returns how many values match</li>
    </ul>
</div>

<div class="meta"><strong>Pro:</strong> no new metadata system; uses existing subgroup data; always shows the most useful alternative. <strong>Con:</strong> no global "every predicate in the library" view.</div>
</section>

---

**Pick one (or a combination — e.g. "A + J" would be quiet sidebar tags plus a compare block).** Nothing above is on real function pages — they're all isolated in this one file.
