<?php
function get_userdata($email) {
    $link = connectdb();
    $sql = 'select * from benutzer where email=?';
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_array(MYSQLI_BOTH);
    $stmt->close();
    return $result;
}

function login($userid){
    $link=connectdb();
    $link->begin_transaction();
    $link->query("CALL anzahlanmeldungen(. $userid. )");
    $link->commit();
    return $link;
}
function login_failed($id, $anzahlfehler, $letzterfehler) {
    $link = connectdb();
    $stmt = $link->stmt_init();
    $stmt = $link->prepare("update benutzer set anzahlfehler=?, letzterfehler=? where id=?");
    $stmt->bind_param('iss', $anzahlfehler, $letzterfehler, $id);
    $stmt->execute();
    $stmt->close();
}
