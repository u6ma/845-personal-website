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
<body>
<div class="title centred">
    <h1 class="masked-text"><?= htmlspecialchars($TITLE) ?></h1>
</div>
<div class="navbar centred">
    <p>It seems you have encountered an error</p>
    <a href="/">Return Home</a>
</div>
</body>
</html>
