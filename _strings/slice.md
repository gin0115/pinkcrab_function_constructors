---
layout: function
title: Strings\slice()
subtitle: Allows you to create a function which can be used to split a string with a defined starting and ending char index. These can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.
group: strings
subgroup: string_manipulation
definition: >

 /**
   * @param int      $start   start position (offset)
   * @param int|null $finish  end position (length)
   * @return Closure(string):string
   */
  Strings\slice(int $start, ?int $finish = null ): Closure
closure: >
 /**
   * @param string $toSlice  The string to be sliced
   * @return string          The sliced string
   * @psalm-pure
   */ 
 $function(string $toSlice): string

---

### Examples

<div class="panel">
    <h4 class="panel__title">        Partial Application</h4>
    <div class="panel__content">
        <p>
            This can be used to create a simple closure which can be used as a regular function.
        </p>
{% highlight php %}
// Create a closure which will take the first 2 characters of a string.
$sliceFirst2 = Strings\slice(0,2);

// Called as a function.
echo $sliceFirst2('Hello'); // He

// Used in a higher order function.
$array = array_map( $makeSpan, ['Hello', 'World']);
print_r($array); // [He, Wo]

// You can also use slice() to skip the first 5 characters of a string.
$skipFirst5 = Strings\slice(5);

// Called as a function.
echo $skipFirst5('HelloWorldBar'); // WorldBar


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
echo Strings\slice(0,2)('Hello'); // He
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
// Remove first 5 characters from each string.
$array = array_map(
    Strings\slice(5), 
    ['12345789', 'abcbdefghi']
);
print_r($array); // ['6789', 'fghi']
{% endhighlight %}
    </div>
</div>
