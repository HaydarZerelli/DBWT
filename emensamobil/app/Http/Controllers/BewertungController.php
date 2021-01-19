<?php


namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bewertung;
use App\Models\Gericht;


class BewertungController extends BaseController
{
    function show(Request $rd) {

        if (!session('auth_token')) {
            return redirect()->to('/');
        } else {

            $data = Gericht::query()->where('id', $rd->query('gerichtid'))->get();
            // $data = DB::select("SELECT name, bildname FROM gericht WHERE id=?", [$rd->query('gerichtid')]);

            return view('bewertung', ['request' => $rd, 'data' => $data]);
        }
    }

    function rate(Request $rd) {

        $kommentar = filter_var($rd->input('kommentar'), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $sterne = filter_var( $rd->input('sterne'), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        if (is_numeric($rd->input('id'))) {
            $gerichtid = $rd->input('id');
        }


        $benutzerid = DB::select("SELECT id FROM benutzer WHERE auth_token=?", [session('auth_token')]);

        $benutzerid = $benutzerid[0]->id;

        DB::insert('INSERT INTO bewertungen (sterne, bemerkung, benutzer_id, gericht_id) VALUES (?,?,?,?);',
            [$sterne, $kommentar, $benutzerid, $gerichtid]);

        return redirect()->to('/');
    }

    function zeigeAlle(Request $rd) {

        $bewertungen = Bewertung::query()->orderBy('bewertungszeitpunkt', 'DESC')->limit(30)->get();

        //$data = DB::select("SELECT * from bewertungen ORDER BY bewertungszeitpunkt DESC LIMIT 30");
        return view('bewertungen', ['bewertungen' => $bewertungen]);
    }

    function zeigeMeine(Request $rd) {
        $benutzerid = DB::select("SELECT id FROM benutzer WHERE auth_token=?", [session('auth_token')]);
        $benutzerid = $benutzerid[0]->id;
        $bewertungen = DB::select("SELECT * FROM bewertungen WHERE benutzer_id=? ORDER BY bewertungszeitpunkt DESC", [$benutzerid]);
        return view('meine_bewertungen', ['bewertungen' => $bewertungen]);
    }

    function loeschen(Request $rd) {
        $id = $rd->input('id');
        Bewertung::destroy($id);
        //$res = DB::delete("delete from bewertungen where id=?", [$rd->input('id')]);
        return redirect()->to('meine_bewertungen');
    }

    function hervorheben(Request $rd) {
        $bewertungsid=$rd->query('bewertungsid');
        //DB::update("update bewertungen set hervorgehoben=true where id=?", [$bewertungsid]);
        $bewertung = Bewertung::query()->find($bewertungsid);
        $bewertung->hervorgehoben = true;
        $bewertung->save();
        return redirect()->to('/bewertungen');
    }

    function abwaehlen(Request $rd) {
        $bewertungsid=$rd->query('bewertungsid');
        DB::update("update bewertungen set hervorgehoben=false where id=?", [$bewertungsid]);
        return redirect()->to('/bewertungen');
    }

}
