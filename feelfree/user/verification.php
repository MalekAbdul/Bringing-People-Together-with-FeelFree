<?php
    session_start();
    require_once '../site.php';
    $title = 'Verify your identity';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        $stmtLevel = "select level from users where uid = '$uid'";
        $resultLevel = mysqli_query($conn, $stmtLevel);
        $fetchLevel = mysqli_fetch_array($resultLevel);

        if($fetchLevel['level'] == 1){
            header('location: member-pending-verification');
        }

        $stmt = "select status from verification where uid = '$uid'";
        $result = mysqli_query($conn, $stmt);
        $count = mysqli_num_rows($result);
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if($count > 0){
                        $fetch = mysqli_fetch_array($result);

                        if($fetch['status'] == 0){
                ?>
                            <section class="ver-area">
                                <div class="container">
                                    <div class="ver-content">
                                        <fieldset>
                                            <legend>Note</legend>
                                            <label for="">***First of all, for any request, you must need to verify your identity.</label>
                                        </fieldset>
                                        <div class="pending-area">
                                            <div class="pending-anm">
                                                <img src="../css/assets/waiting_spinner.gif" alt="waiting spinner">
                                            </div>
                                            <h4>Please, wait for the approval.</h4>
                                        </div>
                                    </div>
                                </div>
                            </section>
                <?php
                            if(isset($_SESSION['ver_success'])){
                                echo '<script type="text/javascript">Swal.fire({
                                        icon: "success",
                                        title: "Your submission is successful!",
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                </script>';

                                unset($_SESSION['ver_success']);
                            }
                        } else{
                ?>
                            <section class="ver-area">
                                <div class="container">
                                    <div class="ver-content">
                                        <fieldset>
                                            <legend>Note</legend>
                                            <label for="">***Congrats! You are now verified member.</label>
                                        </fieldset>
                                        <div class="success-area">
                                            <div class="success-anm">
                                                <img src="../css/assets/success_spinner.gif" alt="success spinner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                <?php
                        }
                    } else{
                ?>

                <?php
                        if(isset($_SESSION['ver_fail'])){
                            echo '<script type="text/javascript">Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Your submission is unsuccessful!",
                                })
                            </script>';

                            unset($_SESSION['ver_fail']);
                        }
                ?>

                <section class="ver-area">
                    <div class="container">
                        <form class="ver-content" action="../cnnction/verification.php" method="post" enctype="multipart/form-data" onsubmit="return ver(this);">
                            <fieldset>
                                <legend>Note</legend>
                                <label for="">***First of all, for any request, you must need to verify your identity.</label>
                            </fieldset>

                            <div class="ver-bcn">
                                <input name="bcn" id="bcn" type="text" placeholder="Birth Registration No" autofocus>

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your birth registration no!</small>
                            </div>
                            <div class="ver-nidn">
                                <input name="nidn" id="nidn" type="text" placeholder="National Identity No">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your national identity no!</small>
                            </div>
                            <div class="ver-bcp">
                                <label for="bcp">Birth Registration Photo</label>
                                <input name="bcp" id="bcp" type="file">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your file!</small>
                            </div>
                            <div class="ver-nidp">
                                <label for="nidp">National Identity Photo</label>
                                <input name="nidp" id="nidp" type="file">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your file!</small>
                            </div>

                            <input type="submit" value="Send">
                        </form>
                    </div>
                </section>

                <?php
                    }
                ?>

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