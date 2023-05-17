<?php

namespace Cramtu\Responder;

use Illuminate\Support\ServiceProvider;

class ResponderServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register(): void
    {
        $this->app->bind("ResponderFacade", function (){
            return new Responder();
        });
    }

}
