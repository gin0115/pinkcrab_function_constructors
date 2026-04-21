<?php

/**
 * Array functions.
 *
 * This file is part of PinkCrab Function Constructors.
 *
 * PinkCrab Function Constructors is free software: you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, either version 2
 * of the License, or (at your option) any later version.
 *
 * PinkCrab Function Constructors is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with PinkCrab Function Constructors.
 * If not, see <https://www.gnu.org/licenses/>.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html
 * @package PinkCrab\FunctionConstructors
 * @since 0.0.1
 *
 * @template Number of int|float
 * @phpstan-template Number of int|float
 * @psalm-template Number of int|float
 */

declare(strict_types=1);

namespace PinkCrab\FunctionConstructors\Arrays;

use Closure;
use stdClass;
use PinkCrab\FunctionConstructors\Comparisons as Comp;

/**
 * Returns a Closure for appending a value to the end of an array or iterable.
 *
 * - Array in  → array out with the value pushed on the end (unchanged behaviour).
 * - Generator/Traversable in → Generator out that first yields every source
 *   element, then yields the new value.
 *
 * @param mixed $value
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function append($value): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($value) {
        if (is_array($source)) {
            $source[] = $value;
            return $source;
        }
        return (function () use ($source, $value) {
            foreach ($source as $key => $v) {
                yield $key => $v;
            }
            yield $value;
        })();
    };
}

/**
 * Returns a Closure for prepending a value to the start of an array or iterable.
 *
 * - Array in  → array out with the value unshifted onto the front (unchanged behaviour).
 * - Generator/Traversable in → Generator out that first yields the new value, then
 *   yields every source element.
 *
 * @param mixed $value
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function prepend($value): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($value) {
        if (is_array($source)) {
            array_unshift($source, $value);
            return $source;
        }
        return (function () use ($source, $value) {
            yield $value;
            foreach ($source as $key => $v) {
                yield $key => $v;
            }
        })();
    };
}

/**
 * Gets the first value from an array or iterable. For Generators this is a
 * genuine early-exit — the rest of the stream is NOT consumed.
 *
 * @param iterable<int|string, mixed> $source The array or iterable.
 * @return mixed The first value, or null if empty.
 */
function head(iterable $source)
{
    if (is_array($source)) {
        return ! empty($source) ? array_values($source)[0] : null;
    }
    foreach ($source as $value) {
        return $value;
    }
    return null;
}

/**
 * Gets the last value from an array or iterable. For a Generator the whole
 * stream is consumed (there is no way to know the last value without doing so).
 *
 * @param iterable<int|string, mixed> $source The array or iterable.
 * @return mixed The last value, or null if empty.
 */
function last(iterable $source)
{
    if (is_array($source)) {
        return ! empty($source) ? array_reverse($source, false)[0] : null;
    }
    $last  = null;
    $found = false;
    foreach ($source as $value) {
        $last  = $value;
        $found = true;
    }
    return $found ? $last : null;
}

/**
 * Gets the remainder of an array or iterable after the first element is removed.
 *
 * - Array in  → new array with the first element dropped, or null if empty (unchanged behaviour).
 * - Generator/Traversable in → Generator that lazily yields every element after
 *   the first. For an empty Generator source the returned Generator is empty
 *   (NOT null — this is the one documented API divergence from the array path).
 *
 * @param iterable<int|string, mixed> $source
 * @return array<int|string, mixed>|\Generator<int|string, mixed>|null
 */
function tail(iterable $source)
{
    if (is_array($source)) {
        if (empty($source)) {
            return null;
        }
        array_shift($source);
        return $source;
    }
    return (function () use ($source) {
        $first = true;
        foreach ($source as $key => $value) {
            if ($first) {
                $first = false;
                continue;
            }
            yield $key => $value;
        }
    })();
}


/**
 * Creates a Closure for joining an array or iterable into a string with a glue.
 * Terminal: Generator input is materialised before joining.
 *
 * @param string|null $glue The string to join each element. If null, will be no separation between elements.
 * @return Closure(iterable<int|string, mixed>):string
 */
function toString(?string $glue = null): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return string
     */
    return function (iterable $source) use ($glue): string {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return $glue ? \join($glue, $array) : \join($array);
    };
}

/**
 * Creates a Closure for zipping a source array or iterable with a secondary
 * array. Each element of the result is a pair — [source_value, additional_value].
 * When the additional array is shorter than the source, `$default` fills the gap.
 *
 * - Array in  → array out (unchanged behaviour).
 * - Generator/Traversable in → Generator out that yields pairs lazily.
 *
 * @param array<mixed> $additional Values paired positionally with the source.
 * @param mixed $default Fallback when the additional array runs out.
 * @return Closure(iterable<mixed>):(array<array{mixed, mixed}>|\Generator<int, array{mixed, mixed}>)
 */
