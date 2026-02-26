<?php
$TITLE = http_response_code()
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ERROR <?= htmlspecialchars($TITLE) ?></title>
    <link href="../static/style/styles.css" rel="stylesheet"/>
</head>

<div class="title">
    <h1 class="masked-text"><?= htmlspecialchars($TITLE) ?></h1>
    <p class="navbar">It seems you have encountered an error</p>
</div>
</body>
</html>
