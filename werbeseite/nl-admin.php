<!--
- Praktikum DBWT. Autoren:
- Haydar, Zerelli, 3204408
- Hünnerscheidt, Philipp, 3192361
-->
<?php
const GET_PARAM_SEARCH_NAME = 'sort_name';
const GET_PARAM_SEARCH_EMAIL = 'sort_email';
const GET_PARAM_NAME = 'search_name';

$file = file('newsletterdata.csv');

foreach($file as $l) {
    $sort[] = explode(",",$l);
}

$name = array_column($sort, 0);


?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Admin-Tool</title>
    <style type="text/css">
        table, th, td {
            border: 1px solid grey;
            background-color: peachpuff;
            border-color: black;
        }

    </style>
</head>
<body>
<form method="get">
    <label for="Name"><input type="submit" name="sort_name" value="Sortierung nach Name (aufsteigend)"></label>
    <input type="submit" name="sort_email" value="Sortierung nach E-Mail (aufsteigend)">
</form>
<br>
<form method="get">
    <?php if(isset($_GET[GET_PARAM_NAME]))
    {
        $b = $_GET[GET_PARAM_NAME];
    }
    ?>
    <label for="search_name">Filter:</label>
    <input id="search_text" type="text" name="search_name" value="<?=htmlspecialchars($b);?>">

    <input type="submit">
    <table>
        <tr>
            <?php
            $filter = [];
            if(isset($b))
            {
                $searchName = $b;
                foreach ($sort as $form) {
                    if (strpos(strtolower($form[0]), strtolower($b)) !== false) {
                        $filter[] = $form;
                    }
                }

                echo "<th>Nachname</th> <th>E-Mail Adresse</th> <th>Sprache</th> <th>Datenschutzstatus</th>";
                foreach ($filter as $index) {
                    echo "<tr>",
                        "<td><center>$index[0]</center></td>".
                        "<td><center>$index[1]</center></td>".
                        "<td><center>$index[2]</center></td>".
                        "<td><center>$index[3]</center></td>".
                        "</tr>";
                }
            }
            ?>
        </tr>
    </table>
</form>
<table>
    <tr>
        <th>Nachname</th> <th>E-Mail Adresse</th> <th>Sprache</th> <th>Datenschutzstatus</th>
        <?php

        $email = array_column($sort, 1);

        foreach ($sort as $form)
        {
            if(!isset($_GET[GET_PARAM_SEARCH_NAME]) && !isset($_GET[GET_PARAM_SEARCH_EMAIL])) {
                echo "<tr>",
                    "<td><center>$form[0]</center></td>" .
                    "<td><center>$form[1]</center></td>" .
                    "<td><center>$form[2]</center></td>" .
                    "<td><center>$form[3]</center></td>" .
                    "</tr>";
            }
        }
        if (isset($_GET[GET_PARAM_SEARCH_NAME])) {
            array_multisort($name, SORT_STRING, $sort);
            foreach ($sort as $form) {
                echo "<tr>",
                    "<td><center>$form[0]</center></td>" .
                    "<td><center>$form[1]</center></td>" .
                    "<td><center>$form[2]</center></td>" .
                    "<td><center>$form[3]</center></td>" .
                    "</tr>";
            }
        }
        if (isset($_GET[GET_PARAM_SEARCH_EMAIL])) {
            array_multisort($email, SORT_STRING, $sort);
            foreach ($sort as $form) {
                echo "<tr>",
                    "<td><center>$form[0]</center></td>" .
                    "<td><center>$form[1]</center></td>" .
                    "<td><center>$form[2]</center></td>" .
                    "<td><center>$form[3]</center></td>" .
                    "</tr>";
            }
        }
        ?>
    </tr>
</body>
</html>