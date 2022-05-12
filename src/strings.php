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

use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

/**
 * Creates a callable for wrapping a string.
 * By defaults uses opening as closing, if no closing defined.
 *
 * String -> String|Null -> ( String -> String )
 *
 * @param string $opening
 * @param string|null $closing
 * @return callable
 */
function wrap(string $opening, ?string $closing = null): callable
{
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($opening, $closing): string {
        return \sprintf('%s%s%s', $opening, $string, $closing ?? $opening);
    };
}

/**
 * Creates a callable for wrapping a string with html/xml style tags.
 * By defaults uses opening as closing, if no closing defined.
 *
 * String -> String|Null -> ( String -> String )
 *
 * @param string $openingTag
 * @param string|null $closingTag
 * @return callable
 */
function tagWrap(string $openingTag, ?string $closingTag = null): callable
{
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($openingTag, $closingTag): string {
        return \sprintf('<%s>%s</%s>', $openingTag, $string, $closingTag ?? $openingTag);
    };
}

/**
 * Creates a callable for turning a string into a url.
 *
 * String -> String|Null -> ( String -> String )
 *
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
            \sprintf(
                "<a href='%s' target='%s'>%s</a>",
                $url,
                $target,
                $string
            ) :
            \sprintf(
                "<a href='%s'>%s</a>",
                $url,
                $string
            );
    };
}


/**
 * Creates a callable for slicinig a string
 *
 * Uses substr()
 *
 * Int -> Int|Null -> ( String -> String )
 *
 * @param int $start start poition
 * @param int|null $finish end poition
 * @return callable
 */
function slice(int $start, ?int $finish = null): callable
{
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($start, $finish): string {
        return ! $finish
            ? substr($string, $start)
            : substr($string, $start, $finish);
    };
}

/**
 * Creates a callable for preppedning to a string.
 *
 * String -> ( String -> String )
 *
 * @param string $prepend
 * @return callable
 */
function prepend(string $prepend): callable
{
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($prepend): string {
        return \sprintf('%s%s', $prepend, $string);
    };
}

/**
 * Creates a callable for appending to a string.
 *
 * String -> ( String -> String )
 *
 * @param string $append
 * @return callable
 */
function append(string $append): callable
{
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($append): string {
        return \sprintf('%s%s', $string, $append);
    };
}

/**
 * Returns a callable for formatting a string with a deifned set of rules
 *
 * Array[String] -> ( String -> String )
 *
 * @param array<string, mixed> $args
 * @return callable
 */
function vSprintf(array $args = array()): callable
{
    /**
     * @param string $string
     * @return string Will return orginial string if false.
     */
    return function (string $string) use ($args): string {
        $result = \vsprintf($string, $args);
        return ! C\isFalse($result) ? $result : $string;
    };
}

/**
 * Creates a double curried find to replace.
 *
 * String -> ( String ) -> ( String -> String )
 *
 * @param string $find Value to look for
 * @return callable(string):callable
 */
function findToReplace(string $find): callable
{
    /**
     * @param string $replace value to replace with
     * @return callable(string): string
     */
    return function (string $replace) use ($find): callable {
        /**
         * @param string $subject String to carry out find and replace.
         * @return string
         */
        return function ($subject) use ($find, $replace): string {
            return \str_replace($find, $replace, $subject);
        };
    };
}

/**
 * Creates a callbale to find and replace within a string.
 *
 * String -> String -> ( String -> string )
 *
 * @param string  $find
 * @param string  $replace
 * @return callable
 */
function replaceWith(string $find, string $replace): callable
{
    /**
     * @param string $source
     * @return string
     */
    return function ($source) use ($find, $replace): string {
        return \str_replace($find, $replace, $source);
    };
}

/**
 * Returns a callable that can replace a sub string with a pre defined value.
 *
 * String -> Int -> Int|Null -> ( String -> String )
 *
 * @param string $replace The value to replace in passed string
 * @param int $offset The offset to start, negative numbers count back from end.
 * @param int|null $length Numer of chars to stop replacing at end of replacement.
 */
