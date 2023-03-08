<?php
    session_start();
    require_once '../site.php';
    $title = 'Create a new post';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        $stmt = "select level, verification from users where uid = '$uid'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);

        if($fetch['level'] == 1 || $fetch['verification'] == 1){}
        else{
            header('location: verification');
        }
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['post_asuccess'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "success",
                                title: "Post successful!",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        </script>';

                        unset($_SESSION['post_asuccess']);
                    } elseif(isset($_SESSION['post_afail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Post unsuccessful!",
                            })
                        </script>';

                        unset($_SESSION['post_afail']);
                    } elseif(isset($_SESSION['post_usuccess'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "success",
                                title: "Post request successful!",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        </script>';

                        unset($_SESSION['post_usuccess']);
                    } elseif(isset($_SESSION['post_ufail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Post request unsuccessful!",
                            })
                        </script>';

                        unset($_SESSION['post_ufail']);
                    }
                ?>

                <section class="cpost-area">
                    <div class="container">
                        <form action="../cnnction/create_post.php" method="post" enctype="multipart/form-data" onsubmit="return cpost(this);">
                            <fieldset>
                                <legend>Note</legend>
                                <label for="">***Must be added any document, which is relative or supportive to your problem.</label>
                            </fieldset>

                            <div class="post-title">
                                <input name="title" id="title" type="text" placeholder="Title" autofocus>

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your title!</small>
                            </div>
                            <div class="post-description">
                                <textarea name="description" id="description" cols="30" rows="10" placeholder="Brief your problem..."></textarea>

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your description!</small>
                            </div>
                            <div class="post-amount">
                                <input name="amount" id="amount" type="text" placeholder="Amount">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your amount!</small>
                            </div>
                            <div class="post-file">
                                <input name="file" id="file" type="file">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide your file!</small>
                            </div>

                            <input type="submit" value="Send">
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