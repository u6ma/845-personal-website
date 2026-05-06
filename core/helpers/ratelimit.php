<?php

// YO GURT RATELIMIT HELPER Version 1

class RATELIMITER {

    // $key should be $_SESSION['$ACTUAL_KEY'] where $ACTUAL_KEY is your actual key duh
    function simple_ratelimit( $key, int $limit): bool
    {
        $period = $limit*5;
        $current_time = time();

        if (!isset($key)) {
            return false;
        }
        $key = array_filter($key, fn($t) => ($current_time - $t) < $period);

        if (count($key) >= $limit) {
            return false;
        }

        $key[] = $current_time;

        return true;
    }

    // same as simple_ratelimit but with a custom period, the $key should be $_SESSION['$ACTUAL_KEY'] where $ACTUAL_KEY is your actual key duh
    function rate_limit( $key, int $limit, int $period): bool
    {
        $current_time = time();
        if (!isset($key)) {
            return false;
        }
        $key = array_filter($key, fn($t) => ($current_time - $t) < $period);

        if (count($key) >= $limit) {
            return false;
        }

        $key[] = $current_time;

        return true;
    }

}