function replaceSubString(
    string $replace,
    int $offset = 0,
    ?int $length = null
): callable {
    /**
     * @param string $string
     * @return string
     */
    return function (string $string) use ($replace, $offset, $length): string {
        return $length
            ? \substr_replace($string, $replace, $offset, $length)
            : \substr_replace($string, $replace, $offset);
    };
}

/**
 * Creates a callable for checking if a string starts with
 *
 * String -> ( String -> bool )
 *
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
        return (\substr($source, 0, \strlen($find)) === $find);
    };
}

/**
 * Creates a callable for checkin if a string ends with
 *
 * String -> ( String -> bool )
 *
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
        if (\strlen($find) === 0) {
            return true;
        }
        return (\substr($source, -\strlen($find)) === $find);
    };
}

/**
 * Creates a callable for checking if a string contains. using stringContains
 *
 * String -> ( String -> bool )
 *
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
        return \stringContains($haystack, $needle);
    };
}

/**
 * Creates a callable for checking if a string contains using preg_match.
 *
 * String -> ( String -> bool )
 *
 * @param string $pattern
 * @return callable(string): bool
 */
function containsPattern(string $pattern): callable
{
    /**
     * @param string $source String to look in.
     * @return bool
     */
    return function (string $source) use ($pattern): bool {
        return (bool) \preg_match($pattern, $source);
    };
}

/**
 * Splits a string with a pattern
 *
 * String -> ( String -> array|null )
 *
 * @param string $pattern
 * @return callable
 */
function splitPattern(string $pattern): callable
{
    /**
     * @param string $name
     * @return array
     */
    return function (string $string) use ($pattern): ?array {
        return \preg_split($pattern, $string) ?: null;
    };
}

/**
 * Converts a number (loose type) to a string representation of a float.
 *
 * Int -> String -> String -> ( String|Int|Float -> String )
 *
 * @param string|int|float $precision Number of decimal places
 * @param string $point The decimal separator
 * @param string $thousands The thousand separator.
 * @return callable
 */
function decimialNumber($precision = 2, $point = '.', $thousands = ''): callable
{

    /**
     * @param string|int|float $number
     * @return string
     */
    return function ($number) use ($precision, $point, $thousands): string {
        return \is_numeric($number)
            ? \number_format((float) $number, (int) $precision, $point, $thousands)
            : '';
    };
}

/**
 * Returns a callable for adding C slashes to a string based on a defined char list.
 *
 * String -> ( String -> String )
 *
 * @param string $charList The Char list to add slashes too.
 * @return callable
 */
function addSlashes(string $charList): callable
{
    /**
     * @param string $string The string to have char, slash escaped.
     * @return string
     */
    return function (string $string) use ($charList): string {
        return \addcslashes($string, $charList);
    };
}

/**
 * Returns a callable for splitting a string by a set amount.
 *
 * Int -> ( String -> Array[String] )
 *
 * @param int $length The length to split the string up with.
 * @return callable(string):array<string> The parts.
 */
function split(int $length): callable
{
    /**
     * @param string $string The string to be split
     * @return array<int, string>
     */
    return function (string $string) use ($length): array {
        return \str_split($string, max(1, $length)) ?: array(); // @phpstan-ignore-line, inconsistent errors with differing php versions.
    };
}

/**
 * Returns a callback for splitting a string into chunks.
 *
 * Int -> String -> ( String -> String )
 *
 * @param int $length The length of each chunk.
 * @param string $end The string to use at the end.
 * @return callable
 */
function chunk(int $length, string $end = "\r\n"): callable
{
    /**
     * @param string $string The string to be chunked
     * @return string
     */
    return function (string $string) use ($length, $end): string {
        return \chunk_split($string, max(1, $length), $end);
    };
}

