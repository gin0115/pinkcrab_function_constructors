---
layout: function
title: Strings\replaceWith()
subtitle: Allows you to create a function which allows for creating a Closure which is populated with a sprintf template. Which accepts the array of args to accept. This can either be used as part of a Higher Order Function such as array_map() or as part of a compiled/pipe function.
group: strings
subgroup: string_manipulation
definition: >
 /**
   * @param string $template The sprintf template to use.
   * @return Closure(array):string
   */
  Strings\vSprintf(string $template): Closure
closure: >
 /**
   * @param mixed[] $values  The values to be used to populate the sprintf template.
   * @return string          The formatted string
   * @psalm-pure
   */ 
 $function(array $values): string

---

### Examples

<div class="panel">
    <h4 class="panel__title">        Partial Application</h4>
    <div class="panel__content">
        <p>
            This can be used to create a simple closure which can be used as a regular function.
        </p>
{% highlight php %}

$nameAndAge = Strings\vSprintf('Hello %s you are %d years old.');

// Called as a function.
echo $nameAndAge(['Dave', 12]); // Hello Dave you are 12 years old.

// Used in a higher order function.
$array = array_map( $nameAndAge, [['Dave', 12], ['Jane', 11]]);
print_r($array); // [Hello Dave you are 12 years old., Hello Jane you are 11 years old.]

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
echo Strings\vSprintf('%s-H')(['Bar']); // Bar-H
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
    Strings\vSprintf('Hello %s you are %d years old.'), 
    [['Dave', 12], ['Jane', 11]]
);
print_r($array); // [Hello Dave you are 12 years old., Hello Jane you are 11 years old.]
{% endhighlight %}
    </div>
</div>