function zip(array $additional, $default = null): Closure
{
    $additional = array_values($additional);
    return function (iterable $source) use ($additional, $default) {
        if (is_array($source)) {
            $source = array_values($source);
            return array_reduce(
                array_keys($source),
                function ($carry, $key) use ($source, $additional, $default): array {
                    $carry[] = array(
                        $source[$key],
                        array_key_exists($key, $additional) ? $additional[$key] : $default,
                    );
                    return $carry;
                },
                array()
            );
        }
        return (function () use ($source, $additional, $default) {
            $i = 0;
            foreach ($source as $value) {
                yield array(
                    $value,
                    array_key_exists($i, $additional) ? $additional[$i] : $default,
                );
                $i++;
            }
        })();
    };
}


/*
 *                                ********************
 *                                * Filter Compilers *
 *                                ********************
 */


/**
 * Compiles an array if a value is passed.
 * Returns the array if nothing passed.
 *
 * @param mixed[] $inital Sets up the inner value.
 * @return Closure
 */
function arrayCompiler(array $inital = array()): Closure
{
    /**
     * @param mixed $value Adds value to inner array if value set, else returns.
     * @return mixed[]|Closure
     */
    return function ($value = null) use ($inital) {
        if ($value) {
            $inital[] = $value;
        }
        return !is_null($value) ? arrayCompiler($inital) : $inital;
    };
}

/**
 * Creates a typed array compiler.
 * All values which do not pass the validator are not added.
 *
 * @param Closure(mixed):bool $validator Used to validate values before adding to array.
 * @param mixed[] $inital The inital data to start with
 * @return Closure
 */
function arrayCompilerTyped(callable $validator, array $inital = array()): Closure
{
    // Ensure all is validated from initial.
    $inital = array_filter($inital, $validator);

    /**
     * @param mixed $value
     * @return mixed[]|Closure
     */
    return function ($value = null) use ($validator, $inital) {
        if (!is_null($value) && $validator($value)) {
            $inital[] = $value;
        }
        return !is_null($value) ? arrayCompilerTyped($validator, $inital) : $inital;
    };
}



/*
 *                                ********************
 *                                * Filter Functions *
 *                                ********************
 */


/**
 * Created a Closure for filtering an array or iterable.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; keys preserved).
 *
 * @param callable $callable The function to apply to each value.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function filter(callable $callable): Closure
{
    /**
     * @param iterable<int|string, mixed> $source Array or iterable to filter.
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($callable) {
        if (is_array($source)) {
            return array_filter($source, $callable);
        }
        return (function () use ($source, $callable) {
            foreach ($source as $key => $value) {
                if ($callable($value)) {
                    yield $key => $value;
                }
            }
        })();
    };
}

/**
 * Create a Closure for filtering an array or iterable by its keys.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; keys preserved).
 *
 * @param callable $callable The function to apply to each key.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function filterKey(callable $callable): Closure
{
    /**
     * @param iterable<int|string, mixed> $source Array or iterable to filter.
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($callable) {
        if (is_array($source)) {
            return array_filter($source, $callable, \ARRAY_FILTER_USE_KEY);
        }
        return (function () use ($source, $callable) {
            foreach ($source as $key => $value) {
                if ($callable($key)) {
                    yield $key => $value;
                }
            }
        })();
    };
}

/**
 * Creates a Closure applying an AND group of predicates.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; keys preserved).
 *
 * @param callable ...$callables
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function filterAnd(callable ...$callables): Closure
{
    $predicate = Comp\groupAnd(...$callables);
    return filter($predicate);
}

/**
 * Creates a Closure applying an OR group of predicates.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; keys preserved).
 *
 * @param callable ...$callables
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function filterOr(callable ...$callables): Closure
{
    $predicate = Comp\groupOr(...$callables);
    return filter($predicate);
}

/**
 * Creates a Closure that returns the first element matching a predicate.
 * Accepts any iterable; short-circuits on the first match (the source is NOT
 * advanced past it).
 *
 * @param callable $func
 * @return Closure(iterable<int|string, mixed>):?mixed
 */
function filterFirst(callable $func): Closure
{
    /**
     * @param iterable<int|string, mixed> $source The array or iterable to filter.
     * @return mixed|null The first matching value, or null if no match found.
     */
    return function (iterable $source) use ($func) {
        foreach ($source as $value) {
            $result = $func($value);
            if (\is_bool($result) && $result) {
                return $value;
            }
        }
    };
}

/**
 * Creates a Closure that returns the last element matching a predicate.
 * Accepts any iterable. Terminal — for a Generator, the whole source is
 * consumed (there is no way to find "last" without doing so).
 *
 * @param callable $func
 * @return Closure(iterable<int|string, mixed>):?mixed
 */
