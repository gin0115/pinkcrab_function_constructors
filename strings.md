---
layout: base
title: Strings
subtitle: Archive of all functions in the Strings namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url  }}">Home</a> 
  >> <a href="{{ page.url | absolute_url }}">{{page.title}}</a>
</div>

> A collection of functions which can be used to work with strings.


## String Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.strings %}
        {% if true != function.deprecated %} 
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %} 
    </div>
</div>


