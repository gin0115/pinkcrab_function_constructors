---
layout: example
title: Normalising messy API payloads
summary: >
 Take a raw third-party response and reshape it into a consistent internal format — trim strings, cast types, rename keys, drop nulls — as one reusable compose() pipeline. The same pipeline works for one record or a list via array_map.

functions:
  - name: compose
    url: /general/compose.html
    note: stitches the transform steps into one callable
  - name: pipe
    url: /general/pipe.html
    note: applies the chain immediately to a single value
  - name: getProperty
    url: /general/getProperty.html
  - name: ifThen
    url: /general/ifThen.html
    note: applies a step only when a predicate matches
  - name: Arrays\map
    url: /arrays/map.html
  - name: Arrays\filter
    url: /arrays/filter.html
  - name: Strings\trim
    url: /strings/trim.html
---

## The problem

External APIs rarely hand back data in the shape your app wants. Fields are differently cased, numbers arrive as strings, optional values show up as empty strings instead of `null`, and deeply nested bits need flattening. You typically end up with a page of `foreach ($data as &$row) { ... }` scaffolding.

## Source data

{% highlight php %}
$raw = [
    [
        'ID'         => '1',
        'FullName'   => '  Ada Lovelace  ',
        'EmailAddr'  => 'ADA@EXAMPLE.COM ',
        'Age'        => '42',
        'Notes'      => '',           // empty string — treat as null
    ],
    [
        'ID'         => '2',
        'FullName'   => 'Bea Smith',
        'EmailAddr'  => 'bea@example.com',
        'Age'        => 'unknown',     // invalid age — drop the row
        'Notes'      => 'VIP',
    ],
];
{% endhighlight %}

Target shape:

{% highlight php %}
[
    'id'    => 1,          // cast to int
    'name'  => 'Ada Lovelace',
    'email' => 'ada@example.com',
    'age'   => 42,
    'notes' => null,
]
{% endhighlight %}

## Build the per-row pipeline from small steps

Each step is a pure function. Each one is named for what it does. No intermediate variables.

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Strings as Str;

// Rename + shape: source field → output field, with a value transform.
$shape = fn($row) => [
    'id'    => (int) $row['ID'],
    'name'  => trim($row['FullName']),
    'email' => strtolower(trim($row['EmailAddr'])),
    'age'   => is_numeric($row['Age']) ? (int) $row['Age'] : null,
    'notes' => $row['Notes'] === '' ? null : $row['Notes'],
];

// The row is useful only if the age cast succeeded.
$hasValidAge = fn($row) => $row['age'] !== null;

// One pipeline that shapes every row, drops invalid ones.
$normalise = F\compose(
    Arrays\map($shape),
    Arrays\filter($hasValidAge)
);

$clean = $normalise($raw);
{% endhighlight %}

Result:

{% highlight php %}
[
    ['id' => 1, 'name' => 'Ada Lovelace', 'email' => 'ada@example.com', 'age' => 42, 'notes' => null],
]
{% endhighlight %}

Bea is dropped because her age failed the numeric check.

## Why this reads well

- `$shape`, `$hasValidAge`, `$normalise` — three named things. Each readable in isolation.
- No `foreach`, no `&$row`, no mutation.
- `$normalise` is a reusable callable — drop it straight into `array_map`, send it through a queue worker, or call on a single record by passing `[$oneRow]`.

## Using it on a single record

`pipe` is the immediate-value counterpart to `compose`:

{% highlight php %}
$one = F\pipe(
    $raw[0],
    $shape,
    $hasValidAge,           // returns bool, but pipe just passes the value through if truthy
);
{% endhighlight %}

Actually that's not quite right — `pipe` doesn't short-circuit on bool. For a single-record version use `ifThen` to gate:

{% highlight php %}
$normaliseOne = F\compose(
    $shape,
    F\ifThen($hasValidAge, fn($row) => $row)   // identity when valid, original row when invalid
);

$normaliseOne($raw[0]);  // shaped row
{% endhighlight %}

## Adding a new field later

Six months from now, the API gains a `Department` field. Only `$shape` changes — the filter, compose, callers all stay the same:

{% highlight php %}
$shape = fn($row) => [
    /* existing fields ... */
    'department' => trim($row['Department'] ?? 'Unknown'),
];
{% endhighlight %}