function filterLast(callable $func): Closure
{
    /**
     * @param iterable<int|string, mixed> $source The array or iterable to scan.
     * @return mixed|null The last matching value, or null if no match.
     */
    return function (iterable $source) use ($func) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        while ($value = array_pop($array)) {
            $result = $func($value);
            if (\is_bool($result) && $result) {
                return $value;
            }
        }
    };
}

/**
 * Creates a Closure which filters then maps over the results.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; keys preserved).
 *
 * @param callable(mixed):bool $filter Predicate used to include values.
 * @param callable(mixed):mixed $map Transformation applied to included values.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function filterMap(callable $filter, callable $map): Closure
{
    /**
     * @param iterable<int|string, mixed> $source Array or iterable to filter+map.
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($filter, $map) {
        if (is_array($source)) {
            return array_map($map, array_filter($source, $filter));
        }
        return (function () use ($source, $filter, $map) {
            foreach ($source as $key => $value) {
                if ($filter($value)) {
                    yield $key => $map($value);
                }
            }
        })();
    };
}

/**
 * Returns a Closure that counts the elements of an array or iterable matching
 * a predicate. Terminal — Generator input is consumed.
 *
 * @param callable $function
 * @return Closure(iterable<int|string, mixed>):int
 */
function filterCount(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return int Count
     */
    return function (iterable $source) use ($function) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return count(array_filter($array, $function));
    };
}

/**
 * Returns a Closure for partitioning an array or iterable into two buckets by
 * a predicate. Terminal — Generator input is consumed fully.
 *
 * Callable will be cast to a bool, if truthy will be listed under key 1, else 0.
 *
 * @param callable(mixed):(bool|int) $function
 * @return Closure(iterable<int|string, mixed>):array{0:mixed[], 1:mixed[]}
 */
function partition(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array{0:mixed[], 1:mixed[]}
     */
    return function (iterable $source) use ($function): array {
        $array = is_array($source) ? $source : iterator_to_array($source);
        /** @var array{0:mixed[], 1:mixed[]} $result */
        $result = array_reduce(
            $array,
            /**
             * @param array{0:mixed[], 1:mixed[]} $carry
             * @param mixed $element
             * @return array{0:mixed[], 1:mixed[]}
             */
            function ($carry, $element) use ($function): array {
                $key             = (bool) $function($element) ? 1 : 0;
                $carry[$key][] = $element;
                return $carry;
            },
            array(array(), array())
        );
        return $result;
    };
}

/**
 * Returns a closure for checking that every element of an array or iterable
 * passes the predicate. Short-circuits on the first non-matching value.
 *
 * @param callable(mixed):bool $function
 * @return Closure(iterable<int|string, mixed>):bool
 */
function filterAll(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return bool
     */
    return function (iterable $source) use ($function): bool {
        foreach ($source as $value) {
            if (false === $function($value)) {
                return false;
            }
        }
        return true;
    };
}


/**
 * Returns a closure for checking that at least one element of an array or
 * iterable passes the predicate. Short-circuits on the first match.
 *
 * @param callable(mixed):bool $function
 * @return Closure(iterable<int|string, mixed>):bool
 */
function filterAny(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return bool
     */
    return function (iterable $source) use ($function): bool {
        foreach ($source as $value) {
            if (true === $function($value)) {
                return true;
            }
        }
        return false;
    };
}


/*
 *                           *****************
 *                           * Map Functions *
 *                           *****************
 */



