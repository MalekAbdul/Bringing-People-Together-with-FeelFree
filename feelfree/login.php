<?php
    session_start();
    require_once 'site.php';
    $title = 'Login';

    if(!isset($_SESSION['uid'])){
        $email = '';
        $pass = '';

        if(isset($_COOKIE['email']) && isset($_COOKIE['pass'])){
            $email = $_COOKIE['email'];
            $pass = $_COOKIE['pass'];
        } if(isset($_SESSION['email']) && isset($_SESSION['pass'])){
            $email = $_SESSION['email'];
            $pass = $_SESSION['pass'];

            unset($_SESSION['email']);
            unset($_SESSION['pass']);
        }

        if(isset($_GET['src'])){
            $link = urldecode($_GET['src']);
            $link_move = '?src='.$link;
        } else{
            $link_move = '';
        }

        if(isset($_GET['evtoken'])){
            $evtoken = $_GET['evtoken'];

            require_once 'db/connection.php';

            $stmt = "select * from users where status = 0 and vkey = '$evtoken'";
            $result = mysqli_query($conn, $stmt);
            $count = mysqli_num_rows($result);

            if($count == 1){
                $pass_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
                $pass = substr(str_shuffle($pass_string),0,8);

                $pass_status_set = "update users set pass = '$pass', status = 1 where vkey = '$evtoken'";
                $run = mysqli_query($conn, $pass_status_set);

                if($run){
                    $fetch = mysqli_fetch_array($result);

                    $name = $fetch['name'];
                    $email = $fetch['email'];

                    require_once 'mailer/send_mail.php';

                    $from = 'noreply@feelfree.com';
                    $from_name = 'noreply';
                    $to = $email;
                    $to_name = $name;
                    $subject = 'Password for your FeelFree account';
                    $message = 'Dear '.$name.', <br> <br> The password for your FeelFree account is: <div style="margin: 10px 0; background-color: #A9A9A9; color: #FFF; padding: 15px 20px; text-align: center;"><b>'.$pass.'</b></div> For your security, please do not share your password with anyone. <br> <br> Thank you, <br> FeelFree Team';

                    send_mail($from, $from_name, $to, $to_name, $subject, $message);

                    $_SESSION['email_confirmed'] = 'email_confirmed';

                    header('location: login');
                } else{
                    $_SESSION['sw'] = 'sw';

                    header('location: login');
                }
            } else{
                $_SESSION['sw'] = 'sw';

                header('location: login');
            }
        }
    ?>

        <!doctype html>
        <html lang="en">
            <?php require_once 'site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <section class="login-area">
                    <div class="login-container">
                        <div class="container">
                            <?php
                                if(isset($_SESSION['registration'])){
                                    echo '<div class="top-error" id="top-error">You have registered an account on FeelFree, you need to verify your email address before you can use your account!<i class="fa fa-times-circle cross" id="cross"></i></div>';

                                    unset($_SESSION['registration']);
                                } elseif(isset($_SESSION['email_confirmed'])){
                                    echo '<div class="top-error" id="top-error">You have successfully confirmed your email address and your password was sent to your email.<i class="fa fa-times-circle cross" id="cross"></i></div>';
                                    // If I unset the session, the error notification does not show.
                                    unset($_SESSION['email_confirmed']);
                                } elseif(isset($_SESSION['pass_confirmed'])){
                                    echo '<div class="top-error" id="top-error">A password was sent to your email.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                                    unset($_SESSION['pass_confirmed']);
                                } elseif(isset($_SESSION['sw'])){
                                    echo '<div class="top-error" id="top-error">Something went wrong.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                                    unset($_SESSION['sw']);
                                } elseif(isset($_SESSION['login_first'])){
                                    $de_msg = base64_decode($_SESSION['login_first']);
                                    echo '<div class="top-error" id="top-error">'.$de_msg.'<i class="fa fa-times-circle cross" id="cross"></i></div>';

                                    unset($_SESSION['login_first']);
                                } elseif(isset($_SESSION['status'])){
                                    echo '<div class="top-error" id="top-error">Your account has not yet been verified. Check your email for account activation.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                                    unset($_SESSION['status']);
                                } elseif(isset($_SESSION['login_error'])){
                                    echo '<div class="top-error" id="top-error">Your email or password is incorrect. Please try again or <a href="forget-password">reset your password</a>.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                                    unset($_SESSION['login_error']);
                                }
                            ?>
                            <div class="login-box">
                                <div class="login-title"><h4>Login</h4></div>
                                <div class="login-body">
                                    <form action="cnnction/login.php<?php echo $link_move; ?>" method="post" onsubmit="return login(this);">
                                        <div class="login-email">
                                            <label for="email">Email</label>
                                            <input name="email" id="email" type="email" value="<?php echo $email; ?>" autofocus>

                                            <i class="cfa fa fa-check-circle"></i>
                                            <i class="cfa fa fa-exclamation-circle"></i>
                                            <small class="line-error">Please, provide your email!</small>
                                        </div>
                                        <div class="login-pass">
                                            <div class="control-pass">
                                                <label for="pass">Password</label>
                                                <i class="fa fa-eye-slash" id="show-pass" onclick="return cntrlPassword(this);"></i>
                                                <i class="fa fa-eye" id="hide-pass" onclick="return cntrlPassword(this);"></i>
                                            </div>
                                            <input name="pass" id="pass" type="password" value="<?php echo $pass; ?>">

                                            <i class="cfa fa fa-check-circle"></i>
                                            <i class="cfa fa fa-exclamation-circle"></i>
                                            <small class="line-error">Please, provide your password!</small>
                                        </div>
                                        <div class="remember-me">
                                            <input name="rmmbr" id="rmmbr" type="checkbox" value="1">
                                            <label for="rmmbr">Remember Me</label>
                                        </div>

                                        <input type="submit" value="Login">
                                    </form>
                                </div>
                                <div class="login-footer">
                                    <span>Forget Password?</span>
                                    <a href="forget-password">GO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php require_once 'footer.php'; ?>
                <?php require_once 'site_body.php'; ?>
                <script>
                    console.log(<?php if(isset($_SESSION["vkey"])) echo $_SESSION["vkey"]; ?>)
                </script>
            </body>
        </html>

<?php
    } else{
        header('location: user/home');
    }
?>