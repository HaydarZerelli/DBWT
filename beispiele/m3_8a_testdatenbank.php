<!--
- Praktikum DBWT. Autoren:
- Haydar, Zerelli, 3204408
- Hünnerscheidt, Philipp, 3192361
-->
<?php
$link = mysqli_connect("127.0.0.1", // Host der Datenbank
    "root",                         // Benutzername zur Anmeldung
    "08101995",                 // Passwort
    "db_emensawerbeseite"   // Auswahl der Datenbanken (bzw. des Schemas)
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}
$sql = "SELECT name,beschreibung FROM gericht";

$result = $link -> query($sql);
?>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Datenbankgerichte</title>
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<table>
    <th>Name des Gerichts</th> <th>Beschreibung des Gerichts</th>
    <tr>
        <?php
        echo "<caption><b>".'Angebotene Gerichte'."</b></caption>";
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $beschreibung = $row['beschreibung'];
            echo "<tr>",
                "<td><center>".$name."</center></td>" .
                "<td><center>".$beschreibung."</center></td>" .
                "</tr>";
        }
        ?>
    </tr>
</table>
</body>
</html>