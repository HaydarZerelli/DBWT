<?php
require_once('../models/kategorie.php');
require_once('../models/gericht.php');

class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        $vars = ['name' => $rd->query['name'] ?? 'name'];
        return view('examples.m4_6a_queryparameter', $vars);
    }
    public function m4_6b_kategorie() {
        $data = db_kategorie_select_all_names();
        return view('examples.m4_6b_kategorie', ['data' => $data]);
    }
    public function m4_6c_gericht() {
        $data = db_gericht_select_pig2();
        return view('examples.m4_6c_gericht', ['data' => $data]);
    }
    public function m4_6d_layout(RequestData $rd) {
        $no = $rd->query['no'] ?? '1';
        return view('examples.m4_6d_page_'.$no, []);

    }
}