<?php
    session_start();
    require_once '../site.php';
    $title = 'Pending';

    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];

        if(isset($_GET['page'])){
            $page = $_GET['page'];
        } else{
            $page = 1;
        }

        $numPerPage = 15;
        $startFrom = ($page-1)*$numPerPage;

        require_once '../db/connection.php';

        $stmtLevel = "select level from users where uid = '$uid'";
        $resultLevel = mysqli_query($conn, $stmtLevel);
        $fetchLevel = mysqli_fetch_array($resultLevel);

        if($fetchLevel['level'] == 1){
            header('location: member-pending');
        }
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <section class="post-area">
                    <div class="container">

                        <?php
                            $stmtPagination = "select * from posts where uid = '$uid' and status = 0";
                            $resultPagination = mysqli_query($conn, $stmtPagination);
                            $countPagination = mysqli_num_rows($resultPagination);

                            $stmt = "select posts.*, users.* from posts, users where posts.uid = users.uid and posts.uid = '$uid' and posts.status = 0 order by posts.pid desc limit $startFrom, $numPerPage";
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
                                                <?php
                                                    $viewDonateBtn = 'javascript:void(0);';
                                                    $viewDonateStyle = 'style="color: #ff0000;"';
                                                ?>
                                            <div class="left pfm"><a href="<?php echo $viewDonateBtn; ?>" <?php echo $viewDonateStyle; ?>>View</a></div>
                                            <div class="right pfm"><a href="<?php echo $viewDonateBtn; ?>" <?php echo $viewDonateStyle; ?>>Donate</a></div>
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