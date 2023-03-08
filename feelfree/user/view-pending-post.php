<?php
    session_start();
    require_once '../site.php';
    $title = 'View post';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        $stmtLevel = "select level from users where uid = '$uid'";
        $resultLevel = mysqli_query($conn, $stmtLevel);
        $fetchLevel = mysqli_fetch_array($resultLevel);

        if($fetchLevel['level'] != 1){
            header('location: pending');
        }

        if(isset($_GET['ui']) && isset($_GET['pid'])){
            $ui = ((base64_decode($_GET['ui']) - 387) / 137);
            $pid = $_GET['pid'];

            $stmtExist = "select * from posts where uid = '$ui' and pid = '$pid' and status = 0";
            $resultExist = mysqli_query($conn, $stmtExist);
            $countExist = mysqli_num_rows($resultExist);

            if($countExist < 1){
                header('location: profile');
            }
        } else{
            header('location: profile');
        }

        $stmt = "select * from posts where uid = '$ui' and pid = '$pid' and status = 0";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['post_accept_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Post accept unsuccessful!",
                                })
                            </script>';

                        unset($_SESSION['post_accept_fail']);
                    } elseif(isset($_SESSION['post_decline_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Post decline unsuccessful!",
                                })
                            </script>';

                        unset($_SESSION['post_decline_fail']);
                    } elseif(isset($_SESSION['post_delete_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Post delete unsuccessful!",
                                })
                            </script>';

                        unset($_SESSION['post_delete_fail']);
                    }
                ?>

                <section class="vpost-area">
                    <div class="container">
                        <div class="vpost-container">
                            <fieldset>
                                <legend>Title</legend>
                                <textarea name="description" id="description" cols="30" rows="2" readonly><?php echo $fetch['title']; ?></textarea>
                            </fieldset>
                            <fieldset>
                                <legend>Description</legend>
                                <textarea name="description" id="description" cols="30" rows="10" readonly><?php echo $fetch['description']; ?></textarea>
                            </fieldset>
                            <fieldset>
                                <legend>Amount</legend>
                                <input name="amount" id="amount" type="text" value="<?php echo $fetch['ta']; ?>" readonly>
                            </fieldset>
                            <div class="view-btn">
                                <a href="../files/documents/<?php echo $fetch['file']; ?>" data-lightbox="<?php echo $fetch['title']; ?>" data-title="<?php echo $fetch['title']; ?>">View</a>
                            </div>
                            <div class="view-btn">
                                <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                    <input name="accept_vpp" type="text" value="accept_vpp" hidden>
                                    <input name="pid" type="text" value="<?php echo $_GET['pid']; ?>" hidden>
                                    <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                </form>
                                <a href="#" onclick="document.getElementsByClassName('acs-form')[0].submit();">Accept</a>
                            </div>
                            <div class="view-btn">
                                <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                    <input name="decline_vpp" type="text" value="decline_vpp" hidden>
                                    <input name="pid" type="text" value="<?php echo $_GET['pid']; ?>" hidden>
                                    <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                </form>
                                <a href="#" onclick="document.getElementsByClassName('acs-form')[1].submit();">Decline</a>
                            </div>
                            <div class="view-btn">
                                <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                    <input name="delete_vpp" type="text" value="delete_vpp" hidden>
                                    <input name="pid" type="text" value="<?php echo $_GET['pid']; ?>" hidden>
                                    <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                </form>
                                <a href="#" onclick="document.getElementsByClassName('acs-form')[2].submit();">Delete</a>
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