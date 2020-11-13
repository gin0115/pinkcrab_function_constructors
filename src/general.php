<?php

declare(strict_types=1);

/**
 * Mixture of general functions, including compose, pipe, invoke and property
 * accessors.
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

namespace PinkCrab\FunctionConstructors\GeneralFunctions;

/**
 * Composes a function based on a set of callbacks.
 * All functions passed should have matching parameters.
 *
 * @param callable ...$callables
 * @return callable
 * @annotaion: (...(a -> b)) -> ( a -> b )
 */
function compose(callable ...$callables): callable
{
    /**
     * @param mixed The value passed into the functions
     * @return mixed The final result.
     */
    return function ($e) use ($callables) {
        foreach ($callables as $callable) {
            $e = $callable($e);
        }
        return $e;
    };
}

/**
 * Compose a function which is escaped if the value returns as null.
 * This allows for safer composition.
 *
 * @param callable ...$callables
 * @return callable
 * @annotaion: ( ...( a -> a ) ) -> ( a -> a )
 */
function composeSafe(callable ...$callables): callable
{
    /**
     * @param mixed The value passed into the functions
     * @return mixed|null The final result or null.
     */
    return function ($e) use ($callables) {
        foreach ($callables as $callable) {
            if (! is_null($e)) {
                $e = $callable($e);
            }
        }
        return $e;
    };
}

/**
 * Creates a strictly pure function.
 * Every return from every class, must pass a validation function
 * If any fail validation, null is returned.
 *
 * @param callable $validator The validation function (b -> bool)
 * @param callable ...$callables The functions to execute (a -> a)
 * @return callable
 * @annotaion: ( ( b -> bool ) -> ...( a -> a ) ) -> ( a -> a )
 */
function composeTypeSafe(callable $validator, callable ...$callables): callable
{
    /**
     * @param mixed $e The value being passed through the functions.
     * @return mixed The final result.
     */
    return function ($e) use ($validator, $callables) {
        foreach ($callables as $callable) {
            // Only do this passes validator
            if ($validator($e)) {
                $e = $callable($e);
            }
            // If the result passes the validator, set else as null.
            $e = $validator($e) ? $e : null;
        }
        return $e;
    };
}

/**
 * Alias for composeSafe()
 *
 * @param callable ...$callables
 * @return callable
 * @annotaion: ( ...( a -> a ) ) -> ( a -> a )
 */
function pipe(callable ...$callables): callable
{
    return composeSafe(...$callables);
}





/**
 * Returns a callback for getting a property or element from an array/object.
 *
 * @param string $property
 * @return callable
 */
function getProperty(string $property): callable
{
    /**
     * @param mixed $data The array or object to attmept to get param.
     * @return mixed|null
     */
    return function ($data) use ($property) {
        if (is_array($data)) {
            return array_key_exists($property, $data) ? $data[ $property ] : null;
        } elseif (is_object($data)) {
            return property_exists($data, $property) ? $data->{$property} : null;
        } else {
            return null;
        }
    };
}

function hasProperty(string $property): callable
{
    /**
     * @param mixed $data The array or object to attmept to get param.
     * @return mixed|null
     */
    return function ($data) use ($property): bool {
        if (is_array($data)) {
            return array_key_exists($property, $data);
        } elseif (is_object($data)) {
            return property_exists($data, $property);
        } else {
            return false;
        }
    };
}

function propertyEquals(string $property, $value): callable
{
    /**
     * @param mixed $data The array or object to attmept to get param.
     * @return bool
     */
    return function ($data) use ($property, $value): bool {
        return compose(
            getProperty($property),
            \PinkCrab\FunctionConstructors\Comparisons\isEqualTo($value)
        )($data);
    };
}



/**
 * Used to invoke a callback.
 *
 * @param callable $fn
 * @param mixed ...$args
 * @return void
 */
function invoke(callable $fn, ...$args)
{
    return $fn(...$args);
}

/**
 * Returns a function which always returns the value you created it with
 *
 * @param mixed $value The value you always want to return.
 * @return callable
 * @annotaion: ( a ) -> ( ...b -> a )
 */
function always($value): callable
{
    return function (...$ignored) use ($value) {
        return $value;
    };
}


function mapMany(callable $function): callable
{
    return function (array ...$arrays) use ($function): array {
        return array_map($function, ...$arrays);
    };
}


function get_max_length_from_arrays(array ...$arrays): int
{
    return max(array_map('count', $arrays));
}
