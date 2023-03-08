<?php
    session_start();
    require_once '../site.php';
    require_once '../db/connection.php';

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];

    $stmt = "select * from users where email = '$email'";
    $result = mysqli_query($conn, $stmt);
    $count = mysqli_num_rows($result);

    if($count == 1){
        $_SESSION['ex_email'] = 'ex_email';
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['birthday'] = $birthday;
        $_SESSION['gender'] = $gender;

        header('location: ../registration');
    } else{
        $vkey = md5(time().$email);

        $stmt = "select * from users order by uid desc limit 1";
        $result = mysqli_query($conn, $stmt);
        $count = mysqli_num_rows($result);

        if($count == 1){
            $fetch = mysqli_fetch_array($result);
            $uid = $fetch['uid'];
        } else{
            $uid = 0;
        }

        $uid++;

        date_default_timezone_set('Asia/Dhaka');
        $reg_date = date('Y-m-d H:i:s');

        $reg = "insert into users(uid, name, phone, email, birthday, gender, vkey, reg_date) values('$uid', '$name', '$phone', '$email', '$birthday', '$gender', '$vkey', '$reg_date')";
        $run = mysqli_query($conn, $reg);

        if($run){
            require_once '../mailer/send_mail.php';

            $from = 'noreply@feelfree.com';
            $from_name = 'noreply';
            $to = $email;
            $to_name = $name;
            $subject = 'Please activate your FeelFree account';
            $message = 'Dear '.$name.', <br> <br> Thank you for registering. To activate your account, please click on the following link (this will confirm your email address) <br> <br> <a href="'.$site_url.'login?evtoken='.$vkey.'">Confirm Email</a>';

            send_mail($from, $from_name, $to, $to_name, $subject, $message);

            $_SESSION['registration'] = 'registration';
            $_SESSION['vkey'] = $vkey;

            header('location: ../login');
        } else{
            $_SESSION['sw'] = 'sw';
            $_SESSION['name'] = $name;
            $_SESSION['phone'] = $phone;
            $_SESSION['email'] = $email;
            $_SESSION['birthday'] = $birthday;
            $_SESSION['gender'] = $gender;

            header('location: ../registration');
        }
    }