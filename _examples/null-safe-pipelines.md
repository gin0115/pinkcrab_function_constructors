---
layout: example
title: Null-safe pipelines
summary: >
 Build pipelines that gracefully abort or default when they hit missing data, without littering every step with `if ($x !== null)` checks. Three approaches — composeSafe, composeTypeSafe, and ifThen / always guards — each suited to a different shape of problem.

functions:
  - name: composeSafe
    url: /general/composeSafe.html
  - name: composeTypeSafe
    url: /general/composeTypeSafe.html
  - name: pluckProperty
    url: /general/pluckProperty.html
  - name: ifThen
    url: /general/ifThen.html
  - name: ifElse
    url: /general/ifElse.html
  - name: always
    url: /general/always.html
---

## The scenario

You're walking data that might be partially missing. Nested property lookups, optional fields, fallback defaults. The imperative version is nested ternaries or a mound of `if` guards. You want a pipeline that just *deals* with null.

## Approach 1 — composeSafe (stops at the first null)

Best when "null anywhere" means "give up, answer is null".

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

$getAuthorName = F\composeSafe(
    F\getProperty('book'),          // might be null
    F\getProperty('author'),        // might be null
    F\getProperty('name')           // might be null
);

$order = ['book' => ['author' => ['name' => 'Ada']]];
echo $getAuthorName($order);   // 'Ada'

$orderNoBook = ['book' => null];
var_dump($getAuthorName($orderNoBook));   // NULL — chain halted on book
{% endhighlight %}

No inline null checks. One failing step short-circuits the whole chain.

## Approach 2 — composeTypeSafe (require a specific type at every step)

When you want stronger assurance than "not null" — e.g. "every intermediate must still be a string".

{% highlight php %}
$buildSlug = F\composeTypeSafe(
    'is_string',
    'trim',
    'strtolower',
    fn($s) => str_replace(' ', '-', $s)
);

echo $buildSlug('  Hello World  ');   // 'hello-world'
var_dump($buildSlug(42));              // NULL — 42 isn't a string, chain aborts
var_dump($buildSlug(null));            // NULL — same
{% endhighlight %}

## Approach 3 — ifThen / ifElse to provide defaults at specific steps

When you want the pipeline to continue, using a default when something's missing.

{% highlight php %}
$fallbackTo = fn($default) => F\ifElse(
    fn($v) => $v !== null,
    fn($v) => $v,                 // pass through if set
    F\always($default)            // default otherwise
);

$getUsername = F\compose(
    F\pluckProperty('profile', 'displayName'),
    $fallbackTo('anonymous')
);

echo $getUsername(['profile' => ['displayName' => 'Ada']]);   // 'Ada'
echo $getUsername(['profile' => []]);                          // 'anonymous'
echo $getUsername([]);                                          // 'anonymous'
{% endhighlight %}

## Picking the right one

| You want… | Use |
|---|---|
| "Null anywhere → whole result is null" | `composeSafe` |
| "Null anywhere → abort with null, AND the type must stay consistent" | `composeTypeSafe` |
| "Null here → substitute a default, keep going" | `ifThen` / `ifElse` + `always` |

## Mixing approaches

You can nest these freely. A typical shape: use `composeSafe` to walk a nested lookup, then `ifElse` at the end to turn the result (possibly null) into a sensible default:

{% highlight php %}
$getTitle = F\compose(
    F\composeSafe(
        F\getProperty('book'),
        F\getProperty('title')
    ),
    F\ifElse(
        fn($v) => $v !== null,
        'strtoupper',
        F\always('UNTITLED')
    )
);

echo $getTitle(['book' => ['title' => 'abc']]);   // 'ABC'
echo $getTitle(['book' => null]);                  // 'UNTITLED'
{% endhighlight %}

Each step still describes one thing. No `isset()` ladder.
