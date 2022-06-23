# Strings

> A collection of functions which can be used to work with strings. They have broken down into the following sub sections.

<div class="vmenu-wrapper">
    <div class="vmenu-item">String Manipulation</div>
    <div class="vmenu-item">Foo</div>
    <div class="vmenu-item">Foo</div>
</div>

## String Functions.


[Link button](http://example.com/){: .btn .btn-green }
 

<div class="container">
    <div class="row">
    {% for function in site.strings %}

        <div class="col-xs-12 col-md-6 {{ function.subgroup }}">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ function.title }}</h2>
                    <p class="card-text">{{  function.subtitle }}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
   
    {% endfor %} 

    </div>
</div>

