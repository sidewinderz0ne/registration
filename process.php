<?php
require_once('config.php');
?>
<?php

if (isset($_POST)) {

    $mobile     = $_POST['mobile'];
    $firstname  = $_POST['firstname'];
    $lastname   = $_POST['lastname'];
    $email      = $_POST['email'];

    $stmt = $db->prepare('SELECT COUNT(email) AS EmailCount FROM users WHERE email = :email');
    $stmt->execute(array('email' => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtm = $db->prepare('SELECT COUNT(mobile) AS MobileCount FROM users WHERE mobile = :mobile');
    $stmtm->execute(array('mobile' => $mobile));
    $resultm = $stmtm->fetch(PDO::FETCH_ASSOC);

    if ($result['EmailCount'] == 0 && $resultm['MobileCount'] == 0) {
        $sql = "INSERT INTO users (mobile, firstname, lastname, email) VALUES (?,?,?,?)";
        $stmtinsert = $db->prepare($sql);
        $result = $stmtinsert->execute([$mobile, $firstname, $lastname, $email]);
        echo 'success';
    } else if($result['EmailCount'] != 0 && $resultm['MobileCount'] != 0){
        echo 'E-mail and mobile already registered!';
    } else if($result['EmailCount'] != 0){
        echo 'E-mail already registered!';
    } else if($resultm['MobileCount'] != 0){
        echo 'Mobile already registered!';
    } else {
        echo 'Data error!';
    }
} else {
    echo 'No data';
}
