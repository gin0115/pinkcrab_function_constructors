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

/**
 * Returns a function for adding a fixed amount.
 * (INT only)
 *
 * @param int $intial Defualts to 0
 * @annoation : ( int ) -> ( int -> int )
 */
function sumInt(int $initial = 0): callable
{
    /**
     * @param int $value
     * @return int
     */
    return function (int $value) use ($initial): int {
        return $initial + $value;
    };
}

/**
 * Returns a function for adding a fixed amount.
 * (FLOAT only)
 *
 * @param float $intial Defualts to 0
 * @annoation : ( float ) -> ( float -> float )
 */
function sumFloat(float $initial = 0.00): callable
{
    /**
     * @param float $value
     * @return float
     */
    return function (float $value) use ($initial): float {
        return $initial + $value;
    };
}

/**
 * Returns a function for adding a fixed amount.
 * (INT only)
 *
 * @param int $intial Defualts to 0
 * @annoation : ( int ) -> ( int -> int )
 */
function subtractInt(int $initial = 0): callable
{
    /**
     * @param int $value
     * @return int
     */
    return function (int $value) use ($initial): int {
        return $value - $initial;
    };
}

/**
 * Returns a function for adding a fixed amount.
 * (FLOAT only)
 *
 * @param float $intial Defualts to 0
 * @annoation : ( float ) -> ( float -> float )
 */
function subtractFloat(float $initial = 0.00): callable
{
    /**
     * @param float $value
     * @return float
     */
    return function (float $value) use ($initial): float {
        return $value - $initial;
    };
}

/**
 * Returns a function for multiplying a fixed amount.
 * (INT only)
 *
 * @param int $intial Defualts to 1
 * @annoation : ( int ) -> ( int -> int )
 */
function multiplyInt(int $initial = 1): callable
{
    /**
     * @param int $value
     * @return int
     */
    return function (int $value) use ($initial): int {
        return $value * $initial;
    };
}

/**
 * Returns a function for multiplying a fixed amount.
 * (FLOAT only)
 *
 * @param float $intial Defualts to 1
 * @annoation : ( float ) -> ( float -> float )
 */
function multiplyFloat(float $initial = 1): callable
{
    /**
     * @param float $value
     * @return float
     */
    return function (float $value) use ($initial): float {
        return $value * $initial;
    };
}


/**
 * Returns a function for divideBy a fixed amount.
 *
 * @param float $divisor The value to divide the passed value by
 * @return callable
 * @annoation : ( int|float ) -> ( int|float -> float )
 */
function divideBy($divisor = 1): callable
{
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
 * @return callable
 * @annoation : ( int|float ) -> ( int|float -> float )
 */
function divideInto($dividend = 1): callable
{
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
 * @return callable
 * @annoation : ( int|float ) -> ( int|float -> float )
 */
function remainderBy($divisor = 1): callable
{
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
 * @return callable
 * @annoation : ( int|float ) -> ( int|float -> float )
 */
function remainderInto($dividend = 1): callable
{
    /**
     * @param float $value
     * @return float
     */
    return function ($value) use ($dividend): float {
        return $dividend % $value;
    };
}