<?php

declare(strict_types=1);

/**
 * Composeable array functions.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\FunctionConstructors
 */

namespace PinkCrab\FunctionConstructors\Arrays;

use stdClass;
use PinkCrab\FunctionConstructors\Comparisons as Comp;

/**
 * Returns a callback for pushing a value to the head of an array
 *
 * Array[A] -> ( B -> Array[B,A] )
 *
 * @param array<int|string, mixed> $array
 * @return callable
 */
function pushHead(array $array): callable
{
    /**
     * @param mixed $value Adds value start of array.
     * @return array New array with value on head.
     */
    return function ($value) use ($array): array {
        array_unshift($array, $value);
        return $array;
    };
}

/**
 * Returns a callback for pushing a value to the head of an array
 *
 * Array[A] -> ( B -> Array[B,A] )
 *
 * @param array<int|string, mixed> $array
 * @return callable
 */
function pushTail(array $array): callable
{
    /**
     * @param mixed $value Adds value end of array.
     * @return array New array with value on tail.
     */
    return function ($value) use ($array): array {
        $array[] = $value;
        return $array;
    };
}

/**
 * Gets the first value from an array.
 *
 * Array -> A
 *
 * @param array<int|string, mixed> $array The array.
 * @return mixed Will return the first value is array is not empty, else null.
 */
function head(array $array)
{
    return !empty($array) ? array_values($array)[0] : null;
}

/**
 * Gets the last value from an array.
 *
 * Array -> A
 *
 * @param array<int|string, mixed> $array
 * @return mixed Will return the last value is array is not empty, else null.
 */
function tail(array $array)
{
    return !empty($array) ? array_reverse($array, false)[0] : null;
}


/**
 * Returns a callable for concatinatiing arrays with a defined glue.
 *
 * String|Null -> ( Array[String] -> String )
 *
 * @param string|null $glue The string to join each element. If null, will be no seperation between elements.
 * @return callable
 *
 */
function toString(?string $glue = null): callable
{
    /**
     * @param array<int|string, mixed> $array Array join
     * @return string.
     */
    return function (array $array) use ($glue): string {
        return $glue ? \join($glue, $array) : \join($array) ;
    };
}

/**
 * Returns a callable for zipping 2 arrays.
 *
 * Array -> Mixed -> ( Array -> Array )
 *
 * @param array<mixed> $additional Values with the same key will be paried.
 * @param mixed $default The fallback value if the addtional array doesnt have the same length
 * @return callable(array<mixed>):array<array{mixed, mixed}>
 *
 */
