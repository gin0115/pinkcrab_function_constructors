<?php

/**
 * Number functions.
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
 */

declare(strict_types=1);

namespace PinkCrab\FunctionConstructors\Numbers;

use Closure;
use InvalidArgumentException;
use PinkCrab\FunctionConstructors\Comparisons as C;

/**
 * Used to accumulate integers
 *
 * @param int $initial
 * @return Closure(int|null):(Closure|int)
 */
function accumulatorInt(int $initial = 0): Closure
{
    /**
     * @param int|null $value
     * @return Closure(int|null):(Closure|int)|int
     */
    return function (?int $value = null) use ($initial) {
        if ($value) {
            $initial += $value;
        }
        return $value ? accumulatorInt($initial) : $initial;
    };
}

/**
 * Used to accumulate floats
 *
 * @param float $initial
 * @return Closure(float|null):(Closure|float)
 */
function accumulatorFloat(float $initial = 0): Closure
{
    /**
     * @param float|null $value
     * @return Closure(float|null):(Closure|float)|float
     */
    return function (?float $value = null) use ($initial) {
        if ($value) {
            $initial += $value;
        }
        return $value ? accumulatorFloat($initial) : $initial;
    };
}

/**
 * Returns a function for adding a fixed amount.
 *
 * @param Number $initial Defaults to 0
 * @return Closure(Number):Number
 * @throws InvalidArgumentException If neither int or float passed.
 */
function sum($initial = 0): Closure
{
    if (! C\isNumber($initial)) {
        throw new InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param Number $value
     * @return int|float
     */
    return function ($value) use ($initial) {
        return $initial + $value;
    };
}


/**
 * Returns a function for adding a fixed amount.
 *
 * @param int $initial Defualts to 0
 * @return Closure(Number):Number
 * @throws InvalidArgumentException If neither int or float passed.
 */
function subtract($initial = 0): Closure
{
    if (! C\isNumber($initial)) {
        throw new InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param Number $value
     * @return int|float
     */
    return function ($value) use ($initial) {
        return $value - $initial;
    };
}


/**
 * Returns a function for multiplying a fixed amount.
 *
 * @param Number $initial Defualts to 1
 * @return Closure(Number):Number
 * @throws InvalidArgumentException
 */
function multiply($initial = 1): Closure
{
    if (! C\isNumber($initial)) {
        throw new InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param Number $value
     * @return Number
     */
    return function ($value) use ($initial) {
        return $value * $initial;
    };
}



/**
 * Returns a function for divideBy a fixed amount.
 *
 * @param float $divisor The value to divide the passed value by
 * @return Closure(Number):float
 */
function divideBy($divisor = 1): Closure
{
    if (! C\isNumber($divisor)) {
        throw new \InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param float $value
     * @return float
     */
    return function ($value) use ($divisor): float {
        return $value / $divisor;
    };
}

/**
 * Returns a function for divideInto a fixed amount.
 *
 * @param float $dividend The value to divide the passed value by
 * @return Closure(Number):float
 */
function divideInto($dividend = 1): Closure
{
    if (! C\isNumber($dividend)) {
        throw new \InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param float $value
     * @return float
     */
    return function ($value) use ($dividend): float {
        return $dividend / $value;
    };
}

/**
 * Returns a function for getting the remainder with a fixed divisor.
 *
 * @param float $divisor
 * @return Closure(Number):float
 */
function remainderBy($divisor = 1): Closure
{
    if (! C\isNumber($divisor)) {
        throw new \InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param float $value
     * @return float
     */
    return function ($value) use ($divisor): float {
        return $value % $divisor;
    };
}

/**
 * Returns a function for getting the remainder with a fixed dividend.
 *
 * @param float $dividend
 * @return Closure(Number):float
 */
function remainderInto($dividend = 1): Closure
{
    if (! C\isNumber($dividend)) {
        throw new \InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param float $value
     * @return float
     */
    return function ($value) use ($dividend): float {
        return $dividend % $value;
    };
}

/**
 * Returns a function for getting the remainder with a fixed dividend.
 *
 * @param int $precision Number of decimal places.
 * @return Closure(Number):float
 */
function round($precision = 1): Closure
{
    if (! C\isNumber($precision)) {
        throw new \InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param Number $value
     * @return float
     */
    return function ($value) use ($precision): float {
        if (! C\isNumber($value)) {
            throw new \InvalidArgumentException("Num\\round() only accepts a valid Number ( Int|Float -> Float )");
        }
        return \round(\floatval($value), $precision);
    };
}
