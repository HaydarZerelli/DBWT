<?php

$mysqli = new mysqli("127.0.0.1",
    "root",
    "08101995",
    "db_emensawerbeseite"
);
/* prüfe Verbindung */
if (mysqli_connect_errno()) {
    printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
    exit();
}
$fehler = array();
$email = $_POST['email'] ?? NULL;
$name = $_POST['name'] ?? NULL;
$gericht = $_POST['gericht'] ?? NULL;
$beschreibung = $_POST['desc'] ?? NULL;
$email_ok = true;

if (isset($_POST['submitted'])) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_ok = false;
        array_push($fehler, "E-Mail Adresse ung&uuml;ltig!");
    } else {
    $exp = array("/@rcpt.at/i", "/@damnthespam.at/i", "/@wegwerfmail.de/i", "/@trashmail./i");
        foreach ($exp as $e) {
            if (preg_match($e, $email)) {
                $email_ok = false;
                array_push($fehler, "E-Mail Adresse als Spammail erkannt!");
                break;
            }
        }
    }
    if ($email_ok) {
        $statement = $mysqli->stmt_init();
        $date = date('Y-m-d');
        if(!empty($name)) {
            $statement = $mysqli->prepare("INSERT INTO wunschgerichte (name, beschreibung, erstellungs_datum, ersteller, email) VALUE (?,?,?,?,?)");
            $statement->bind_param('sssss', $gericht, $beschreibung, $date, $name, $email);

        } else {
            $statement = $mysqli->prepare("INSERT INTO wunschgerichte (name, beschreibung, erstellungs_datum, email) VALUE (?,?,?,?)");
            $statement->bind_param('ssss', $gericht, $beschreibung, $date, $email);

        }
        var_dump($statement);
        $statement->execute();
        $result = $statement->get_result();
        printf("%d Zeile eingefügt.\n", $statement->affected_rows);
        $statement->close();
    }

}
if ($fehler) {
    echo '<div class="row"><p>Ein Fehler ist aufgetreten:</p><ul>';
    foreach ($fehler as $f) {
        echo '<li>'.$f.'</li>';
    }
    echo '</ul></div>';
}


?>
<html>
    <div class="row">
        <form name="wunschgericht" target="_self" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <fieldset>
                <legend> Ihr Wunsch </legend>
                <label>Name</label><br>
                <input type="text" name="name" size="50" placeholder="Bitte geben Sie Ihren Name ein"><br>
                <label>E-Mail</label><br>
                <input type="text" size="50" name="email" placeholder="e-mail Adresse" required><br>
                <label>Name Ihres Wunschgerichts</label><br>
                <input type="text" size="80" name="gericht" placeholder="Name des Gerichts"><br>
                <label for="beschreibung">Beschreibung</label><br>
                <textarea name="desc" cols="80" rows="5" placeholder="Geben Sie eine Beschreibung Ihres Wunschgerichts an."></textarea>
                <br>
                <input type="hidden" name="submitted" value="1">
                <button type="submit">Wunsch abschicken</button>
            </fieldset>
        </form>
    </div>
</html>
