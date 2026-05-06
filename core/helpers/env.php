<?php

// YO GURT ENV HELPER Version 2

class ENVFUNCTIONS {
    private $basefile = __DIR__ . '/../../.env';

    public function env(string $key, $file = null) {
        if ($file === null) {
            $file = $this->basefile;
        }
        if (!file_exists($file) || !is_readable($file)) {
            return null;
        }

        $get = file_get_contents($file);
        if ($get === false) {
            return null;
        }

        $parse = parse_ini_string($get);

        if ($parse === false) {

            return null;
        }

        return $parse[$key] ?? null;
    }

    public function envprint($file = null): ?array
    {
        if ($file === null) {
            $file = $this->basefile;
        }

        if (!file_exists($file) || !is_readable($file)) {
            return null;
        }

        $get = file_get_contents($file);
        if ($get === false) {
            return null;
        }

        $envstring = [];

        foreach (parse_ini_string($get) as $key => $value) {
            $envstring[] = "$key=$value";
        }
        return $envstring;
    }

}
