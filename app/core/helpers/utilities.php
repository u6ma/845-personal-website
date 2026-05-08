<?php

// YO GURT MISC UTILITIES HELPER Version 2


class UTIL {

    private ENVFUNCTIONS $ENV;

    public function __construct(ENVFUNCTIONS $ENV) {
        $this->ENV = $ENV;
    }

    // ENV_TYPE: 'DEVELOPMENT' or 'PRODUCTION'  inside env
    public function IsDevMode(): bool
    {

        if ($this->ENV->env("ENV_TYPE") === 'DEVELOPMENT') {
           return true;
        } elseif ($this->ENV->env("ENV_TYPE") === 'PRODUCTION') {
            return false;
        } else {return false;}


    }
}
