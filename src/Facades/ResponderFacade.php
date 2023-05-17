<?php

namespace Cramtu\Responder\Facades;

use Illuminate\Support\Facades\Facade;

class ResponderFacade extends Facade
{
    /**
     * @method static hasError(): bool
     * @method static setErrorStack(array $errorStack)
     * @method static getErrorStack()
     * @method static clearErrorStack()
     */
    protected static function getFacadeAccessor(): string
    {
        return "ResponderFacade";
    }
}
