<?php
    session_start();
    require_once '../site.php';
    $title = 'View pending verification';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        $stmtLevel = "select level from users where uid = '$uid'";
        $resultLevel = mysqli_query($conn, $stmtLevel);
        $fetchLevel = mysqli_fetch_array($resultLevel);

        if($fetchLevel['level'] != 1){
            header('location: verification');
        }

        if(isset($_GET['ui']) && isset($_GET['vid'])){
            $ui = ((base64_decode($_GET['ui']) - 387) / 137);
            $vid = $_GET['vid'];

            $stmtExist = "select * from verification where uid = '$ui' and vid = '$vid' and status = 0";
            $resultExist = mysqli_query($conn, $stmtExist);
            $countExist = mysqli_num_rows($resultExist);

            if($countExist < 1){
                header('location: verification');
            }
        } else{
            header('location: verification');
        }

        $stmt = "select verification.*, users.* from verification, users where verification.uid = users.uid and verification.uid = '$ui' and verification.status = 0";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['ver_accept_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Verification accept unsuccessful!",
                                    })
                                </script>';

                        unset($_SESSION['ver_accept_fail']);
                    } elseif(isset($_SESSION['ver_delete_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Verification delete unsuccessful!",
                                    })
                                </script>';

                        unset($_SESSION['ver_delete_fail']);
                    }
                ?>

                <section class="vmpv-area">
                    <div class="container">
                        <div class="vmpv-container">
                            <fieldset>
                                <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                    <input name="accept_vmpv" type="text" value="accept_vmpv" hidden>
                                    <input name="vid" type="text" value="<?php echo $fetch['vid']; ?>" hidden>
                                    <input name="ui" type="text" value="<?php echo $ui; ?>" hidden>
                                    <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                </form>
                                <a href="#" onclick="document.getElementsByClassName('acs-form')[0].submit();"><i class="fa fa-check fc"></i></a>

                                <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                    <input name="delete_vmpv" type="text" value="delete_vmpv" hidden>
                                    <input name="vid" type="text" value="<?php echo $fetch['vid']; ?>" hidden>
                                    <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                </form>
                                <a href="#" onclick="document.getElementsByClassName('acs-form')[1].submit();"><i class="fa fa-trash lc"></i></a>

                                <legend>Name</legend>
                                <label for=""><?php echo $fetch['name']; ?></label>
                            </fieldset>
                            <div class="view-btn">
                                <a href="../files/documents/verification/<?php echo $fetch['bcp']; ?>" data-lightbox="file" data-title="<?php echo $fetch['bcn']; ?>">Birth Registration</a>
                            </div>
                            <div class="view-btn">
                                <a href="../files/documents/verification/<?php echo $fetch['nidp']; ?>" data-lightbox="file" data-title="<?php echo $fetch['nidn']; ?>">National Identity</a>
                            </div>
                        </div>
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