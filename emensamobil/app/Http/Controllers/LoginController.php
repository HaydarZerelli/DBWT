<?php


namespace App\Http\Controllers;

use Faker\Provider\Base;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends BaseController
{
    public function anmeldung(Request $rd) {
        $msg = $_SESSION['login_result_message'] ?? NULL;
        return view('anmeldung', ['rd' => $rd, 'fehlermeldung' => $msg]);
    }
    public function abmeldung() {
        $log = logger();

        $log->info('Abmeldung');

        session_destroy();

        header('Location: /');
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
        $userdata = DB::select('select * from benutzer where email=?', [$email]);

        // abfrage ob es den user in der datenbank gibt
        if (!$userdata) {
            $_SESSION['login_result_message'] = "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!";
            return back();
        }
        $userdata = $userdata[0];
        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');
        $_SESSION['login_result_message'] = NULL;
        $logger = logger();




        $pw_hash = sha1($salt . $pw);
        if ($userdata->passwort == $pw_hash) {        //erfolgreiche anmeldung
            $_SESSION['login_ok'] = true;

            /*login func*/
            DB::beginTransaction();
            DB::select("CALL anzahlanmeldungen(?)", [$userdata->id]);
            DB::commit();
            /**/

            $logger->info("Anmeldung erfolgreich: " . $email);
            return redirect()->to('/');
        } else {                                    // anmeldung fehlgeschlagen
            $_SESSION['login_result_message'] = "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!";
            $anzahlfehler = $userdata->anzahlfehler + 1;
            login_failed($userdata->id, $anzahlfehler, $date);
            $logger->warning("Anmeldung fehlgeschlagen: " . $email);
            return redirect()->to('/anmeldung');
        }
    }
}
