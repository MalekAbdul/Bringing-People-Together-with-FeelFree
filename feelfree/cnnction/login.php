<?php
    session_start();
    require_once '../site.php';
    require_once '../db/connection.php';

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $stmt = "select * from users where email = '$email'";
    $result = mysqli_query($conn, $stmt);
    $count = mysqli_num_rows($result);

    if($count == 1){
        $fetch = mysqli_fetch_array($result);

        if($pass == $fetch['pass']){
            if($fetch['status'] == '1'){
                $uid = $fetch['uid'];
                $_SESSION['uid'] = $uid;

                if(!empty($_POST['rmmbr'])){
                    setcookie('email', $email, time() + (86400 * 30), '/');
                    setcookie('pass', $pass, time() + (86400 * 30), '/');
                } else{
                    setcookie('email', NULL, time() - (86400 * 30), '/');
                    setcookie('pass', NULL, time() - (86400 * 30), '/');
                }

                if(isset($_GET['src'])){
                    $link = urldecode($_GET['src']);

                    header('location: '.$link);
                } else{
                    header('location: ../user/home');
                }
            } else{
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                $_SESSION['status'] = 'status';

                header('location: ../login');
            }
        } else{
            $_SESSION['email'] = $email;
            $_SESSION['pass'] = $pass;
            $_SESSION['login_error'] = 'login_error';

            header('location: ../login');
        }
    } else{
        $_SESSION['email'] = $email;
        $_SESSION['pass'] = $pass;
        $_SESSION['login_error'] = 'login_error';

        header('location: ../login');
    }