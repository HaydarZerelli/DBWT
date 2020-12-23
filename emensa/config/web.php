<?php
/**
 * Mapping of paths to controlls.
 * Note, that the path only support 1 level of directory depth:
 *     /demo is ok,
 *     /demo/subpage will not work as aspected
 */
return array(
    "/"            => "HomeController@index",
    "/demo"        => "DemoController@demo",
    "/dbconnect"   => "DemoController@dbconnect",
    "/anmeldung"   => "LoginController@anmeldung",
    "/anmeldung_verifizieren" => "LoginController@auth",

    // Erstes Beispiel:
    '/m4_6a_queryparameter' => 'ExampleController@m4_6a_queryparameter',
    '/m4_6b_kategorie' => 'ExampleController@m4_6b_kategorie',
    '/m4_6c_gericht' => 'ExampleController@m4_6c_gericht',
    '/m4_6d_layout' => 'ExampleController@m4_6d_layout',
);