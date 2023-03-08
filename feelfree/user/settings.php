<?php
    session_start();
    require_once '../site.php';
    $title = 'Settings';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        $stmt = "select * from users where uid = '$uid'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['pass_updated_successful'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "success",
                                title: "Password updated successful!",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        </script>';

                        unset($_SESSION['pass_updated_successful']);
                    } elseif(isset($_SESSION['pass_updated_unsuccessful'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Password updated unsuccessful!",
                            })
                        </script>';

                        unset($_SESSION['pass_updated_unsuccessful']);
                    }
                ?>

                <section class="settings-area">
                    <div class="container">
                        <form action="../cnnction/settings.php" method="post" onsubmit="return settingsPass(this);">
                            <fieldset>
                                <legend>Note</legend>
                                <label for="">***Please, edit carefully.</label>
                            </fieldset>

                            <div class="settings-name">
                                <label for="name">Name</label>
                                <input name="name" id="name" type="text" value="<?php echo $fetch['name']; ?>" readonly>
                            </div>
                            <div class="settings-phone">
                                <label for="phone">Phone</label>
                                <input name="phone" id="phone" type="text" value="<?php echo $fetch['phone']; ?>" readonly>
                            </div>
                            <div class="settings-email">
                                <label for="email">Email</label>
                                <input name="email" id="email" type="email" value="<?php echo $fetch['email']; ?>" readonly>
                            </div>
                            <div class="settings-password">
                                <label for="password">Password</label>
                                <input name="password" id="password" type="password" autofocus>

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your password!</small>
                            </div>

                            <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>

                            <input type="submit" value="Update">
                        </form>
                    </div>
                </section>

                <?php require_once '../footer.php'; ?>
                <?php require_once '../site_body.php'; ?>
            </body>
        </html>

<?php
    } else{
        $string = 'Access Denied. To view this page, you must log in to this page.';
        $en_msg = base64_encode($string);
        $_SESSION['login_first'] = $en_msg;

        $link = urlencode($fullUrl);
        header('location: ../login?src='.$link);
    }