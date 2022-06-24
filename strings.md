# Strings

> A collection of functions which can be used to work with strings. They have broken down into the following sub sections.

<div class="vmenu-wrapper">
    <div class="vmenu-item">String Manipulation</div>
    <div class="vmenu-item">Foo</div>
    <div class="vmenu-item">Foo</div>
</div>

## String Functions.


[Link button](http://example.com/){: .btn .btn-green }  


**Watch out!** This paragraph of text has been [emphasized](#) with the `{: .notice--danger}` class.
{: .notice--danger}  

<div class="row">
  <div class="col-1-of-4">
      Col 1 of 2
  </div>
  <div class="col-1-of-2">
      Col 1 of 2
  </div>
  <div class="col-1-of-2">
      Col 1 of 2
  </div>
  <div class="col-1-of-2">
      Col 1 of 2
  </div>
  <div class="col-1-of-2">
      Col 1 of 2
  </div>
</div>


[Text](#link){: .btn .btn--light-outline}  
<div class="container">
    <div class="d">
    {% for function in site.strings %}

        <div class="col-xs-12 col-md-6 {{ function.subgroup }}">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ function.title }}</h2>
                    <p class="card-text">{{  function.subtitle }}</p>
                    <a href="{{ function.url | absolute_url }}" class="btn btn-primary">Go somewhere {{ function.url | absolute_url }}</a>
                </div>
            </div>
        </div>
   
    {% endfor %} 

    </div>
</div>


<div class="grid">
    <div class="col-12 col-md-4">I'm a column 2/3 wide</div>
    <div class="col-12 col-md-4">I'm a column 1/3 wide</div>
    <div class="col-12 col-md-4">I'm a column 1/3 wide</div>
</div>