/**
 * Returns a Closure which applies a callback to every element of an array
 * or iterable.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; values are transformed
 *   on demand, keys preserved).
 *
 * @param callable(mixed):mixed $func Callback to apply to each element.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function map(callable $func): Closure
{
    /**
     * @param iterable<int|string, mixed> $source The array or iterable to map.
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($func) {
        if (is_array($source)) {
            return array_map($func, $source);
        }
        return (function () use ($source, $func) {
            foreach ($source as $key => $value) {
                yield $key => $func($value);
            }
        })();
    };
}

/**
 * Returns a Closure for transforming the keys of an array or iterable.
 * Setting the key to an existing index will overwrite the current value at same index.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; transformed keys preserved).
 *
 * @param callable $func Callback applied to each key.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function mapKey(callable $func): Closure
{
    /**
     * @param iterable<int|string, mixed> $source Array or iterable whose keys are transformed.
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($func) {
        if (is_array($source)) {
            return array_reduce(
                array_keys($source),
                function ($carry, $key) use ($func, $source) {
                    $carry[$func($key)] = $source[$key];
                    return $carry;
                },
                array()
            );
        }
        return (function () use ($source, $func) {
            foreach ($source as $key => $value) {
                yield $func($key) => $value;
            }
        })();
    };
}

/**
 * Returns a Closure for mapping an array or iterable with additional data arguments
 * passed to the callback alongside each element's value.
 *
 * - Array in  → array out (eager, unchanged behaviour).
 * - Generator/Traversable in → Generator out (lazy; keys preserved).
 *
 * @param callable(mixed ...$a):mixed $func Callback invoked as `$func($value, ...$data)`.
 * @param mixed ...$data Extra arguments threaded into each invocation of `$func`.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function mapWith(callable $func, ...$data): Closure
{
    /**
     * @param iterable<int|string, mixed> $source Array or iterable to map.
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($func, $data) {
        if (is_array($source)) {
            return array_map(
                function ($e) use ($data, $func) {
                    return $func($e, ...$data);
                },
                $source
            );
        }
        return (function () use ($source, $func, $data) {
            foreach ($source as $key => $value) {
                yield $key => $func($value, ...$data);
            }
        })();
    };
}

/**
 * Returns a Closure for mapping over an array or iterable with access to both value
 * and key in the callback: `$func($value, $key)`.
 *
 * Note on keys: for parity with the existing array-path behaviour (which uses
 * `array_map` with two arrays — causing the result to be numerically re-indexed),
 * the Generator path also yields sequential integer keys starting at 0.
 *
 * - Array in  → array out with sequential numeric keys (unchanged behaviour).
 * - Generator/Traversable in → Generator out with sequential numeric keys.
 *
 * @param callable(mixed $value, int|string $key):mixed $func
 * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
 */
function mapWithKey(callable $func): Closure
{
    /**
     * @param iterable<int|string, mixed> $source Array or iterable to map.
     * @return array<int, mixed>|\Generator<int, mixed>
     */
    return function (iterable $source) use ($func) {
        if (is_array($source)) {
            return array_map(
                function ($key, $value) use ($func) {
                    return $func($value, $key);
                },
                $source,
                array_keys($source)
            );
        }
        return (function () use ($source, $func) {
            $i = 0;
            foreach ($source as $key => $value) {
                yield $i++ => $func($value, $key);
            }
        })();
    };
}

/**
 * Returns a Closure that iterates over an array or iterable, invoking the
 * callback with each ($key, $value) pair for its side effect.
 *
 * @param callable(int|string $key, mixed $value):void $func
 * @return Closure(iterable<int|string, mixed>):void
 */
function each(callable $func): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return void
     */
    return function (iterable $source) use ($func): void {
        foreach ($source as $key => $value) {
            $func($key, $value);
        }
    };
}

/**
 * Returns a Closure for flattening and mapping an array or iterable.
 *
 * - Array in  → array out (unchanged behaviour via array_reduce/array_merge).
 * - Generator/Traversable in → Generator out that lazily recurses into nested
 *   arrays up to depth $n, applying $function to leaf non-array elements.
 *
 * @param callable(mixed):mixed $function Applied to leaf non-array elements.
 * @param int|null $n Recursion depth; null = flatten fully.
 * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
 */
function flatMap(callable $function, ?int $n = null): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int, mixed>|\Generator<int, mixed>
     */
    return function (iterable $source) use ($n, $function) {
        if (is_array($source)) {
            return array_reduce(
                $source,
                /**
                 * @param mixed[] $carry
                 * @param mixed $element
                 * @return mixed[]
                 */
                function (array $carry, $element) use ($n, $function): array {
                    if (is_array($element) && (is_null($n) || $n > 0)) {
                        // Recursive call on an array element always hits the array path,
                        // which returns array. The return type is widened to include
                        // Generator for iterable inputs; narrow it back here for array_merge.
                        $recursed = flatMap($function, $n ? $n - 1 : null)($element);
                        $carry    = array_merge($carry, is_array($recursed) ? $recursed : iterator_to_array($recursed));
                    } else {
                        $carry[] = is_array($element) ? $element : $function($element);
                    }
                    return $carry;
                },
                array()
            );
        }
        return (function () use ($source, $n, $function) {
            foreach ($source as $element) {
                if (is_array($element) && (is_null($n) || $n > 0)) {
                    foreach (flatMap($function, $n ? $n - 1 : null)($element) as $sub) {
                        yield $sub;
                    }
                } else {
                    yield is_array($element) ? $element : $function($element);
                }
            }
        })();
    };
}

/*
 *                         **********************
 *                         * General Operations *
 *                         **********************
 */


