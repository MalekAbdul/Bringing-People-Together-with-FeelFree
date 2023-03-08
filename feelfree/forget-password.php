<?php
    session_start();
    require_once 'site.php';
    $title = 'Forget password';

    if(!isset($_SESSION['uid'])){
?>

        <!doctype html>
        <html lang="en">
        <?php require_once 'site_head.php'; ?>
        <body>
        <?php require_once 'header.php'; ?>

        <section class="fgtpass-area">
            <?php
                if(isset($_SESSION['fgtpass-second-phase'])){
                    echo '<div class="top-error" id="top-error">We sent a mail with the OTP code to the email address listed below. It may take a few minutes for the code to arrive.<i class="fa fa-times-circle cross" id="cross"></i></div>';
                } elseif(isset($_SESSION['sw'])){
                    echo '<div class="top-error" id="top-error">Something went wrong.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                    unset($_SESSION['sw']);
                }
            ?>
            <div class="fgtpass-box">
                <div class="fgtpass-title"><h4>Forget Password</h4></div>
                <div class="fgtpass-body">
                    <?php
                        if(isset($_SESSION['fgtpass-second-phase'])){
                    ?>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#fgtpass-first-phase').hide();
                                });
                            </script>

                            <form id="fgtpass-second-phase" action="cnnction/forget_password.php" method="post" onsubmit="return fgtpassOtp(this);">
                                <div class="fgtpass-email">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" type="email" value="<?php echo $_SESSION['fgtpass-second-phase']; ?>" style="border-color: #008000;" readonly>

                                    <i class="cfa fa fa-check-circle" style="visibility: visible; color: #008000;"></i>
                                </div>
                                <div class="fgtpass-otp">
                                    <label for="otp">OTP</label>
                                    <input name="otp" id="otp" type="text" autofocus>

                                    <i class="cfa fa fa-check-circle"></i>
                                    <i class="cfa fa fa-exclamation-circle"></i>
                                    <small class="line-error">Please, provide your otp!</small>
                                </div>

                                <input name="fgtpass-second-phase" type="submit" value="Confirm">
                            </form>

                            <div class="cd-timer" id="cd-timer" style="margin: 10px 0; color: #FFF; text-align: center;"></div>

                            <script type="text/javascript">
                                let start_min = 5;
                                let time = start_min * 60;

                                setInterval(function(){
                                    let min = Math.floor(time / 60);
                                    let sec = time % 60;

                                    if(time < 0){
                                        document.getElementById('cd-timer').innerHTML = 'Expired';
                                    } else{
                                        if(sec < 10){
                                            sec = '0' + sec;
                                        } else{
                                            sec = sec;
                                        }

                                        document.getElementById('cd-timer').innerHTML = min+' : '+sec;
                                    }

                                    time--;
                                }, 1000);
                            </script>
                    <?php
                            unset($_SESSION['fgtpass-second-phase']);
                        }
                    ?>

                    <form id="fgtpass-first-phase" action="cnnction/forget_password.php" method="post" onsubmit="return fgtpassEmail(this);">
                        <div class="fgtpass-email">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" autofocus>

                            <i class="cfa fa fa-check-circle"></i>
                            <i class="cfa fa fa-exclamation-circle"></i>
                            <small class="line-error">Please, provide your email!</small>
                        </div>

                        <input name="fgtpass-first-phase" type="submit" value="Get New Password">
                    </form>
                </div>
                <div class="fgtpass-footer">
                    <a href="login">Back</a>
                </div>
            </div>
        </section>

        <?php require_once 'footer.php'; ?>
        <?php require_once 'site_body.php'; ?>
        </body>
        </html>

<?php
    } else{
        header('location: user/home');
    }
?>