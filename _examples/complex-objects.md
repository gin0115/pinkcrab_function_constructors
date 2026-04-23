---
layout: example
title: Transforming complex objects
summary: >
 Take a list of raw API records, derive a fresh view model for each — with computed fields, nested lookups, and conditional logic — using recordEncoder, encodeProperty, pluckProperty and compose. No foreach loops, no temporary variables.

functions:
  - name: recordEncoder
    url: /general/recordEncoder.html
    note: the scaffold that builds each output record from scratch
  - name: encodeProperty
    url: /general/encodeProperty.html
    note: defines one output field by pairing a key with a value-producing callable
  - name: getProperty
    url: /general/getProperty.html
    note: reads a single field from an array or object
  - name: pluckProperty
    url: /general/pluckProperty.html
    note: reads a value along a nested path
  - name: propertyEquals
    url: /general/propertyEquals.html
    note: predicate that asks "does this field equal that value?"
  - name: compose
    url: /general/compose.html
    note: stitches several small transforms into one
  - name: ifElse
    url: /general/ifElse.html
    note: conditional branch lifted into a callable
  - name: always
    url: /general/always.html
    note: a callable that ignores its input and returns a fixed value
---

## The scenario

You're pulling user records out of an API. Each one looks like this — flat, a mix of strings, booleans, numbers, plus a nested `profile` object:

{% highlight php %}
$apiUsers = [
    [
        'id'      => 1,
        'first'   => 'ada',
        'last'    => 'lovelace',
        'role'    => 'admin',
        'signups' => 12,
        'profile' => (object) ['country' => 'GB', 'joined' => '2019-05-01'],
    ],
    [
        'id'      => 2,
        'first'   => 'bea',
        'last'    => 'smith',
        'role'    => 'user',
        'signups' => 0,
        'profile' => (object) ['country' => 'US', 'joined' => '2024-11-17'],
    ],
];
{% endhighlight %}

But the view layer wants something different — a tidy view model with a formatted display name, a derived boolean, a default when data is missing, and a field pulled from the nested object:

{% highlight php %}
// What we want for each user:
[
    'id'           => 1,
    'displayName'  => 'Ada Lovelace',
    'isAdmin'      => true,
    'active'       => true,
    'country'      => 'GB',
]
{% endhighlight %}

The imperative way to do this is a `foreach` with nested `if`s and string concatenation. The compositional way is to **describe the output shape declaratively** — each field as a small pure function over the input — and let `recordEncoder` wire the pieces together.

---

## Step 1 — one field at a time with `encodeProperty`

Each field in the output record is one `encodeProperty` call. It pairs the output key with a callable that takes the source record and returns the value for that key.

The simplest case: `id` is already in the source, just copied across. `getProperty('id')` is the callable that reads it.

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

$encodeId = F\encodeProperty('id', F\getProperty('id'));
{% endhighlight %}

On its own, `encodeProperty` does nothing useful — it just remembers "when you see a record, set the output's `id` to whatever `getProperty('id')` returns on it". The work happens later, when `recordEncoder` runs all the steps together.

---

## Step 2 — computed fields with `compose`

`displayName` needs transformation: concatenate `first` and `last`, separated by a space, with each word capitalised.

Build the callable by composing smaller pieces:

{% highlight php %}
use PinkCrab\FunctionConstructors\Strings as Str;

// Takes a user record, returns "Ada Lovelace"
$toDisplayName = function (array $user): string {
    $first = ucfirst($user['first']);
    $last  = ucfirst($user['last']);
    return "$first $last";
};

$encodeDisplayName = F\encodeProperty('displayName', $toDisplayName);
{% endhighlight %}

`$toDisplayName` is a small pure function — given a user record, returns a string. Any callable that takes the record and returns a value fits here.

---

## Step 3 — booleans from predicates

`isAdmin` is a plain boolean. `propertyEquals('role', 'admin')` returns a predicate — exactly the shape `encodeProperty` needs.

