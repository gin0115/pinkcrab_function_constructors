<?php

declare(strict_types=1);

/**
 * Collection of constants used for simple functions.
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

class Functions
{
    ## Comparisons ##

    /**
     * Constants used for PinkCrab\FunctionConstructors\Comparisons\notEmpty(mixed $val):bool
     */
    public const NOT_EMPTY = 'PinkCrab\FunctionConstructors\Comparisons\notEmpty';

    /**
     * Constants used for PinkCrab\FunctionConstructors\Comparisons\isTrue(mixed $val):bool
     */
    public const IS_TRUE = 'PinkCrab\FunctionConstructors\Comparisons\isTrue';

    /**
     * Constants used for PinkCrab\FunctionConstructors\Comparisons\isFalse(mixed $val):bool
     */
    public const IS_FALSE = 'PinkCrab\FunctionConstructors\Comparisons\isFalse';

    /**
     * Constants used for PinkCrab\FunctionConstructors\Comparisons\isNumber(mixed $val):bool
     */
    public const IS_NUMBER = 'PinkCrab\FunctionConstructors\Comparisons\isNumber';


    ## Arrays ##

    /**
     * Constants used for PinkCrab\FunctionConstructors\Arrays\head(array $array):?mixed
     */
    public const ARRAY_HEAD = 'PinkCrab\FunctionConstructors\Arrays\head';

    /**
     * Constants used for PinkCrab\FunctionConstructors\Arrays\tail(array $array):?mixed
     */
    public const ARRAY_TAIL = 'PinkCrab\FunctionConstructors\Arrays\tail';
}
