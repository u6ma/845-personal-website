<?php

// YO GURT CLOUDFLARE HELPER Version 1

function CloudflareTurnstileVerify(string $token, string $secret): bool
{
    $verify = file_get_contents(
        "https://challenges.cloudflare.com/turnstile/v0/siteverify",
        false,
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query([
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $_SERVER['REMOTE_ADDR'],
                ]),
            ]
        ])
    );

    if ($verify === false) {
           return false;
    }

    $result = json_decode($verify, true);

    return !empty($result['success']);
}
