<?php
    session_start();
    $uid = $_SESSION['uid'];

    require_once '../site.php';
    require_once '../db/connection.php';

    $link = $_POST['link'];
    $pid = $_POST['pid'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    $stmt = "select file from posts where pid = '$pid'";
    $result = mysqli_query($conn, $stmt);
    $fetch = mysqli_fetch_array($result);

    if(!empty($_FILES['file']['name'])){
        unlink('../files/documents/'.$fetch['file']);

        $file_name = $_FILES['file']['name'];
		$file_tmp_name = $_FILES['file']['tmp_name'];
		$file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
		$file_ex_lc = strtolower($file_ex);
		$file_new_name = uniqid('IMG-', true).'.'.$file_ex_lc;
		$path = '../files/documents/'.$file_new_name;
		move_uploaded_file($file_tmp_name, $path);
    } else{
        $file_new_name = $fetch['file'];
    }

    $stmt = "update posts set title = '$title', description = '$description', ta = '$amount', file = '$file_new_name' where pid = '$pid'";
    $run = mysqli_query($conn, $stmt);

    if($run){
        $_SESSION['post_success'] = 'post_success';

        header('location: '.$link);
    } else{
        $_SESSION['post_fail'] = 'post_fail';

        header('location: '.$link);
    }