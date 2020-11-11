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
 * @package PinkCrab\PinkCrab\FunctionConstructors
 */

namespace PinkCrab\FunctionConstructors\Arrays;

use PinkCrab\FunctionConstructors\Comparisons as Comp;


/**
 * Returns a callback for pushing a value to the head of an array
 *
 * @param array $array
 * @return callable{
 *      @param mixed $value Adds value start of array.
 *      @return array New array with value on head.
 * }
 */
function pushHead( array $array ): callable {
	return function( $value ) use ( $array ): array {
		$array   = array_reverse( $array );
		$array[] = $value;
		return array_reverse( $array );
	};
}

/**
 * Returns a callback for pushing a value to the head of an array
 *
 * @param array $array
 * @return callable{
 *      @param mixed $value Adds value end of array.
 *      @return array New array with value on tail.
 * }
 */
function pushTail( array $array ): callable {
	return function( $value ) use ( $array ): array {
		$array[] = $value;
		return $array;
	};
}

/**
 * Compiles an array if a value is passed.
 * Reutrns the array if nothing passed.
 *
 * @param array $array Sets up the inner value.
 * @return callable{
 *      @param mixed $value Adds value to inner array if value set, else reutrns.
 *      @return callable|mixed Will reutrn a new callable if value passed, else contents.
 * }
 */
function arrayCompiler( array $array = array() ): callable {
	return function( $value = null ) use ( $array ) {
		if ( $value ) {
			$array[] = $value;
		}
		return $value ? arrayCompiler( $array ) : $array;
	};
};

/**
 * Returns a callback for mapping of an arrays keys.
 * Setting the key to an existing index will overwerite the current value at same index.
 *
 * @param callable $func
 * @return callable{
 *      @param array $array
 *      @return array
 * }
 */
function mapKey( callable $func ): callable {
	return function( array $array ) use ( $func ): array {
		return array_reduce(
			array_keys( $array ),
			function( $carry, $key ) use ( $func, $array ) {
				$carry[ $func( $key ) ] = $array[ $key ];
				return $carry;
			},
			array()
		);
	};
}

/**
 * Returns a callback which can be passed an array.
 *
 * @param callable $func
 * @return callable{
 *      @param array $array
 *      @return array
 * }
 */
function map( callable $func ): callable {
	return function( array $array ) use ( $func ): array {
		return array_map( $func, $array );
	};
}

/**
 * Returns a callback for mapping an array with additonal data.
 *
 * @param callable $func
 * @return callable{
 *      @param array $array
 *      @param mixed ...$data
 *      @return array
 * }
 */
function mapWith( callable $func, ...$data ): callable {
	return function( array $array ) use ( $func, $data ): array {
		return array_map(
			function( $e ) use ( $data, $func ) {
				return $func( $e, ...$data );
			},
			$array
		);
	};
}

/**
 * Creates a callback for running an array through various callbacks for all true response.
 * Wrapper for creating a AND group of callbacks and running through array filter.
 *
 * @param callable ...$callables
 * @return callable{
 *      @param mixed $source
 *      @return bool
 * }
 */
function filterAnd( callable ...$callables ): callable {
	return function( $source ) use ( $callables ) {
		return array_filter( $source, Comp\groupAnd( ...$callables ) );
	};
}

/**
 * Creates a callback for running an array through various callbacks for any true response.
 * Wrapper for creating a OR group of callbacks and running through array filter.
 *
 * @param callable ...$callables
 * @return callable{
 *      @param mixed $source
 *      @return bool
 * }
 */
function filterOr( callable ...$callables ): callable {
	return function( $source ) use ( $callables ) {
		return array_filter( $source, Comp\groupOr( ...$callables ) );
	};
}

/**
 * Returns a callable for running array filter and getting the first value.
 *
 * @param callable $func
 * @return callable{
 *      @param array $array
 *      @return mixed
 * }
 */
function filterFirst( callable $func ): callable {
	return function( array $array ) use ( $func ) {
		return first( array_filter( $array, $func ) );
	};
}

/**
 * Returns a callable for running array filter and getting the last value.
 *
 * @param callable $func
 * @return callable{
 *      @param array $array
 *      @return mixed
 * }
 */
function filterLast( callable $func ): callable {
	return function( array $array ) use ( $func ) {
		return last( array_filter( $array, $func ) );
	};
}

/**
 * Gets the first value from an array.
 *
 * @param array $array The array.
 * @return mixed Will return the first value is array is not empty, else null.
 */
function first( array $array ) {
	return ! empty( $array ) ? array_values( $array )[0] : null;
}

/**
 * Gets the last value from an array.
 *
 * @param array $array
 * @return mixed Will return the last value is array is not empty, else null.
 */
function last( array $array ) {
	return ! empty( $array ) ? array_reverse( $array, false )[0] : null;
}

/**
 * Creates a callback for grouping an array.
 *
 * @param callable ...$callables
 * @return callable{
 *      @param array $source
 *      @return bool
 * }
 */
function groupBy( callable $function ): callable {
	return function( array $array ) use ( $function ): array {
		return array_reduce(
			$array,
			function( $carry, $item ) use ( $function ) {
				$carry[ call_user_func( $function, $item ) ][] = $item;
				return $carry;
			},
			array()
		);
	};
}

