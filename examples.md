---
layout: base
title: Examples
description: >
 Worked examples that show how the library's functions compose together for real-world tasks.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
    <a href="{{ site.url }}/">Home</a>
    >> <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
</div>

<p>Worked examples that go beyond single-function docs — each one starts with a real scenario, builds the solution step by step, and explains which pieces of the library do what and why.</p>

<ul class="tag-archive__list">
{% for ex in site.examples %}
    <li>
        <a href="{{ site.url }}{{ ex.url }}"><strong>{{ ex.title }}</strong></a>
        {% if ex.summary %} — {{ ex.summary }}{% endif %}
    </li>
{% endfor %}
</ul>
