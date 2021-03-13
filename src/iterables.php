<?php

declare(strict_types=1);

/**
 * Composeable iterable functions.
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

namespace PinkCrab\FunctionConstructors\Iterables;

use CallbackFilterIterator;
use PinkCrab\FunctionConstructors\{
    Comparisons as C,
    Numbers as Num,
    Arrays as Arr,
    Strings as Str,
    Iterables as Itr,
    GeneralFunctions as F
};

/*
 * Use array_filter as a patial.
 *
 * ( A -> Bool ) -> ( Iterable[AB] -> Iterable[A|Empty] )
 *
 * @param callable(mixed):bool $callable The function to apply to the Iterable.
 * @return callable(iterable): iterable
 */
function filter(callable $callable): callable
{
    /**
     * @param iterable<mixed, mixed> $source Iterable to filter
     * @return iterable<mixed, mixed> Filtered Iterable.
     */
    return function (iterable $source) use ($callable): iterable {
        return is_array($source)
            ? array_filter($source, $callable)
            : new CallbackFilterIterator($source, function ($current, $key, $iterator) use ($callable) {
                return $callable($current);
            });
    };
}

/**
 * Creates a callback for running an array through various callbacks for all true response.
 * Wrapper for creating a AND group of callbacks and running through array filter.
 *
 * ...( A -> Bool ) -> ( Iterable[AB] -> Iterable[A|Empty] )
 *
 * @param callable(mixed):bool ...$callables
 * @return callable(iterable): iterable
 */
function filterAnd(callable ...$callables): callable
{
    /**
     * @param iterable<mixed, mixed> $source Iterable to filter
     * @return iterable<mixed, mixed> Filtered Iterable.
     */
    return function (iterable $source) use ($callables): iterable {
        return is_array($source)
            ? array_filter($source, C\groupAnd(...$callables))
            : new CallbackFilterIterator($source, function ($current, $key, $iterator) use ($callables): bool {
                return C\groupAnd(...$callables)($current);
            });
    };
}

/**
 * Creates a callback for running an array through various callbacks for any true response.
 * Wrapper for creating a OR group of callbacks and running through array filter.
 *
 *  ...( A -> Bool ) -> ( Iterable[AB] -> Iterable[A|Empty] )
 *
* @param callable(mixed):bool ...$callables
 * @return callable
 */
function filterOr(callable ...$callables): callable
{
    /**
     * @param iterable<mixed, mixed> $source Iterable to filter
     * @return iterable<mixed, mixed> Filtered Iterable.
     */
    return function (iterable $source) use ($callables): iterable {
        return is_array($source)
            ? array_filter($source, C\groupOr(...$callables))
            : new CallbackFilterIterator($source, function ($current, $key, $iterator) use ($callables): bool {
                return C\groupOr(...$callables)($current);
            });
    };
}