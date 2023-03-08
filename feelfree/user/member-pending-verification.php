<?php
    session_start();
    require_once '../site.php';
    $title = 'Member pending verification';

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

        if($fetchLevel['level'] != 1){
            header('location: verification');
        }
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['ver_accept_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "success",
                                    title: "Verification accept successful!",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>';

                        unset($_SESSION['ver_accept_success']);
                    } elseif(isset($_SESSION['ver_delete_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "success",
                                    title: "Verification delete successful!",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>';

                        unset($_SESSION['ver_delete_success']);
                    }
                ?>

                <section class="mpv-area">
                    <div class="container">

                        <?php
                            $stmtPagination = "select * from verification where status = 0";
                            $resultPagination = mysqli_query($conn, $stmtPagination);
                            $countPagination = mysqli_num_rows($resultPagination);

                            $stmt = "select verification.*, users.* from verification, users where verification.uid = users.uid and verification.status = 0 order by verification.vid desc limit $startFrom, $numPerPage";
                            $result = mysqli_query($conn, $stmt);
                            $count = mysqli_num_rows($result);

                            if($count >= 1){
                                for($i = 1; $i <= $count; $i++){
                                    $fetch = mysqli_fetch_array($result);
                        ?>

                                    <div class="mpv-box">
                                        <h4><a href="view-member-pending-verification?ui=<?php echo base64_encode(($fetch['uid'] * 137) + 387); ?>&vid=<?php echo $fetch['vid']; ?>"><?php echo $fetch['name']; ?></a></h4>
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