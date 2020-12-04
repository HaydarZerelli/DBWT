<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gericht_select_all() {
    $link = connectdb();

    $sql = "SELECT id, name, beschreibung FROM gericht ORDER BY name";
    $result = mysqli_query($link, $sql);

    $data = mysqli_fetch_all($result, MYSQLI_BOTH);

    mysqli_close($link);
    return $data;
}
function db_gericht_select_pig2() {
    $link = connectdb();
    $sql = "SELECT name, preis_intern From gericht WHERE preis_intern > 2 ORDER BY name DESC";
    $result = mysqli_query($link, $sql);
    $data= mysqli_fetch_all($result, MYSQLI_BOTH);
    mysqli_close($link);
    return $data;
}
function db_gericht_alle_gerichte_mit_allergenen() {
    $link = connectdb();

    $mysqli= "SELECT gericht.name, GROUP_CONCAT(gericht_hat_allergen.code), preis_intern, preis_extern
                FROM gericht
                LEFT JOIN gericht_hat_allergen ON gericht_hat_allergen.id = gericht.id
                GROUP BY gericht.name
                Order by gericht.name;
                ";
    $result = mysqli_query($link, $mysqli);
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    $data = mysqli_fetch_all($result, MYSQLI_BOTH);

    mysqli_close($link);
    return $data;
}

