---
layout: base
title: Arrays
description: >
 Archive of all functions in the Arrays namespace.
---

<h1 class="page-title">{{ page.title }}</h1>

<div class="breadcrumbs">
  <a href="{{ site.url | absolute_url  }}">Home</a> 
  >> <a href="{{ page.url | absolute_url }}">{{page.title}}</a>
</div>

> A collection of functions which can be used to work with arrays/lists.

#### Map

This library contains a large number of variations of `array_map` , these can all be pre composed, using the other functions to be extremely powerful and easy to follow.

{% highlight php %}
// Create a mapper which doubles the value.
$doubleIt = Arr\map( Num\multiply(2) );
$doubleIt([1,2,3,4]); // [2,4,6,8] 

// Create mapper to normalise array keys
$normaliseKeys = Arr\mapKey(F\compose(
    'strval',
    'trim',
    Str\replace(' ', '-')
    Str\prepend('__')
));

$normaliseKeys(1 => 'a', ' 2 ' => 'b', 'some key' => 'c');
// ['__1'=> 'a', '__2' => 'b', '__some-key' => 'c']

// Map and array with the value and key.
$mapWithKey = Arr\mapWithKey( function($key, $value) {
    return $key . $value;
});
$mapWithKey('a' => 'pple', 'b' => 'anana'); 
// ['apple', 'banana']
{% endhighlight %}

> There is `flatMap()` and `mapWith()` also included, please see the wiki.

#### Filter and Take

There is a large number of composible functions based around `array_filter()` . Combined with a basic set of `take*()` functions, you can compose functions to work with lists/collections much easier.

{% highlight php %}
// Filter out ony factors of 3
$factorsOf3s = Arr\filter( Num\factorOf(3) );
$factorsOf3s([1,3,5,6,8,7,9,11]); // [3,6,9]

// Filer first and last of an array/
$games = [
    ['id'=>1, 'result'=>'loss'],
    ['id'=>2, 'result'=>'loss'],
    ['id'=>3, 'result'=>'win'],
    ['id'=>4, 'result'=>'win'],
    ['id'=>5, 'result'=>'loss'],
];

$firstWin = Arr\filterFirst( F\propertyEquals('result','win') );
$result = $firstWin($games); // ['id'=>3, 'result'=>'win']

$lastLoss = Arr\filterLast( F\propertyEquals('result','loss') );
$result = $lastLoss($games); // ['id'=>5, 'result'=>'loss']

// Count result of filter.
$totalWins = Arr\filterCount( F\propertyEquals('result','win') );
$result = $totalWins($games); // 2
{% endhighlight %}

> Filter is great if you want to just process every result in the collection, the `take()` family of functions allow for controlling how much of an array is filtered

{% highlight php %}
// Take the first or last items from an array
$first5 = Arr\take(5);
$last3 = Arr\takeLast(5);

$nums = [1,3,5,6,8,4,1,3,5,7,9,3,4];
$first5($nums); // [1,3,5,6,8]
$last3($nums);  // [9,3,4]

// Using takeWhile and takeUntil to get the same result.
$games = [
    ['id'=>1, 'result'=>'loss'],
    ['id'=>2, 'result'=>'loss'],
    ['id'=>3, 'result'=>'win'],
    ['id'=>4, 'result'=>'win'],
    ['id'=>5, 'result'=>'loss'],
];

// All games while the result is a loss, then stop
$initialLoosingStreak = Arr\takeWhile(F\propertyEquals('result','loss'));
// All games until the first win, then stop
$untilFirstWin = Arr\takeUntil(F\propertyEquals('result', 'win'));

$result = $initialLoosingStreak($game);
$result = $untilFirstWin($game);
// [['id' => 1, 'result' => 'loss'], ['id' => 2, 'result' => 'loss']]
{% endhighlight %}

#### Fold and Scan

Folding or reducing an a list is a pretty common operation and unlike the native `array_reduce` you have a little more flexibility.

{% highlight php %}

$payments = [
    'gfg1dg3d' => ['type' => 'card', 'amount' => 12.53],
    'eg43ytfh' => ['type' => 'cash', 'amount' => 21.95],
    '5g7tgxfb' => ['type' => 'card', 'amount' => 1.99],
    'oitu87uo' => ['type' => 'cash', 'amount' => 4.50],
    'ew1e5435' => ['type' => 'cash', 'amount' => 21.50],
];

// Get total for all cash payment.
$allCash = Arr\fold(function($total, $payment){
    if($payment['type'] === 'cash'){
        $total += $payment['amount'];
    }
    return $total;
},0.00);

$result = $allCash($payments); // 47.95

// Log all card payment in some class, with access to array keys.
$logCardPayments = Arr\foldKeys(function($log, $key, $payment){
    if($payment['type'] === 'card'){
        $log->addPayment(payment_key: $key, amount: $payment['amount']);
    }
    return $log;
}, new CardPaymentLog('some setup') );

