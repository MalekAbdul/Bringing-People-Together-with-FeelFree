<?php
    session_start();
    $uid = $_SESSION['uid'];

    require_once '../site.php';
    require_once '../db/connection.php';

    $stmt = "select pid from posts order by pid desc limit 1";
    $result = mysqli_query($conn, $stmt);
    $count = mysqli_num_rows($result);

    if($count == 1){
        $fetch = mysqli_fetch_array($result);
        $pid = $fetch['pid'];
    } else{
        $pid = 0;
    }

    $pid++;

    $stmtLevel = "select level from users where uid = '$uid'";
    $resultLevel = mysqli_query($conn, $stmtLevel);
    $fetchLevel = mysqli_fetch_array($resultLevel);

    if($fetchLevel['level'] == 1){
        $status = 1;
    } else{
        $status = 0;
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_ex_lc = strtolower($file_ex);
    $file_new_name = uniqid('IMG-', true).'.'.$file_ex_lc;
    $path = '../files/documents/'.$file_new_name;
    move_uploaded_file($file_tmp_name, $path);

    date_default_timezone_set('Asia/Dhaka');
    $pub_date = date('Y-m-d H:i:s');

    $stmt = "insert into posts(pid, uid, title, description, ta, file, pd, status) values('$pid', '$uid', '$title', '$description', '$amount', '$file_new_name', '$pub_date', '$status')";
    $run = mysqli_query($conn, $stmt);

    if($run){
        if($fetchLevel['level'] == 1){
            $_SESSION['post_asuccess'] = 'post_success';
        } else{
            $_SESSION['post_usuccess'] = 'post_success';
        }

        header('location: ../user/create-post');
    } else{
        if($fetchLevel['level'] == 1){
            $_SESSION['post_afail'] = 'post_fail';
        } else{
            $_SESSION['post_ufail'] = 'post_fail';
        }

        header('location: ../user/create-post');
    }