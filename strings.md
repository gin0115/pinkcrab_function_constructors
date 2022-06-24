# Strings

> A collection of functions which can be used to work with strings. They have broken down into the following sub sections.

<div class="vmenu-wrapper">
    <div class="vmenu-item">String Manipulation</div>
    <div class="vmenu-item">Foo</div>
    <div class="vmenu-item">Foo</div>
</div>

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


