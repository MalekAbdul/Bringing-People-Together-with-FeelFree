<?php
    session_start();
    require_once 'site.php';
    $title = 'Registration';

    if(!isset($_SESSION['uid'])){
        $name = '';
        $phone = '';
        $email = '';
        $birthday = '';
        $gmchecked = 'checked';
        $gfmchecked = '';

        if(isset($_SESSION['name'])){
            $name = $_SESSION['name'];
            unset($_SESSION['name']);
        } if(isset($_SESSION['phone'])){
            $phone = $_SESSION['phone'];
            unset($_SESSION['phone']);
        } if(isset($_SESSION['email'])){
            $email = $_SESSION['email'];
            unset($_SESSION['email']);
        } if(isset($_SESSION['birthday'])){
            $birthday = $_SESSION['birthday'];
            unset($_SESSION['birthday']);
        } if(isset($_SESSION['gender'])){
            $gender = $_SESSION['gender'];

            if($gender == 1){
                $gmchecked = 'checked';
            } else{
                $gfmchecked = 'checked';
            }

            unset($_SESSION['gender']);
        }
?>

        <!doctype html>
        <html lang="en">
        <?php require_once 'site_head.php'; ?>
        <body>
        <?php require_once 'header.php'; ?>

        <section class="reg-area">
            <?php
                if(isset($_SESSION['ex_email'])){
                    echo '<div class="top-error" id="top-error">This email is already registered.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                    unset($_SESSION['ex_email']);
                } elseif(isset($_SESSION['sw'])){
                    echo '<div class="top-error" id="top-error">Something went wrong.<i class="fa fa-times-circle cross" id="cross"></i></div>';

                    unset($_SESSION['sw']);
                }
            ?>
            <div class="reg-box">
                <div class="reg-title"><h4>Registration</h4></div>
                <div class="reg-body">
                    <form action="cnnction/registration.php" method="post" onsubmit="return reg(this);">
                        <div class="reg-name">
                            <label for="name">Name</label>
                            <input name="name" id="name" type="text" value="<?php echo $name; ?>" autofocus>

                            <i class="cfa fa fa-check-circle"></i>
                            <i class="cfa fa fa-exclamation-circle"></i>
                            <small class="line-error">Please, provide your name!</small>
                        </div>
                        <div class="reg-phone">
                            <label for="phone">Phone</label>
                            <input name="phone" id="phone" type="text" value="<?php echo $phone; ?>">

                            <i class="cfa fa fa-check-circle"></i>
                            <i class="cfa fa fa-exclamation-circle"></i>
                            <small class="line-error">Please, provide your phone!</small>
                        </div>
                        <div class="reg-email">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" value="<?php echo $email; ?>">

                            <i class="cfa fa fa-check-circle"></i>
                            <i class="cfa fa fa-exclamation-circle"></i>
                            <small class="line-error">Please, provide your email!</small>
                        </div>
                        <div class="reg-birthday">
                            <label for="birthday">Birthday</label>
                            <input name="birthday" id="birthday" type="date" value="<?php echo $birthday; ?>" required>
                        </div>
                        <div class="reg-gender">
                            <input name="gender" id="male" type="radio" value="1" <?php echo $gmchecked; ?>>
                            <label for="male">Male</label>
                            <input name="gender" id="female" type="radio" value="2" <?php echo $gfmchecked; ?>>
                            <label for="female">Female</label>
                        </div>
                        <div class="acceptance">
                            <input name="acceptance" id="acceptance" type="checkbox" value="1" onchange="return regAcceptance(this);" checked>
                            <label for="acceptance">
                                I have read and agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                            </label>
                        </div>

                        <input class="reg-submit" type="submit" value="Submit">
                    </form>
                </div>
                <div class="reg-footer">
                    <span>Already have an account?</span>
                    <a href="login">GO</a>
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