$cardPaymentLog = $logCardPayments($payments);
var_dump($cardPayments->getPayments());
// [{'key': 'gfg1dg3d', 'amount': 12.53}, {'key': '5g7tgxfb', 'amount': 1.99}]

// Generate a running total of all payments.
$runningTotal = Arr\scan(function($runningTotal, $payment){
    $runningTotal += $payment['amount'];
    return $runningTotal;

}, 0.00);

$result = $runningTotal($payments);
// [0.0, 12.53, 34.48, 36.47, 40.97, 62.47]
{% endhighlight %}

> You also have access to `foldR()` and `scanR()` which will iterate through the array backwards.

#### Grouping and Partitioning 

Function Constructor has a number of functions which make it easy to group and partition arrays

{% highlight php %}
$data = [
    ['id'=>1, 'name'=>'John', 'age'=>20, 'someMetric' => 'A12'],
    ['id'=>2, 'name'=>'Jane', 'age'=>21, 'someMetric' => 'B10'],
    ['id'=>3, 'name'=>'Joe', 'age'=>20, 'someMetric' => 'C15'],
    ['id'=>4, 'name'=>'Jack', 'age'=>18, 'someMetric' => 'B10'],
    ['id'=>5, 'name'=>'Jill', 'age'=>22, 'someMetric' => 'A12'],
];

// Group by the return value of the function.
$groupedByMetric = Arr\groupBy(function($item){
    return $item['someMetric'];
});

$results = $groupedByMetric($data);
["A12" =>  [
    ["id" => 1,"name" => "John", ...],
    ["id" => 5,"name" => "Jill", ...]
],
"B10" =>  [
    ["id" => 2,"name" => "Jane", ...],
    ["id" => 4,"name" => "Jack", ...]
],
"C15" =>  [
    ["id" => 3,"name" => "Joe", ...]
]];

// Partition using a predicate function.
$over21 = Arr\partition(function($item){
    return $item['age'] >= 21;
});

$results = $over21($data);
[0 => [ // false values
    ["name" => "John", "age" => 20, ...],
    ["name" => "Joe", "age" => 20, ...],
    ["name" => "Jack", "age" => 18, ...]
],
1 => [ // true values
    ["name" => "Jane", "age" => 21, ...],
    ["name" => "Jill", "age" => 22, ...]
]];
{% endhighlight %}

> It is possible to chunk and split arrays, see the wiki for more.

#### Sorting

The native PHP `sort` functions are tricky with a functional approach, as they sort via reference, rather than by a return value. The Function Constructor library covers all native sorting as partially applied functions.

{% highlight php %}
// Sorting simple arrays
$dataWords = ['Zoo', 'cat', 'Dog', 'ant', 'bat', 'Cow']; 

$sortWords = Arr\sort(SORT_STRING);
$result = $sortWords($dataWords);
// ['ant', 'bat', 'cat', 'Cow', 'Dog', 'Zoo'];

// Sorting associative arrays
$dataBooks = [    
    'ehjf89' => ['id'=>'ehjf89', 'title'=>'Some title', 'author'=> 'Adam James'],
    'retg23' => ['id'=>'retg23', 'title'=>'A Title', 'author'=> 'Jane Jones'],
    'fvbi43' => ['id'=>'fvbi43', 'title'=>'Some title words', 'author'=> 'Sam Smith'],
    'mgged3' => ['id'=>'mgged3', 'title'=>'Book', 'author'=> 'Will Adams'],
]; 


// Sort by key
$sortBookByKey = Arr\ksort(SORT_STRING | SORT_FLAG_CASE);
$result = $sortBookByKey($dataBooks);
[
    'ehJF89' => ['id' => 'ehjf89', 'title' => 'Some title', 'author' => 'Adam James'],
    'fvbI43' => ['id' => 'fvbi43', 'title' => 'Some title words', 'author' => 'Sam Smith'],
    'MggEd3' => ['id' => 'mgged3', 'title' => 'Book', 'author' => 'Will Adams'],
    'Retg23' => ['id' => 'retg23', 'title' => 'A Title', 'author' => 'Jane Jones'],
]

// Sort by author
$sortBookByAuthor = Arr\uasort(function ($a, $b) {
    return strcmp($a['author'], $b['author']);
});
$sortBookByAuthor($dataBooks);
[
    'ehJF89' => ['id' => 'ehjf89', 'title' => 'Some title', 'author' => 'Adam James'],
    'Retg23' => ['id' => 'retg23', 'title' => 'A Title', 'author' => 'Jane Jones'],
    'fvbI43' => ['id' => 'fvbi43', 'title' => 'Some title words', 'author' => 'Sam Smith'],
    'MggEd3' => ['id' => 'mgged3', 'title' => 'Book', 'author' => 'Will Adams'],
]

{% endhighlight %}



## Array Functions.

<div class="container">
    <div class="grid all-functions">
    {% for function in site.arrays %}
        {% if true != function.deprecated %} 
        <div class="col-12 col-md-4">
            <a href="{{ site.url }}{{ function.url}}">{{ function.title }}</a>
        </div>
        {% endif %}
    {% endfor %} 
    </div>
</div>


