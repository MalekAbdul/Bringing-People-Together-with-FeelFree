<?php
    session_start();
    $uid = $_SESSION['uid'];

    require_once '../site.php';
    require_once '../db/connection.php';

    $link = $_POST['link'];
    $pid = $_POST['pid'];
    $amount = $_POST['amount'];

    $stmt = "select ca from posts where pid = '$pid'";
    $result = mysqli_query($conn, $stmt);
    $fetch = mysqli_fetch_array($result);

    $amount += $fetch['ca'];

    $stmt = "update posts set ca = '$amount' where pid = '$pid'";
    $run = mysqli_query($conn, $stmt);

    if($run){
        $_SESSION['donate_success'] = 'donate_success';

        header('location: '.$link);
    } else{
        $_SESSION['donate_fail'] = 'donate_fail';

        header('location: '.$link);
    }