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

if ($_GET["sprache"] == "" && $GET_PARAM_LANG="")
{$GET_PARAM_LANG = "de";}
else if ($_GET["sprache"] == "de")
{$GET_PARAM_LANG="de";}
else if ($_GET["sprache"] == "en")
{$GET_PARAM_LANG="en";}
else {$GET_PARAM_LANG="de";}
$translation["de"]["description_show"]="Beschreibung zeigen";
$translation["en"]["description_show"]="show description";

$translation["de"]["description_hide"]="Beschreibung verbergen";
$translation["en"]["description_hide"]="hide description";

$translation["de"]["bewertung"]="Bewertung (Insgesamt";
$translation["en"]["bewertung"]="Feedback (Total";

$translation["de"]["suchen"]="Suchen";
$translation["en"]["suchen"]="Search";


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
        input[id="search_text"] {
            value : <?php GET_PARAM_SEARCH_TEXT ?>
        }
    </style>
</head>
<body>
<ul style=" padding:0; ">
    <li style=" display:inline-block; "><a href="?sprache=de" >Deutsch</a></li> |
    <li style="display:inline-block;" ><a href="?sprache=en" >Englisch</a></li>
</ul>
<?php //echo $_SERVER["REQUEST_URI"];     ?>
<?php //echo $GET_PARAM_LANG; ?>
<h1>Gericht: <?php echo $meal['name']; ?> nur für <?php echo number_format($meal['price_extern'],2) ?>  &euro; für Externe und <?php echo number_format($meal['price_intern'],2)?> &euro; für Interne</h1>

 <?php  if ($_GET[GET_PARAM_DESCRIPTION] == "" || $_GET[GET_PARAM_DESCRIPTION]== "0" ){
 ?>  <a href="?sprache=<?php echo $GET_PARAM_LANG; ?>&show_description=1" ><?php echo $translation[$GET_PARAM_LANG]["description_show"]; ?></a> <?php
}
else {
 ?> <a href="?sprache=<?php echo $GET_PARAM_LANG; ?>&show_description=0" ><?php echo $translation[$GET_PARAM_LANG]["description_hide"]; ?></a> <?php
}
?>

<p> <?php if ($_GET[GET_PARAM_DESCRIPTION] == 1){
        echo $meal['description'];
    } ?></p>
<h1><?php echo $translation[$GET_PARAM_LANG]["bewertung"]; ?> : <?php echo calcMeanStars($ratings); ?>)</h1>
<form method="get">
    <label for="search_text">Filter:</label>
    <input id="search_text" type="text" name="search_text" value= <?php echo $_GET[GET_PARAM_SEARCH_TEXT] ?> >
    <input type="submit" value="<?php echo $translation[$GET_PARAM_LANG]["suchen"]; ?>">
</form>

            <table class="rating" id="de">
                <thead>
                <?php if ($GET_PARAM_LANG == "de") {
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