/**
 * Creates a Closure for grouping an array or iterable by a key-producing fn.
 * Terminal — Generator input is consumed fully.
 *
 * @param callable(mixed):(string|int) $function The function to group by.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function groupBy(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source The array or iterable to be grouped.
     * @return mixed[] Grouped array.
     */
    return function (iterable $source) use ($function): array {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return array_reduce(
            $array,
            /**
             * @param mixed[] $carry
             * @param mixed $element
             * @return mixed[]
             */
            function ($carry, $item) use ($function): array {
                $carry[call_user_func($function, $item)][] = $item;
                return $carry;
            },
            array()
        );
    };
}

/**
 * Creates a Closure for chunking an array or iterable into batches of up to N.
 *
 * - Array in  → array of arrays (unchanged behaviour via array_chunk).
 * - Generator/Traversable in → Generator that yields each completed batch as
 *   an array. The final partial batch is yielded when the source exhausts.
 *
 * @param int $count The max size of each chunk. Values less than 1 are
 *                   clamped to 1.
 * @param bool $preserveKeys Should the source keys be kept inside each batch.
 * @return Closure(iterable<int|string, mixed>):(array<int, array<int|string, mixed>>|\Generator<int, array<int|string, mixed>>)
 */
function chunk(int $count, bool $preserveKeys = false): Closure
{
    $count = max(1, $count);
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int, array<int|string, mixed>>|\Generator<int, array<int|string, mixed>>
     */
    return function (iterable $source) use ($count, $preserveKeys) {
        if (is_array($source)) {
            return array_chunk($source, $count, $preserveKeys);
        }
        return (function () use ($source, $count, $preserveKeys) {
            $buffer = array();
            foreach ($source as $key => $value) {
                if ($preserveKeys) {
                    $buffer[$key] = $value;
                } else {
                    $buffer[] = $value;
                }
                if (count($buffer) >= $count) {
                    yield $buffer;
                    $buffer = array();
                }
            }
            if (count($buffer) > 0) {
                yield $buffer;
            }
        })();
    };
}

/**
 * Create callback for extracting a single column from an array or iterable of
 * array/object rows.
 *
 * - Array in  → array of extracted values (unchanged behaviour via array_column).
 * - Generator/Traversable in → Generator that lazily yields the column value
 *   from each row. If `$key` is provided, each yielded pair is `rowKey => value`;
 *   otherwise sequential integer keys are used.
 *
 * @param string $column Column to retrieve.
 * @param string|null $key Column to use as the yielded key. Null = sequential ints.
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function column(string $column, ?string $key = null): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($column, $key) {
        if (is_array($source)) {
            return array_column($source, $column, $key);
        }
        return (function () use ($source, $column, $key) {
            foreach ($source as $row) {
                $value = null;
                if (is_array($row) && array_key_exists($column, $row)) {
                    $value = $row[$column];
                } elseif (is_object($row) && isset($row->{$column})) {
                    $value = $row->{$column};
                }
                if ($key === null) {
                    yield $value;
                    continue;
                }
                $rowKey = null;
                if (is_array($row) && array_key_exists($key, $row)) {
                    $rowKey = $row[$key];
                } elseif (is_object($row) && isset($row->{$key})) {
                    $rowKey = $row->{$key};
                }
                yield $rowKey => $value;
            }
        })();
    };
}

/**
 * Returns a Closure for flattening an array or iterable to a defined depth.
 *
 * - Array in  → array out (unchanged behaviour).
 * - Generator/Traversable in → Generator out that lazily recurses into nested
 *   arrays up to depth $n. Empty nested arrays are dropped.
 *
 * @param int|null $n Depth of nodes to flatten. If null will flatten fully.
 * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
 */
function flattenByN(?int $n = null): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int, mixed>|\Generator<int, mixed>
     */
    return function (iterable $source) use ($n) {
        if (is_array($source)) {
            return array_reduce(
                $source,
                /**
                 * @param array<int|string, mixed> $carry
                 * @param mixed|mixed[] $element
                 * @return array<int|string, mixed>
                 */
                function (array $carry, $element) use ($n): array {
                    // Remove empty arrays.
                    if (is_array($element) && empty($element)) {
                        return $carry;
                    }
                    // If the element is an array and we are still flattening, call again
                    if (is_array($element) && (is_null($n) || $n > 0)) { // @phpstan-ignore-line
                        // Recursion on an array hits the array path; narrow the widened
                        // array|Generator return back to array for array_merge.
                        $recursed = flattenByN($n ? $n - 1 : null)($element);
                        $carry    = array_merge($carry, is_array($recursed) ? $recursed : iterator_to_array($recursed));
                    } else {
                        // Else just add the element.
                        $carry[] = $element;
                    }
                    return $carry;
                },
                array()
            );
        }
        return (function () use ($source, $n) {
            foreach ($source as $element) {
                if (is_array($element) && empty($element)) {
                    continue;
                }
                if (is_array($element) && (is_null($n) || $n > 0)) {
                    foreach (flattenByN($n ? $n - 1 : null)($element) as $sub) {
                        yield $sub;
                    }
                } else {
                    yield $element;
                }
            }
        })();
    };
}

