<?php
    session_start();
    $uid = $_SESSION['uid'];

    require_once '../site.php';
    require_once '../db/connection.php';

    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_ex_lc = strtolower($file_ex);
    $file_new_name = uniqid('IMG-', true).'.'.$file_ex_lc;
    $path = '../files/photos/'.$file_new_name;
    move_uploaded_file($file_tmp_name, $path);

    $stmt = "select photo from users where uid = '$uid'";
    $result = mysqli_query($conn, $stmt);
    $fetch = mysqli_fetch_array($result);

    if($fetch['photo'] != 'default.png'){
        unlink('../files/photos/'.$fetch['photo']);
    }

    $stmt = "update users set photo = '$file_new_name' where uid = '$uid'";
    $run = mysqli_query($conn, $stmt);

    if($run){
        $_SESSION['profile_photo_success'] = 'profile_photo_success';

        header('location: ../user/profile');
    } else{
        $_SESSION['profile_photo_fail'] = 'profile_photo_fail';

        header('location: ../user/profile');
    }