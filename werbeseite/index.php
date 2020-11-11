<!DOCTYPE html>
<!--
- Praktikum DBWT. Autoren:
- Haydar, Zerelli, 3204408
- Hünnerscheidt, Philipp, 3192361
-->
<?php
$visit_count = unserialize(file_get_contents("./visits.txt"));
$visit_count = $visit_count + 1;
file_put_contents("./visits.txt", serialize($visit_count));
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>E-Mensa</title>
</head>
<body>
    <div class="container">
    <header>
        <nav>
            <div class="row">
                <!-- E-Mensa Logo -->
                <div class="col-2">
                    <a href="index.php">
                        <img id="logo" alt="logo" src="e-mensa_logo.png">
                    </a>
                </div>
                <!-- Navigation Bar -->
                <div class="col-10">
                    <ul>
                        <li><a href="#ankuendigung">Ank&uuml;ndigung</a></li>
                        <li><a href="#speisen">Speisen</a></li>
                        <li><a href="#zahlen">Zahlen</a></li>
                        <li><a target="_blank" href="../beispiele/Wir_Sind.html">Kontakt</a></li>
                        <li><a href="#wichtig-fuer-uns">wichtig f&uuml;r uns</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <hr>
    <main>
        <div class="row main">
            <div class="col-2"></div>

            <div class="col-8">
                <!-- bild -->
                <div class="row">
                    <img src="https://via.placeholder.com/760x150" alt="placeholder">
                </div>
                <!-- Ankündigung -->
                <a name="ankuendigung"></a>
                <div class="row">
                    <h1>Bald gibt es Essen auch online ;)</h1>
                </div>
                <!-- text box -->
                <div class="row" id="textbox">
                    <p>Lorem Ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.
                        C/O https://placeholder.com/text/lorem-ipsum/
                    </p>
                </div>
                <!-- speisen table -->
                <a name="speisen"></a>
                <div class="row">
                    <h1>K&ouml;stlichkeiten, die Sie erwarten</h1>
                    <table class="food-table">
                        <tr>
                            <th class="dish"></th>
                            <th class="preis-intern">Preis intern</th>
                            <th class="preis-extern">Preis extern</th>
                        </tr>
                        <?php
                        $gerichte = unserialize(file_get_contents("./gerichte.txt"));

                        foreach ($gerichte as $gericht) {
                            echo "<tr>
                            <td>" . $gericht['desc'] . "</td>
                            <td>" . $gericht['preis-int'] . "</td>
                            <td>" . $gericht['preis-ext'] . "</td>
                            </tr>";
                        }
                        ?>
                    </table>
                    <div class="row">
                    <?php
                    foreach ($gerichte as $gericht) {
                        echo '<div class="col-3">
                        <img class="food-pic" src="'.$gericht['bild'].'" alt="'.$gericht['desc'].'">
                        <a>'.$gericht['desc'].'</a>
                        </div>';
                    }
                    ?>
                    </div>
                </div>

                <!-- e mensa in zahlen -->
                <a name="zahlen"></a>
                <div class="row" id="num-table-row">
                    <h1>E-Mensa in Zahlen</h1>
                    <table class="num-table">
                        <tr>
                            <th class="num-table-x"><?php echo $visit_count;?></th>
                            <th class="num-table-besuche">Besuche</th>
                            <th class="num-table-y"><?php echo count(file("./newsletterdata.csv"));?></th>
                            <th class="num-table-anmeldungen">Anmeldungen zum Newsletter</th>
                            <th class="num-table-z"><?php echo count($gerichte); ?></th>
                            <th class="num-table-speisen">Speisen</th>
                        </tr>
                    </table>
                </div>
                <!-- newsletter -->
                <div class="row newsletter-anmeldung">
                    <div class="col-12">
                        <div class="row"><h1>Interesse geweckt? Wir informieren Sie!</h1></div>
                        <form name="Anmeldung" method="post" target="_self" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <?php
                            $fehler = array();
                            $email = $_POST['email'] ?? NULL;
                            $name = $_POST['vorname'] ?? NULL;
                            $ds = $_POST['ds'] ?? NULL;
                            $sprache = $_POST['sprache'] ?? NULL;

                            if (isset($_POST['submitted'])) {

                                $name = trim($name);
                                if (empty($name)) {
                                    array_push($fehler, "Name darf nicht leer sein!");
                                }
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    array_push($fehler, "E-Mail Adresse ung&uuml;ltig!");
                                }
                                if (!$ds) {
                                    array_push($fehler, "Datenschutzbestimmung nicht akzeptiert!");
                                }

                                $exp = array("/@rcpt.at/i", "/@damnthespam.at/i", "/@wegwerfmail.de/i", "/@trashmail./i");
                                foreach ($exp as $e) {
                                    if (preg_match($e, $email)) {
                                        array_push($fehler, "E-Mail Adresse als Spammail erkannt!");
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?php if ($fehler) {
                                echo '<div class="row">
                        <p>Fehler bei der Anmeldung:</p>
                        <ul>';
                                foreach ($fehler as $f) {
                                    echo '<li>'.$f.'</li>';
                                }
                                echo '</ul></div>';
                            }?>
                            <div class="row">
                                <ul>
                                    <li>
                                        <label>Ihr Name</label><br>
                                        <input type="text" name="vorname" id="vorname" placeholder="Bitte geben Sie Ihren Vorname ein"
                                               <?php if ($_POST && isset($_POST['vorname'])) {
                                                   echo 'value="'.htmlspecialchars($_POST['vorname']).'"';
                                               }?> required>
                                    </li>
                                    <li>
                                        <label>E-mail</label><br>
                                        <input type="text" name="email" id="email" placeholder="Bitte geben Sie Ihre E-mail ein"
                                               <?php if ($_POST && isset($_POST['email'])) {
                                                   echo 'value="'.htmlspecialchars($_POST['email']).'"';
                                               }?> required><br>
                                    </li>
                                    <li>
                                        <label>Newsletter bitte in:</label><br>
                                        <select name="sprache" id="sprache">
                                            <option value="de">Deutsch</option>
                                            <option value="en">Enlisch</option>
                                        </select><br>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <ul>
                                    <li>
                                        <input type="checkbox" name="ds" id="ds" >Ich Stimme den Datenschutzbestimmungen zu<br>
                                    </li>
                                    <li>
                                        <input type="hidden" name="submitted" value="1">
                                        <input type="submit" value="Zum Newsletter anmelden">
                                    </li>
                                </ul>
                            </div>
                            <?php if ($_POST && empty($fehler)) {
                                $data = $name . "," . $email . "," . $sprache . "\n";
                                if (file_put_contents("./newsletterdata.csv", $data, FILE_APPEND | LOCK_EX)) {
                                    echo '<div class="row">
                                            <p>Sie haben sich erfolgreich zum Newsletter angemeldet!</p>
                                          </div>';
                                } else {
                                    echo '<div class="row">
                                            <p>Ups! Es ist ein Fehler aufgetreten, versuchen Sie es erneut!</p>
                                          </div>';
                                }
                            } ?>
                        </form>
                    </div>
                </div>

                <!-- das ist uns wichtig -->
                <a name="wichtig-fuer-uns"></a>
                <div class="row das-ist-uns-wichtig">
                    <div class="col-12">
                        <div class="row"><h1>Das ist uns wichtig</h1></div>
                        <div class="row list">
                            <ul>
                                <li>Beste frische saisonale Zutaten</li>
                                <li>Ausgewogene abwechslungsreiche Gerichte</li>
                                <li>Sauberkeit</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- banner -->
                <div class="row banner"><h1>Wir freuen uns auf Ihren Besuch!</h1></div>
            </div>

            <div class="col-2"></div>
        </div>

    </main>
    <hr>
    <footer>
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>&copy; E-Mensa GmbH</li>
                    <li><a target="_blank" href="../beispiele/Wir_Sind.html">About Us</a></li>
                    <li><a href="#">Impressum</a></li>
                </ul>
            </div>
        </div>
    </footer>
    </div>
</body>
</html>