{% highlight php %}
$encodeIsAdmin = F\encodeProperty('isAdmin', F\propertyEquals('role', 'admin'));
{% endhighlight %}

No boolean casting, no `if` — the predicate's bool return value becomes the output field.

---

## Step 4 — conditional logic with `ifElse`

A user is "active" if they've signed up at least once — `signups > 0`. Express that without an inline `if`:

{% highlight php %}
$isActive = F\ifElse(
    fn($user) => $user['signups'] > 0,   // condition
    F\always(true),                      // when true
    F\always(false)                      // when false
);

$encodeActive = F\encodeProperty('active', $isActive);
{% endhighlight %}

`ifElse` takes three callables and returns a new one that branches. `always(true)` / `always(false)` are tiny "return this value no matter what" callables — useful as the branch bodies of `ifElse`.

---

## Step 5 — nested paths with `pluckProperty`

`country` lives inside the `profile` object. `pluckProperty` walks an arbitrary path through arrays and objects in one go:

{% highlight php %}
$encodeCountry = F\encodeProperty('country', F\pluckProperty('profile', 'country'));
{% endhighlight %}

`pluckProperty('profile', 'country')` reads `$user['profile']` then `->country` — seamlessly, whichever mix of arrays and objects the path involves. Missing path → `null`.

---

## Step 6 — assemble with `recordEncoder`

`recordEncoder([])` says "the output is an array, start empty". Feed it the five `encodeProperty` steps and it returns a factory Closure — give that factory a user record and you get the view model out.

{% highlight php %}
$toViewModel = F\recordEncoder([])(
    $encodeId,
    $encodeDisplayName,
    $encodeIsAdmin,
    $encodeActive,
    $encodeCountry
);
{% endhighlight %}

Apply it to one user:

{% highlight php %}
print_r($toViewModel($apiUsers[0]));
/*
[
    'id'           => 1,
    'displayName'  => 'Ada Lovelace',
    'isAdmin'      => true,
    'active'       => true,
    'country'      => 'GB',
]
*/
{% endhighlight %}

Or across the whole list — `array_map` alone does the job because `$toViewModel` is just another callable:

{% highlight php %}
$viewModels = array_map($toViewModel, $apiUsers);
/*
[
    ['id' => 1, 'displayName' => 'Ada Lovelace', 'isAdmin' => true,  'active' => true,  'country' => 'GB'],
    ['id' => 2, 'displayName' => 'Bea Smith',    'isAdmin' => false, 'active' => false, 'country' => 'US'],
]
*/
{% endhighlight %}

---

## Why this pattern pays off

- **Every field is a pure function.** You can test each encoder piece in isolation — no setup fixture larger than a single user record.
- **Order is the definition.** Reordering the `encodeProperty` calls reorders the output fields. Adding a new field is one line, inserted wherever you like.
- **No foreach, no temporary accumulators.** The shape of the output matches the shape of your description — you read the code and you see the record.
- **It composes further.** `$toViewModel` is a callable. Drop it into `pipe`, `compose`, `array_map`, or another encoder as a nested producer.

---

## Variations worth knowing

### Object output instead of array

Pass an object instance to `recordEncoder` instead of `[]` and the encoder writes to its properties (via `setProperty`):

{% highlight php %}
$toDto = F\recordEncoder(new UserViewModel())(
    $encodeId,
    $encodeDisplayName,
    /* ... */
);
{% endhighlight %}

### Encoding a field conditionally

Make the encoded value itself use `ifElse` — no need to branch at the encoder level:

{% highlight php %}
F\encodeProperty(
    'greeting',
    F\ifElse(
        F\propertyEquals('role', 'admin'),
        F\always('Welcome, admin'),
        fn($u) => "Hi {$u['first']}"
    )
)
{% endhighlight %}

### Reusing encoders across shapes

`$toViewModel` doesn't care what kind of record it gets, as long as the accessor callables match. A list of objects with the same fields works identically — `getProperty` / `pluckProperty` handle both arrays and objects.
