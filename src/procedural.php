<?php

declare(strict_types=1);

/**
 * Procedural wrappers for various functions.
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

if (! function_exists('stringContains')) {
    /**
     * Checks if a string contains a sub string
     *
     * @param string $haystack The string to search within.
     * @param string $needle The sub string to look for.
     * @return bool
     */
    function stringContains(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }
}

if (! function_exists('array_flatten')) {
    /**
     * Flattens an array to desired depth.
     * Doesnt preserve keys
     *
     * @param array<mixed> $array The array to flatten
     * @param int|null $n The depth to flatten the array, if null will flatten all arrays.
     * @return array<mixed>
     */
    function arrayFlatten(array $array, ?int $n = null): array
    {
        return array_reduce(
            $array,
            function (array $carry, $element) use ($n): array {
                // Remnove empty arrays.
                if (is_array($element) && empty($element)) {
                    return $carry;
                }
                // If the element is an array and we are still flattening, call again
                if (is_array($element) && ( is_null($n) || $n > 0 )) {
                    $carry = array_merge($carry, arrayFlatten($element, $n ? $n - 1 : null));
                } else {
                    // Else just add the elememnt.
                    $carry[] = $element;
                }
                return $carry;
            },
            array()
        );
    }
}

if (! function_exists('toObject')) {
    /**
     * Simple mapper for turning arrays into stdClass objects.
     *
     * @param array<mixed> $array
     * @return stdClass
     */
    function toObject(array $array): object
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            $key            = is_string($key) ? $key : (string) $key;
            $object->{$key} = $value;
        }
        return $object;
    }
}

if (! function_exists('invokeCallable')) {
    /**
     * Used to invoke a callable.
     *
     * @param callable $fn
     * @param mixed ...$args
     * @return void
     */
    function invokeCallable(callable $fn, ...$args): void
    {
        $fn(...$args);
    }
}

if (! function_exists('isArrayAccess')) {
    /**
     * Checks if an array or an object which has array like access.
     *
     * @source https://stackoverflow.com/questions/12346479/how-to-check-for-arrayness-in-php
     * @param mixed $var
     * @return bool
     */
    function isArrayAccess($var)
    {
        return is_array($var) ||
           ($var instanceof \ArrayAccess  &&
            $var instanceof \Traversable  &&
            $var instanceof \Serializable &&
            $var instanceof \Countable);
    }
}
