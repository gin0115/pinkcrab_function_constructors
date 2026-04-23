---
layout: base
title: Objects
description: >
 Archive of all functions in the Objects namespace — predicates and helpers for working with class instances, interfaces, traits, and object construction.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url }}/">Home</a>
  >> <a href="{{ site.url }}{{ page.url }}">{{page.title}}</a>
</div>

> Small namespace. Four reflection-style predicates and one object factory. All are curried and compose with the Arrays filter/map family for type-driven collection processing.

#### Type predicates

{% highlight php %}
use PinkCrab\FunctionConstructors\Objects as Obj;

$isString = Obj\isInstanceOf(\Stringable::class);
$implementsCountable = Obj\implementsInterface(\Countable::class);
$usesIterator = Obj\usesTrait(\IteratorAggregate::class);

array_filter($mixed, $implementsCountable); // only the Countable ones
{% endhighlight %}

#### Converting objects to arrays

`toArray()` takes no arguments and returns a Closure that shallow-copies an object's public properties into an associative array. Non-public properties are skipped.

{% highlight php %}
$toArr = Obj\toArray();

$user = new class { public $name = 'Ada'; public $role = 'admin'; };
print_r($toArr($user)); // ['name' => 'Ada', 'role' => 'admin']
{% endhighlight %}

#### Object factories

`createWith()` binds a class name and a base property set, returning a Closure that takes per-instance overrides and produces a fully-populated object. Good for fixture builders and prototype patterns.

{% highlight php %}
$makeUser = Obj\createWith(User::class, ['role' => 'user', 'active' => true]);

$admin  = $makeUser(['name' => 'Ada', 'role' => 'admin']);
$member = $makeUser(['name' => 'Bea']);  // inherits role=user, active=true
{% endhighlight %}

## Object Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.objects %}
        {% if true != function.deprecated %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
