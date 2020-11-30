<?php
require_once('../models/kategorie.php');

class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        $vars = ['name' => $rd->query['name'] ?? 'name'];
        return view('examples.m4_6a_queryparameter', $vars);
    }
}