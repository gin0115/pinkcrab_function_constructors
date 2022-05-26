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
    if (!class_exists($class)) {
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
        if (!class_exists($value)) {
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
