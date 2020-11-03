<?php
/**
 * Praktikum DBWT. Autoren
 * Philipp, Hünnerscheidt, 3192361
 * Haydar, Zerelli, 3204408
 */
$result = false;
if (isset($_GET['a']) && isset($_GET['b'])) {
    $a = (int) $_GET['a'];
    $b = (int) $_GET['b'];
    if (isset($_GET['addieren'])) {
        $result = add($a, $b);
    } elseif (isset($_GET['multiplizieren'])) {
        $result = mult($a, $b);
    }
}

function add($a, $b) {
    return $a + $b;
}

function mult($a, $b) {
    return $a * $b;
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mein Formular</title>
</head>
<body>
<form action="m2_4c_adform.php" method="get">
    <fieldset>
        <legend>Rechner</legend><br>
        <input id="a" type="number" name="a" placeholder="13">
        <input id="b" type="number" name="b" placeholder="37">
        <input type="submit" id="addieren" name="addieren" value="add">
        <input type="submit" id="multiplizieren" name="multiplizieren" value="mult">
        <br>
        <?php
            echo "Das Ergebnis lautet: ", $result;
        ?>
    </fieldset>
</form>
</body>
</html>