/**
 * Returns a closure for recursively replacing values in an array or iterable.
 * Terminal — Generator input is materialised first.
 *
 * @param mixed[] ...$with The array values to replace with
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function replaceRecursive(array ...$with): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] Array with replacements.
     */
    return function (iterable $source) use ($with): array {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return array_replace_recursive($array, ...$with);
    };
}

/**
 * Returns a Closure for changing values in a flat array or iterable, based on key.
 * Terminal — Generator input is materialised first.
 *
 * @param mixed[] ...$with Array with values to replace with, must have matching key with base array.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function replace(array ...$with): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] Array with replacements.
     */
    return function (iterable $source) use ($with): array {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return array_replace($array, ...$with);
    };
}

/**
 * Returns a Closure for summing the result of a callback applied to each element
 * of an array or iterable. Terminal — Generator input is materialised.
 *
 * @param callable(mixed):Number $function Applied to each value before summing.
 * @return Closure(iterable<int|string, mixed>):Number
 */
function sumWhere(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return Number The total.
     */
    return function (iterable $source) use ($function) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return array_sum(array_map($function, $array));
    };
}

/**
 * Creates a closure for casting an array or iterable into an object.
 * Assumes all properties are public; non-existing properties are set dynamically.
 * Terminal — Generator input is materialised first.
 *
 * @param object|null $object The object to cast to, defaults to stdClass.
 * @phpstan-param mixed $object
 * @return Closure(iterable<int|string, mixed>):object
 * @throws \InvalidArgumentException If property does not exist or is not public.
 */
function toObject($object = null): Closure
{
    $object = $object ?? new stdClass();

    // Throws an exception if $object is not an object.
    if (!is_object($object)) {
        throw new \InvalidArgumentException('Object must be an object.');
    }

    /**
     * @param iterable<int|string, mixed> $source
     * @return object
     */
    return function (iterable $source) use ($object) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        foreach ($array as $key => $value) {
            // If key is not a string or numerical, skip it.
            if (!is_string($key) || is_numeric($key)) {
                continue;
            }

            try {
                $object->{$key} = $value;
            } catch (\Throwable $th) {
                throw new \InvalidArgumentException("Property {$key} does not exist or is not public.");
            }
        }
        return $object;
    };
}

/**
 * Creates a closure for encoding json with defined flags/depth
 *
 * @param int $flags json_encode flags (default = 0)
 * @param int $depth Nodes deep to encode (default = 512)
 * @return \Closure(mixed):?string
 * @constants JSON_FORCE_OBJECT, JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP,
 *            JSON_HEX_APOS, JSON_INVALID_UTF8_IGNORE,
 *            JSON_INVALID_UTF8_SUBSTITUTE, JSON_NUMERIC_CHECK,
 *            JSON_PARTIAL_OUTPUT_ON_ERROR, JSON_PRESERVE_ZERO_FRACTION,
 *            JSON_PRETTY_PRINT, JSON_UNESCAPED_LINE_TERMINATORS,
 *            JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE, JSON_THROW_ON_ERROR
 */
function toJson(int $flags = 0, int $depth = 512): Closure
{
    /**
     * @param mixed $data
     * @return string|null
     */
    return function ($data) use ($flags, $depth): ?string {
        return \json_encode($data, $flags, max(1, $depth)) ?: null;
    };
}


/*
 *                         ****************
 *                         *  Array Sort  *
 *                         ****************
 */


/**
 * Returns a Closure for doing regular SORT against an array or iterable.
 * Doesn't maintain keys. Terminal — Generator input is materialised.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function sort(int $flag = SORT_REGULAR): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($flag) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \sort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for doing regular Reverse SORT against an array or iterable.
 * Doesn't maintain keys. Terminal — Generator input is materialised.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function rsort(int $flag = SORT_REGULAR): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($flag) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \rsort($array, $flag);
        return $array;
    };
}


/**
 * Returns a Closure for sorting an array or iterable by key in ascending order.
 * Terminal — Generator input is materialised.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function ksort(int $flag = SORT_REGULAR): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($flag) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \ksort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable by key in descending order.
 * Terminal — Generator input is materialised.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function krsort(int $flag = SORT_REGULAR): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($flag) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \krsort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable by value in ascending order.
 * Maintains keys. Terminal — Generator input is materialised.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function asort(int $flag = SORT_REGULAR): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($flag) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \asort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable by value in descending order.
 * Maintains keys. Terminal — Generator input is materialised.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function arsort(int $flag = SORT_REGULAR): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($flag) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \arsort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable with a "natural order" algorithm.
 * Terminal — Generator input is materialised.
 *
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function natsort(): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \natsort($array);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable with a case-insensitive
 * "natural order" algorithm. Terminal — Generator input is materialised.
 *
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function natcasesort(): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \natcasesort($array);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable by key using a custom comparator.
 * Terminal — Generator input is materialised.
 *
 * @param callable(mixed $a, mixed $b): int $function
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function uksort(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($function) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \uksort($array, $function);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array or iterable by value using a custom
 * comparator. Maintains keys. Terminal — Generator input is materialised.
 *
 * @param callable(mixed $a, mixed $b): int $function
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function uasort(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($function) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \uasort($array, $function);
        return $array;
    };
}


/**
 * Returns a Closure for sorting an array or iterable using a custom comparator.
 * Does not maintain keys. Terminal — Generator input is materialised.
 *
 * @param callable(mixed $a, mixed $b): int $function
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function usort(callable $function): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[] The sorted array (new array).
     */
    return function (iterable $source) use ($function) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        \usort($array, $function);
        return $array;
    };
}


