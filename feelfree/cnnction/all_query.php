<?php
    session_start();
    $uid = $_SESSION['uid'];
    $link = $_POST['link'];

    require_once '../site.php';
    require_once '../db/connection.php';

    if(!empty($_POST['pause_home'])){
        $pid = $_POST['pid'];

        $stmt = "update posts set status = 0 where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_pending_success'] = 'post_pending_success';

            header('location: '.$link);
        } else{
            $_SESSION['post_pending_fail'] = 'post_pending_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['decline_home'])){
        $pid = $_POST['pid'];

        $stmt = "update posts set status = 2 where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_decline_success'] = 'post_decline_success';

            header('location: '.$link);
        } else{
            $_SESSION['post_decline_fail'] = 'post_decline_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['delete_home'])){
        $pid = $_POST['pid'];

        $stmt = "select file from posts where pid = '$pid'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);

        unlink('../files/documents/'.$fetch['file']);

        $stmt = "delete from posts where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_delete_success'] = 'post_delete_success';

            header('location: '.$link);
        } else{
            $_SESSION['post_delete_fail'] = 'post_delete_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['accept_mp'])){
        $pid = $_POST['pid'];

        $stmt = "update posts set status = 1 where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_accept_success'] = 'post_accept_success';

            header('location: '.$link);
        } else{
            $_SESSION['post_accept_fail'] = 'post_accept_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['decline_mp'])){
        $pid = $_POST['pid'];

        $stmt = "update posts set status = 2 where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_decline_success'] = 'post_decline_success';

            header('location: '.$link);
        } else{
            $_SESSION['post_decline_fail'] = 'post_decline_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['delete_mp'])){
        $pid = $_POST['pid'];

        $stmt = "select file from posts where pid = '$pid'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);

        unlink('../files/documents/'.$fetch['file']);

        $stmt = "delete from posts where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_delete_success'] = 'post_delete_success';

            header('location: '.$link);
        } else{
            $_SESSION['post_delete_fail'] = 'post_delete_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['accept_vpp'])){
        $pid = $_POST['pid'];

        $stmt = "update posts set status = 1 where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_accept_success'] = 'post_accept_success';

            header('location: ../user/member-pending');
        } else{
            $_SESSION['post_accept_fail'] = 'post_accept_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['decline_vpp'])){
        $pid = $_POST['pid'];

        $stmt = "update posts set status = 2 where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_decline_success'] = 'post_decline_success';

            header('location: ../user/member-pending');
        } else{
            $_SESSION['post_decline_fail'] = 'post_decline_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['delete_vpp'])){
        $pid = $_POST['pid'];

        $stmt = "select file from posts where pid = '$pid'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);

        unlink('../files/documents/'.$fetch['file']);

        $stmt = "delete from posts where pid = '$pid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['post_delete_success'] = 'post_delete_success';

            header('location: ../user/member-pending');
        } else{
            $_SESSION['post_delete_fail'] = 'post_delete_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['accept_vmpv'])){
        $vid = $_POST['vid'];
        $ui = $_POST['ui'];

        $stmt = "update users set verification = 1 where uid = '$ui'";
        $run = mysqli_query($conn, $stmt);

        $stmt = "update verification set status = 1 where vid = '$vid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['ver_accept_success'] = 'ver_accept_success';

            header('location: ../user/member-pending-verification');
        } else{
            $_SESSION['ver_accept_fail'] = 'ver_accept_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['delete_vmpv'])){
        $vid = $_POST['vid'];

        $stmt = "select bcp, nidp from verification where vid = '$vid'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);

        unlink('../files/documents/verification/'.$fetch['bcp']);
        unlink('../files/documents/verification/'.$fetch['nidp']);

        $stmt = "delete from verification where vid = '$vid'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['ver_delete_success'] = 'ver_delete_success';

            header('location: ../user/member-pending-verification');
        } else{
            $_SESSION['ver_delete_fail'] = 'ver_delete_fail';

            header('location: '.$link);
        }
    } elseif(!empty($_POST['reject_ml'])){
        $ui = $_POST['ui'];

        $stmt = "update users set status = 0 where uid = '$ui'";
        $run = mysqli_query($conn, $stmt);

        if($run){
            $_SESSION['reject_success'] = 'reject_success';

            header('location: '.$link);
        } else{
            $_SESSION['reject_fail'] = 'reject_fail';

            header('location: '.$link);
        }
    }