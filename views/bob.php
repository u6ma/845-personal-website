<?php
$TITLE = "BOB WILL COME FOR YOU";

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($TITLE) ?></title>
    <link href="../static/style/styles.css" rel="stylesheet"/>
</head>
<body>
<div class="title">
    <h1 id="bobtitle"><?= htmlspecialchars($TITLE) ?></h1>
    <nav id="navbar">
        <a class="masked-text" id="sayhi">Say hi to bob</a>
    </nav>
</div>
</body>
</html>
