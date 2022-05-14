<?php

/**
 * Procedural wrappers for various functions.
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
 */

declare(strict_types=1);

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
                if (is_array($element) && (is_null($n) || $n > 0)) { // @phpstan-ignore-line
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
