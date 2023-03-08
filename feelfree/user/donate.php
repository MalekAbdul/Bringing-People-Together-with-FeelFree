<?php
    session_start();
    require_once '../site.php';
    $title = 'Donate';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        if(isset($_GET['ui']) && isset($_GET['pid'])){
            $ui = ((base64_decode($_GET['ui']) - 387) / 137);
            $pid = $_GET['pid'];

            $stmtExist = "select * from posts where uid = '$ui' and pid = '$pid' and status = 1";
            $resultExist = mysqli_query($conn, $stmtExist);
            $countExist = mysqli_num_rows($resultExist);

            if($countExist < 1){
                header('location: profile');
            } else{
                if($ui != $uid){}
                else{
                    header('location: profile');
                }
            }
        } else{
            header('location: profile');
        }

        $stmt = "select * from posts where uid = '$ui' and pid = '$pid' and status = 1";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['donate_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "success",
                                    title: "Donate successful!",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>';

                        unset($_SESSION['donate_success']);
                    } elseif(isset($_SESSION['donate_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Donate unsuccessful!",
                                })
                            </script>';

                        unset($_SESSION['donate_fail']);
                    }
                ?>

                <section class="donate-area">
                    <div class="container">
                        <form action="../cnnction/donate.php" method="post" onsubmit="return donateAmount(this);">
                            <div class="post-title">
                                <fieldset>
                                    <legend>Title</legend>
                                    <textarea name="description" id="description" cols="30" rows="2" readonly><?php echo $fetch['title']; ?></textarea>
                                </fieldset>
                                <div class="view-btn">
                                    <a href="../files/documents/<?php echo $fetch['file']; ?>" data-lightbox="<?php echo $fetch['title']; ?>" data-title="<?php echo $fetch['title']; ?>"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="post-amount">
                                <fieldset>
                                    <legend>Give Amount</legend>
                                    <input name="amount" id="amount" type="text" autofocus>

                                    <i class="cfa fa fa-check-circle"></i>
                                    <i class="cfa fa fa-exclamation-circle"></i>
                                    <small class="line-error">Please, provide your amount!</small>
                                </fieldset>
                            </div>

                            <input name="pid" type="text" value="<?php echo $_GET['pid']; ?>" hidden>
                            <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>

                            <input type="submit" value="Donate">
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