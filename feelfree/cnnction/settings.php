<?php
    session_start();
    $uid = $_SESSION['uid'];
    $link = $_POST['link'];

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    require_once '../site.php';
    require_once '../db/connection.php';

    $stmt = "update users set pass = '$password' where uid = '$uid'";
    $run = mysqli_query($conn, $stmt);

    if($run){
        $_SESSION['pass_updated_successful'] = 'pass_updated_successful';

        header('location: '.$link);
    } else{
        $_SESSION['pass_updated_unsuccessful'] = 'pass_updated_unsuccessful';

        header('location: '.$link);
    }