<?php
    session_start();
    require_once '../site.php';
    require_once '../db/connection.php';

    $email = $_POST['email'];

    $stmt = "select * from users where email = '$email' and status = 1";
    $result = mysqli_query($conn, $stmt);
    $count = mysqli_num_rows($result);

    if($count == 1){
        if(isset($_POST['fgtpass-first-phase'])){
            $otp_gen = rand(10000,99999);
            date_default_timezone_set('Asia/Dhaka');
            $otp_create = date('Y-m-d H:i:s');

            $otpset = "update users set otp = '$otp_gen', otp_create = '$otp_create' where email = '$email'";
            $run = mysqli_query($conn, $otpset);

            if($run){
                $fetch = mysqli_fetch_array($result);
                $name = $fetch['name'];

                require_once '../mailer/send_mail.php';

                $from = 'noreply@feelfree.com';
                $from_name = 'noreply';
                $to = $email;
                $to_name = $name;
                $subject = 'Reset your FeelFree account password';
                $message = 'Dear '.$name.', <br> <br> A request has been received to change the password for your FeelFree account. <div style="margin: 10px 0; background-color: #A9A9A9; color: #FFF; padding: 15px 20px; text-align: center;"><b>OTP: '.$otp_gen.'</b> <br> (This code will expire in 5 minutes)</div> If you did not initiate this request, just ignore this mail and do not share your OTP with anyone. <br> <br> Thank you, <br> FeelFree Team';

                send_mail($from, $from_name, $to, $to_name, $subject, $message);

                $_SESSION['fgtpass-second-phase'] = $email;

                header('location: ../forget-password');
            } else{
                $_SESSION['sw'] = 'sw';

                header('location: ../login');
            }
        } elseif(isset($_POST['fgtpass-second-phase'])){
            date_default_timezone_set('Asia/Dhaka');
            $current_time = date('Y-m-d H:i:s');

            $stmt = "select * from users where email = '$email' and '$current_time' <= date_add(otp_create, interval 5 minute)";
            $result = mysqli_query($conn, $stmt);
            $count = mysqli_num_rows($result);

            if($count == 1){
                $fetch = mysqli_fetch_array($result);

                $otp = $_POST['otp'];

                if($fetch['otp'] == $otp){
                    $pass_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
                    $pass = substr(str_shuffle($pass_string),0,8);
                    $pass_hash = password_hash($pass, PASSWORD_BCRYPT);

                    $pass_set = "update users set pass = '$pass_hash' where email = '$email'";
                    $run = mysqli_query($conn, $pass_set);

                    if($run){
                        $name = $fetch['name'];

                        require_once '../mailer/send_mail.php';

                        $from = 'noreply@feelfree.com';
                        $from_name = 'noreply';
                        $to = $email;
                        $to_name = $name;
                        $subject = 'Recovery password for your FeelFree account';
                        $message = 'Dear '.$name.', <br> <br> The password for your FeelFree account has been reset. Now your password is: <div style="margin: 10px 0; background-color: #A9A9A9; color: #FFF; padding: 15px 20px; text-align: center;"><b>'.$pass.'</b></div> For your security, please do not share your password with anyone. <br> <br> Thank you, <br> FeelFree Team';

                        send_mail($from, $from_name, $to, $to_name, $subject, $message);

                        $_SESSION['pass_confirmed'] = 'pass_confirmed';

                        header('location: ../login');
                    } else{
                        $_SESSION['sw'] = 'sw';

                        header('location: ../login');
                    }
                } else{
                    $_SESSION['sw'] = 'sw';

                    header('location: ../login');
                }
            } else{
                $_SESSION['sw'] = 'sw';

                header('location: ../login');
            }
        }
    } else{
        $_SESSION['sw'] = 'sw';

        header('location: ../login');
    }