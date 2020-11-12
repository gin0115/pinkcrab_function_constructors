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
 */
function compose(callable ...$callables): callable
{
    return function ($e) use ($callables) {
        foreach ($callables as $callable) {
            $e = $callable($e);
        }
        return $e;
    };
}

function composeSafe(callable ...$callables): callable
{
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
 * Acts an alias for composeSafe()
 *
 * @param callables ...$callables
 * @return callable
 */
function pipe(callable ...$callables): callable
{
    return function ($e) use ($callables) {
        foreach ($callables as $callable) {
            if (! is_null($e)) {
                $e = $callable($e);
            }
        }
        return $e;
    };
}

function composeTypeSafe(callable $validator, callable ...$callables): callable
{
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
