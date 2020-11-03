<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_AUTHOR = 'search_author';//Eingefügt um der Author zu suchen.
const GET_PARAM_DESCRIPTION ='show_description';
/**
 * Liste aller möglichen Allergene.
 */
$allergens = array(
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch')
;
$meal = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42   // Anzahl der verfügbaren Gerichte.
];
$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (strpos(strtolower($rating['text']), strtolower($searchTerm)) !== false) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }
    /*Diese else if habe eingefügt für die Autoren zu suchen*/
}else if (!empty($_GET[GET_PARAM_AUTHOR])){
    $searchAuthor = $_GET[GET_PARAM_AUTHOR];
    foreach ($ratings as $rating) {
        if (strpos($rating['author'], $searchAuthor) !== false) {
            $showRatings[] = $rating;
        }
    }
} else {
    $showRatings = $ratings;
}
function calcMeanStars($ratings) : float { // : float gibt an, dass der Rückgabewert vom Typ "float" ist
    $sum = 0;
//    $i = 1;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'];
//        $i++;
    }
    return $sum / count($ratings);
}
$showAllergene=[];
foreach ($meal['allergens'] as $allerg){
    $showAllergene[]=$allergens["$allerg"];
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title>Gericht: <?php echo $meal['name'];?></title>
    <style type="text/css">
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }

    </style>

</head>
<body>
<!--    Diesen Select dient für die Sprache der Seite -->
<select  method="get" id="langselector">
    <option value="de">Deutsch</option>
    <option value="en">Englich</option>
</select>

<h1>Gericht: <?php echo $meal['name']; ?></h1>
<p> <?php echo $meal['description']; ?></p>
<h1>Bewertungen (Insgesamt: <?php echo calcMeanStars($ratings); ?>)</h1>
<form method="get">
    <label for="search_text">Filter:</label>
    <input id="search_text" type="text" name="search_text">
    <input type="submit" value="Suchen">
</form>
<table class="rating">
    <thead>
    <tr>
        <td>Text</td>
        <td>Sterne</td>
        <td>Author</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($showRatings as $rating) {
        echo "<tr><td class='rating_text'>{$rating['text']}</td>
                      <td class='rating_stars'>{$rating['stars']}</td>
                      <td class='rating_authors'>{$rating['author']}</td>/*das ist das Table*/
                  </tr>";
    }
    ?>
    </tbody>
</table>
           <!-- Liste von Allergene Ausgeben -->
<ul class="allerg">
    <?php
    foreach($showAllergene as $allerg ){
        echo " <li>{$allerg}</li>";
    }
    ?>
</ul>
</body>
</html>