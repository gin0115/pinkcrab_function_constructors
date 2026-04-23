---
layout: base
title: Strings
description: >
 Archive of all functions in the Strings namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

> Curried wrappers around PHP's native string functions — every one of them is a value-first callable that binds the "how" up front so the subject string can be fed in later. Drop them into `array_map`, compose them into pipelines, or use them as predicates for filters.

#### Manipulation

{% highlight php %}
$shoutWrap = F\compose(
    Str\trim(),
    'strtoupper',
    Str\wrap('[ ', ' ]')
);

$shoutWrap('  hello  ');   // '[ HELLO ]'
{% endhighlight %}

Also: `append`, `prepend`, `replaceWith`, `replaceSubString`, `findToReplace`, `translateWith`, `pad`, `repeat`, `slice`, `stripTags`.

#### Predicates

{% highlight php %}
$containsFoo = Str\contains('foo');
$containsFoo('its foo');   // true
$containsFoo('its bar');   // false

Str\isBlank('');    // true
Str\isBlank('   '); // false  — whitespace is not blank
Str\isBlank(null);  // false  — only a zero-length string counts
{% endhighlight %}

Also: `startsWith`, `endsWith`, `containsPattern`.

#### Splits and positions

{% highlight php %}
$splitCsv = Str\split(',');
$splitCsv('a,b,c');        // ['a', 'b', 'c']

$firstPos = Str\firstPosition('e');
$firstPos('hello');        // 1
$firstPos('world');        // NULL  — not found
{% endhighlight %}

Also: `splitByLength`, `splitPattern`, `lastPosition`, `firstSubString`, `firstChar`, `lastChar`, `countChars`, `countSubString`.

#### Composition helpers

`composeSafeStringFunc` — compose several string-returning callables with an `is_string` guard between every step. `stringCompiler` — an accumulator for building strings across successive calls.

#### Formatting &amp; trimming

`trim`, `lTrim`, `rTrim`, `wordWrap`, `wordCount`, `digit` (number formatting → string), `vSprintf`, `chunk`, `addSlashes`, `similar`.

### Deep-dive examples

- [Sanitising form input]({{ site.url }}/examples/sanitise-form-input.html) — compose trim / strip tags / lowercase into a reusable field-level pipeline.
- [Currency and pricing pipelines]({{ site.url }}/examples/currency-pricing.html) — `digit` for number formatting inside a larger chain.
- [All worked examples]({{ site.url }}/examples.html) →

## String Functions

<div class="container">
    <div class="grid all-functions">
    {% for function in site.strings %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url }}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
