---
layout: base
title: String Functions
subtitle: Archive of all functions in the Strings namespace.
---

# Strings

> A collection of functions which can be used to work with strings. They have broken down into the following sub sections.


## String Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.strings %}
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
    {% endfor %} 
    </div>
</div>


