<?php

declare(strict_types=1);

/**
 * Composeable strings functions.
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

namespace PinkCrab\FunctionConstructors\Strings;

use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

/**
 * Creates a callable for wrapping a string with html/xml style tags.
 * By defaults uses opening as closing, if no closing defined.
 *
 * @flow 2*Str->fn()->Str
 * @param string $openingTag
 * @param string|null $closingTag
 * @return callable{
 *      @param string $string
 *      @return string
 * }
 */
function tagWrap(string $openingTag, ?string $closingTag = null): callable
{
    return function (string $string) use ($openingTag, $closingTag): string {
        return sprintf('<%s>%s</%s>', $openingTag, $string, $closingTag ?? $openingTag);
    };
}

/**
 * Creates a callable for preppedning to a string.
 *
 * @flow Str->fn()->Str
 * @param string $append
 * @return callable {
 *      @param string $string
 *      @return string
 * }
 */
function prepend(string $prepend): callable
{
    return function (string $string) use ($prepend): string {
        return sprintf('%s%s', $prepend, $string);
    };
}

/**
 * Creates a callable for wrapping a string.
 * By defaults uses opening as closing, if no closing defined.
 *
 * @flow 2*Str->fn()->Str
 * @param string $tag
 * @return callable {
 *      @param string $string
 *      @return string
 * }
 */
function wrap(string $opening, ?string $closing = null): callable
{
    return function (string $string) use ($opening, $closing): string {
        return sprintf('%s%s%s', $opening, $string, $closing ?? $opening);
    };
}

/**
 * Creates a callable for appending to a string.
 *
 * @flow Str->fn()->Str
 * @param string $append
 * @return callable {
 *      @param string $string
 *      @return string
 * }
 */
function append(string $append): callable
{
    return function (string $string) use ($append): string {
        return sprintf('%s%s', $string, $append);
    };
}

/**
 * Creates a double curried find to replace.
 *
 * @flow Str->fn()->fn()->Str
 * @param stirng  $find Value to look for
 * @return callable{
 *      @param string $replace value to replace with
 *      @return callable{
 *          @param string $source String to carry out find and replace.
 *          @return string
 *      }
 * }
 */
function findToReplace(string $find): callable
{
    return function (string $replace) use ($find): callable {
        return function ($source) use ($find, $replace): string {
            return str_replace($find, $replace, $source);
        };
    };
}

/**
 * Creates a callbale to find and replace within a string.
 *
 * @flow 2*Str->fn()->Str
 * @param stirng  $find
 * @param stirng  $replace
 * @return callable
 */
function replaceWith(string $find, string $replace): callable
{
    /**
     * @param string $source
     * @return string
     */
    return function ($source) use ($find, $replace): string {
        return str_replace($find, $replace, $source);
    };
}

/**
 * Creates a callable for checking if a string starts with
 *
 * @flow Str->fn()->bool
 * @param string $find The value to look for.
 * @return callable
 */
function startsWith(string $find): callable
{
    /**
     * @param string $source
     * @return bool
     */
    return function (string $source) use ($find): bool {
        return ( substr($source, 0, strlen($find)) === $find );
    };
}

/**
 * Creates a callable for checkin if a string ends with
 *
 * @flow Str->fn()->bool
 * @param string $find The value to look for.
 * @return callable
 */
function endsWith(string $find): callable
{
    /**
     * @param string $source
     * @return bool
     */
    return function (string $source) use ($find): bool {
        if (strlen($find) === 0) {
            return true;
        }
        return ( substr($source, -strlen($find)) === $find );
    };
}

/**
 * str_contains pollyfill.
 */
if (! function_exists('str_contains')) {
    function str_contains($haystack, $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }
}

/**
 * Creates a callable for checking if a string contains. using str_contains
 *
 * @annoation string -> fn(string) -> bool
 * @param string $needle The value to look for.
 * @return callable
 */
function contains(string $needle): callable
{
    /**
     * @param string $haystack String to look in.
     * @return bool
     */
    return function (string $haystack) use ($needle): bool {
        return str_contains($haystack, $needle);
    };
}

/**
 * Creates a callable for checking if a string contains using preg_match.
 *
 * @flow Str->fn()->bool
 * @param string $pattern
 * @return void
 */
function containPattern(string $pattern): callable
{
    /**
     * @param string $source String to look in.
     * @return bool
     */
    return function (string $source) use ($pattern): bool {
        return (bool) preg_match($pattern, $source);
    };
}

/**
 * Creates a callable for turning a string into a url.
 *
 * @flow Str -> Str -> ( fn( Str ) -> Str )
 * @param string $url
 * @param string|null $target
 * @return callable
 */
function asUrl(string $url, ?string $target = null): callable
{
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($url, $target): string {
        return $target ?
            sprintf(
                "<a href='%s' target='%s'>%s</a>",
                $url,
                $target ?? '_blank',
                $string,
            ) :
            sprintf(
                "<a href='%s'>%s</a>",
                $url,
                $string,
            );
    };
}

/**
 * Creates a callable for a string safe function compose.
 *
 * @flow ...fn->fn()->fn
 * @uses Func\composeTypeSafe
 * @param callable ...$callables
 * @return callable
 */
function composeSafeStringFunc(callable ...$callables): callable
{
    return Func\composeTypeSafe('is_string', ...$callables);
}

/**
 * Creates a callable for compiling a string.
 *
 * @param string $initial
 * @return callable
 * @throws TypeError If not string or null passed.
 * @annoation : ( string -> ( string ) ) -> ( string )|string
 */
function stringCompiler(string $initial = ''): callable
{
    /**
     * @param string|null $value
     * @return callable|string
     */
    return function (?string $value = null) use ($initial) {
        if ($value) {
            $initial .= $value;
        }
        return $value ? stringCompiler($initial) : $initial;
    };
}

/**
 * Splits a string with a pattern
 *
 * @flow str->fn()->array
 * @param string $pattern
 * @return callable
 */
function splitPattern(string $pattern): callable
{
    /**
     * @param stirng $name
     * @return array
     */
    return function (string $string) use ($pattern): ?array {
        return preg_split($pattern, $string);
    };
};

/**
 * Converts a number (loose type) to a string representation of a float.
 *
 * @flow (int, string, string)->fn( int|float|string )->str
 * @param string $precission Number of decimal places
 * @param string $point The deciaml seperator
 * @param string $thousands The thousand seperator.
 * @return callable
 */
function decimialNumber(int $precission = 2, $point = '.', $thousands = ''): callable
{
    /**
     * @param stirng|int|float $number
     * @return string|null
     */
    return function ($number) use ($precission, $point, $thousands): ?string {
        return number_format((float) $number, $precission, $point, $thousands);
    };
};