/**
 * Creates a callable for wrapping a string to a defined value.
 *
 * Int -> String -> Bool -> ( String -> String )
 *
 * @param int $width Max width for each "line"
 * @param string $break The string to use to denote the end of line.
 * @param bool $cut If set to true, words are cut at $width, else overflow.
 * @return callable
 */
function wordWrap(int $width, string $break = "\n", bool $cut = false): callable
{
    /**
     * @param string $string The string to be wrapped
     * @return string
     */
    return function (string $string) use ($width, $break, $cut): string {
        return \wordwrap($string, $width, $break, $cut);
    };
}

/**
 * Returns a callback for counting the number of occurrences of each char in a string.
 *
 * Int -> ( String -> Array )
 *
 * @link https://www.php.net/manual/en/function.count-chars.php
 * @param int $mode See the PHP docs for details.
 * @return callable
 */
function countChars(int $mode = 1): callable
{
    // Throw an exception if the mode is not supported.
    if (! in_array($mode, array( 0, 1, 2, 3, 4 ), true)) {
        throw new \InvalidArgumentException('Invalid mode');
    }

    /**
     * @param string $string The string to have its char counted.
     * @return array
     */
    return function (string $string) use ($mode) {
        return \count_chars($string, $mode);
    };
}

/**
 * Returns a callable that counts the occurrences of a given substring in a string
 *
 * String -> Int -> Int|Null -> ( String -> Int )
 *
 * @param string $needle The substring to find
 * @param int $offset Place to start, defaults to 0 (start)
 * @param int|null $length Max length after offset to search.
 */
function countSubString(
    string $needle,
    int $offset = 0,
    ?int $length = null
): callable {
    /**
     * @param string $haystack
     * @return int|array
     */
    return function (string $haystack) use ($needle, $offset, $length): int {
        return $length
            ? \substr_count($haystack, $needle, $offset, $length)
            : \substr_count($haystack, $needle, $offset);
    };
}

/**
 * Returns a callable for doing repeated trim.
 *
 * String -> ( String -> String )
 *
 * @param string $mask
 * @return callable
 */
function trim(string $mask = "\t\n\r\0\x0B"): callable
{
    /**
     * @param string $string The string to be trimmed
     * @return array
     */
    return function (string $string) use ($mask): string {
        return \trim($string, $mask);
    };
}

/**
 * Returns a callable for doing repeated ltrim.
 *
 * String -> ( String -> String )
 *
 * @param string $mask
 * @return callable
 */
function lTrim(string $mask = "\t\n\r\0\x0B"): callable
{
    /**
     * @param string $string The string to be trimmed
     * @return array
     */
    return function (string $string) use ($mask): string {
        return \ltrim($string, $mask);
    };
}

/**
 * Returns a callable for doing repeated rtrim.
 *
 * String -> ( String -> String )
 *
 * @param string $mask
 * @return callable
 */
function rTrim(string $mask = "\t\n\r\0\x0B"): callable
{
    /**
     * @param string $string The string to be trimmed
     * @return array
     */
    return function (string $string) use ($mask): string {
        return \rtrim($string, $mask);
    };
}

/**
 * Returns a callable for finding the similarities between 2 string.
 * This sets the defined value as the base (similar_text as first)
 *
 * String -> Bool -> ( String -> Int|Float )
 *
 * @param string $base The string to act as the base.
 * @param bool $asPc If set to true will reutrn the percentage match, rather than char count.
 */
function similarAsBase(string $base, bool $asPc = false): callable
{
    /**
     * @param string $comparissonString The string to compare against base.
     * @return int|float
     */
    return function (string $comparissonString) use ($base, $asPc) {
        $pc       = 0.00;
        $matching = similar_text($base, $comparissonString, $pc);
        return $asPc ? $pc : $matching;
    };
}

/**
 * Returns a callable for finding the similarities between 2 string.
 * This sets the defined value as the comparissonString (similar_text as second)
 *
 * String -> Bool -> ( String -> Int|Float )
 *
 * @param string $comparissonString The string to compare against base.
 * @param bool $asPc If set to true will reutrn the percentage match, rather than char count.
 */
