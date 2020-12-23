<?php
require_once('../models/benutzer.php');

class LoginController
{
    public function anmeldung(RequestData $rd) {
        $msg = $_SESSION['login_result_message'] ?? NULL;
        return view('anmeldung', ['rd' => $rd, 'fehlermeldung' => $msg]);
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
        if (!$userdata) {
            $_SESSION['login_result_message'] = "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!";
            header("Location: /anmeldung");
            die();
        }

        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');
        $_SESSION['login_result_message'] = NULL;


        $pw_hash = sha1($salt . $pw);
        if ($userdata['passwort'] == $pw_hash) {
            $_SESSION['login_ok'] = true;
            $anzahlanmeldungen = $userdata['anzahlanmeldungen'] + 1;
            login($userdata['id'], $anzahlanmeldungen, $date);
            header("Location: /");
            die();
        } else {
            $_SESSION['login_result_message'] = "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!";
            $anzahlfehler = $userdata['anzahlfehler'] + 1;
            login_failed($userdata['id'], $anzahlfehler, $date);
            header("Location: /anmeldung");
            die();
        }
    }
}