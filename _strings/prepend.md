---
layout: function
title: Strings\prepend()
subtitle: Allows you to create a function which can be used to prepend a sub string to a passed string. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.
group: strings
subgroup: string_manipulation
definition: >
 /**
   * @param string $prepend
   * @return Closure(string):string
   */
  Strings\prepend(string $prepend): Closure
closure: >
 /**
   * @param string $toPrependOnto  The string to have the sub string added to
   * @return string                The sliced string
   * @psalm-pure
   */ 
 $function(string $toPrependOnto): string

---

### Examples

<div class="panel">
    <h4 class="panel__title">        Partial Application</h4>
    <div class="panel__content">
        <p>
            This can be used to create a simple closure which can be used as a regular function.
        </p>
{% highlight php %}

$prependFoo = Strings\prepend('foo');

// Called as a function.
echo $prependFoo('Hello'); // fooHello

// Used in a higher order function.
$array = array_map( $prependFoo, ['Hello', 'World']);
print_r($array); // [fooHello, fooWorld]

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
echo Strings\prepend('foo')('Bar'); // fooBar
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
    Strings\prepend('--'), 
    ['foo', 'bar']
);
print_r($array); // ['--foo', '--bar']
{% endhighlight %}
    </div>
</div>
