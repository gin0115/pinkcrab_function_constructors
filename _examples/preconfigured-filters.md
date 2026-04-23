---
layout: example
title: Preconfigured filters — "ready-made" predicates
summary: >
 Use partial application to turn generic filter conditions into named, intention-revealing callables — "active users", "recent orders", "high-value transactions" — then reuse them across the app instead of repeating the predicate every time.

functions:
  - name: Comparisons\propertyEquals
    url: /general/propertyEquals.html
  - name: Comparisons\isGreaterThanOrEqualTo
    url: /comparisons/isGreaterThanOrEqualTo.html
  - name: Comparisons\groupAnd
    url: /comparisons/groupAnd.html
  - name: Comparisons\not
    url: /comparisons/not.html
  - name: Arrays\filter
    url: /arrays/filter.html
  - name: getProperty
    url: /general/getProperty.html
---

## The pattern

Every team accumulates domain concepts — *"active users"*, *"high-value orders"*, *"this month's signups"*. In imperative code, those concepts show up as inline predicates sprinkled across controllers, services, and tests — and they drift over time ("oh, that endpoint uses `status !== 'inactive'`, this one uses `active === true`").

With partial application, the concept becomes a **named first-class callable**. One definition, reused everywhere.

## Define the concepts once

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Comparisons as C;

// "Active" means active=true AND email_verified_at is not null.
$isActive = C\groupAnd(
    F\propertyEquals('active', true),
    fn($user) => $user['email_verified_at'] !== null
);

// "High value" means lifetime_spend >= 10,000.
$isHighValue = fn($user) => ($user['lifetime_spend'] ?? 0) >= 10_000;

// "Recent" means created_at within the last 30 days.
$isRecent = fn($thing) =>
    strtotime($thing['created_at']) >= strtotime('-30 days');

// And composite ones.
$isActiveHighValue = C\groupAnd($isActive, $isHighValue);
{% endhighlight %}

Each is a one-line callable. Each is testable on its own:

{% highlight php %}
var_dump($isActive(['active' => true, 'email_verified_at' => '2024-01-01']));  // true
var_dump($isActive(['active' => true, 'email_verified_at' => null]));          // false
{% endhighlight %}

## Use them without mentioning their internals

{% highlight php %}
$activeUsers      = array_filter($users, $isActive);
$topCustomers     = array_filter($users, $isActiveHighValue);
$recentOrders     = array_filter($orders, $isRecent);
$inactiveOverdue  = array_filter($users, C\not($isActive));
{% endhighlight %}

Any reader scanning that code knows exactly what's being filtered without jumping to the definition. If the definition changes — say "active" now also requires `deleted_at === null` — every consumer picks it up.

## Building rules from a registry

For a CRM-style app where end users can combine filters, store the predicates by name and assemble them at runtime:

{% highlight php %}
$filters = [
    'active'      => $isActive,
    'high_value'  => $isHighValue,
    'recent'      => $isRecent,
];

// Build an AND of whichever filters the user selected.
$selected = ['active', 'high_value'];
$predicate = C\groupAnd(...array_map(
    fn($name) => $filters[$name],
    $selected
));

$results = array_filter($users, $predicate);
{% endhighlight %}

## Why this pays off

- The filter's name IS the business concept. Reviewer reads "isActiveHighValue" and understands the intent without reading its body.
- The predicate is storage-agnostic — reuse it in DB pre-filtering logic, after-the-fact verification, test fixtures.
- Extending the concept ripples automatically — change the definition of "active" in one place.
- Compose freely: `C\not($isActive)`, `C\groupOr($isRecent, $isHighValue)`, etc.
