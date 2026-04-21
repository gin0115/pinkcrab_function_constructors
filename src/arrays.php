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
 * Creates a Closure for concatenating arrays with a defined glue.
 *
 * @param string|null $glue The string to join each element. If null, will be no separation between elements.
 * @return Closure(array<int|string, mixed>):string
 *
 */
function toString(?string $glue = null): Closure
{
    /**
     * @param array<int|string, mixed> $array Array join
     * @return string
     */
    return function (array $array) use ($glue): string {
        return $glue ? \join($glue, $array) : \join($array);
    };
}

/**
 * Creates a Closure for zipping 2 arrays.
 *
 * @param array<mixed> $additional Values with the same key will be paired.
 * @param mixed $default The fallback value if the additional array doesn't have the same length
 * @return Closure(array<mixed>):array<array{mixed, mixed}>
 *
 */
function zip(array $additional, $default = null): Closure
{
    $additional = array_values($additional);
    return function (array $array) use ($additional, $default) {
        $array = array_values($array);
        return array_reduce(
            array_keys($array),
            function ($carry, $key) use ($array, $additional, $default): array {
                $carry[] = array(
                    $array[$key],
                    array_key_exists($key, $additional) ? $additional[$key] : $default,
                );
                return $carry;
            },
            array()
        );
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
 * Creates a Closure for running array filter and getting the last value.
 *
 * @param callable $func
 * @return Closure(array<int|string, mixed>):?mixed
 */
function filterLast(callable $func): Closure
{
    /**
     * @param array<int|string, mixed> $array The array to filter
     * @return mixed|null The last element from the filtered array.
     */
    return function (array $array) use ($func) {
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
 * Runs an array through a filters, returns the total count of true
 *
 * @param callable $function
 * @return Closure(array<int|string, mixed>):int
 */
function filterCount(callable $function): Closure
{
    /**
     * @param array<int|string, mixed> $array
     * @return int Count
     */
    return function (array $array) use ($function) {
        return count(array_filter($array, $function));
    };
}

/**
 * Returns a Closure for partitioning an array based
 * on the results of a filter type function.
 * Callable will be cast to a bool, if truthy will be listed under 1 key, else 0 for falsey
 *
 * @param callable(mixed):(bool|int) $function
 * @return Closure(mixed[]):array{0:mixed[], 1:mixed[]}
 */
function partition(callable $function): Closure
{
    /**
     * @param mixed[] $array
     * @return array{0:mixed[], 1:mixed[]}
     */
    return function (array $array) use ($function): array {
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
 * Returns a Closure foreaching over an array
 *
 * @param callable(int|string $key, mixed $value):void $func
 * @return Closure(mixed[]):void
 */
function each(callable $func): Closure
{
    /**
     * @param mixed[] $array The array to map
     * @return void
     */
    return function (array $array) use ($func): void {
        array_map(
            function ($key, $value) use ($func) {
                $func($key, $value);
            },
            array_keys($array),
            $array
        );
    };
}

/**
 * Returns a Closure for flattening and mapping an array
 *
 * @param callable(mixed):mixed $function The function to map the element. (Will no be called if resolves to array)
 * @param int|null $n Depth of nodes to flatten. If null will flatten to n
 * @return Closure(mixed[]):mixed[]
 */
function flatMap(callable $function, ?int $n = null): Closure
{
    /**
     * @param mixed[] $array
     * @return mixed[]
     */
    return function (array $array) use ($n, $function): array {
        return array_reduce(
            $array,
            /**
             * @param mixed[] $carry
             * @param mixed $element
             * @return mixed[]
             */
            function (array $carry, $element) use ($n, $function): array {
                if (is_array($element) && (is_null($n) || $n > 0)) {
                    $carry = array_merge($carry, flatMap($function, $n ? $n - 1 : null)($element));
                } else {
                    $carry[] = is_array($element) ? $element : $function($element);
                }
                return $carry;
            },
            array()
        );
    };
}

/*
 *                         **********************
 *                         * General Operations *
 *                         **********************
 */


/**
 * Creates a Closure for grouping an array.
 *
 * @param callable(mixed):(string|int) $function The function to group by.
 * @return Closure(mixed):mixed[]
 */
function groupBy(callable $function): Closure
{
    /**
     * @param mixed[] $array The array to be grouped
     * @return mixed[] Grouped array.
     */
    return function (array $array) use ($function): array {
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
 * Creates a Closure for chunking an array to set a limit.
 *
 * @param int $count The max size of each chunk. Must not be less than 1!
 * @param bool $preserveKeys Should inital keys be kept. Default false.
 * @return Closure(mixed[]):mixed[]
 */
function chunk(int $count, bool $preserveKeys = false): Closure
{
    /**
     * @param mixed[] $array Array to chunk
     * @return mixed[]
     */
    return function (array $array) use ($count, $preserveKeys): array {
        return array_chunk($array, max(1, $count), $preserveKeys);
    };
}

/**
 * Create callback for extracting a single column from an array.
 *
 * @param string $column Column to retrieve.
 * @param string $key Use column for assigning as the index. defaults to numeric keys if null.
 * @return Closure(mixed[]):mixed[]
 */
function column(string $column, ?string $key = null): Closure
{
    /**
     * @param mixed[] $array
     * @return mixed[]
     */
    return function (array $array) use ($column, $key): array {
        return array_column($array, $column, $key);
    };
}

/**
 * Returns a Closure for flattening an array to a defined depth
 *
 * @param int|null $n Depth of nodes to flatten. If null will flatten to n
 * @return Closure(mixed[] $var): mixed[]
 */
function flattenByN(?int $n = null): Closure
{
    /**
     * @param mixed[] $array Array to flatten
     * @return mixed[]
     */
    return function (array $array) use ($n): array {
        return array_reduce(
            $array,
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
                    $carry = array_merge($carry, flattenByN($n ? $n - 1 : null)($element));
                } else {
                    // Else just add the element.
                    $carry[] = $element;
                }
                return $carry;
            },
            array()
        );
    };
}

/**
 * Returns a closure for recursively changing values in an array.
 *
 * @param mixed[] ...$with The array values to replace with
 * @return Closure(mixed[]):mixed[]
 */
function replaceRecursive(array ...$with): Closure
{
    /**
     * @param mixed[] $array The array to have elements replaced from.
     * @return mixed[] Array with replacements.
     */
    return function (array $array) use ($with): array {
        return array_replace_recursive($array, ...$with);
    };
}

/**
 * Returns a Closure for changing all values in a flat array, based on key.
 *
 * @param mixed[] ...$with Array with values to replace with, must have matching key with base array.
 * @return Closure(mixed[]):mixed[]
 */
function replace(array ...$with): Closure
{
    /**
     * @param mixed[] $array The array to have elements replaced from.
     * @return mixed[] Array with replacements.
     */
    return function (array $array) use ($with): array {
        return array_replace($array, ...$with);
    };
}

/**
 * Returns a Closure for doing array_sum with the results of a function/expression.
 *
 * @param callable(mixed):Number $function The function to return the value for array sum
 * @return Closure(mixed[]):Number
 */
function sumWhere(callable $function): Closure
{
    /**
     * @param mixed[] $array Array to do sum() on.
     * @return Number The total.
     */
    return function (array $array) use ($function) {
        return array_sum(array_map($function, $array));
    };
}

/**
 * Creates a closure for casting an array to an object.
 * Assumed all properties are public
 * None existing properties will be set as dynamic properties.
 *
 * @param object|null $object The object to cast to, defaults to stdClass
 * @phpstan-param mixed $object
 * @return Closure(mixed[]):object
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
     * @param mixed[] $array
     * @return object
     */
    return function (array $array) use ($object) {
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
 * Returns a Closure for doing regular SORT against an array.
 * Doesn't maintain keys.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(mixed[]):mixed[]
 */
function sort(int $flag = SORT_REGULAR): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \sort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for doing regular Reverse SORT against an array.
 * Doesn't maintain keys.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(mixed[]):mixed[]
 */
function rsort(int $flag = SORT_REGULAR): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \rsort($array, $flag);
        return $array;
    };
}


/**
 * Returns a Closure for sorting an array by key in ascending order.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(mixed[]):mixed[]
 */
function ksort(int $flag = SORT_REGULAR): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \ksort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array by key in descending (reverse) order.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(mixed[]):mixed[]
 */
function krsort(int $flag = SORT_REGULAR): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \krsort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array by value in ascending order.
 * Maintain keys.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(mixed[]):mixed[]
 */
function asort(int $flag = SORT_REGULAR): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \asort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array by value in descending (reverse) order.
 * Maintain keys.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return Closure(mixed[]):mixed[]
 */
function arsort(int $flag = SORT_REGULAR): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \arsort($array, $flag);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array using a "natural order" algorithm
 *
 * @return Closure(mixed[]):mixed[]
 */
function natsort(): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) {
        \natsort($array);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array using a case insensitive "natural order" algorithm
 *
 * @return Closure(mixed[]):mixed[]
 */
function natcasesort(): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) {
        \natcasesort($array);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array by key using a custom comparison function
 *
 * @param callable(mixed $a, mixed $b): int $function
 * @return Closure(mixed[]):mixed[]
 */
function uksort(callable $function): Closure
{
    /**
     *  @param mixed[] $array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($function) {
        \uksort($array, $function);
        return $array;
    };
}

/**
 * Returns a Closure for sorting an array using a custom comparison function
 * Maintain keys.
 *
 * @param callable(mixed $a, mixed $b): int $function
 * @return Closure(mixed[]):mixed[]
 */
function uasort(callable $function): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($function) {
        \uasort($array, $function);
        return $array;
    };
}


/**
 * Returns a Closure for sorting an array using a custom comparison function
 * Doesn't maintain keys.
 *
 * @param callable(mixed $a, mixed $b): int $function
 * @return Closure(mixed[]):mixed[]
 */
function usort(callable $function): Closure
{
    /**
     *  @param mixed[]$array The array to sort
     *  @return mixed[] The sorted array (new array)
     */
    return function (array $array) use ($function) {
        \usort($array, $function);
        return $array;
    };
}


/**
 * Returns a Closure for applying a function to every element of an array
 *
 * @param callable(mixed $carry, mixed $value):mixed $function
 * @param mixed $initialValue
 * @return Closure(mixed[]):mixed[]
 */
function scan(callable $function, $initialValue): Closure
{
    return function (array $array) use ($function, $initialValue) {
        $carry[] = $initialValue;
        foreach ($array as $key => $value) {
            $initialValue = $function($initialValue, $value);
            $carry[]      = $initialValue;
        }
        return $carry;
    };
}

/**
 * Returns a Closure for applying a function to every element of an array
 *
 * @param callable(mixed $carry, mixed $value):mixed $function
 * @param mixed $initialValue
 * @return Closure(mixed[]):mixed[]
 */
function scanR(callable $function, $initialValue): Closure
{
    return function (array $array) use ($function, $initialValue) {
        $carry[] = $initialValue;
        foreach (array_reverse($array) as $key => $value) {
            $initialValue = $function($initialValue, $value);
            $carry[]      = $initialValue;
        }
        return \array_reverse($carry);
    };
}

/**
 * Creates a function for defining the callback and initial for reduce/fold
 *
 * @param callable(mixed $carry, mixed $value): mixed $callable
 * @param mixed $initial
 * @return Closure(mixed[]):mixed
 */
function fold(callable $callable, $initial = array()): Closure
{
    /**
     * @param mixed[] $array
     * @return mixed
     */
    return function (array $array) use ($callable, $initial) {
        return array_reduce($array, $callable, $initial);
    };
}

/**
 * Creates a function for defining the callback and initial for reduce/fold
 *
 * @param callable(mixed $carry, mixed $value): mixed $callable
 * @param mixed $initial
 * @return Closure(mixed[]):mixed
 */
function foldR(callable $callable, $initial = array()): Closure
{
    /**
     * @param mixed[] $array
     * @return mixed
     */
    return function (array $array) use ($callable, $initial) {
        return array_reduce(\array_reverse($array), $callable, $initial);
    };
}

/**
 * Creates a function for defining the callback and initial for reduce/fold, with the key
 * also passed to the callback.
 *
 * @param callable(mixed $carry, int|string $key, mixed $value): mixed $callable
 * @param mixed $initial
 * @return Closure(mixed[]):mixed
 */
function foldKeys(callable $callable, $initial = array()): Closure
{
    /**
     * @param mixed[] $array
     * @return mixed
     */
    return function (array $array) use ($callable, $initial) {
        foreach ($array as $key => $value) {
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
 * Creates a function which takes the last n elements from an array
 *
 * @param int $count
 * @return Closure(mixed[]):mixed[]
 * @throws \InvalidArgumentException if count is negative
 */
function takeLast(int $count = 1): Closure
{
    // throw InvalidArgumentException if count is negative
    if ($count < 0) {
        throw new \InvalidArgumentException(__FUNCTION__ . ' count must be greater than or equal to 0');
    }

    // If count is 0, return an empty array
    if ($count === 0) {
        return function (array $array) {
            return array();
        };
    }

    /**
     * @param mixed[] $array
     * @return mixed[]
     */
    return function (array $array) use ($count) {
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
 * Picks selected indexes from an array
 *
 * @param string ...$indexes
 * @return Closure(mixed[]):mixed[]
 */
function pick(string ...$indexes): Closure
{
    /**
     * @param mixed[] $array
     * @return mixed[]
     */
    return function (array $array) use ($indexes) {
        return array_intersect_key($array, array_flip($indexes));
    };
}
