---
layout: base
title: Home
subtitle: >
 This is where I will tell my friends way too much about me
---

<div class="function__releated-group">
    <h3><a href="{{ site.url | absolute_url }}/strings.html">
        <em>String</em> Functions
    </a></h3>
    <ul>
        {% for related in site.strings %}
            <li><a href="{{ site.url | absolute_url }}{{related.url}}">{{ related.title }}</a></li>
        {% endfor %}
    </ul>
</div>