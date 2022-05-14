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
 */

declare(strict_types=1);

namespace PinkCrab\FunctionConstructors\Numbers;

use InvalidArgumentException;
use PinkCrab\FunctionConstructors\Comparisons as C;

/**
 * Used to accumulate integers
 *
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param int $initial
 * @return callable
 */
function accumulatorInt(int $initial = 0): callable
{
    /**
     * @param int|null $value
     * @return callable|int
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
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param float $initial
 * @return callable
 */
function accumulatorFloat(float $initial = 0): callable
{
    /**
     * @param float|null $value
     * @return callable|float
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
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param int|float $initial Defualts to 0
 * @return callable
 * @throws InvalidArgumentException If neither int or float passed.
 */
function sum($initial = 0): callable
{
    if (! C\isNumber($initial)) {
        throw new InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param int|float $value
     * @return int|float
     */
    return function ($value) use ($initial) {
        return $initial + $value;
    };
}


/**
 * Returns a function for adding a fixed amount.
 *
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param int $initial Defualts to 0
 * @return callable
 * @throws InvalidArgumentException If neither int or float passed.
 */
function subtract($initial = 0): callable
{
    if (! C\isNumber($initial)) {
        throw new InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param int|float $value
     * @return int|float
     */
    return function ($value) use ($initial) {
        return $value - $initial;
    };
}


/**
 * Returns a function for multiplying a fixed amount.
 *
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param int|float $initial Defualts to 1
 * @return callable
 * @throws InvalidArgumentException
 */
function multiply($initial = 1): callable
{
    if (! C\isNumber($initial)) {
        throw new InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param int|float $value
     * @return int|float
     */
    return function ($value) use ($initial) {
        return $value * $initial;
    };
}



/**
 * Returns a function for divideBy a fixed amount.
 *
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param float $divisor The value to divide the passed value by
 * @return callable
 * @annotation ( int|float ) -> ( int|float -> float )
 */
function divideBy($divisor = 1): callable
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
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param float $dividend The value to divide the passed value by
 * @return callable
 */
function divideInto($dividend = 1): callable
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
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param float $divisor
 * @return callable
 */
function remainderBy($divisor = 1): callable
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
 * Int|Float -> ( Int|Float -> Int|Float )
 *
 * @param float $dividend
 * @return callable
 */
function remainderInto($dividend = 1): callable
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
 * Int|Float -> ( Int|Float -> Float )
 *
 * @param int $precission Number of decimal places.
 * @return callable
 */
function round($precission = 1): callable
{
    if (! C\isNumber($precission)) {
        throw new \InvalidArgumentException(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }

    /**
     * @param int|float $value
     * @return float
     */
    return function ($value) use ($precission): float {
        if (! C\isNumber($value)) {
            throw new \InvalidArgumentException("Num\\round() only accepts a valid Number ( Int|Float -> Float )");
        }
        return \round(\floatval($value), $precission);
    };
}
