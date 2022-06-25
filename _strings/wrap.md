---
layout: function
title: Strings\wrap()
subtitle: Allows you to create a function which wraps any passed string with opening and closing strings. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.
group: strings
subgroup: string_manipulation
definition: >

 /**
   * @param string       $opening Added to the start of the string (and end, if no $closing supplied)
   * @param string|null  $closing Added to the end of the string (optional)
   * @return Closure(string):string
   */
  Strings\wrap(string $opening, ?string $closing = null ): Closure
closure: >
 /**
   * @param string $toWrap  The string to be wrapped
   * @return string         The wrapped string
   * @psalm-pure
   */ 
 $function(string $toWrap): string

---

### Examples

<div class="panel">
    <h4 class="panel__title">        Partial Application</h4>
    <div class="panel__content">
        <p>
            This can be used to create a simple closure which can be used as a regular function.
        </p>
{% highlight php %}
// Create the closure to wrap any string with a <span> tag
$makeSpan = Strings\wrap('<span>', '</span>');

// Called as a function.
echo $makeSpan('Hello'); // <span>Hello</span>

// Used in a higher order function.
$array = array_map( $makeSpan, ['Hello', 'World']);
print_r($array); // [<span>Hello</span>, <span>World</span>]
{% endhighlight %}
    </div>
</div>

<div class="panel">
    <h4 class="panel__title">        Curried</h4>
    <div class="panel__content">
        <p>
            You can use currying to directly define can call the function as it is, without defining the Closure first.
        </p>
{% highlight php %}
echo Strings\wrap('##')('Hello'); // ##Hello##
{% endhighlight %}
    </div>
</div>
    
<div class="panel">
    <h4 class="panel__title">        Inlined with Higher Order Function</h4>
    <div class="panel__content">
        <p>
            If you are not planning on reusing the Closure created, you can just call it inline with a higher order function as its callable.
        </p>
{% highlight php %}
$array = array_map
    Strings\wrap('<p>', '</p>'), 
    ['Hello', 'World']
);
print_r($array); // [<p>Hello</p>, <p>World</p>]
{% endhighlight %}
    </div>
</div>