/**
 * Creates a callback for chunking an array to set a limit.
 *
 * @param int $count The max size of each chunk.
 * @param bool $preserveKeys Should inital keys be kept. Default false.
 * @return callable{
 *      @param array $array The array to chunk
 *      @return array
 * }
 */
function chunk( int $count, bool $preserveKeys = false ): callable {
	return function( array $array ) use ( $count, $preserveKeys ) {
		return array_chunk( $array, $count, $preserveKeys );
	};
}

/**
 * Create callback for extracting a single column from an array.
 *
 * @param string $column Column to retirve.
 * @param string $key Use column for assigning as index. Defualts to numeric keys.
 * @return callable{
 *      @param array $array The array to search
 *      @return array
 * }
 */
function column( string $column, ?string $key = null ): callable {
	return function( array $array ) use ( $column, $key ) {
		return array_column( $array, $column, $key );
	};
}

/**
 * Returns a callback for flattening an array to a defined depth
 *
 * @param int|null $n Depth of nodes to flatten. If null will flatten to n
 * @return callable{
 *      @param array $array The array to flatten
 *      @return array
 * }
 */
function flattenByN( ?int $n = null ): callable {
	return function( array $array ) use ( $n ) {
		return array_reduce(
			$array,
			function( array $carry, $element ) use ( $n ) {
				// Remnove empty arrays.
				if ( is_array( $element ) && empty( $element ) ) {
					return $carry;
				}
				// If the element is an array and we are still flattening, call again
				if ( is_array( $element ) && ( is_null( $n ) || $n > 0 ) ) {
					$carry = array_merge( $carry, flattenByN( $n ? $n - 1 : null )( $element ) );
				} else {
					// Else just add the elememnt.
					$carry[] = $element;
				}
				return $carry;
			},
			array()
		);
	};
}

/**
 * Returns a callback for flattening and mapping an array
 *
 * @param callable $function The function to map the element. (Will no be called if resolves to array)
 * @param int|null $n Depth of nodes to flatten. If null will flatten to n
 * @return callable{
 *      @param array $array The array to flatten
 *      @return array
 * }
 */
function flatMap( callable $function, ?int $n = null ): callable {
	return function( array $array ) use ( $n, $function ) {
		return array_reduce(
			$array,
			function( array $carry, $element ) use ( $n, $function ) {
				if ( is_array( $element ) && ( is_null( $n ) || $n > 0 ) ) {
					$carry = array_merge( $carry, flatMap( $function, $n ? $n - 1 : null )( $element ) );
				} else {
					$carry[] = is_array( $element ) ? $element : $function( $element );
				}
				return $carry;
			},
			array()
		);
	};
}


function replaceRecursive( array ...$with ): callable {
	return function( array $array ) use ( $with ) {
		return array_replace_recursive( $array, ...$with );
	};
}

function replace( array ...$with ): callable {
	return function( array $array ) use ( $with ) {
		return array_replace( $array, ...$with );
	};
}

/**
 * Returns a callback for doing regular SORT again an array.
 *
 * @param int|null $flag Uses php stock sort constants or numerical values.
 * @return callable{
 *      @param array $array The array to sort
 *      @return array The sorted array (new array)
 * }
 */
function sort( int $flag = null ): callable {
	return function( array $array ) use ( $flag ) {
		\sort( $array, $flag );
		return $array;
	};
}

function rsort( int $flag = null ): callable {
	return function( array $array ) use ( $flag ) {
		\rsort( $array, $flag );
		return $array;
	};
}

function asort( int $flag = null ): callable {
	return function( array $array ) use ( $flag ) {
		\asort( $array, $flag );
		return $array;
	};
}

function krsort( int $flag = null ): callable {
	return function( array $array ) use ( $flag ) {
		\krsort( $array, $flag );
		return $array;
	};
}

function ksort( int $flag = null ): callable {
	return function( array $array ) use ( $flag ) {
		\ksort( $array, $flag );
		return $array;
	};
}

function arsort( int $flag = null ): callable {
	return function( array $array ) use ( $flag ) {
		\arsort( $array, $flag );
		return $array;
	};
}

function natsort(): callable {
	return function( array $array ) {
		\natsort( $array );
		return $array;
	};
}

function natcasesort(): callable {
	return function( array $array ) {
		\natcasesort( $array );
		return $array;
	};
}

function uksort( callable $function ): callable {
	return function( array $array ) use ( $function ) {
		\uksort( $array, $function );
		return $array;
	};
}

function uasort( callable $function ): callable {
	return function( array $array ) use ( $function ) {
		\uasort( $array, $function );
		return $array;
	};
}

function usort( callable $function ): callable {
	return function( array $array ) use ( $function ) {
		\usort( $array, $function );
		return $array;
	};
}


function sumWhere( callable $function ): callable {
	return function( array $array ) use ( $function ): int {
		return array_sum( array_map( $function, $array ) ?? array() );
	};
}

function filterMap( callable $filter, callable $map ): callable {
	return function( array $array ) use ( $filter, $map ): array {
		return array_map( $map, array_filter( $array, $filter ) );
	};
}
