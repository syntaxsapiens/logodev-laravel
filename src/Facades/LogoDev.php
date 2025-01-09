<?php

namespace Syntaxsapiens\LogoDev\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Syntaxsapiens\LogoDev\LogoDev
 */
class LogoDev extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logodev';
    }
}