function zip(array $additional, $default = null): callable
{
    $additional = array_values($additional);
    return function (array $array) use ($additional, $default) {
        $array = array_values($array);
        return array_reduce(
            array_keys($array),
            function ($carry, $key) use ($array, $additional, $default): array {
                $carry[] = [
                    $array[$key],
                    array_key_exists($key, $additional) ? $additional[$key] : $default
                ];
                return $carry;
            },
            []
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
 * Reutrns the array if nothing passed.
 *
 * Array -> ( A|Null ) -> ( A|Null )|Array[A]
 *
 * @param array<int|string, mixed> $inital Sets up the inner value.
 * @return callable
 */
function arrayCompiler(array $inital = []): callable
{
    /**
     * @param mixed $value Adds value to inner array if value set, else reutrns.
     * @return callable|mixed Will reutrn a new callable if value passed, else contents.
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
 * Validates the intial array passed also.
 *
 * ( A -> Bool ) -> Array ->  ( A|Null ) ->  ( A|Null )|Array[A]
 *
 * @param callable $validator (mixed->bool)
 * @param array<int|string, mixed> $inital The intial data to start with
 * @return callable
 */
function arrayCompilerTyped(callable $validator, array $inital = []): callable
{
    // Ensure all is validated from initial.
    $inital = array_filter($inital, $validator);

    /**
     * @param mixed $value
     * @return callable|array
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
 * Use array_filter as a patial.
 *
 * @param callable $callable The function to apply to the array.
 * @return callable
 * @annotation : ( A -> Bool ) -> ( Array[AB] -> Array[A|Empty] )
 */
function filter(callable $callable): callable
{
    /**
     * @param array<int|string, mixed> $source Array to filter
     * @return array Filtered array.
     */
    return function (array $source) use ($callable): array {
        return array_filter($source, $callable);
    };
}

/**
 * Use array_filter as keys as a patial.
 *
 * @param callable $callable The function to apply to the array.
 * @return callable
 * @annotation : ( A -> Bool ) -> ( Array[AB] -> Array[A|Empty] )
 */
function filterKey(callable $callable): callable
{
    /**
     * @param array<int|string, mixed> $source Array to filter
     * @return array Filtered array.
     */
    return function (array $source) use ($callable): array {
        return array_filter($source, $callable, \ARRAY_FILTER_USE_KEY);
    };
}


/**
 * Creates a callback for running an array through various callbacks for all true response.
 * Wrapper for creating a AND group of callbacks and running through array filter.
 *
 * ...( A -> Bool ) -> ( Array[AB] -> Array[A|Empty] )
 *
 * @param callable ...$callables
 * @return callable
 */
function filterAnd(callable ...$callables): callable
{
    /**
     * @param array<int|string, mixed> $source Array to filter
     * @return array Filtered array.
     */
    return function (array $source) use ($callables): array {
        return array_filter($source, Comp\groupAnd(...$callables));
    };
}

/**
 * Creates a callback for running an array through various callbacks for any true response.
 * Wrapper for creating a OR group of callbacks and running through array filter.
 *
 *  ...( A -> Bool ) -> ( Array[AB] -> Array[A|Empty] )
 *
 * @param callable ...$callables
 * @return callable
 */
function filterOr(callable ...$callables): callable
{
    /**
     * @param array<int|string, mixed> $source Array to filter
     * @return array Filtered array.
     */
    return function (array $source) use ($callables): array {
        return array_filter($source, Comp\groupOr(...$callables));
    };
}

/**
 * Returns a callable for running array filter and getting the first value.
 *
 * ( A -> Bool ) -> ( Array[AB] -> A|Null )
 *
 * @param callable $func
 * @return callable
 */
function filterFirst(callable $func): callable
{
    /**
     * @param array<int|string, mixed> $array The array to filter
     * @return mixed|null The first element from the filtered array or null if filter returns empty
     */
    return function (array $array) use ($func) {
        return head(array_filter($array, $func));
    };
}

/**
 * Returns a callable for running array filter and getting the last value.
 *
 * ( A -> Bool ) -> ( Array[AB]  -> A|Null )
 *
 * @param callable $func
 * @return callable
 */
function filterLast(callable $func): callable
{
    /**
     * @param array<int|string, mixed> $array The array to filter
     * @return mixed|null The last element from the filtered array.
     */
    return function (array $array) use ($func) {
        return tail(array_filter($array, $func));
    };
}

/**
 * Returns a callable which takes an array, applies a filter, then maps the
 * results of the map.
 *
 * ( A -> Bool ) -> ( a -> b ) -> ( Array[A|b] -> array[b|null] )
 *
 * @param callable $filter Function to of filter contents
 * @param callable $map Function to map results of filter funciton.
 * @return callable
 */
function filterMap(callable $filter, callable $map): callable
{
    /**
     * @param array<int|string, mixed> $array The arry to filter then map.
     * @return array
     */
    return function (array $array) use ($filter, $map): array {
        return array_map($map, array_filter($array, $filter));
    };
}

/**
 * Runs an array through a filters, returns the total count of true
 *
 * ( A -> Bool ) -> ( Array[A] -> Int )
 *
 * @param callable $function
 * @return callable
 */
function filterCount(callable $function): callable
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
 * Returns a callback for partitioning an array based
 * on the results of a filter type function.
 * Callable will be cast to a bool, if truthy will be listed under 1 key, else 0 for falsey
 *
 * ( A|B -> Bool ) -> ( Array[A|B] -> Array[Array[A][B]] )
 *
 * @param callable $function
 * @return callable
 */
function partition(callable $function): callable
{
    return function (array $array) use ($function): array {
        return array_reduce(
            $array,
            function ($carry, $element) use ($function): array {
                $key = (bool)$function($element) ? 1 : 0;
                $carry[$key][] = $element;
                return $carry;
            },
            []
        );
    };
}





/*
 *                           *****************
 *                           * Map Functions *
 *                           *****************
 */



/**
 * Returns a callback which can be passed an array.
 *
 * @param callable $func Callback to apply to each element in array.
 * @return callable
 * @annotation : ( a -> b ) -> ( Array[A] -> array[b] )
 */
function map(callable $func): callable
{
    /**
     * @param array<int|string, mixed> $array The array to map
     * @return array
     */
    return function (array $array) use ($func): array {
        return array_map($func, $array);
    };
}

/**
 * Returns a callback for mapping of an arrays keys.
 *
 * Setting the key to an existing index will overwerite the current value at same index.
 *
 * ( a -> b ) -> ( array -> array )
 *
 * @param callable $func
 * @return callable{
 */
function mapKey(callable $func): callable
{
    return function (array $array) use ($func): array {
        return array_reduce(
            array_keys($array),
            function ($carry, $key) use ($func, $array) {
                $carry[$func($key)] = $array[$key];
                return $carry;
            },
            []
        );
    };
}

/**
 * Returns a callback for mapping an array with additonal data.
 *
 *  ( A -> Array[B] ) -> ...B  -> ( Array[A] -> Array[AB] )
 *
 * @param callable $func
 * @param mixed ...$data
 * @return callable
 */
function mapWith(callable $func, ...$data): callable
{
    return function (array $array) use ($func, $data): array {
        return array_map(
            function ($e) use ($data, $func) {
                return $func($e, ...$data);
            },
            $array
        );
    };
}

/**
 * Returns a callback for flattening and mapping an array
 *
 * ( A -> B ) -> Int|Null  -> ( Array[][A] -> Array[B] )
 *
 * @param callable $function The function to map the element. (Will no be called if resolves to array)
 * @param int|null $n Depth of nodes to flatten. If null will flatten to n
 * @return callable{
 */
function flatMap(callable $function, ?int $n = null): callable
{
    /**
     * @param array<int|string, mixed> $array
     * @return array
     */
    return function (array $array) use ($n, $function): array {
        return array_reduce(
            $array,
            function (array $carry, $element) use ($n, $function) {
                if (is_array($element) && (is_null($n) || $n > 0)) {
                    $carry = array_merge($carry, flatMap($function, $n ? $n - 1 : null)($element));
                } else {
                    $carry[] = is_array($element) ? $element : $function($element);
                }
                return $carry;
            },
            []
        );
    };
}

/*
 *                         **********************
 *                         * General Operations *
 *                         **********************
 */


/**
 * Creates a callback for grouping an array.
 *
 * @param callable $function
 * @return callable
 * @annotation : (array -> a) -> ( array -> array )
 */
function groupBy(callable $function): callable
{
    /**
     * @param array<int|string, mixed> $array The array to be grouped
     * @return array Grouped array.
     */
    return function (array $array) use ($function): array {
        return array_reduce(
            $array,
            function ($carry, $item) use ($function) {
                $carry[call_user_func($function, $item)][] = $item;
                return $carry;
            },
            []
        );
    };
}

/**
 * Creates a callback for chunking an array to set a limit.
 *
 * Int -> Bool  -> ( Array[A] -> Array[][A] )
 *
 * @param int $count The max size of each chunk. Must not be less than 1!
 * @param bool $preserveKeys Should inital keys be kept. Default false.
 * @return callable
 */
function chunk(int $count, bool $preserveKeys = false): callable
{

    /**
     * @param array<int|string, mixed> $array Array to chunk
     * @return array
     */
    return function (array $array) use ($count, $preserveKeys): array {
        return array_chunk($array, max(1, $count), $preserveKeys);
    };
}

/**
 * Create callback for extracting a single column from an array.
 *
 * @param string $column Column to retirve.
 * @param string $key Use column for assigning as the index. defaults to numeric keys if null.
 * @return callable
 * @annotation : ( string -> string|null ) -> ( array -> array )
 */
function column(string $column, ?string $key = null): callable
{
    /**
     * @param array<int|string, mixed> $array
     * @return array
     */
    return function (array $array) use ($column, $key): array {
        return array_column($array, $column, $key);
    };
}

/**
 * Returns a callback for flattening an array to a defined depth
 *
 * @param int|null $n Depth of nodes to flatten. If null will flatten to n
 * @return callable(array<int|string, mixed|array> $var): array<int|string, mixed|array>
 * @annotation : ( int|null ) -> ( array -> array )
 */
function flattenByN(?int $n = null): callable
{
    /**
     * @param array<int|string, mixed|array> $array Array to flatten
     * @return array
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
                    // Else just add the elememnt.
                    $carry[] = $element;
                }
                return $carry;
            },
            []
        );
    };
}

/**
 * Returns a callaback for recursivly channging values in an array.
 *
 * @param array<int|string, mixed> ...$with The array values to replace with
 * @return callable
 * @annotation :  ( ...array[b] ) -> ( Array[A] -> Array[A|b] )
 */
function replaceRecursive(array ...$with): callable
{
    /**
     * @param array<int|string, mixed> $array The array to have elements replaced from.
     * @return array Array with replacements.
     */
    return function (array $array) use ($with): array {
        return array_replace_recursive($array, ...$with);
    };
}

/**
 * Returns a callaback for chaning all values in a flat array, based on key.
 *
 * @param array<int|string, mixed> ...$with Array with values to replace with, must have matching key with base array.
 * @return callable
 * @annotation :  ( array[b] ) -> ( Array[A] -> Array[A|b] )
 */
function replace(array ...$with): callable
{
    /**
     * @param array<int|string, mixed> $array The array to have elements replaced from.
     * @return array Array with replacements.
     */
    return function (array $array) use ($with) {
        return array_replace($array, ...$with);
    };
}

/**
 * Returns a callback for doing array_sum with the results of a function/expression.
 *
 * @param callable $function The function to return the value for array sum
 * @return callable
 * @annotation : ( a -> int|float ) -> ( array -> int|float )
 */
function sumWhere(callable $function): callable
{
    /**
     * @param array<int|string, mixed> $array Array to do sum() on.
     * @return int|float The total.
     */
    return function (array $array) use ($function) {
        return array_sum(array_map($function, $array));
    };
}

/**
 * Creates a closure for casting an arry to an object.
 * Assumed all properties are public
 * None existing properties will be set as dynamic properties.
 *
 * A -> ( Array[B] -> AB )
 *
 * @param object $object The object to cast to, defaults to stdClass
 * @return callable
 */
function toObject(?object $object = null): callable
{
    $object = $object ?? new stdClass();

    /**
     * @param array<int|string, mixed> $array
     * @return object
     */
    return function (array $array) use ($object): object {
        foreach ($array as $key => $value) {
            $key = is_string($key) ? $key : (string) $key;
            $object->{$key} = $value;
        }
        return $object;
    };
}

/**
 * Creates a closure for encoding json with defined flags/depth
 *
 * Int -> Int -> ( A -> String )
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
function toJson(int $flags = 0, int $depth = 512): callable
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
 * Returns a callback for doing regular SORT again an array.
 *
 * @param int $flag Uses php stock sort constants or numerical values.
 * @return callable
 */
function sort(int $flag = SORT_REGULAR): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \sort($array, $flag);
        return $array;
    };
}

function rsort(int $flag = SORT_REGULAR): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \rsort($array, $flag);
        return $array;
    };
}

function asort(int $flag = SORT_REGULAR): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \asort($array, $flag);
        return $array;
    };
}

function krsort(int $flag = SORT_REGULAR): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \krsort($array, $flag);
        return $array;
    };
}

function ksort(int $flag = SORT_REGULAR): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \ksort($array, $flag);
        return $array;
    };
}

function arsort(int $flag = SORT_REGULAR): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($flag) {
        \arsort($array, $flag);
        return $array;
    };
}

function natsort(): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) {
        \natsort($array);
        return $array;
    };
}

function natcasesort(): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) {
        \natcasesort($array);
        return $array;
    };
}

function uksort(callable $function): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($function) {
        \uksort($array, $function);
        return $array;
    };
}

function uasort(callable $function): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($function) {
        \uasort($array, $function);
        return $array;
    };
}

function usort(callable $function): callable
{
    /**
     *  @param array<int|string, mixed> $array The array to sort
     *  @return array The sorted array (new array)
     */
    return function (array $array) use ($function) {
        \usort($array, $function);
        return $array;
    };
}
