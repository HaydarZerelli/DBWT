<?php
require_once('../models/benutzer.php');

class LoginController
{
    public function anmeldung(RequestData $rd) {
        $msg = $_SESSION['login_result_message'] ?? NULL;
        return view('anmeldung', ['rd' => $rd, 'fehlermeldung' => $msg]);
    }
    public function abmeldung(RequestData $rd) {
        /** session zerstören = anmeldung tot **/
        session_destroy();
        /**
         * ACHTUNG dbwt/M5/:emensa/public/index_72.php/  kann entfernt werden, da sliegt an manuels rechner!!!
         */
        header('Location: /DBWT/emensa/public/index_72.php/');
        exit;
    }
    public function auth() {
        $salt = 1337;
        $email = $_POST['email'] ?? NULL;
        $pw = $_POST['pw'] ?? NULL;

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $userdata = get_userdata($email);
        // abfrage ob es den user in der datenbank gibt
        if (!$userdata) {
            $_SESSION['login_result_message'] = "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!";
            header("Location: /anmeldung");
            die();
        }

        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');
        $_SESSION['login_result_message'] = NULL;
        $logger = logger();


        $pw_hash = sha1($salt . $pw);
        if ($userdata['passwort'] == $pw_hash) {        //erfolgreiche anmeldung
            $_SESSION['login_ok'] = true;
            $anzahlanmeldungen = $userdata['anzahlanmeldungen'] + 1;
            login($userdata['id'], $anzahlanmeldungen, $date);
            $logger->info("Anmeldung erfolgreich: " . $email);
            header("Location: /");
            die();
        } else {                                    // anmeldung fehlgeschlagen
            $_SESSION['login_result_message'] = "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!";
            $anzahlfehler = $userdata['anzahlfehler'] + 1;
            login_failed($userdata['id'], $anzahlfehler, $date);
            $logger->warning("Anmeldung fehlgeschlagen: " . $email);
            header("Location: /anmeldung");
            die();
        }
    }
}