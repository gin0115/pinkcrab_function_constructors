---
layout: example
title: Config-driven pipelines
summary: >
 Build a pipeline from a list of function names loaded at runtime — from config, from a database, from user choices. Because compose takes an array of callables, "define your pipeline in YAML" is a one-line implementation.

functions:
  - name: compose
    url: /general/compose.html
  - name: pipe
    url: /general/pipe.html
  - name: Arrays\map
    url: /arrays/map.html
---

## The insight

`compose` takes variadic callables. But variadic in PHP is just an array internally. So composing a pipeline from configuration is as simple as:

{% highlight php %}
$pipeline = F\compose(...$callables);
{% endhighlight %}

Where `$callables` can be built at runtime from any source you like.

## A concrete example — post-processing user messages

Say an admin can configure what happens to every user-submitted message. Some of the available steps:

{% highlight php %}
use PinkCrab\FunctionConstructors\GeneralFunctions as F;
use PinkCrab\FunctionConstructors\Arrays;
use PinkCrab\FunctionConstructors\Strings as Str;

$registry = [
    'trim'         => Str\trim(" \t\n\r"),
    'lowercase'    => 'strtolower',
    'strip_tags'   => Str\stripTags(),
    'linkify'      => fn($s) => preg_replace('#https?://\S+#', '<a href="$0">$0</a>', $s),
    'truncate_200' => Str\slice(0, 200),
    'suffix_elips' => fn($s) => strlen($s) >= 200 ? rtrim($s) . '…' : $s,
];
{% endhighlight %}

Each key is the name the admin/config will reference. Each value is a plain callable.

## The config

{% highlight yaml %}
# config/messages.yml
pipeline:
  - trim
  - strip_tags
  - truncate_200
  - suffix_elips
  - linkify
{% endhighlight %}

## Building the pipeline at runtime

{% highlight php %}
$config = Yaml::parseFile('config/messages.yml');

$pipeline = F\compose(
    ...array_map(fn($name) => $registry[$name], $config['pipeline'])
);

echo $pipeline('<b>Hello</b>  https://example.com/page-with-a-very-long-path-and-query-string');
// '<a href="https://example.com/...">https://example.com/...</a>'  (trimmed, tags stripped, truncated, linkified)
{% endhighlight %}

## Swap per environment

Production wants less aggressive trimming; staging wants everything:

{% highlight yaml %}
# config/messages.staging.yml
pipeline: [trim, strip_tags, truncate_200, suffix_elips, linkify]

# config/messages.production.yml
pipeline: [trim, strip_tags, linkify]     # no truncation
{% endhighlight %}

Same code, different behaviour, zero branching.

## Plugin systems — extensions inject steps

Third-party plugins can register new callables into the registry:

{% highlight php %}
// A plugin registers itself:
$registry['spellcheck'] = $spellcheckPlugin->asCallable();

// Admin adds it to the pipeline:
// pipeline: [trim, strip_tags, spellcheck, truncate_200]
{% endhighlight %}

The core code never changes. Plugins integrate by adding entries to a map and naming themselves in config.

## Validation before wiring

A production system should complain loudly about unknown names rather than silently skipping them:

{% highlight php %}
$names = $config['pipeline'];
$missing = array_diff($names, array_keys($registry));
if ($missing) {
    throw new \RuntimeException('Unknown pipeline steps: ' . implode(', ', $missing));
}

$pipeline = F\compose(...array_map(fn($n) => $registry[$n], $names));
{% endhighlight %}

## When to reach for this

- You have users/admins who should be able to change behaviour without a deploy.
- Plugins or extensions need a way to compose themselves into the main flow.
- The same logical pipeline runs in different shapes across environments.

In all three cases, the "data is functions" insight turns configuration into live behaviour with almost no glue code.
