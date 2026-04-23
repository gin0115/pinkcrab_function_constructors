---
layout: example
title: Using library functions instead of fn() lambdas
summary: >
 A practical reference for swapping inline arrow-function predicates for composable library calls. Shorter, more reusable, and — most importantly — named for what they do instead of how they do it.

functions:
  - name: propertyEquals
    url: /general/propertyEquals.html
  - name: getProperty
    url: /general/getProperty.html
  - name: compose
    url: /general/compose.html
  - name: Comparisons\not
    url: /comparisons/not.html
  - name: Comparisons\isEqualTo
    url: /comparisons/isEqualTo.html
  - name: Comparisons\isGreaterThan
    url: /comparisons/isGreaterThan.html
  - name: Comparisons\groupAnd
    url: /comparisons/groupAnd.html
  - name: Numbers\isMultipleOf
    url: /numbers/isMultipleOf.html
  - name: Strings\contains
    url: /strings/contains.html
  - name: Strings\replaceWith
    url: /strings/replaceWith.html
---

## Why bother?

An `fn()` lambda is small and fast to write. But six months later, scanning a filter chain, you're reading predicates instead of names. The whole point of this library is to give you **named, reusable predicates and transforms** so the code reads like a specification.

The patterns below are the most common offenders. Each swap is a one-liner and the right-hand side is usually shorter than the lambda anyway.

## 1. Property equals a value

{% highlight php %}
// inline:
fn($user) => $user['role'] === 'admin'

// library:
F\propertyEquals('role', 'admin')
{% endhighlight %}

`propertyEquals` works on arrays and objects alike. Bind the key and the expected value up front; reuse across any collection.

## 2. Not null

{% highlight php %}
// inline:
fn($v) => $v !== null

// library:
C\not('is_null')
{% endhighlight %}

`is_null` is a built-in PHP function; as a string it's a valid callable, so `C\not('is_null')` composes cleanly into filters. No wrapper needed.

## 3. Negate any predicate

{% highlight php %}
// inline:
fn($x) => ! $isAdmin($x)

// library:
C\not($isAdmin)
{% endhighlight %}

Works for predicates defined anywhere — your own Closures, imported library predicates, even PHP's built-ins like `'is_numeric'`.

## 4. Numeric comparisons

{% highlight php %}
// inline:
fn($n) => $n > 100

// library:
C\isGreaterThan(100)
{% endhighlight %}

Same shape for `isLessThan`, `isGreaterThanOrEqualTo`, `isLessThanOrEqualTo`, `isEqualTo`.

## 5. "Field of a record passes a comparison" — compose two library pieces

{% highlight php %}
// inline:
fn($order) => $order['total'] >= 100

// library:
F\compose(F\getProperty('total'), C\isGreaterThanOrEqualTo(100))
{% endhighlight %}

Longer on one line but each piece is a named concept you can reuse. Common enough that you'll name the result:

{% highlight php %}
$isHighValue = F\compose(F\getProperty('total'), C\isGreaterThanOrEqualTo(100));

// Now everywhere that used the inline version becomes:
array_filter($orders, $isHighValue);
{% endhighlight %}

## 6. Multiple-of / divisibility

{% highlight php %}
// inline:
fn($n) => $n % 2 === 0

// library:
N\isMultipleOf(2)
{% endhighlight %}

Same pattern for `isFactorOf`. Instantly readable inside a filter chain.

## 7. Substring check

{% highlight php %}
// inline:
fn($s) => str_contains($s, 'foo')

// library:
Str\contains('foo')
{% endhighlight %}

`startsWith`, `endsWith`, `containsPattern` all follow the same shape — one library call instead of a lambda.

## 8. String transforms

{% highlight php %}
// inline:
fn($s) => str_replace(' ', '-', $s)

// library:
Str\replaceWith(' ', '-')
{% endhighlight %}

Many PHP string functions need arguments in a specific order before the subject — `replaceWith`, `append`, `prepend`, `trim`, `lTrim`, `rTrim`, `slice`, `pad`, etc. all return a Closure that takes just the subject, perfect for drop-in into map/pipe.

## 9. Combining predicates with AND / OR

{% highlight php %}
// inline:
fn($user) => $user['active'] && $user['verified']

// library:
C\groupAnd(
    F\propertyEquals('active', true),
    F\propertyEquals('verified', true)
)
{% endhighlight %}

Shorter for one-off, but the library version composes with **other** library predicates and lets you name the overall concept (`$isTrustedUser`). Same story for `groupOr`.

## 10. Everything together — a filter chain

Before:

{% highlight php %}
$highValueAdmins = array_filter($orders, fn($o) =>
    $o['customer']['role'] === 'admin'
    && $o['total'] >= 100
    && $o['refunded'] !== true
);
{% endhighlight %}

After — three named concepts, one composed predicate:

{% highlight php %}
$isAdminOrder  = F\compose(F\getProperty('customer'), F\propertyEquals('role', 'admin'));
$isHighValue   = F\compose(F\getProperty('total'),    C\isGreaterThanOrEqualTo(100));
$isRefunded    = F\propertyEquals('refunded', true);

$isTargetOrder = C\groupAnd($isAdminOrder, $isHighValue, C\not($isRefunded));

$highValueAdmins = array_filter($orders, $isTargetOrder);
{% endhighlight %}

Five lines instead of four, but:

- Each concept is **named** and independently testable.
- `$isAdminOrder`, `$isHighValue`, `$isRefunded` are reusable across the codebase.
- Changing the definition of "admin order" is one-line edit at the top; every caller picks it up.
- The final predicate reads as English: "an admin order, high value, not refunded".

## When to still use a lambda

Don't force composition. If a predicate genuinely is one line of custom logic that won't be reused, reaches into context (uses `use (...)` to capture outside variables), or involves arithmetic no library piece abstracts — an `fn()` is fine. The point is to reach for the library FIRST.
