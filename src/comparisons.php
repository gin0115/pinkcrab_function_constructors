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
 * @param mixed $source The value to compare against.
 * @return callable
 */
function isEqualTo($source): callable
{
    /**
     * @param mixed $target The values to comapre with
     * @return bool
     */
    return function ($target) use ($source): bool {

        if (! sameScalar($target, $source)) {
            return false;
        }

        switch (gettype($target)) {
            case 'string':
            case 'integer':
            case 'double':
            case 'boolean':
                $equal = $source === $target;
                break;
            case 'object':
                $equal = count(get_object_vars($source)) === count(array_intersect_assoc((array) $source, (array) $target));
                break;
            case 'array':
                $equal = count($source) === count(array_intersect_assoc($source, $target));
                break;
            default:
                $equal = false;
                break;
        }
        return $equal;
    };
}

function isNotEqualTo($source): callable
{
    return function ($target) use ($source): bool {
        return ! isEqualTo($source)($target);
    };
}

function isGreaterThan($source): callable
{
    return function ($target) use ($source): bool {
        return isEqualIn(array( 'integer', 'double' ))(gettype($target)) ?
        $source > $target : false;
    };
}

function isLessThan($source): callable
{
    return function ($target) use ($source): bool {
        return isEqualIn(array( 'integer', 'double' ))(gettype($target)) ?
        $source < $target : false;
    };
}

function isEqualIn(array $target): callable
{
    /**    @TODO SWITCH THIS ROUND, ITS NOT RIGHT!
     * @param array $haystack The array of values which it could be
     * @return bool
     */
    return function ($source) use ($target): ?bool {
        if (
            is_numeric($source) || is_bool($source) ||
            is_string($source) || is_array($source)
        ) {
            return in_array($source, $target, true);
        } elseif (is_object($source)) {
            return in_array(
                (array) $source,
                array_map(
                    function ( $e): array {
                        return  (array) $e;
                    },
                    $target
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
 * @param mixed $value The value
 * @return bool
 */
function notEmpty($value): bool
{
    return ! empty($value);
}

/**
 * Groups callbacks and checks they all return true.
 *
 * @param callable ...$callables
 * @return callable{
 *      @param mixed $source
 *      @return bool
 * }
 */
function groupAnd(callable ...$callables): callable
{
    return function ($source) use ($callables): bool {
        return (bool) array_reduce(
            $callables,
            function ($result, $callable) use ($source) {
                return ( is_bool($result) && $result === false ) ? false : $callable($source);
            },
            null
        );
    };
}

/**
 * Groups callbacks and checks they any return true.
 *
 * @param callable ...$callables
 * @return callable{
 *      @param mixed $source
 *      @return bool
 * }
 */
function groupOr(callable ...$callables): callable
{
    return function ($source) use ($callables): bool {
        return (bool) array_reduce(
            $callables,
            function ($result, $callable) use ($source) {
                return ( is_bool($result) && $result === true ) ? true : $callable($source);
            },
            null
        );
    };
}

/**
 * Creates a callback for checking if a value has the desired scalar type.
 *
 * @param string $source Type to compare with
 * @return callable{
 *      @param mixed $target The value to chech if type of source
 *      @return bool
 * }
 */
function isScalar(string $source): callable
{
    return function ($target) use ($source) {
        return gettype($target) === $source;
    };
}



/**
 * Checks if all passed have the same scala
 *
 * @param [type] $a
 * @param [type] $b
 * @return bool
 */
function sameScalar(...$variables): bool
{
    return count(
        array_unique(
            array_map('gettype', $variables)
        )
    ) === 1;
}

/**
 * Checks if all values passed are true.
 */
function allTrue(bool ...$var): bool
{
    $var = array_map('boolval', $var);
    return ! in_array(false, $var, true) && in_array(true, $var, true);
}

/**
 * Checks if any passed are true.
 */
function someTrue(bool ...$var): bool
{
    return in_array(true, array_map('boolval', $var), true);
}

/**
 * Checks if the passed value is a boolean and false
 *
 * @param mixed $value
 * @return bool
 * @annotaion: mixed -> bool
 */
function isFalse($value): bool
{
    return  is_bool($value) && $value === false;
}

/**
 * Checks if the passed value is a boolean and true
 *
 * @param mixed $value
 * @return bool
 * @annotaion: mixed -> bool
 */
function isTrue($value): bool
{
    return  is_bool($value) && $value === true;
}

/**
 * Alias for groupOr
 */
function any(...$callables): callable
{
    return groupOr(...$callables);
}

/**
 * Alias for groupAnd
 */
function all(...$callables): callable
{
    return groupAnd(...$callables);
}