/**
 * Returns a Closure for a left-scan (running fold) over an array or iterable.
 * Emits the initial value, then every intermediate accumulation.
 *
 * - Array in  → array out (unchanged behaviour).
 * - Generator/Traversable in → Generator out that yields the initial value
 *   first, then each running accumulation lazily.
 *
 * @param callable(mixed $carry, mixed $value):mixed $function
 * @param mixed $initialValue
 * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
 */
function scan(callable $function, $initialValue): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int, mixed>|\Generator<int, mixed>
     */
    return function (iterable $source) use ($function, $initialValue) {
        if (is_array($source)) {
            $carry[] = $initialValue;
            foreach ($source as $key => $value) {
                $initialValue = $function($initialValue, $value);
                $carry[]      = $initialValue;
            }
            return $carry;
        }
        return (function () use ($source, $function, $initialValue) {
            yield $initialValue;
            foreach ($source as $value) {
                $initialValue = $function($initialValue, $value);
                yield $initialValue;
            }
        })();
    };
}

/**
 * Returns a Closure for a right-scan (running fold from the right) over an array
 * or iterable. Emits every intermediate accumulation, finishing with the initial.
 *
 * - Array in  → array out (unchanged behaviour).
 * - Generator/Traversable in → the source is materialised to an array (reverse
 *   scan requires it), the scan is computed, then the results are re-yielded
 *   as a Generator for API consistency.
 *
 * @param callable(mixed $carry, mixed $value):mixed $function
 * @param mixed $initialValue
 * @return Closure(iterable<int|string, mixed>):(array<int, mixed>|\Generator<int, mixed>)
 */
function scanR(callable $function, $initialValue): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int, mixed>|\Generator<int, mixed>
     */
    return function (iterable $source) use ($function, $initialValue) {
        if (is_array($source)) {
            $carry[] = $initialValue;
            foreach (array_reverse($source) as $key => $value) {
                $initialValue = $function($initialValue, $value);
                $carry[]      = $initialValue;
            }
            return \array_reverse($carry);
        }
        return (function () use ($source, $function, $initialValue) {
            $materialised = iterator_to_array($source);
            $carry        = array($initialValue);
            foreach (array_reverse($materialised) as $value) {
                $initialValue = $function($initialValue, $value);
                $carry[]      = $initialValue;
            }
            foreach (array_reverse($carry) as $v) {
                yield $v;
            }
        })();
    };
}

/**
 * Creates a Closure that reduces an array or iterable left-to-right with an
 * initial accumulator. Terminal — Generator input is consumed fully via a
 * streaming foreach (no materialisation).
 *
 * @param callable(mixed $carry, mixed $value): mixed $callable
 * @param mixed $initial
 * @return Closure(iterable<int|string, mixed>):mixed
 */
function fold(callable $callable, $initial = array()): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed
     */
    return function (iterable $source) use ($callable, $initial) {
        if (is_array($source)) {
            return array_reduce($source, $callable, $initial);
        }
        foreach ($source as $value) {
            $initial = $callable($initial, $value);
        }
        return $initial;
    };
}

/**
 * Creates a Closure that reduces an array or iterable right-to-left with an
 * initial accumulator. Terminal — Generator input must be materialised to
 * reverse before reducing.
 *
 * @param callable(mixed $carry, mixed $value): mixed $callable
 * @param mixed $initial
 * @return Closure(iterable<int|string, mixed>):mixed
 */
function foldR(callable $callable, $initial = array()): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed
     */
    return function (iterable $source) use ($callable, $initial) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return array_reduce(\array_reverse($array), $callable, $initial);
    };
}

