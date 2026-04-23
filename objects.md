---
layout: base
title: Objects
description: >
 Archive of all functions in the Objects namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url }}">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

> Small namespace. Four reflection-style predicates and one object factory. All curried and compose cleanly with the Arrays filter/map family for type-driven collection processing.

#### Type predicates

{% highlight php %}
$isCountable = Obj\implementsInterface(\Countable::class);

$isCountable(new \ArrayObject());     // true
$isCountable(new \stdClass());        // false

array_filter($mixed, $isCountable);   // only the Countable ones
{% endhighlight %}

Also: `isInstanceOf`, `usesTrait`.

#### toArray

{% highlight php %}
$user = new class {
    public $name = 'Ada';
    public $role = 'admin';
    private $secret = 'hidden';
};

$toArr = Obj\toArray();

$toArr($user);   // ['name' => 'Ada', 'role' => 'admin']
                 // — $secret is private, so it's skipped
{% endhighlight %}

`toArray()` takes no arguments and returns a Closure — drop it straight into `array_map` to convert a list of objects to arrays.

#### createWith

{% highlight php %}
class User {
    public string $name   = '';
    public string $role   = 'user';
    public bool   $active = true;
}

$makeUser = Obj\createWith(User::class, ['role' => 'user', 'active' => true]);

$admin  = $makeUser(['name' => 'Ada', 'role' => 'admin']);  // role overridden
$member = $makeUser(['name' => 'Bea']);                      // inherits base

$admin->role;    // 'admin'
$member->role;   // 'user'
{% endhighlight %}

## Object Functions

<div class="container">
    <div class="grid all-functions">
    {% for function in site.objects %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url }}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
