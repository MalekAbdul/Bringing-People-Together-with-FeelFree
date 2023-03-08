<?php
    session_start();
    require_once '../site.php';
    $title = 'Home';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];

        if(isset($_GET['page'])){
            $page = $_GET['page'];
        } else{
            $page = 1;
        }

        $numPerPage = 15;
        $startFrom = ($page-1)*$numPerPage;
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['post_pending_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                        icon: "success",
                                        title: "Post pending successful!",
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                </script>';

                        unset($_SESSION['post_pending_success']);
                    } elseif(isset($_SESSION['post_decline_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                        icon: "success",
                                        title: "Post decline successful!",
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                </script>';

                        unset($_SESSION['post_decline_success']);
                    } elseif(isset($_SESSION['post_delete_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                        icon: "success",
                                        title: "Post delete successful!",
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                </script>';

                        unset($_SESSION['post_delete_success']);
                    } elseif(isset($_SESSION['post_pending_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "Post pending unsuccessful!",
                                        })
                                    </script>';

                        unset($_SESSION['post_pending_fail']);
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

                <section class="post-area">
                    <div class="container">

                        <?php
                            require_once '../db/connection.php';

                            $stmtPagination = "select * from posts where status = 1";
                            $resultPagination = mysqli_query($conn, $stmtPagination);
                            $countPagination = mysqli_num_rows($resultPagination);

                            $stmt = "select posts.*, users.* from posts, users where posts.uid = users.uid and posts.status = 1 order by posts.pid desc limit $startFrom, $numPerPage";
                            $result = mysqli_query($conn, $stmt);
                            $count = mysqli_num_rows($result);

                            if($count >= 1){
                                for($i = 1; $i <= $count; $i++){
                                    $fetch = mysqli_fetch_array($result);
                        ?>

                                    <div class="post-box">
                                        <div class="post-header">
                                            <div class="left">PID: <?php echo $fetch['pid']; ?></div>
                                            <div class="right">PD: <?php echo date('d-m-Y', strtotime($fetch['pd'])); ?></div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <hr>

                                        <div class="post-body">
                                            <div class="user">
                                                <div class="user-img">
                                                    <img src="../files/photos/<?php echo $fetch['photo']; ?>" alt="user-img">
                                                </div>
                                                <h4><a href="profile?ui=<?php echo base64_encode(($fetch['uid'] * 137) + 387); ?>"><?php echo $fetch['name']; ?></a></h4>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="title"><b><?php echo $fetch['title']; ?></b></div>
                                            <div class="description">
                                                <?php
                                                    if(strlen($fetch['description']) > 200){
                                                        echo $description = substr($fetch['description'], 0, 199) . '...';
                                                    } else{
                                                        echo $fetch['description'];
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="post-footer">
                                            <div class="left pfm">

                                                <?php
                                                    $stmtLevel = "select level from users where uid = '$uid'";
                                                    $resultLevel = mysqli_query($conn, $stmtLevel);
                                                    $fetchLevel = mysqli_fetch_array($resultLevel);

                                                    if($fetchLevel['level'] == 1){
                                                ?>

                                                        <!-- When I hover the quick view, it shows menu for all posts at a time. That's an error! -->
                                                        <div class="qview-menu">
                                                            <a href="edit-post?ui=<?php echo base64_encode(($fetch['uid'] * 137) + 387); ?>&pid=<?php echo $fetch['pid']; ?>"><i class="fa fa-edit"></i></a>

                                                            <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                                                <input name="pause_home" type="text" value="pause_home" hidden>
                                                                <input name="pid" type="text" value="<?php echo $fetch['pid']; ?>" hidden>
                                                                <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                                            </form>
                                                            <a href="#" onclick="document.getElementsByClassName('acs-form')[0].submit();"><i class="fa fa-pause"></i></a>

                                                            <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                                                <input name="decline_home" type="text" value="decline_home" hidden>
                                                                <input name="pid" type="text" value="<?php echo $fetch['pid']; ?>" hidden>
                                                                <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                                            </form>
                                                            <a href="#" onclick="document.getElementsByClassName('acs-form')[1].submit();"><i class="fa fa-times"></i></a>

                                                            <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                                                <input name="delete_home" type="text" value="delete_home" hidden>
                                                                <input name="pid" type="text" value="<?php echo $fetch['pid']; ?>" hidden>
                                                                <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                                            </form>
                                                            <a href="#" onclick="document.getElementsByClassName('acs-form')[2].submit();"><i class="fa fa-trash"></i></a>
                                                        </div>

                                                        <a href="javascript:void(0);" class="qview">Edit</a>

                                                <?php

                                                    } else{
                                                ?>
                                                        <a href="view-post?ui=<?php echo base64_encode(($fetch['uid'] * 137) + 387); ?>&pid=<?php echo $fetch['pid']; ?>">View</a>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                                <?php
                                                    if($fetch['uid'] != $uid){
                                                        $donateBtn = "donate?ui=".base64_encode(($fetch['uid'] * 137) + 387)."&pid=".$fetch['pid'];
                                                        $donateStyle = '';
                                                    } else{
                                                        $donateBtn = 'javascript:void(0);';
                                                        $donateStyle = 'style="color: #ff0000;"';
                                                    }
                                                ?>
                                            <div class="right pfm"><a href="<?php echo $donateBtn; ?>" <?php echo $donateStyle; ?>>Donate</a></div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="post-progress">
                                            <?php
                                                $ta = $fetch['ta'] / 100;
                                                $ca = $fetch['ca'] / $ta;

                                                if($uid == $fetch['uid'] || $fetchLevel['level'] == 1){
                                                    $taShow = 'TA: '.$fetch['ta'].' BDT | ';
                                                    $caShow = 'CA: '.$fetch['ca'].' BDT';
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

                            if($countPagination > $numPerPage){
                        ?>

                                <div class="show-more" id="show-more">

                                    <?php
                                        $total = ceil($countPagination / $numPerPage);
                                        $adjacents = 2;
                                        $second_last = $total - 1;

                                        if($page > 1){
                                            echo '<a href="?page='.($page - 1).'">Previous</a>';
                                        }

                                        if ($total <= 10){
                                            for($i = 1; $i <= $total; $i++){
                                                if($i == $page){
                                                    echo '<strong>'.$i.'</strong>';
                                                } else{
                                                    echo '<a href="?page='.$i.'">'.$i.'</a>';
                                                }
                                            }
                                        }

                                        if ($total > 10){
                                            if($page <= 4){
                                                for($i = 1; $i < 8; $i++){
                                                    if($i == $page){
                                                        echo '<strong>'.$i.'</strong>';
                                                    } else{
                                                        echo '<a href="?page='.$i.'">'.$i.'</a>';
                                                    }
                                                }

                                                echo '<span>...</span>';
                                                echo '<a href="?page='.$second_last.'">'.$second_last.'</a>';
                                                echo '<a href="?page='.$total.'">'.$total.'</a>';
                                            } else{
                                                if($page > 4 && $page < $total - 4){
                                                    echo '<a href="?page=1">1</a>';
                                                    echo '<a href="?page=2">2</a>';
                                                    echo '<span>...</span>';

                                                    for($i = $page - 1; $i <= $page + $adjacents; $i++){
                                                        if ($i == $page){
                                                            echo '<strong>'.$i.'</strong>';
                                                        } else{
                                                            echo '<a href="?page='.$i.'">'.$i.'</a>';
                                                        }
                                                    }

                                                    echo '<span>...</span>';
                                                    echo '<a href="?page='.$second_last.'">'.$second_last.'</a>';
                                                    echo '<a href="?page='.$total.'">'.$total.'</a>';
                                                } else{
                                                    echo '<a href="?page=1">1</a>';
                                                    echo '<a href="?page=2">2</a>';
                                                    echo '<span>...</span>';

                                                    for($i = $total - 6; $i <= $total; $i++){
                                                        if ($i == $page){
                                                            echo '<strong>'.$i.'</strong>';
                                                        } else{
                                                            echo '<a href="?page='.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if($i > ($page + 1)){
                                            echo '<a href="?page='.($page + 1).'">Next</a>';
                                        }

                                        if($page < $total){
                                            echo '<a href="?page='.$total.'">Last &rsaquo; &rsaquo;</a>';
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

        $link = urlencode($fullUrl);
        header('location: ../login?src='.$link);
    }