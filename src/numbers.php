<?php

declare(strict_types=1);

/**
 * Number functions.
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
        throw new \TypeError(__FUNCTION__ . "only accepts a Number (Float or Int)");
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
        throw new \TypeError(__FUNCTION__ . "only accepts a Number (Float or Int)");
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
        throw new \TypeError(__FUNCTION__ . "only accepts a Number (Float or Int)");
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
        throw new \TypeError(__FUNCTION__ . "only accepts a Number (Float or Int)");
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
        throw new \TypeError(__FUNCTION__ . "only accepts a Number (Float or Int)");
    }
    
    /**
     * @param int|float $value
     * @return float
     */
    return function ($value) use ($precission): float {
        if (! C\isNumber($value)) {
            throw new \TypeError("Num\\round() only accepts a valid Number ( Int|Float -> Float )");
        }
        return \round(\floatval($value), $precission);
    };
}
