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
 * @param string $opening
 * @param string|null $closing
 * @return callable
 * @annotation : string -> string|null -> ( string -> string )
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
 * @param string $openingTag
 * @param string|null $closingTag
 * @return callable
 * @annotation : string -> string|null -> ( string -> string )
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
 * @param string $url
 * @param string|null $target
 * @return callable
 * @annotation : string -> string|null -> ( string -> string )
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
                $target ?? '_blank',
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
 * Creates a callable for preppedning to a string.
 *
 * @param string $prepend
 * @return callable
 * @annotation : string -> ( string -> string )
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
 * @param string $append
 * @return callable
 * @annotation : string -> ( string -> string )
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
 * Creates a double curried find to replace.
 *
 * @param stirng  $find Value to look for
 * @return callable
 * @annotation : string -> ( string ) -> ( string -> stirng )
 */
function findToReplace(string $find): callable
{
    /**
     * @param string $replace value to replace with
     * @return callable
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
 * @param stirng  $find
 * @param stirng  $replace
 * @return callable
 * @annotation : string -> string -> ( string -> stirng )
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
 * Creates a callable for checking if a string starts with
 *
 * @param string $find The value to look for.
 * @return callable
 * @annotation : string -> ( string -> bool )
 */
function startsWith(string $find): callable
{
    /**
     * @param string $source
     * @return bool
     */
    return function (string $source) use ($find): bool {
        return ( \substr($source, 0, \strlen($find)) === $find );
    };
}

/**
 * Creates a callable for checkin if a string ends with
 *
 * @param string $find The value to look for.
 * @return callable
 * @annotation : string -> ( string -> bool )
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
        return ( \substr($source, - \strlen($find)) === $find );
    };
}

/**
 * Creates a callable for checking if a string contains. using str_contains
 *
 * @param string $needle The value to look for.
 * @return callable
 * @annotation : string -> ( string -> bool )
 */
function contains(string $needle): callable
{
    /**
     * @param string $haystack String to look in.
     * @return bool
     */
    return function (string $haystack) use ($needle): bool {
        return \str_contains($haystack, $needle);
    };
}

/**
 * Creates a callable for checking if a string contains using preg_match.
 *
 * @param string $pattern
 * @return void
 * @annotation : string -> ( string -> bool )
 */
function containPattern(string $pattern): callable
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
 * @param string $pattern
 * @return callable
 * @annotation string -> ( string -> array|null )
 */
function splitPattern(string $pattern): callable
{
    /**
     * @param stirng $name
     * @return array
     */
    return function (string $string) use ($pattern): ?array {
        return \preg_split($pattern, $string);
    };
}

/**
 * Converts a number (loose type) to a string representation of a float.
 *
 * @param string $precission Number of decimal places
 * @param string $point The deciaml seperator
 * @param string $thousands The thousand seperator.
 * @return callable
 * @annotation int -> string -> string -> ( string|int|float -> string )
 */
function decimialNumber(int $precission = 2, $point = '.', $thousands = ''): callable
{
    /**
     * @param stirng|int|float $number
     * @return string|null
     */
    return function ($number) use ($precission, $point, $thousands): ?string {
        return \number_format((float) $number, $precission, $point, $thousands);
    };
}

/**
 * Returns a callable for adding C slashes to a string based on a defined pattern.
 *
 * @param string $charList The Char list to add slashes too.
 * @return callable
 * @annotation string -> ( string -> string )
 */
function addCSlashes(string $charList): callable
{
    /**
     * @param string $string The stirng to have char, slash escaped.
     * @return string
     */
    return function (string $string) use ($charList): string {
        return \addcslashes($string, $charList);
    };
}

/**
 * Returns a callable for splitting a string by a set amount.
 *
 * @param int $length The length to split the sring up with.
 * @return array The parts.
 */
function split(int $length): callable
{
    /**
     * @param string $string The stirng to be split
     * @return string
     */
    return function (string $string) use ($length): array {
        return \str_split($string, $length);
    };
}

/**
 * Returns a callback for splitting a string into chunks.
 *
 * @param init $length The legenth of each chunk.
 * @param string $end The string to use at the end.
 * @return callable
 * @annotation Int -> String -> ( String -> String )
 */
function chunkSplit(int $length, string $end = '\r\n'): callable
{
     /**
     * @param string $string The stirng to be chunked
     * @return string
     */
    return function (string $string) use ($length, $end): string {
        return \chunk_split($string, $length, $end);
    };
}

/**
 * Returns a callback for counting the number of occurances of each char in a string.
 *
 * @link https://www.php.net/manual/en/function.count-chars.php
 * @param int $mode See the PHP docs for details.
 * @return callable
 * @annotation Int -> ( String -> Array )
 */
function countChars(int $mode = 1): callable
{
    /**
     * @param string $string The string to have its char counted.
     * @return array
     */
    return function (string $string) use ($mode): array {
        return \count_chars($string, $mode);
    };
}

/**
 * Returns a callable for doing repeated ltrim.
 *
 * @param string $mask
 * @return callable
 * @annotation String -> ( String -> String )
 */
function lTrim(string $mask = ''): callable
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
 * @param string $mask
 * @return callable
 * @annotation String -> ( String -> String )
 */
function rTrim(string $mask = ''): callable
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
 * @param string $base The stirng to act as the base.
 * @param bool $asPc If set to true will reutrn the percentage match, rather than char count.
 * @annotation String -> Bool -> ( String -> Int|Float )
 */
function similarTextAsBase(string $base, bool $asPc = false): callable
{
    /**
     * @param string $comparissonString The string to compare against base.
     * @return int|float
     */
    return function (string $comparissonString) use ($base, $asPc) {
        $pc = 0.00;
        $matching = similar_text($base, $comparissonString, $pc);
        return $asPc ? $pc : $matching;
    };
}

/**
 * Returns a callable for finding the similarities between 2 string.
 * This sets the defined value as the comparissonString (similar_text as second)
 *
 * @param string $comparissonString The string to compare against base.
 * @param bool $asPc If set to true will reutrn the percentage match, rather than char count.
 * @annotation String -> Bool -> ( String -> Int|Float )
 */
function similarTextAsComparisson(string $comparissonString, bool $asPc = false): callable
{
    /**
     * @param string $comparissonString The stirng to act as the base.
     * @return int|float
     */
    return function (string $base) use ($comparissonString, $asPc) {
        $pc = 0.00;
        $matching = similar_text($base, $comparissonString, $pc);
        return $asPc ? $pc : $matching;
    };
}

/**
 * Reutrns a callable for padding out a string.
 *
 * @param int $length Max length to make string.
 * @param string $padContent The value to padd the stirng with (defulats to ' ')
 * @param int $type How to pad, please use these constants. STR_PAD_RIGHT|STR_PAD_LEFT|STR_PAD_BOTH
 * @annotation Int -> Stirng -> Int -> ( String -> String )
 */
function pad(int $length, string $padContent = ' ', int $type = STR_PAD_RIGHT): callable
{
    /**
     * @param string $string The string to pad out.
     * @return int|float
     */
    return function (string $string) use ($length, $padContent, $type) {
        return \str_pad($string, $length, $padContent, $type);
    };
}

/**
 * Returns a callable for repeating a string by a defined number of times.
 *
 * @param int $count Number of times to repeat string.
 * @return callable
 * @annotation Int -> ( String -> String )
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
 * @param int $format can use WORD_COUNT_NUMBER_OF_WORDS | WORD_COUNT_ARRAY | WORD_COUNT_ASSOCIATIVE_ARRAY
 * @param string|null $charList The char list of option values considered words.
 * @annotation Int -> String|null -> ( String -> Int|Array )
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
 * @param string|null $allowedTags The allowed tags, pass null or leave blank for all.
 * @return callable
 * @annotation String|null -> ( String -> String )
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
 * @param string $needle The value to look for.
 * @param int  $offset The offset to start
 * @param int $flags STRINGS_CASE_SENSITIVE | STRINGS_CASE_INSENSITIVE
 * @return callable
 * @annotation String -> Int -> Bool -> ( String -> String|null )
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
        return ! C\isFalse($pos) ? $pos : null;
    };
}

/**
 * Returns a callable for finding the first postition of a defined value in any string.
 *
 * @param string $needle The value to look for.
 * @param int  $offset The offset to start
 * @param int $flags STRINGS_CASE_SENSITIVE | STRINGS_CASE_INSENSITIVE
 * @return callable
 * @annotation String -> Int -> Bool -> ( String -> String|null )
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
        return ! C\isFalse($pos) ? $pos : null;
    };
}

/**
 * Returns a callable for looking for the first occurance of a substring.
 * When found can return all after or before the needle (sub string)
 * Can be done as case sensitive (strstr()) or insenstive (stristr())
 *
 * @param string $needle The substring to look for.
 * @flags int $flags Possible STRINGS_CASE_INSENSITIVE | STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE | STRINGS_BEFORE_NEEDLE
 * @return callable
 * @annotation String -> Bool -> Bool -> ( String -> String|null )
 */
function firstSubString(
    string $needle,
    int $flags = STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE
): callable {

    // Deocde flags, only look for none defaults.
    $beforeNeedle = (bool) ($flags & STRINGS_BEFORE_NEEDLE);
    $caseSensitive = ! (bool) ($flags & STRINGS_CASE_INSENSITIVE); // Assumes true unless INSESNITVE passed

    /**
     * @param string $haystack The haystack to look through.
     * @return int|null
     */
    return function (string $haystack) use ($needle, $beforeNeedle, $caseSensitive): ?string {
        $result = $caseSensitive
            ? strstr($haystack, $needle, $beforeNeedle)
            : stristr($haystack, $needle, $beforeNeedle);
        return ! C\isFalse($result) ? $result : null;
    };
}

/**
 * Returns a callable for creating a fucntion which finds the first occurance of
 * any character (from a list) in a defined string.
 *
 * @param string $chars All chars to check with.
 * @return callable
 * @annotation String -> ( String -> String|null )
 */
function firstCharInString(string $chars): callable
{
    /**
     * @param string $haystack
     * @return string|null
     */
    return function (string $haystack) use ($chars): ?string {
        $result = strpbrk($haystack, $chars);
        return ! C\isFalse($result) ? $result : null;
    };
}

/**
 * Returns a callable for looking for the last occurance of a substring.
 * Can be done as case sensitive (strrpos()) or insenstive (strripos())
 *
 * @param string $needle The substring to look for.
 * @flags int $flags Possible STRINGS_CASE_INSENSITIVE | STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE | STRINGS_BEFORE_NEEDLE
 * @return callable
 * @annotation String -> Bool -> Bool -> ( String -> String|null )
 */
// function lastSubString(
//     string $needle,
//     int $flags = STRINGS_CASE_SENSITIVE | STRINGS_AFTER_NEEDLE
// ): callable {

//     // Deocde flags, only look for none defaults.
//     $beforeNeedle = (bool) ($flags & STRINGS_BEFORE_NEEDLE);
//     $caseSensitive = ! (bool) ($flags & STRINGS_CASE_INSENSITIVE); // Assumes true unless INSESNITVE passed

//     /**
//      * @param string $haystack The haystack to look through.
//      * @return int|null
//      */
//     return function (string $haystack) use ($needle, $beforeNeedle, $caseSensitive): ?string {
//         $result = $caseSensitive
//             ? strrpos($haystack, $needle, $beforeNeedle)
//             : strripos($haystack, $needle, $beforeNeedle);
//         return ! C\isFalse($result) ? $result : null;
//     };
// }



/**
 * Returns a function that finds the last char in a string and returns the following text.
 * Matches the first char passed, if more than 1 char passed, the rest are ignored.
 *
 * @param string $char
 * @return callable
 * @annoation String -> ( String -> String|null )
 */
function lastCharInString(string $char): callable
{
    /**
     * @param string $haystack
     * @return string|null
     */
    return function (string $haystack) use ($char): ?string {
        $result = strrchr($haystack, $char);
        return ! C\isFalse($result) ? $result : null;
    };
}

/**
 * Returns a callable which translates substrings from a defined dictionary.
 * Dictionary should be ['from' => 'to' ]
 *
 * @param array $dictionary
 * @return callable
 * @annoation Array -> ( String -> String )
 */
function translateSubStrings(array $dictionary): callable
{
    /**
     * @param string $haystack
     * @return string|null
     */
    return function (string $haystack) use ($dictionary): ?string {
        $result = strtr($haystack, $dictionary);
        return C\isFalse($result) ? null : $result;
    };
}

/**
 * Creates a callable for a string safe function compose.
 *
 * @uses F\composeTypeSafe
 * @param callable ...$callables
 * @return callable
 * @annotation (...(a -> b)) -> ( a -> b )
 */
function composeSafeStringFunc(callable ...$callables): callable
{
    return F\composeTypeSafe('is_string', ...$callables);
}

/**
 * Creates a callable for compiling a string.
 *
 * @param string $initial
 * @return callable
 * @throws TypeError If not string or null passed.
 * @annotation ( string ) -> ( string|null -> ( string -> (..self..)| string ) )
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