function similarAsComparisson(string $comparissonString, bool $asPc = false): callable
{
    /**
     * @param string $comparissonString The string to act as the base.
     * @return int|float
     */
    return function (string $base) use ($comparissonString, $asPc) {
        $pc       = 0.00;
        $matching = similar_text($base, $comparissonString, $pc);
        return $asPc ? $pc : $matching;
    };
}

/**
 * Reutrns a callable for padding out a string.
 *
 * Int -> string -> Int -> ( String -> String )
 *
 * @param int $length Max length to make string.
 * @param string $padContent The value to padd the string with (defulats to ' ')
 * @param int $type How to pad, please use these constants. STR_PAD_RIGHT|STR_PAD_LEFT|STR_PAD_BOTH
 */
function pad(int $length, string $padContent = ' ', int $type = STR_PAD_RIGHT): callable
{
    /**
     * @param string $string The string to pad out.
     * @return string
     */
    return function (string $string) use ($length, $padContent, $type): string {
        return \str_pad($string, $length, $padContent, $type);
    };
}

/**
 * Returns a callable for repeating a string by a defined number of times.
 *
 * Int -> ( String -> String )
 *
 * @param int $count Number of times to repeat string.
 * @return callable
 */
function repeat(int $count): callable
{
    /**
     * @param string $string The string to repeat
     * @return int|float
     */
    return function (string $string) use ($count) {
        return \str_repeat($string, $count);
    };
}

/**
 * Returns a callback for creating a word counter, with set format and char list.
 *
 * Int -> String|Null -> ( String -> Int|Array )
 *
 * @param int $format can use WORD_COUNT_NUMBER_OF_WORDS | WORD_COUNT_ARRAY | WORD_COUNT_ASSOCIATIVE_ARRAY
 * @param string|null $charList The char list of option values considered words.
 */
function wordCount(int $format = WORD_COUNT_NUMBER_OF_WORDS, ?string $charList = null): callable
{
    /**
     * @param string $string The string to pad out.
     * @return int|array
     */
    return function (string $string) use ($format, $charList) {
        return $charList
            ? \str_word_count($string, $format, $charList)
            : \str_word_count($string, $format);
    };
}

/**
 * Creates a function for stripping tags with a defined set of allowed tags.
 *
 * String|Null -> ( String -> String )
 *
 * @param string|null $allowedTags The allowed tags, pass null or leave blank for none.
 * @return callable
 */
function stripTags(?string $allowedTags = null): callable
{
    /**
     * @param string $string The string to strip tags from.
     * @return string
     */
    return function (string $string) use ($allowedTags): string {
        return $allowedTags
            ? \strip_tags($string, $allowedTags)
            : \strip_tags($string);
    };
}

/**
 * Returns a callable for finding the first postition of a defined value in any string.
 *
 * String -> Int -> Bool -> ( String -> String|null )
 *
 * @param string $needle The value to look for.
 * @param int  $offset The offset to start
 * @param int $flags STRINGS_CASE_SENSITIVE | STRINGS_CASE_INSENSITIVE
 * @return callable
 */
function firstPosistion(
    string $needle,
    int $offset = 0,
    int $flags = STRINGS_CASE_SENSITIVE
): callable {
    $caseSensitive = ! (bool) ($flags & STRINGS_CASE_INSENSITIVE); // Assumes true unless INSESNITVE passed

    /**
     * @param string $haystack The haystack to look throuh.
     * @return int|null
     */
    return function (string $haystack) use ($needle, $offset, $caseSensitive): ?int {
        $pos = $caseSensitive
            ? strpos($haystack, $needle, $offset)
            : stripos($haystack, $needle, $offset);
        return is_int($pos) ? (int) $pos : null;
    };
}

/**
 * Returns a callable for finding the first postition of a defined value in any string.
 *
 * String -> Int -> Bool -> ( String -> String|null )
 *
 * @param string $needle The value to look for.
 * @param int  $offset The offset to start
 * @param int $flags STRINGS_CASE_SENSITIVE | STRINGS_CASE_INSENSITIVE
 * @return callable
 */
