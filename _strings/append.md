---
layout: function
title: Strings\append()
subtitle: Allows you to create a function which can be used to append a sub string to a passed string. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.
group: strings
subgroup: string_manipulation
definition: >
 /**
   * @param string $append
   * @return Closure(string):string
   */
  Strings\append(string $append): Closure
closure: >
 /**
   * @param string $toAppendOnto  The string to have the sub string added to
   * @return string                The sliced string
   * @psalm-pure
   */ 
 $function(string $toAppendOnto): string

---

### Examples

<div class="panel">
    <h4 class="panel__title">        Partial Application</h4>
    <div class="panel__content">
        <p>
            This can be used to create a simple closure which can be used as a regular function.
        </p>
{% highlight php %}

$appendFoo = Strings\append('foo');

// Called as a function.
echo $appendFoo('Hello'); // Hellofoo

// Used in a higher order function.
$array = array_map( $appendFoo, ['Hello', 'World']);
print_r($array); // [Hellofoo, Worldfoo]

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
echo Strings\append('foo')('Bar'); // Barfoo
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
$array = array_map(
    Strings\append('--'), 
    ['foo', 'bar']
);
print_r($array); // ['foo--', 'bar--']
{% endhighlight %}
    </div>
</div>
