<?php

// YO GURT MISC UTILITIES HELPER Version 2


class UTIL {
    // ENV_TYPE: 'DEVELOPMENT' or 'PRODUCTION'  inside env
    public function IsDevMode(): bool
    {
        $ENV = new ENVFUNCTIONS();

        if ($ENV->env("ENV_TYPE") === 'DEVELOPMENT') {
           return true;
        } elseif ($ENV->env("ENV_TYPE") === 'PRODUCTION') {
            return false;
        } else {return false;}


    }
}
