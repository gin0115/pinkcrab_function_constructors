---
layout: base
title: Tags
description: Browse functions by tag — role, iteration behaviour, input type, purity.
---

<h1 class="page-title">Browse by tag</h1>

<div class="breadcrumbs">
    <a href="{{ site.url | absolute_url }}">Home</a>
    &raquo; Tags
</div>

<p>Every function is classified along a few axes — what kind of thing it <em>is</em>, how it consumes iterables, what it accepts as input, what it returns, and whether it's pure. Click any tag to see every function carrying it.</p>

<ul class="tag-index__list">
{% for tag in site.tags %}
    {% assign count = 0 %}
    {% for collection in site.collections %}
        {% if collection.label == "tags" or collection.label == "posts" %}{% continue %}{% endif %}
        {% assign matches = collection.docs | where_exp: "d", "d.tags contains tag.slug" %}
        {% assign count = count | plus: matches.size %}
    {% endfor %}
    <li>
        <a href="{{ site.url | absolute_url }}{{ tag.url }}"><strong>{{ tag.label | default: tag.slug }}</strong></a>
        <span class="tag-index__count">{{ count }}</span>
        — {{ tag.description }}
    </li>
{% endfor %}
</ul>
