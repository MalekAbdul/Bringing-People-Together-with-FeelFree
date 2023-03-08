<?php
    session_start();
    $uid = $_SESSION['uid'];
    $ui = $_POST['ui'];
    $link = $_POST['link'];

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $level = $_POST['level'];

    require_once '../site.php';
    require_once '../db/connection.php';

    $stmt = "select pass from users where uid = '$ui'";
    $result = mysqli_query($conn, $stmt);
    $fetch = mysqli_fetch_array($result);

    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    } else{
        $password = $fetch['pass'];
    }

    if($level == 1){
        $verification = 1;
    } else{
        $verification = 0;
    }

    $stmt = "update users set name = '$name', phone = '$phone', email = '$email', pass = '$password', birthday = '$birthday', gender = '$gender', level = '$level', verification = '$verification' where uid = '$ui'";
    $run = mysqli_query($conn, $stmt);

    if($run){
        $_SESSION['profile_updated_successful'] = 'profile_updated_successful';

        header('location: '.$link);
    } else{
        $_SESSION['profile_updated_unsuccessful'] = 'profile_updated_unsuccessful';

        header('location: '.$link);
    }