<?php
    session_start();
    require_once '../site.php';
    $title = 'Edit profile';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once '../db/connection.php';

        if(isset($_GET['ui'])){
            $ui = ((base64_decode($_GET['ui']) - 387) / 137);

            $stmtExist = "select * from users where uid = '$ui'";
            $resultExist = mysqli_query($conn, $stmtExist);
            $countExist = mysqli_num_rows($resultExist);

            if($countExist < 1){
                header('location: profile');
            } else{
                $stmtLevel = "select level from users where uid = '$uid'";
                $resultLevel = mysqli_query($conn, $stmtLevel);
                $fetchLevel = mysqli_fetch_array($resultLevel);

                if($fetchLevel['level'] == 1){}
                else{
                    header('location: profile');
                }
            }
        } else{
            header('location: profile');
        }

        $stmt = "select * from users where uid = '$ui'";
        $result = mysqli_query($conn, $stmt);
        $fetch = mysqli_fetch_array($result);

        if($fetch['status'] == '1'){}
        else{
            header('location: profile');
        }
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['profile_updated_successful'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "success",
                                title: "Profile updated successful!",
                                showConfirmButton: false,
                                timer: 1500
                            })
                        </script>';

                        unset($_SESSION['profile_updated_successful']);
                    } elseif(isset($_SESSION['profile_updated_unsuccessful'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Profile updated unsuccessful!",
                            })
                        </script>';

                        unset($_SESSION['profile_updated_unsuccessful']);
                    }
                ?>

                <section class="eprofile-area">
                    <div class="container">
                        <form action="../cnnction/edit_profile.php" method="post" onsubmit="return eprofile(this);">
                            <fieldset>
                                <legend>Note</legend>
                                <label for="">***Please, edit carefully.</label>
                            </fieldset>

                            <div class="eprofile-name">
                                <label for="name">Name</label>
                                <input name="name" id="name" type="text" value="<?php echo $fetch['name']; ?>">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide member name!</small>
                            </div>
                            <div class="eprofile-phone">
                                <label for="phone">Phone</label>
                                <input name="phone" id="phone" type="text" value="<?php echo $fetch['phone']; ?>">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide member phone!</small>
                            </div>
                            <div class="eprofile-email">
                                <label for="email">Email</label>
                                <input name="email" id="email" type="email" value="<?php echo $fetch['email']; ?>">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide member email!</small>
                            </div>
                            <div class="eprofile-password">
                                <label for="password">Password</label>
                                <input name="password" id="password" type="password">

                                <i class="cfa fa fa-check-circle"></i>
                                <i class="cfa fa fa-exclamation-circle"></i>
                                <small class="line-error">Please, provide member password!</small>
                            </div>
                            <div class="eprofile-birthday">
                                <label for="birthday">Birthday</label>
                                <input name="birthday" id="birthday" type="date" value="<?php echo date('Y-m-d', strtotime($fetch['birthday'])); ?>" required>
                            </div>
                            <?php
                                if($fetch['gender'] == 1){
                                    $gmchecked = 'checked';
                                    $gfmchecked = '';
                                } else{
                                    $gmchecked = '';
                                    $gfmchecked = 'checked';
                                }
                            ?>
                            <div class="eprofile-gender">
                                <input name="gender" id="male" type="radio" value="1" <?php echo $gmchecked; ?>>
                                <label for="male">Male</label>
                                <input name="gender" id="female" type="radio" value="2" <?php echo $gfmchecked; ?>>
                                <label for="female">Female</label>
                            </div>
                            <?php
                                if($fetch['level'] == 1){
                                    $lvlaselected = 'selected';
                                    $lvluselected = '';
                                } else{
                                    $lvlaselected = '';
                                    $lvluselected = 'selected';
                                }
                            ?>
                            <div class="eprofile-level">
                                <label for="level">Access</label>
                                <select name="level" id="level">
                                    <option value="1" <?php echo $lvlaselected; ?>>Admin</option>
                                    <option value="2" <?php echo $lvluselected; ?>>User</option>
                                </select>
                            </div>

                            <input name="ui" type="text" value="<?php echo $ui; ?>" hidden>
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