/**
 * Creates a Closure that reduces an array or iterable left-to-right with the
 * key passed to the callback alongside the value. Terminal — streams the
 * source via foreach (no materialisation needed).
 *
 * @param callable(mixed $carry, int|string $key, mixed $value): mixed $callable
 * @param mixed $initial
 * @return Closure(iterable<int|string, mixed>):mixed
 */
function foldKeys(callable $callable, $initial = array()): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed
     */
    return function (iterable $source) use ($callable, $initial) {
        foreach ($source as $key => $value) {
            $initial = $callable($initial, $key, $value);
        }
        return $initial;
    };
}

/**
 * Creates a function which takes the first n elements from an array or iterable.
 *
 * - Array in  → array of the first $count elements (unchanged behaviour).
 * - Generator/Traversable in → Generator that yields up to $count elements
 *   lazily. The source is NOT advanced beyond what was taken.
 *
 * @param int $count
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 * @throws \InvalidArgumentException if count is negative
 */
function take(int $count = 1): Closure
{
    if ($count < 0) {
        throw new \InvalidArgumentException(__FUNCTION__ . ' count must be greater than or equal to 0');
    }

    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($count) {
        if (is_array($source)) {
            return \array_slice($source, 0, $count);
        }
        return (function () use ($source, $count) {
            if ($count === 0) {
                return;
            }
            $taken = 0;
            foreach ($source as $key => $value) {
                yield $key => $value;
                $taken++;
                if ($taken >= $count) {
                    break;
                }
            }
        })();
    };
}

/**
 * Creates a function which takes the last N elements from an array or iterable.
 * Terminal — Generator input is materialised fully (the last N is only
 * knowable once the source has been consumed).
 *
 * @param int $count
 * @return Closure(iterable<int|string, mixed>):mixed[]
 * @throws \InvalidArgumentException if count is negative
 */
function takeLast(int $count = 1): Closure
{
    // throw InvalidArgumentException if count is negative
    if ($count < 0) {
        throw new \InvalidArgumentException(__FUNCTION__ . ' count must be greater than or equal to 0');
    }

    // If count is 0, return an empty array for any input.
    if ($count === 0) {
        return function (iterable $source) {
            return array();
        };
    }

    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[]
     */
    return function (iterable $source) use ($count) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return \array_slice($array, -$count);
    };
}

/**
 * Creates a function that takes elements from an array or iterable until the
 * conditional returns true (exclusive — the first truthy element is NOT included).
 *
 * - Array in  → array out (unchanged behaviour).
 * - Generator/Traversable in → Generator out, yields lazily, stops at the first
 *   truthy predicate. Source is not advanced past the stopping element.
 *
 * @param callable(mixed): bool $conditional
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function takeUntil(callable $conditional): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($conditional) {
        if (is_array($source)) {
            $carry = array();
            foreach ($source as $key => $value) {
                if (true === $conditional($value)) {
                    break;
                }
                $carry[$key] = $value;
            }
            return $carry;
        }
        return (function () use ($source, $conditional) {
            foreach ($source as $key => $value) {
                if (true === $conditional($value)) {
                    break;
                }
                yield $key => $value;
            }
        })();
    };
}

/**
 * Creates a function that takes elements from an array or iterable while the
 * conditional returns true. Stops at the first falsy predicate (exclusive).
 *
 * - Array in  → array out (unchanged behaviour).
 * - Generator/Traversable in → Generator out, yields lazily, stops at the first
 *   falsy predicate. Source is not advanced past the stopping element.
 *
 * @param callable(mixed): bool $conditional
 * @return Closure(iterable<int|string, mixed>):(array<int|string, mixed>|\Generator<int|string, mixed>)
 */
function takeWhile(callable $conditional): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return array<int|string, mixed>|\Generator<int|string, mixed>
     */
    return function (iterable $source) use ($conditional) {
        if (is_array($source)) {
            $carry = array();
            foreach ($source as $key => $value) {
                if (false === $conditional($value)) {
                    break;
                }
                $carry[$key] = $value;
            }
            return $carry;
        }
        return (function () use ($source, $conditional) {
            foreach ($source as $key => $value) {
                if (false === $conditional($value)) {
                    break;
                }
                yield $key => $value;
            }
        })();
    };
}

/**
 * Picks selected indexes from an array or iterable.
 * Terminal — Generator input is materialised first.
 *
 * @param string ...$indexes
 * @return Closure(iterable<int|string, mixed>):mixed[]
 */
function pick(string ...$indexes): Closure
{
    /**
     * @param iterable<int|string, mixed> $source
     * @return mixed[]
     */
    return function (iterable $source) use ($indexes) {
        $array = is_array($source) ? $source : iterator_to_array($source);
        return array_intersect_key($array, array_flip($indexes));
    };
}
