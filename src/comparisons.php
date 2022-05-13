<?php

declare(strict_types=1);

/**
 * Comparison functions
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

namespace PinkCrab\FunctionConstructors\Comparisons;

/**
 * Returns a callback for checkining is a value is equal.
 * Works with String, Ints, Floats, Array, Objects & Bools
 *
 * A -> ( A|B -> Bool )
 *
 * @param mixed $a The value to compare against.
 * @return callable
 */
function isEqualTo( $a ): callable {
	/**
	 * @param mixed $b The values to comapre with
	 * @return bool
	 */
	return function ( $b ) use ( $a ): bool {
		if ( ! sameScalar( $b, $a ) ) {
			return false;
		}

		switch ( gettype( $b ) ) {
			case 'string':
			case 'integer':
			case 'double':
			case 'boolean':
				$equal = $a === $b;
				break;
			case 'object':
				$equal = count( get_object_vars( $a ) ) === count( array_intersect_assoc( (array) $a, (array) $b ) );
				break;
			case 'array':
				$equal = count( $a ) === count( array_intersect_assoc( $a, $b ) );
				break;
			default:
				$equal = false;
				break;
		}
		return $equal;
	};
}

/**
 * Returns a callable for checking if a value is not the same as the base ($a).
 *
 * A -> ( A|B -> Bool )
 *
 * @param mixed $a
 * @return callable
 */
function isNotEqualTo( $a ): callable {
	/**
	 * @param mixed $b The values to comapre with
	 * @return bool
	 */
	return function ( $b ) use ( $a ): bool {
		return ! isEqualTo( $a )( $b );
	};
}

/**
 * Returns a callable for checking the base is larger than comparisson.
 * If the comparisson value is not a int or float, will return false.
 *
 * A -> ( A|B -> Bool )
 *
 * @param int|float $a
 * @return callable
 */
function isGreaterThan( $a ): callable {
	/**
	 * @param mixed $b
	 * @return bool
	 */
	return function ( $b ) use ( $a ): bool {
		return isEqualIn( array( 'integer', 'double' ) )( gettype( $b ) )
			? $a < $b : false;
	};
}

/**
 * Returns a callable for checking the base is smnaller than comparisson.
 * If the comparisson value is not a int or float, will return false.
 *
 * A -> ( A|B -> Bool )
 *
 * @param int|float $a
 * @return callable
 */
function isLessThan( $a ): callable {
	/**
	 * @param mixed $b
	 * @return bool
	 */
	return function ( $b ) use ( $a ): bool {
		return isEqualIn( array( 'integer', 'double' ) )( gettype( $b ) )
			? $a > $b : false;
	};
}

/**
 * Checks if a value is in an array of values.
 *
 * Array -> ( A -> Bool )
 *
 * @param array<mixed> $a
 * @return callable
 */
function isEqualIn( array $a ): callable {
	/**
	 * @param array $b The array of values which it could be
	 * @return bool
	 */
	return function ( $b ) use ( $a ): ?bool {
		if (
			is_numeric( $b ) || is_bool( $b ) ||
			is_string( $b ) || is_array( $b )
		) {
			return in_array( $b, $a, true );
		} elseif ( is_object( $b ) ) {
			return in_array(
				(array) $b,
				array_map(
					function ( $e ): array {
						return (array) $e;
					},
					$a
				),
				true
			);
		} else {
			return null;
		}
	};
}

/**
 * Simple named function for ! empty()
 * Allows to be used in function composition.
 *
 * A -> Bool
 *
 * @param mixed $value The value
 * @return bool
 */
function notEmpty( $value ): bool {
	return ! empty( $value );
}

/**
 * Groups callbacks and checks they all return true.
 *
 * ...(A -> Bool) -> ( B -> Bool )
 *
 * @param callable ...$callables
 * @return callable
 */
function groupAnd( callable ...$callables ): callable {
	/**
	 * @param mixed $value
	 * @return bool
	 */
	return function ( $value ) use ( $callables ): bool {
		return (bool) array_reduce(
			$callables,
			function ( $result, $callable ) use ( $value ) {
				return ( is_bool( $result ) && $result === false ) ? false : $callable( $value );
			},
			null
		);
	};
}

/**
 * Groups callbacks and checks they any return true.
 *
 * ...(A -> Bool) -> ( B -> Bool )
 *
 * @param callable ...$callables
 * @return callable
 */
function groupOr( callable ...$callables ): callable {
	/**
	 * @param mixed $value
	 * @return bool
	 */
	return function ( $value ) use ( $callables ): bool {
		return (bool) array_reduce(
			$callables,
			function ( $result, $callable ) use ( $value ) {
				return ( is_bool( $result ) && $result === true ) ? true : $callable( $value );
			},
			null
		);
	};
}

/**
 * Creates a callback for checking if a value has the desired scalar type.
 *
 * A -> ( B -> Bool )
 *
 * @param string $source Type to compare with (bool, boolean, integer, object)
 * @return callable
 */
function isScalar( string $source ): callable {
	/**
	 * @param mixed $value
	 * @return bool
	 */
	return function ( $value ) use ( $source ) {
		return gettype( $value ) === $source;
	};
}



/**
 * Checks if all passed have the same scalar
 *
 * ...A -> Bool
 *
 * @param mixed ...$variables
 * @return bool
 */
function sameScalar( ...$variables ): bool {
	return count(
		array_unique(
			array_map( 'gettype', $variables )
		)
	) === 1;
}

/**
 * Checks if all the values passed are true.
 *
 * ...Bool -> Bool
 *
 * @param bool ...$variables
 * @return bool
 */
function allTrue( bool ...$variables ): bool {
	foreach ( $variables as $value ) {
		if ( ! is_bool( $value ) || $value !== true ) {
			return false;
		}
	}
	return true;
}

/**
 * Checks if all the values passed are true.
 *
 * ...Bool -> Bool
 *
 * @param bool ...$variables
 * @return bool
 */
function anyTrue( bool ...$variables ): bool {
	foreach ( $variables as $value ) {
		if ( is_bool( $value ) && $value === true ) {
			return true;
		}
	}
	return false;
}

/**
 * Checks if the passed value is a boolean and false
 *
 * ...A -> Bool
 *
 * @param mixed $value
 * @return bool
 */
function isFalse( $value ): bool {
	return is_bool( $value ) && $value === false;
}

/**
 * Checks if the passed value is a boolean and true
 *
 * A -> Bool
 *
 * @param mixed $value
 * @return bool
 */
function isTrue( $value ): bool {
	return is_bool( $value ) && $value === true;
}

/**
 * Checks if the passed value is a float or int.
 *
 * A -> Bool
 *
 * @param mixed $value
 * @return boolean
 */
function isNumber( $value ): bool {
	return is_float( $value ) || is_int( $value );
}

/**
 * Alias for groupOr
 *
 * ...(A > Bool) -> (B > Boll)
 *
 * @param callable ...$callables
 * @return callable
 */
function any( callable ...$callables ): callable {
	return groupOr( ...$callables );
}

/**
 * Alias for groupAnd
 *
 * ...(A > Bool) -> (B > Boll)
 *
 * @param callable ...$callables
 * @return callable
 */
function all( callable ...$callables ): callable {
	return groupAnd( ...$callables );
}

/**
 * Returns a callable for giving the reverse boolean response.
 *
 * ( A -> Bool ) -> ( A -> Bool )
 *
 * @param callable $callable
 * @return callable
 */
function not( callable $callable ): callable {
	/**
	 * @param mixed $value
	 * @return bool
	 */
	return function ( $value ) use ( $callable ): bool {
		return ! (bool) $callable( $value );
	};
}
