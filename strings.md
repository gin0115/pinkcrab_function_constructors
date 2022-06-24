# Strings

> A collection of functions which can be used to work with strings. They have broken down into the following sub sections.

<div class="vmenu-wrapper">
    <div class="vmenu-item">String Manipulation</div>
    <div class="vmenu-item">Foo</div>
    <div class="vmenu-item">Foo</div>
</div>

## String Functions.


<div class="container">
    <div class="d">
    {% for function in site.strings %}

        <div class="col-xs-12 col-md-6 {{ function.subgroup }}">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ function.title }}</h2>
                    <p class="card-text">{{  function.subtitle }}</p>
                    <a href="{{ site.url }}{{ function.url}}" class="btn btn-primary">Read Function Docs</a>
                </div>
            </div>
        </div>
   
    {% endfor %} 

    </div>
</div>

{{ site.url }}
<div class="grid">
    <div class="col-12 col-md-4">I'm a column 2/3 wide</div>
    <div class="col-12 col-md-4">I'm a column 1/3 wide</div>
    <div class="col-12 col-md-4">I'm a column 1/3 wide</div>
</div>

