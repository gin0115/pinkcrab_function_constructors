---
layout: example
title: Validation chains with error accumulation
summary: >
 Compose small single-purpose validators into a single check that either passes or returns a list of every problem. Compare with imperative validation code that short-circuits on the first failure.

functions:
  - name: Arrays\filter
    url: /arrays/filter.html
  - name: Arrays\map
    url: /arrays/map.html
  - name: compose
    url: /general/compose.html
  - name: Comparisons\notEmpty
    url: /comparisons/notEmpty.html
  - name: Comparisons\isScalar
    url: /comparisons/isScalar.html
  - name: Strings\contains
    url: /strings/contains.html
---

## The usual imperative shape

{% highlight php %}
function validate(array $data): array {
    $errors = [];
    if (empty($data['name']))                     { $errors[] = 'name is required'; }
    if (empty($data['email']) || !str_contains($data['email'], '@')) { $errors[] = 'email invalid'; }
    if (!is_int($data['age']) || $data['age'] < 0){ $errors[] = 'age invalid'; }
    return $errors;
}
{% endhighlight %}

Works. But each rule mixes "predicate" and "error message" together and you can't reuse them.

## Factor rules into data

Each rule is a pair: a predicate that says whether the field is VALID, and the message when it's not:

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\Strings as Str;

$rules = [
    ['name is required',  fn($d) => C\notEmpty($d['name'] ?? '')],
    ['email invalid',     fn($d) => Str\contains('@')($d['email'] ?? '')],
    ['age invalid',       fn($d) => is_int($d['age'] ?? null) && $d['age'] >= 0],
];
{% endhighlight %}

## Validator as a pure function over rules

{% highlight php %}
$validate = fn(array $data): array => array_values(array_map(
    fn($rule) => $rule[0],                          // the message
    array_filter($rules, fn($rule) => ! $rule[1]($data))   // rules that failed
));
{% endhighlight %}

## Use it

{% highlight php %}
print_r($validate([
    'name'  => '',
    'email' => 'nope',
    'age'   => 30,
]));

// ['name is required', 'email invalid']
{% endhighlight %}

Every failing rule is collected. A well-formed input returns `[]` — truthy-empty, so `$errors ? fail() : proceed()` reads naturally.

## Why this scales

- **New rules are one row.** Add `['password too short', fn($d) => strlen($d['password']) >= 12]`.
- **Rules are reusable.** Move them to a constant, pass a different subset per endpoint, or compose rule groups with `Comparisons\groupAnd` / `groupOr`.
- **Testable in isolation.** Each rule's predicate is a tiny pure function — test it without instantiating a validator object.

## Reusing predicates across rules

If several rules share a shape ("field X is a non-empty string"), compose that predicate once:

{% highlight php %}
$isPresentString = F\compose(
    fn($d) => $d['name'] ?? null,   // or parameterise
    fn($v) => is_string($v) && $v !== ''
);
{% endhighlight %}

Or build a rule factory:

{% highlight php %}
$mustBeString = fn(string $field) => fn(array $d) =>
    isset($d[$field]) && is_string($d[$field]) && $d[$field] !== '';

$rules = [
    ['name is required',  $mustBeString('name')],
    ['title is required', $mustBeString('title')],
    // ...
];
{% endhighlight %}
