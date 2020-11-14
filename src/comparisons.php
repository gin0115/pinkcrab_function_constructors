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
 * @param mixed $a The value to compare against.
 * @return callable
 */
function isEqualTo($a): callable
{
    /**
     * @param mixed $b The values to comapre with
     * @return bool
     */
    return function ($b) use ($a): bool {

        if (! sameScalar($b, $a)) {
            return false;
        }

        switch (gettype($b)) {
            case 'string':
            case 'integer':
            case 'double':
            case 'boolean':
                $equal = $a === $b;
                break;
            case 'object':
                $equal = count(get_object_vars($a)) === count(array_intersect_assoc((array) $a, (array) $b));
                break;
            case 'array':
                $equal = count($a) === count(array_intersect_assoc($a, $b));
                break;
            default:
                $equal = false;
                break;
        }
        return $equal;
    };
}

function isNotEqualTo($a): callable
{
    return function ($b) use ($a): bool {
        return ! isEqualTo($a)($b);
    };
}

function isGreaterThan($a): callable
{
    return function ($b) use ($a): bool {
        return isEqualIn(array( 'integer', 'double' ))(gettype($b))
        ? $a > $b : false;
    };
}

function isLessThan($a): callable
{
    return function ($b) use ($a): bool {
        return isEqualIn(array( 'integer', 'double' ))(gettype($b))
        ? $a < $b : false;
    };
}

/**	
 * Checks if a value is in an array of values.
 * 
 * @param array $a
 */
function isEqualIn(array $a): callable
{
    /**
     * @param array $b The array of values which it could be
     * @return bool
     */
    return function ($b) use ($a): ?bool {
        if (
            is_numeric($b) || is_bool($b) ||
            is_string($b) || is_array($b)
        ) {
            return in_array($b, $a, true);
        } elseif (is_object($b)) {
            return in_array(
                (array) $b,
                array_map(
                    function ($e): array {
                        return  (array) $e;
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
 * @annotation mixed -> bool
 */
function isFalse($value): bool
{
    return is_bool($value) && $value === false;
}

/**
 * Checks if the passed value is a boolean and true
 *
 * @param mixed $value
 * @return bool
 * @annotation mixed -> bool
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
