---
layout: example
title: Sanitising form input
summary: >
 Build a once-and-reuse sanitisation pipeline for form fields — trim, strip tags, lowercase emails, default missing values — then apply the same pipeline across every form in the app by composition.

functions:
  - name: compose
    url: /general/compose.html
  - name: Strings\trim
    url: /strings/trim.html
  - name: Strings\stripTags
    url: /strings/stripTags.html
  - name: Arrays\map
    url: /arrays/map.html
  - name: ifThen
    url: /general/ifThen.html
  - name: always
    url: /general/always.html
  - name: Comparisons\notEmpty
    url: /comparisons/notEmpty.html
---

## The scenario

Every form in the app needs the same handful of defences: trim whitespace, strip unsafe tags, normalise email case, default missing fields. The per-route code usually ends up copy-pasted and drifts out of sync.

Build one field-level sanitiser and one form-level sanitiser. Reuse both everywhere.

## Field-level — a small composed callable per kind of field

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Arrays;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\Comparisons as C;

// Plain text: trim + strip tags.
$sanitiseText = F\compose(
    Str\trim(" \t\n\r\0\x0B"),   // includes spaces
    Str\stripTags()
);

// Email: trim + strip tags + lowercase.
$sanitiseEmail = F\compose(
    $sanitiseText,
    'strtolower'
);

// Any required field that came back empty gets a default.
$defaultTo = fn($value) => F\ifThen(
    F\compose(C\not(C\notEmpty)),   // predicate: empty?
    F\always($value)
);
{% endhighlight %}

Each is a first-class callable you can pass around, test, or drop into a pipeline.

## Form-level — map fields-to-sanitisers over the input

{% highlight php %}
// Configuration: one row per field.
$rules = [
    'name'    => $sanitiseText,
    'email'   => $sanitiseEmail,
    'message' => F\compose($sanitiseText, $defaultTo('(no message supplied)')),
];

// Apply every rule to the corresponding input field.
$sanitiseForm = function (array $input) use ($rules): array {
    $out = [];
    foreach ($rules as $field => $sanitiser) {
        $out[$field] = $sanitiser($input[$field] ?? '');
    }
    return $out;
};
{% endhighlight %}

## Use it anywhere

{% highlight php %}
$submitted = [
    'name'    => '  <b>Ada</b> ',
    'email'   => ' ADA@Example.com ',
    'message' => '',
];

$clean = $sanitiseForm($submitted);
/*
[
    'name'    => 'Ada',
    'email'   => 'ada@example.com',
    'message' => '(no message supplied)',
]
*/
{% endhighlight %}

## Adding a rule for a new form

Add one more row to `$rules`. Same sanitiser pipeline if the field is just text — or compose a specific one if it's different:

{% highlight php %}
$rules['username'] = F\compose(
    $sanitiseText,
    'strtolower',
    Str\trim('@')                    // allow users to paste '@ada' — strip the sigil
);
{% endhighlight %}

## Why this is better than `htmlspecialchars` on every write

It isn't a single "one and done" call — it's a **named pipeline per field kind**. You can test `$sanitiseEmail` in isolation, extend it (add punycode normalisation, say) in one place, and reuse it across forms without copying.
