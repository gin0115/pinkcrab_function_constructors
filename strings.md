---
layout: base
title: Strings
description: >
 Archive of all functions in the Strings namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url  }}">Home</a> 
  >> <a href="{{ page.url | absolute_url }}">{{page.title}}</a>
</div>

> A collection of functions which can be used to work with strings.

> Much of the string functions found in this library act as wrappers for common standard (PHP) library functions, but curried to allow them to be easier composed with.

#### String Manipulation

There is a collection of functions with make for the concatenation of strings.

{% highlight php %}
$appendFoo = Str\append('foo');
$result = $appendFoo('BAR');

$prependFoo = Str\prepend('foo');
$result = $prependFoo('BAR');

$replaceFooWithBar = Str\replaceWith('foo', 'bar');
$result = $replaceFooWithBar("its all a bit foo foo");
// "its all a bit bar bar"

$wrapStringWithBar = Str\wrap('bar-start-', '-bar-end');
$result = $wrapStringWithBar('foo');
// bar-start-foo-bar-end
{% endhighlight %}

#### String Contents

There is a collection of functions that be used to check the contents of a string.

{% highlight php %}
// Check if a string contains
$containsFoo = Str\contains('foo');
$containsFoo('foo');   // true
$containsFoo('fobar'); // false

// Check if string start with (ends with also included)
$startsBar = Str\startsWith('bar');
$startsBar('bar-foo'); // true
$startsBar('foo-bar'); // false

// Check if a blank string
Str\isBlank('');   // true
Str\isBlank(' ');  // false

// Unlike using empty(), this checks if the value is a string also.
Str\isBlank(0);    // false 
Str\isBlank(null); // false

// Contains a regex pattern
$containsNumber = Str\containsPattern('~[0-9]+~');
$containsNumber('apple');   // false
$containsNumber('A12DFR3'); // true
{% endhighlight %}

> `Str\isBlank()` can be used when composing a function, thanks to the Functions::isBlank constant.

{% highlight php %}
$data = [0 => '', 1 => 'fff', 2 => '    '];
$notBlanks = array_filter(PinkCrab\FunctionConstructors\Functions::IS_BLANK, $data);
// [0 => ''] 
{% endhighlight %}

#### Sub Strings

There is a series of functions that can be used to work with substrings.

{% highlight php %}
// Split the string into sub string
$inFours = Str\split(4);
$split = $inFours('AAAABBBBCCCCDDDD');
// ['AAAA','BBBB','CCCC','DDDD']

// Chunk the string
$in5s = Str\chunk(5, '-');
$result = $in5s('aaaaabbbbbccccc');
// 'aaaaa-bbbbb-ccccc-'

// Count all characters in a given string.
$charCount = Str\countChars();
$results = $charCount('Hello World');
// [32 => 1, 72 => 1, 87 => 1, 100 => 1, 101 => 1, 108 => 3, 111 => 2, 114 => 1]
// If the keys are mapped using chr(), you will get 
$results = (Arr\mapKey('chr')($results));
// ['H' => 1,'e' => 1,'l' => 3,'o' => 2,' ' => 1,'W' => 1,'r' => 1,'d' => 1,]

// Count occurrences of a substring.
$countFoo = Str\countSubString('foo');
$results = $countFoo('foo is foo and bar is not foo');
// 3

// Find the first position of foo in string.
$firstFoo = Str\firstPosition('foo');
$result = $firstFoo('abcdefoog');
// 5
{% endhighlight %}


## String Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.strings %}
        {% if true != function.deprecated %} 
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %} 
    </div>
</div>


