<?php
    session_start();
    $uid = $_SESSION['uid'];

    require_once '../site.php';
    require_once '../db/connection.php';

    $stmt = "select vid from verification order by vid desc limit 1";
    $result = mysqli_query($conn, $stmt);
    $count = mysqli_num_rows($result);

    if($count == 1){
        $fetch = mysqli_fetch_array($result);
        $vid = $fetch['vid'];
    } else{
        $vid = 0;
    }

    $vid++;

    $bcn = $_POST['bcn'];
    $nidn = $_POST['nidn'];

    $bcp_name = $_FILES['bcp']['name'];
    $bcp_tmp_name = $_FILES['bcp']['tmp_name'];
    $bcp_ex = pathinfo($bcp_name, PATHINFO_EXTENSION);
    $bcp_ex_lc = strtolower($bcp_ex);
    $bcp_new_name = uniqid('IMG-', true).'.'.$bcp_ex_lc;
    $path = '../files/documents/verification/'.$bcp_new_name;
    move_uploaded_file($bcp_tmp_name, $path);

    $nidp_name = $_FILES['nidp']['name'];
    $nidp_tmp_name = $_FILES['nidp']['tmp_name'];
    $nidp_ex = pathinfo($nidp_name, PATHINFO_EXTENSION);
    $nidp_ex_lc = strtolower($nidp_ex);
    $nidp_new_name = uniqid('IMG-', true).'.'.$nidp_ex_lc;
    $path = '../files/documents/verification/'.$nidp_new_name;
    move_uploaded_file($nidp_tmp_name, $path);

    date_default_timezone_set('Asia/Dhaka');
    $sub_date = date('Y-m-d H:i:s');

    $stmt = "insert into verification(vid, uid, bcn, nidn, bcp, nidp, sub_date) values('$vid', '$uid', '$bcn', '$nidn', '$bcp_new_name', '$nidp_new_name', '$sub_date')";
    $run = mysqli_query($conn, $stmt);

    if($run){
        $_SESSION['ver_success'] = 'ver_success';

        header('location: ../user/verification');
    } else{
        $_SESSION['ver_fail'] = 'ver_fail';

        header('location: ../user/verification');
    }