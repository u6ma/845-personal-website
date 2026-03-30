<?php

// TODO: FINISH

$TITLE = "Random Number Generator";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function randomIntExcluding(int $min, int $max, array $exclude = []): int
{
    if ($min > $max) {
        throw new InvalidArgumentException('Min must be <= max');
    }

    $range = range($min, $max);
    $allowed = array_values(array_diff($range, $exclude));

    if (empty($allowed)) {
        throw new RuntimeException('No numbers available');
    }

    return $allowed[array_rand($allowed)];
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>845.lol - <?= htmlspecialchars($TITLE) ?></title>
    <link href="../static/style/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/svg" href="../static/assets/icons/favicon.svg">
</head>
<body>
<div class="title centred">
    <h1 class="masked-text"><?= htmlspecialchars($TITLE) ?></h1>
</div>
<nav class="navbar">
    <p><a href="/contact">Contact</a> | <a href="/portfolio">Portfolio</a> | <a href="/projects">Projects</a> | <a href="/gallery">Gallery</a> | <a href="/host">Hosting Services</a></p>
</nav>

<form method="GET" action="/randomnumbers">
    Min: <input type="number" name="min" value="1"><br>
    Max: <input type="number" name="max" value="50"><br>
    Count: <input type="number" name="count" value="5"><br>
    Exclude (comma): <input type="text" name="exclude"><br>
    <button type="submit">Generate</button>
</form>

<form method="POST" action="/randomnumbers">
    <div class="cf-turnstile"
         data-sitekey="<?= htmlspecialchars($_ENV['TURNSTILE_SITE_KEY']) ?>"></div>
    <button type="submit">Generate Number</button>
</form>
<br>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</body>
</html>
