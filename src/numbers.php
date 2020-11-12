<?php

declare(strict_types=1);

/**
 * PinkCrab Functions - Numbers
 *
 * A colleciton of string based fucntions.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @since 0.1.0
 */

namespace PinkCrab\FunctionConstructors\Numbers;

/** 
 * Used to accumulate integers
 *
 * @param int $initial
 * @return callable
 * @throws TypeError If not int or null passed.
 * @annoation : ( int -> ( int ) ) -> ( int )|int
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
 * @param float $initial
 * @return callable
 * @throws TypeError If not float or null passed.
 * @annoation : ( float -> ( float ) ) -> ( float )|float
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
