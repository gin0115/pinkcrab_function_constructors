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

use stdClass;
use TypeError;

/**
 * Composes a function based on a set of callbacks.
 * All functions passed should have matching parameters.
 *
 * ...( A -> B ) -> ( A -> B )
 *
 * @param callable ...$callables
 * @return callable
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
 * ...( A -> A ) -> ( A -> A|Null )
 *
 * @param callable ...$callables
 * @return callable
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
 * ( A -> Bool ) -> ...( A -> A ) -> ( A -> A|Null )
 * 
 * @param callable $validator The validation function (b -> bool)
 * @param callable ...$callables The functions to execute (a -> a)
 * @return callable
 * @annotation ( ( b -> bool ) -> ...( a -> a ) ) -> ( a -> a )
 */
function composeTypeSafe(callable $validator, callable ...$callables): callable
{
    /**
     * @param mixed $e The value being passed through the functions.
     * @return mixed The final result.
     */
    return function ($e) use ($validator, $callables) {
        foreach ($callables as $callable) {
            // If invalid, abort and return null
            if (! $validator($e)) {
                return null;
            }
            // Run through callable.
            $e = $callable($e);

            // Check results and bail if invlaid type.
            if (! $validator($e)) {
                return null;
            }
        }
        // Return the final result.
        return $e;
    };
}

/**
 * Alias for compose()
 *
 * ...( A -> B ) -> ( A -> B )
 *
 * @param callable ...$callables
 * @return callable
 */
function pipe(callable ...$callables): callable
{
    return compose(...$callables);
}

/**
 * The reverse of the functions passed into compose() (pipe())).
 * To give a more functional feel to some piped calls.
 *
 * ...( A -> B ) -> ( A -> B )
 *
 * @param callable ...$callables
 * @return callable
 */
function pipeR(callable ...$callables): callable
{
    return compose(...\array_reverse($callables));
}

/**
 * Returns a callback for getting a property or element from an array/object.
 *
 * String -> ( A -> B|Null )
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

/**
 * Walks an array or object tree based on the nodes passed.
 * Will return whatever value at final node passed.
 * If any level returns null, process aborts.
 *
 * ..String -> ( A -> B|Null )
 *
 * @param string ...$nodes
 * @return callable
 */
function pluckProperty(string ...$nodes): callable
{
    return function ($data) use ($nodes) {
        foreach ($nodes as $node) {
            $data = getProperty($node)($data);

            if (is_null($data)) {
                return $data;
            }
        }
        return $data;
    };
}

/**
 * Returns a callable for a checking if a property exists.
 * Works for both arrays and objects (with public properties).
 *
 * String -> ( Array|Object -> Bool )
 *
 * @param string $property
 * @return callable
 */
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

/**
 * Returns a callable for a checking if a property exists and matches the passed value
 * Works for both arrays and objects (with public properties).
 *
 * String -> A -> ( Array|Object -> Bool )
 *
 * @param string $property
 * @return callable
 */
function propertyEquals(string $property, $value): callable
{
    /**
     * @param mixed $data The array or object to attmept to get param.
     * @return bool
     */
    return function ($data) use ($property, $value): bool {
        return pipe(
            getProperty($property),
            \PinkCrab\FunctionConstructors\Comparisons\isEqualTo($value)
        )($data);
    };
}

/**
 * Sets a property in an object or array.
 *
 * Array|Object -> ( String -> Mixed -> Array\Object )
 *
 * All object properties are passed as $object->{$property} = $value.
 * So no methods can be called using set property.
 * Will throw error is the property is protect or private.
 * Only works for public or dynamic properties.
 *
 * @param array|object $store
 * @return callable|null
 */
function setProperty($store): ?callable
{
    $isArray = is_array($store)
        || (get_class($store) === 'ArrayObject' && $store->getFlags() === 2);

    if (!$isArray && !is_object($store)) {
        throw new TypeError("Only objects or arrays can be constructed using setProperty.");
    }
    
    /**
     * @param string $property The property key.
     * @param mixed $value The value to set to keu.
     * @return array|object The datastore.
     */
    return function (string $property, $value) use ($store, $isArray) {
        if ($isArray) {
            $store[$property] = $value;
        } else {
            $store->{$property} = $value;
        }
        
        return $store;
    };
}

/**
 * Returns a callable for created an array with a set key
 * sets the value as the result of a callable being passed some data.
 *
 * String -> ( A -> B ) -> ( A -> Array[B] )
 *
 * @param string $key
 * @param callable $value
 * @return callable
 */
function encodeProperty(string $key, callable $value): callable
{
    /**
     * @param mixed $data The data to pass through the callable
     * @return array
     */
    return function ($data) use ($key, $value): array {
        return [$key => $value($data)];
    };
}

/**
 * Creates a callable for encoding an arry or object,
 * from an array of encodeProperty functions.
 *
 * Array|Object ->  ( ...( String -> ( A -> B ) ) ) -> ( A -> Object|Array[B] )
 *
 * @param  array|object $dataType
 * @return callable
 */
function recordEncoder($dataType): callable
{
    /**
     * @param callable ...$encoders encodeProperty() functions.
     * @return callable
     */
    return function (...$encoders) use ($dataType): callable {
        /**
         * @param mixed $data The data to pass through the encoders.
         * @return array|object The encoded object/array.
         */
        return function ($data) use ($dataType, $encoders) {
            foreach ($encoders as $encoder) {
                $dataType = setProperty($dataType)(
                    array_keys($encoder($data))[0],
                    array_values($encoder($data))[0]
                );
            }
            return $dataType;
        };
    };
}

/**
 * Partially applied callable invoker.
 *
 * ( A -> B ) -> ( ...A -> AB )
 *
 * @param callable $fn
 * @return callable
 */
function invoker(callable $fn): callable
{
    /**
     * @param mixed ...$args
     * @return mixed
     */
    return function (...$args) use ($fn) {
        return $fn(...$args);
    };
}

/**
 * Returns a function which always returns the value you created it with
 *
 * A -> (  ...B -> A  )
 *
 * @param mixed $value The value you always want to return.
 * @return callable
 */
function always($value): callable
{
    /**
     * @param mixed $ignored Any values can be passed and ignored.
     * @return mixed
     */
    return function (...$ignored) use ($value) {
        return $value;
    };
}

/**
 * Returns a function for turning objects into aarrays.
 * Only takes public properties.
 *
 * () -> ( Object -> Array )
 *
 * @return callable
 */
function toArray(): callable
{
    /**
     * @var object $object
     * @return array
     */
    return function ($object): array {
        
        // If not object, return empty array.
        // Pollyfill for php7.1 lacking object type hint.
        if (! is_object($object)) {
            return [];
        }

        $objectVars = get_object_vars($object);
        return array_reduce(
            array_keys($objectVars),
            function (array $array, $key) use ($objectVars): array {
                $array[ltrim((string)$key, '_')] = $objectVars[$key];
                return $array;
            },
            []
        );
    };
}
