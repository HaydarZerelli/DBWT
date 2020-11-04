<?php
echo '<p>'.var_dump($_POST).'</p>';
$email = "";
if (isset($_POST['email'])) {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];
    } else {
        echo 'alert("email not valid");';
    }
}
if (!(isset($_POST['ds']) && $_POST['ds'] == "on")) {
    echo 'alert("datenschutz bestimmung nicht akzeptiert")';
}
if (!(isset($_POST['vorname'])));