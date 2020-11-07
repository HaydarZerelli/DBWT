<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_AUTHOR = 'search_author';//Eingefügt um der Author zu suchen.
const GET_PARAM_DESCRIPTION ='show_description';
const GET_PARAM_LANG = 'sprache';

$sprache_gesetzt = false;
if (isset($_GET['submitted']) && $_GET['submitted'] == 1) {
    $sprache_gesetzt = true;
}
if (!$sprache_gesetzt) {
    $sprache = "de";
}
if (isset($_GET[GET_PARAM_LANG])) {
    $sprache = $_GET[GET_PARAM_LANG];
}
$zeigBeschreibung = 0;
if (isset($_GET[GET_PARAM_DESCRIPTION])) {
    $zeigBeschreibung = $_GET[GET_PARAM_DESCRIPTION];
}
$search_text ="";
if (isset($_GET[GET_PARAM_SEARCH_TEXT])) {
    $search_text = $_GET[GET_PARAM_SEARCH_TEXT];
}

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

$translation["de"]["gericht"] = "Gericht";
$translation["en"]["gericht"] = "Meal";

$translation["de"]["nurfuer"] = "f&uuml;r nur ";
$translation["en"]["nurfuer"] = "for only ";

$translation["de"]["fuer"] = "f&uuml;r";
$translation["en"]["fuer"] = "for";

$translation["de"]["und"] = "und";
$translation["en"]["und"] = "and";

$translation["de"]["interne"] = "Interne";
$translation["en"]["interne"] = "members";

$translation["de"]["externe"] = "Externe";
$translation["en"]["externe"] = "non members";

$translation["de"]["description_show"]="Beschreibung zeigen";
$translation["en"]["description_show"]="show description";

$translation["de"]["description_hide"]="Beschreibung verbergen";
$translation["en"]["description_hide"]="hide description";

$translation["de"]["bewertung"]="Bewertung (Insgesamt";
$translation["en"]["bewertung"]="Feedback (Total";

$translation["de"]["suchen"]="Suchen";
$translation["en"]["suchen"]="Search";


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
    <title><?php echo $translation[$sprache]['gericht'].' : '. $meal['name'];?></title>
    <style type="text/css">
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }
        input[id="search_text"] {
            value : <?php GET_PARAM_SEARCH_TEXT ?>
        }
        #lang-link li {
            display: inline-block;
        }
    </style>
</head>
<body>
<!--
<form method="get" action="meal.php">
    <select name="sprache">
        <option value="de">deutsch</option>
        <option value="en">english</option>
    </select>
    <input type="hidden" name="submitted" value="1">
    <button type="submit">submit</button>
</form>-->
<ul id="lang-link">
    <li><a href="?sprache=de" >Deutsch</a></li> |
    <li><a href="?sprache=en" >Englisch</a></li>
</ul>


<h1><?php echo $translation[$sprache]['gericht'].' : '. $meal['name'].' '.$translation[$sprache]['nurfuer'].' '.number_format($meal['price_extern'],2). '&euro; '
        .$translation[$sprache]['fuer'].' '.$translation[$sprache]['externe'].' '.$translation[$sprache]["und"].' ' .number_format($meal['price_intern'],2). ' &euro; '.$translation[$sprache]['fuer'].' '
        .$translation[$sprache]['interne'] .'</h1>';
 ?>


<?php

if (!$zeigBeschreibung){
  echo '<a href="?sprache='.$sprache.'&show_description=1">'.$translation[$sprache]["description_show"].'</a>';
}
else {
  echo '<a href="?sprache='.$sprache.'&show_description=0">'.$translation[$sprache]["description_hide"].'</a>';
}
?>

<p> <?php if ($zeigBeschreibung){
        echo $meal['description'];
    } ?></p>
<h1><?php echo $translation[$sprache]["bewertung"]; ?> : <?php echo calcMeanStars($ratings); ?>)</h1>



<form method="get">
    <label for="search_text">Filter:</label>
    <input id="search_text" type="text" name="search_text" value="<?php echo $search_text?>" >
    <input type="submit" value="<?php echo $translation[$sprache]["suchen"]; ?>">
</form>

            <table class="rating" id="de">
                <thead>
                <?php if ($sprache == "de") {
                    ?>
                <tr>
                    <td>Text</td>
                    <td>Sterne</td>
                    <td>Autor</td>
                </tr>
                 <?php
                }
                else
                {
                    ?>
                    <tr>
                        <td>Text</td>
                        <td>Stars </td>
                        <td>Author</td>
                    </tr>
                <?php
                }
                ?>
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