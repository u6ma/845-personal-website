<?php

// YO GURT LOG CONTROLLER v1


// Codes
// 100 -> INFO
// 150 -> INVALID CODES FALLBACK
// 200 -> WARNING
// 300 -> ERROR
// 400 -> DEBUG
// 450 -> DEVINFO - MISCELLANEOUS
// 500 -> PRIORITY




class LOGFUNCTIONS {
    private UTIL $UTIL;
    private ENVFUNCTIONS $ENV;
    private ERRORHANDLE $ERR;

    private $logdir;
    private $mlogfile;
    private $dlogfile;


    public function __construct(UTIL $UTIL, ENVFUNCTIONS $ENV, ERRORHANDLE $ERR) {
        $this->UTIL = $UTIL;
        $this->ENV = $ENV;
        $this->ERR = $ERR;

        $this->logdir = __DIR__ . '/../../' . $this->ENV->env("LOG_DIR");
        $this->mlogfile = $this->ENV->env("MAIN_LOG_FILE_NAME");
        $this->dlogfile = $this->ENV->env("DEVELOPMENT_LOG_FILE_NAME");
    }

    protected function logcodeformat(int $SEVERITY): ?string
    {
        $isdev = $this->UTIL->IsDevMode();

        if ($SEVERITY === 100) {
            return "[100] - ";
        } elseif ($SEVERITY === 150) {
            return "[150] {WARNING: INVALID INPUT CODE} - ";
        } elseif ($SEVERITY === 200) {
            return "[200] - ";
        } elseif ($SEVERITY === 300) {
            return "[300] - ";
        } elseif ($SEVERITY === 400 and $this->UTIL->IsDevMode()) {
            return "[D400] - ";
        } elseif ($SEVERITY === 450 and $this->UTIL->IsDevMode()) {
            return "[D450] - ";
        } elseif ($SEVERITY === 500) {
            return "[500] - ";
        } else {
            if (!$this->UTIL->IsDevMode()) {
                $this->ERR->errorlog();
                 return null;
            } else {
                return null;
            }
        }


    }

    public function log(int $SEVERITY,$MSG,$logfile = null,$logdir = null): bool
    {
        if ($logfile === null) {
            $logfile = $this->mlogfile;
        }
        if ($logdir === null || !is_dir($logdir)) {
            $logdir = $this->logdir;
        }
        if ($MSG === null){
            return false;
        }

        if ($SEVERITY === null) {
            $SEVERITY = 150;
        }


        $PREFIX = $this->logcodeformat($SEVERITY);




        $DATE = " (" . date('Y-m-d H:i:s') . ")  ";
        $LINE = $PREFIX . $DATE .  $MSG . PHP_EOL;

        $bytes = file_put_contents($logdir . $logfile, $LINE, FILE_APPEND | LOCK_EX);

        return $bytes !== false;
    }
}

class LOGDEVTOOLS {
    private UTIL $UTIL;
    private ENVFUNCTIONS $ENV;

    private $logdir;
    private $mlogfile;

    public function __construct(UTIL $UTIL, ENVFUNCTIONS $ENV) {
        $this->UTIL = $UTIL;
        $this->ENV = $ENV;

        $this->logdir = __DIR__ . '/../../' . $this->ENV->env("LOG_DIR");
        $this->mlogfile = $this->ENV->env("MAIN_LOG_FILE_NAME");
    }

    public function logdump($logfile = null, $logdir = null): ?array {
        if ($logfile === null) {
            $logfile = $this->mlogfile;
        }
        if ($logdir === null || !is_dir($logdir)) {
            $logdir = $this->logdir;
        }


        if (!file_exists($logdir . $logfile)){
            return null;
        }


        $lines = file($logdir . $logfile, FILE_IGNORE_NEW_LINES);

        if (empty($lines)) {
            return null;
        }

        return $lines;
    }

    public function latestlog($logfile = null, $logdir = null){
        if ($logfile === null) {
            $logfile = $this->mlogfile;
        }
        if ($logdir === null || !is_dir($logdir)) {
            $logdir = $this->logdir;
        }

        if (!file_exists($logdir . $logfile)){
            return null;
        };
        $lines = file($logdir . $logfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (empty($lines)) {
            return null;
        }
        $lastLine = end($lines);
        return $lastLine;

    }


}
