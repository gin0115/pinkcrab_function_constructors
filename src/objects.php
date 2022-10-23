<?php

/**
 * Object functions.
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
 * @since 0.0.1
 *
 * @template Number of int|float
 * @phpstan-template Number of int|float
 * @psalm-template Number of int|float
 * @template Class of object|class-string
 * @phpstan-template Class of object|class-string
 * @psalm-template Class of object|class-string
 */

declare(strict_types=1);

namespace PinkCrab\FunctionConstructors\Objects;

use Closure;
use InvalidArgumentException;
use PinkCrab\FunctionConstructors\Comparisons as C;

/**
 * Returns a function for checking if the passed class or string-class-name matches
 * that of the predefined class or string-class-name.
 *
 * @template Class of object|class-string
 * @param Class $class
 * @return Closure(Class): bool
 */
function isInstanceOf($class): Closure
{

    // If we have an object, get full name.
    if (is_object($class)) {
        $class = get_class($class);
    }
    if (! class_exists($class)) {
        throw new InvalidArgumentException(__FUNCTION__ . 'only accepts a Class or Class Name');
    }

    /**
     * @param Class $value
     * @return bool
     */
    return function ($value) use ($class): bool {
        if (is_object($value)) {
            $value = get_class($value);
        }
        if (! class_exists($value)) {
            throw new InvalidArgumentException(__FUNCTION__ . 'only accepts a Class or Class Name');
        }
        return is_a($value, $class, true);
    };
}

/**
 * Returns a function to check if a passed class or string-class-name implements a predefined interface.
 *
 * @template Class of object|class-string
 * @param Class $interface The interface to check against.
 * @return Closure(Class): bool
 */
function implementsInterface($interface): Closure
{
    /**
     * @param Class $class
     * @return bool
     */
    return function ($class) use ($interface): bool {
        return in_array(
            $interface,
            class_implements($class, false) ?: array(),
            true
        );
    };
}

/**
 * Returns a function for turning objects into arrays.
 * Only takes public properties.
 *
 * @return Closure(object):array<string, mixed>
 */
function toArray(): Closure
{
    /**
     * @param object $object
     * @return array<string, mixed>
     */
    return function ($object): array {

        // If not object, return empty array.
        if (! is_object($object)) {
            return array();
        }

        $objectVars = get_object_vars($object);
        return array_reduce(
            array_keys($objectVars),
            function (array $array, $key) use ($objectVars): array {
                $array[ ltrim((string) $key, '_') ] = $objectVars[ $key ];
                return $array;
            },
            array()
        );
    };
}


/**
 * Returns a closure for checking if an object uses a trait.
 *
 * @param string $trait
 * @return Closure(object):bool
 */
function usesTrait(string $trait): Closure
{
    /**
     * @param object $object
     * @return bool
     */
    return function ($object) use ($trait): bool {
        $traits = array();
        do {
            $traits = array_merge(class_uses($object, true) ?: array(), $traits);
        } while ($object = get_parent_class($object));

        return in_array($trait, $traits, true);
    };
};
