<?php
$TITLE = http_response_code()
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>845.lol - ERROR <?= htmlspecialchars($TITLE) ?></title>
    <link href="../static/style/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/svg" href="../static/assets/favicon.svg">
</head>
<body>
<div class="title centred">
    <h1 class="masked-text"><?= htmlspecialchars($TITLE) ?></h1>
</div>
<div class="navbar centred">
    <p>It seems you have encountered an error</p>
    <a href="/">Return Home</a>
</div>
<footer>
    <h3 class="titlething">
        845.lol
    </h3>
    <p>Made by <a href="https://github.com/u6ma/">Ale</a></p>
    <p>Website source is available for free <a href="https://github.com/u6ma/845-personal-website">here</a>.</p>
</footer>
</body>
</html>
