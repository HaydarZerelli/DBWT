<?php


function add_user($email, $pw, $admin=false) {

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p>Passwort oder E-Mail Adresse ung&uuml;ltig</p>';
        return false;
    }
    $exp = array("/@rcpt.at/i", "/@damnthespam.at/i", "/@wegwerfmail.de/i", "/@trashmail./i");
    foreach ($exp as $e) {
        if (preg_match($e, $email)) {
            echo '<p>Passwort oder E-Mail Adresse ung&uuml;ltig</p>';
            return false;
        }
    }
    $admin = (int) $admin;
    $salt = 1337;
    $passwort = sha1($salt . $pw);

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
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("insert into benutzer (email, passwort, admin) value(?,?,?)");
    $stmt->bind_param('ssi', $email, $passwort, $admin);
    $stmt->execute();
    $result = $stmt->get_result();
    printf("%d Zeile eingefügt.\n", $stmt->affected_rows);
    $stmt->close();
}

add_user("admin@emensa.example", "abcd1234", true);
