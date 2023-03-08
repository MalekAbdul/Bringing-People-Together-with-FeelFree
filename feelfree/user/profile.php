<?php
    session_start();
    require_once '../site.php';
    $title = 'Profile';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        require_once('../db/connection.php');

        if(isset($_GET['ui'])){
            $ui = ((base64_decode($_GET['ui']) - 387) / 137);

            $stmtExist = "select * from users where uid = '$ui'";
            $resultExist = mysqli_query($conn, $stmtExist);
            $countExist = mysqli_num_rows($resultExist);

            if($countExist < 1){
                header('location: profile');
            }
        } else{
            $ui = $uid;
        }

        if(isset($_GET['page'])){
            $page = $_GET['page'];
        } else{
            $page = 1;
        }

        $numPerPage = 15;
        $startFrom = ($page-1)*$numPerPage;

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
                    if(isset($_SESSION['profile_photo_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                            icon: "success",
                                            title: "Photo update successful!",
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    </script>';

                        unset($_SESSION['profile_photo_success']);
                    } elseif(isset($_SESSION['profile_photo_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                                icon: "error",
                                                title: "Oops...",
                                                text: "Photo update unsuccessful!",
                                            })
                                        </script>';

                        unset($_SESSION['profile_photo_fail']);
                    }
                ?>

                <section class="user-area">
                    <div class="container">
                        <div class="user-box">
                            <div id="user-img" class="user-img">
                                <?php
                                    if($ui == $uid){
                                        echo '<label id="file-btn" for="file"><i class="fa fa-camera"></i></label>';
                                    }
                                ?>
                                <img src="../files/photos/<?php echo $fetch['photo']; ?>" alt="user-img">
                            </div>

                            <form action="../cnnction/profile_photo.php" method="post" enctype="multipart/form-data" onsubmit="return profileFile(this);">
                                <small class="line-error">Please, upload your photo!</small>
                                <input name="file" id="file" type="file" onchange="return ppUpdate(this);" hidden>
                                <input id="update" type="submit" value="Update" style="display: none;">
                            </form>

                            <div class="user-name">
                                <h4><?php echo $fetch['name']; ?></h4>
                            </div>

                            <?php
                                $stmtLevel = "select level from users where uid = '$uid'";
                                $resultLevel = mysqli_query($conn, $stmtLevel);
                                $fetchLevel = mysqli_fetch_array($resultLevel);
                                if($fetchLevel['level'] == 1){
                            ?>
                                    <div class="user-btn"><a href="edit-profile?ui=<?php echo base64_encode(($fetch['uid'] * 137) + 387); ?>">Edit</a></div>
                            <?php
                                }
                            ?>

                        </div>
                    </div>
                </section>
                <section class="post-area">
                    <div class="container">

                        <?php
                            $stmtData = "select * from posts where uid = '$ui' and status = 1 order by pid desc limit $startFrom, $numPerPage";
                            $resultData = mysqli_query($conn, $stmtData);
                            $countData = mysqli_num_rows($resultData);

                            if($countData >= 1){
                                for($i = 1; $i <= $countData; $i++){
                                    $fetchData = mysqli_fetch_array($resultData);
                        ?>

                                    <div class="post-box">
                                        <div class="post-header">
                                            <div class="left">PID: <?php echo $fetchData['pid']; ?></div>
                                            <div class="right">PD: <?php echo date('d-m-Y', strtotime($fetchData['pd'])); ?></div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <hr>

                                        <div class="post-body">
                                            <div class="title"><b><?php echo $fetchData['title']; ?></b></div>
                                            <div class="description">
                                                <?php
                                                    if(strlen($fetchData['description']) > 200){
                                                        echo $description = substr($fetchData['description'], 0, 199) . '...';
                                                    } else{
                                                        echo $fetchData['description'];
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="post-footer ppf">

                                            <?php
                                                if($fetchLevel['level'] == 1){
                                            ?>
                                                    <a href="edit-post?ui=<?php echo base64_encode(($fetchData['uid'] * 137) + 387); ?>&pid=<?php echo $fetchData['pid']; ?>">Edit</a>
                                            <?php
                                                } else{
                                            ?>
                                                    <a href="view-post?ui=<?php echo base64_encode(($fetchData['uid'] * 137) + 387); ?>&pid=<?php echo $fetchData['pid']; ?>">View</a>
                                            <?php
                                                }
                                            ?>

                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="post-progress">
                                            <?php
                                                $ta = $fetchData['ta'] / 100;
                                                $ca = $fetchData['ca'] / $ta;

                                                if($uid == $fetchData['uid'] || $fetchLevel['level'] == 1){
                                                    $taShow = 'TA: '.$fetchData['ta'].' BDT | ';
                                                    $caShow = 'CA: '.$fetchData['ca'].' BDT';
                                                } else{
                                                    $taShow = '';
                                                    $caShow = '';
                                                }
                                            ?>
                                            <abbr title="<?php echo $taShow.$caShow; ?>">
                                                <progress value="<?php echo $ca; ?>" max="100"></progress>
                                            </abbr>
                                        </div>
                                    </div>

                        <?php
                                }
                            } else{
                        ?>

                                <div class="no-content-view"></div>

                        <?php
                            }

                            $stmtPagination = "select * from posts where uid = '$ui' and status = 1";
                            $resultPagination = mysqli_query($conn, $stmtPagination);
                            $countPagination = mysqli_num_rows($resultPagination);

                            if($countPagination > $numPerPage){
                        ?>

                                <div class="show-more" id="show-more">

                                    <?php
                                        $uip = base64_encode(($ui * 137) + 387);
                                        $total = ceil($countPagination / $numPerPage);
                                        $adjacents = 2;
                                        $second_last = $total - 1;

                                        if($page > 1){
                                            echo '<a href="?ui='.$uip.'&page='.($page - 1).'">Previous</a>';
                                        }

                                        if ($total <= 10){
                                            for($i = 1; $i <= $total; $i++){
                                                if($i == $page){
                                                    echo '<strong>'.$i.'</strong>';
                                                } else{
                                                    echo '<a href="?ui='.$uip.'&page='.$i.'">'.$i.'</a>';
                                                }
                                            }
                                        }

                                        if ($total > 10){
                                            if($page <= 4){
                                                for($i = 1; $i < 8; $i++){
                                                    if($i == $page){
                                                        echo '<strong>'.$i.'</strong>';
                                                    } else{
                                                        echo '<a href="?ui='.$uip.'&page='.$i.'">'.$i.'</a>';
                                                    }
                                                }

                                                echo '<span>...</span>';
                                                echo '<a href="?ui='.$uip.'&page='.$second_last.'">'.$second_last.'</a>';
                                                echo '<a href="?ui='.$uip.'&page='.$total.'">'.$total.'</a>';
                                            } else{
                                                if($page > 4 && $page < $total - 4){
                                                    echo '<a href="?ui='.$uip.'&page=1">1</a>';
                                                    echo '<a href="?ui='.$uip.'&page=2">2</a>';
                                                    echo '<span>...</span>';

                                                    for($i = $page - 1; $i <= $page + $adjacents; $i++){
                                                        if ($i == $page){
                                                            echo '<strong>'.$i.'</strong>';
                                                        } else{
                                                            echo '<a href="?ui='.$uip.'&page='.$i.'">'.$i.'</a>';
                                                        }
                                                    }

                                                    echo '<span>...</span>';
                                                    echo '<a href="?ui='.$uip.'&page='.$second_last.'">'.$second_last.'</a>';
                                                    echo '<a href="?ui='.$uip.'&page='.$total.'">'.$total.'</a>';
                                                } else{
                                                    echo '<a href="?ui='.$uip.'&page=1">1</a>';
                                                    echo '<a href="?ui='.$uip.'&page=2">2</a>';
                                                    echo '<span>...</span>';

                                                    for($i = $total - 6; $i <= $total; $i++){
                                                        if ($i == $page){
                                                            echo '<strong>'.$i.'</strong>';
                                                        } else{
                                                            echo '<a href="?ui='.$uip.'&page='.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if($i > ($page + 1)){
                                            echo '<a href="?ui='.$uip.'&page='.($page + 1).'">Next</a>';
                                        }

                                        if($page < $total){
                                            echo '<a href="?ui='.$uip.'&page='.$total.'">Last &rsaquo; &rsaquo;</a>';
                                        }

                                    ?>

                                </div>

                        <?php
                            }
                        ?>
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

        //$link = urlencode($site_url.'user/profile');
        $link = urlencode($fullUrl);
        header('location: ../login?src='.$link);
    }