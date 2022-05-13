<?php

declare(strict_types=1);

namespace PinkCrab\FunctionConstructors\Tests\Providers;

use PHPUnit\Framework\TestCase;
use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Numbers as Num;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\FunctionsLoader;
use PinkCrab\FunctionConstructors\GeneralFunctions as Func;

class ObjectFactory
{
    /**
     * Returns a class with proivate, protected and public properties.
     * Value match the property names, which match the visibility.
     * ie $class->public = 'public'
     *
     * @return void
     */
    public static function mixedPropertyTypes()
    {
        return new class () {
            protected $protected = 'protected';
            private $private = 'private';
            public $public = 'public';

            public function setPrivate($value): void
            {
                $this->private = $value;
            }

            public function setProtected($value): void
            {
                $this->protected = $value;
            }
        };
    }
}