function lastPosistion(
    string $needle,
    int $offset = 0,
    int $flags = STRINGS_CASE_SENSITIVE
): callable {
    $caseSensitive = ! (bool) ($flags & STRINGS_CASE_INSENSITIVE); // Assumes true unless INSESNITVE passed

    /**
     * @param string $haystack The haystack to look throuh.
     * @return int|null
     */
    return function (string $haystack) use ($needle, $offset, $caseSensitive): ?int {
        $pos = $caseSensitive
            ? strrpos($haystack, $needle, $offset)
            : strripos($haystack, $needle, $offset);
        return is_int($pos) ? (int) $pos : null;
    };
}

/**
 * Returns a callable for looking for the first occurance of a substring.
 * When found can return all after or before the needle (sub string)
 * Can be done as case sensitive (strstr()) or insenstive (stristr())
 *
 * String -> Int -> ( String -> String )
 *
 * @param string $needle The substring to look for.
 * @param int $flags Possible STRINGS_CASE_INSENSITIVE | STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE | STRINGS_BEFORE_NEEDLE
 * @return callable
 */
function firstSubString(
    string $needle,
    int $flags = STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE
): callable {

    // Deocde flags, only look for none defaults.
    $beforeNeedle  = (bool) ($flags & STRINGS_BEFORE_NEEDLE);
    $caseSensitive = ! (bool) ($flags & STRINGS_CASE_INSENSITIVE); // Assumes true unless INSESNITVE passed

    /**
     * @param string $haystack The haystack to look through.
     * @return string
     */
    return function (string $haystack) use ($needle, $beforeNeedle, $caseSensitive): string {
        $result = $caseSensitive
            ? strstr($haystack, $needle, $beforeNeedle)
            : stristr($haystack, $needle, $beforeNeedle);
        return is_string($result) ? $result : '';
    };
}

/**
 * Returns a callable for creating a fucntion which finds the first occurance of
 * any character (from a list) in a defined string.
 *
 * String -> ( String -> String )
 *
 * @param string $chars All chars to check with.
 * @return callable
 */
function firstChar(string $chars): callable
{
    /**
     * @param string $haystack
     * @return string
     */
    return function (string $haystack) use ($chars): string {
        $result = strpbrk($haystack, $chars);
        return is_string($result) ? $result : '';
    };
}

/**
 * Returns a function that finds the last char in a string and returns the following text.
 * Matches the first char passed, if more than 1 char passed, the rest are ignored.
 *
 * String -> ( String -> String )
 *
 * @param string $char
 * @return callable
 */
function lastChar(string $char): callable
{
    /**
     * @param string $haystack
     * @return string
     */
    return function (string $haystack) use ($char): string {
        $result = strrchr($haystack, $char);
        return is_string($result) ? $result : '';
    };
}

/**
 * Returns a callable which translates substrings from a defined dictionary.
 * Dictionary should be ['from' => 'to' ]
 *
 * Array[String] -> ( String -> String )
 *
 * @param array<string, mixed> $dictionary
 * @return callable
 */
function translateWith(array $dictionary): callable
{
    /**
     * @param string $haystack
     * @return string
     */
    return function (string $haystack) use ($dictionary): string {
        $result = strtr($haystack, $dictionary);
        return $result;
    };
}

/**
 * Creates a callable for a string safe function compose.
 *
 * (...(a -> b)) -> ( a -> b )
 *
 * @uses F\composeTypeSafe
 * @param callable ...$callables
 * @return callable
 */
function composeSafeStringFunc(callable ...$callables): callable
{
    return F\composeTypeSafe('is_string', ...$callables);
}

/**
 * Creates a callable for compiling a string.
 *
 * String -> ( String|Null -> (..self..)|String )
 *
 * @param string $initial
 * @return callable
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
