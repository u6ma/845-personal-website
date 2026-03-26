<?php
$TITLE = "Contact";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>845.lol - <?= htmlspecialchars($TITLE) ?></title>
    <link href="../static/style/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/svg" href="../static/assets/favicon.svg">
</head>
<body>
<div class="title centred">
    <h1 class="masked-text"><?= htmlspecialchars($TITLE) ?></h1>
</div>
<nav class="navbar centred">
    <p><a href="/">Home</a> | <a href="/portfolio">Portfolio</a> | <a href="/projects">Projects</a> |
        <a href="/gallery">Gallery</a> | <a href="/host">Hosting Services</a></p>
</nav>
<form method="POST" action="/contact">
    <div class="cf-turnstile"
         data-sitekey="<?= htmlspecialchars($_ENV['TURNSTILE_SITE_KEY']) ?>"></div>
    <button type="submit">Show Contact Info</button>
</form>
<br>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</body>
</html>
