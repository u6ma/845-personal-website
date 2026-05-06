<?php

// YO GURT ACCESS HELPER Version 1

function simpletempaccess(string $key, int $expiry = 30): bool
{
   $accesstime = $_SESSION['once'][$key] ?? 0;

   if (time() - $accesstime > $expiry) {
       return false;
   }

   return true;
}
