<?php


namespace App\Http\Controllers;

use Faker\Provider\Base;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends BaseController
{
    public function anmeldung(Request $rd) {
        $msg = $rd->session()->exists('login_result_message');
        return view('anmeldung', ['rd' => $rd, 'fehlermeldung' => $msg]);
    }
    public function abmeldung(Request $request) {
        $log = logger();

        $log->info('Abmeldung');
        session()->flush();

        return redirect()->to('/');
    }

    public function auth(Request $request) {

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
            session(['login_result_message' =>  "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!"]);
            return back();
        }
        $userdata = $userdata[0];
        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');
        session(['login_result_message' => NULL]);
        $logger = logger();




        $pw_hash = sha1($salt . $pw);
        if ($userdata->passwort == $pw_hash) {        //erfolgreiche anmeldung
            session(['login_ok' => true]);
            session(['auth' => 'token']);
            /*login func*/
            DB::beginTransaction();
            DB::select("CALL anzahlanmeldungen(?)", [$userdata->id]);
            DB::commit();
            /**/

            $logger->info("Anmeldung erfolgreich: " . $email);
            return redirect()->to('/');
        } else {                                    // anmeldung fehlgeschlagen
            session(['login_result_message' => "Fehler bei der Anmeldung: E-Mail oder Passwort falsch!"]);
            $anzahlfehler = $userdata->anzahlfehler + 1;
            login_failed($userdata->id, $anzahlfehler, $date);
            $logger->warning("Anmeldung fehlgeschlagen: " . $email);
            return redirect()->to('/anmeldung');
        }
    }
}
