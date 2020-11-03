<?php
/**
 * Praktikum DBWT. Autoren
 * Philipp, Hünnerscheidt, 3192361
 * Haydar, Zerelli, 3204408
 */

$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese', 'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => 2019]
];

function keine_gewinner($famousMeals) {
    $winner_years = [];
    foreach ($famousMeals as $meal) {
        if (is_array($meal['winner'])) {
            $winner_years = array_merge($winner_years, $meal['winner']);
        } else {
            $winner_years = array_merge($winner_years, [$meal['winner']]);
        }
    }
    $years = [];
    for ($i = 2000; $i < 2020; $i++) {
        array_push($years, $i);
    }
    return array_diff($years, $winner_years);
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        li{
            margin-bottom: 10px;
        }
    </style>
    <title>Mein Formular</title>
</head>
<body>
    <ol>
        <?php
        foreach ($famousMeals as $meal) {
            echo "<li>" . $meal['name']  . "<br>";
            if(is_array($meal['winner'])) {
                echo implode(", ", $meal['winner']);
            } else {
                echo $meal['winner'];
            }
            echo "</li>";
        }
        ?>
    </ol>

    <?php
    echo "verlierer jahre: ";
    echo implode(", ", keine_gewinner($famousMeals));
    ?>
</body>
</html>
