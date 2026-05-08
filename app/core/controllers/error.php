<?php

// YO GURT ERROR CONTROLLER v1


class ERRORHANDLE {
    private UTIL $UTIL;
    private ENVFUNCTIONS $ENV;
    private LOGFUNCTIONS $LOGF;

    private $logdir;
    private $elogfile;


    public function __construct(UTIL $UTIL, ENVFUNCTIONS $ENV, LOGFUNCTIONS $LOGF) {
        $this->UTIL = $UTIL;
        $this->ENV = $ENV;
        $this->LOGF = $LOGF;

        $this->logdir = __DIR__ . '/../../' . $this->ENV->env("LOG_DIR");
        $this->elogfile = $this->ENV->env("ERROR_LOG_FILE_NAME");
    }
    public function createerror($Code,$Debugopts = null){
          if ($Debugopts === null and $this->UTIL->IsDevMode()){
              return null;
          }
    }

    public function logerror($USR = null, $Error, $Location, $Logdir = null, $Logfile = null) {
        if ($Logdir === null || !is_dir($Logdir)){
            $Logdir = $this->logdir;
        };

        if ($Logfile === null){
            $Logfile = $this->elogfile;
        }
        if ($USR === null and $this->UTIL->IsDevMode()) {
            return false;
        }
        if ($Error === null) {
            return false;
        }
        if ($Location === null){
            return false;
        }
        $Line = "ERROR:" . ' "' . $Error . '" AT LOCATION: "' . $Location . '"';

        if ($this->UTIL->IsDevMode()){
            $linedef = $Line . ' BY USER "' . $USR . '" ';
        } else {
             $linedef = $Line;
        }

        $Errortolog = $this->LOGF->log(300,$linedef,$Logfile,$Logdir);

        return $Errortolog !== false;


    }
}
