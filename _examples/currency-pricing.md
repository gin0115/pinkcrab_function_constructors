---
layout: example
title: Currency and pricing pipelines
summary: >
 Build a reusable "money" pipeline — convert currencies, apply tax, round, format — and use the same composed function across cart totals, invoices, and reports. Changing the rules is one edit; no scattered tax/VAT code.

functions:
  - name: compose
    url: /general/compose.html
  - name: Numbers\multiply
    url: /numbers/multiply.html
  - name: Numbers\sum
    url: /numbers/sum.html
  - name: Numbers\round
    url: /numbers/round.html
  - name: Strings\digit
    url: /strings/digit.html
  - name: Arrays\sumWhere
    url: /arrays/sumWhere.html
  - name: Arrays\map
    url: /arrays/map.html
---

## The usual mess

Pricing logic in most apps is a stew: currency conversions in one service, tax in a helper, rounding in the display layer, formatting in a view. When the tax rate changes, you hunt across three files.

Express each step as a pure number → number callable, compose them into a single `money` pipeline, and you have one callable that handles the whole chain.

## Building the pipeline

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Numbers as N;
use PinkCrab\FunctionConstructors\Strings as Str;

// GBP → EUR at a fixed rate (real code reads from a rate provider, same shape).
$toEuro = N\multiply(1.17);

// 20% VAT.
$withVat = N\multiply(1.20);

// Standard commercial rounding to 2 decimal places.
$round2 = N\round(2);

// Formatted string output: "1,234.56" → "€1,234.56".
$format = F\compose(
    Str\digit(2, '.', ','),
    fn($s) => '€' . $s
);

// The whole pipeline.
$priceForEuropeanCustomer = F\compose($toEuro, $withVat, $round2, $format);

echo $priceForEuropeanCustomer(100.00);   // '€140.40'
{% endhighlight %}

Each step is named for what it does. The composed pipeline reads left-to-right like the conceptual flow.

## Reuse across contexts

The same callable works as a map function on a cart:

{% highlight php %}
$cart = [10.00, 25.50, 4.99];

print_r(array_map($priceForEuropeanCustomer, $cart));
// ['€14.04', '€35.80', '€7.01']
{% endhighlight %}

Or, if you want the total in cents for reporting (drop the formatting step):

{% highlight php %}
$eurosAsFloat = F\compose($toEuro, $withVat, $round2);

$cartItems = [
    ['name' => 'Widget', 'price' => 10.00],
    ['name' => 'Gadget', 'price' => 25.50],
];

// Sum of the transformed prices via sumWhere — map + sum in one pass.
$total = Arrays\sumWhere(F\compose(F\getProperty('price'), $eurosAsFloat));

echo $total($cartItems);   // 49.84
{% endhighlight %}

## Changing the rules in one place

VAT goes to 22%? Rate shifts to 1.15? New currency symbol? Edit one line. Every caller — cart totals, invoices, reports, emails — picks it up.

## Per-region pricing factories

If you're selling in multiple regions, build a factory that spits out per-region pipelines:

{% highlight php %}
$makePricing = fn(float $rate, float $vatMultiplier, string $symbol) =>
    F\compose(
        N\multiply($rate),
        N\multiply($vatMultiplier),
        N\round(2),
        Str\digit(2, '.', ','),
        fn($s) => $symbol . $s
    );

$priceUK  = $makePricing(1.00, 1.20, '£');
$priceEU  = $makePricing(1.17, 1.22, '€');
$priceUS  = $makePricing(1.26, 1.00, '$');      // US prices typically shown ex-tax

echo $priceUK(100);   // '£120.00'
echo $priceEU(100);   // '€142.74'
echo $priceUS(100);   // '$126.00'
{% endhighlight %}

Three named pipelines, one factory definition. Add Japan next week with one more line.
