<?php
    session_start();
    require_once '../site.php';
    $title = 'All member';

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
?>

        <!doctype html>
        <html lang="en">
            <?php require_once '../site_head.php'; ?>
            <body>
                <?php require_once 'header.php'; ?>

                <?php
                    if(isset($_SESSION['reject_success'])){
                        echo '<script type="text/javascript">Swal.fire({
                                    icon: "success",
                                    title: "Reject successful!",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>';

                        unset($_SESSION['reject_success']);
                    } elseif(isset($_SESSION['reject_fail'])){
                        echo '<script type="text/javascript">Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Reject unsuccessful!",
                            })
                        </script>';

                        unset($_SESSION['reject_fail']);
                    }
                ?>

                <section class="ml-area">
                    <div class="container">
                        <?php
                            if(isset($_GET['search'])){
                                $search = $_GET['search'];
                                $searchValue = $_GET['search'];
                                $searchPag = 'search='.$_GET['search'].'&';
                            } else{
                                $search = '';
                                $searchValue = '';
                                $searchPag = '';
                            }
                        ?>

                        <div class="form-container">
                            <form class="formSearch" action="" method="get">
                                <input type="text" name="search" value="<?php echo $searchValue; ?>" placeholder="Type any name..." required>
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <form class="formReset" action="" method="post">
                                <button name="reset" type="submit">Reset</button>
                            </form>
                        </div>

                        <?php
                            if(isset($_POST['reset'])){
                                $link = $fullUrl;

                                if(isset($_GET['page'])){
                                    $link = str_replace('search='.$search.'&','', $link);
                                } else{
                                    $link = str_replace('?search='.$search,'', $link);
                                }

                                header('location: '.$link);
                            }

                            $stmtPagination = "select * from users where status = 1 and name like '%$search%'";
                            $resultPagination = mysqli_query($conn, $stmtPagination);
                            $countPagination = mysqli_num_rows($resultPagination);

                            $stmt = "select * from users where status = 1 and name like '%$search%' order by uid desc limit $startFrom, $numPerPage";
                            $result = mysqli_query($conn, $stmt);
                            $count = mysqli_num_rows($result);

                            if($count >= 1){
                                for($i = 1; $i <= $count; $i++){
                                    $fetch = mysqli_fetch_array($result);
                        ?>

                                    <div class="ml-box">
                                        <?php
                                            if($fetchLevel['level'] == 1){
                                        ?>
                                                <form class="acs-form" action="../cnnction/all_query.php" method="post">
                                                    <input name="reject_ml" type="text" value="reject_ml" hidden>
                                                    <input name="ui" type="text" value="<?php echo $fetch['uid']; ?>" hidden>
                                                    <input name="link" type="text" value="<?php echo $fullUrl; ?>" hidden>
                                                </form>
                                                <a href="#" onclick="document.getElementsByClassName('acs-form')[0].submit();"><i class="fa fa-ban"></i></a>
                                        <?php
                                            }
                                        ?>
                                        <h4><a href="profile?ui=<?php echo base64_encode(($fetch['uid'] * 137) + 387); ?>"><?php echo $fetch['name']; ?></a></h4>
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
                                            echo '<a href="?'.$searchPag.'page='.($page - 1).'">Previous</a>';
                                        }

                                        if ($total <= 10){
                                            for($i = 1; $i <= $total; $i++){
                                                if($i == $page){
                                                    echo '<strong>'.$i.'</strong>';
                                                } else{
                                                    echo '<a href="?'.$searchPag.'page='.$i.'">'.$i.'</a>';
                                                }
                                            }
                                        }

                                        if ($total > 10){
                                            if($page <= 4){
                                                for($i = 1; $i < 8; $i++){
                                                    if($i == $page){
                                                        echo '<strong>'.$i.'</strong>';
                                                    } else{
                                                        echo '<a href="?'.$searchPag.'page='.$i.'">'.$i.'</a>';
                                                    }
                                                }

                                                echo '<span>...</span>';
                                                echo '<a href="?'.$searchPag.'page='.$second_last.'">'.$second_last.'</a>';
                                                echo '<a href="?'.$searchPag.'page='.$total.'">'.$total.'</a>';
                                            } else{
                                                if($page > 4 && $page < $total - 4){
                                                    echo '<a href="?'.$searchPag.'page=1">1</a>';
                                                    echo '<a href="?'.$searchPag.'page=2">2</a>';
                                                    echo '<span>...</span>';

                                                    for($i = $page - 1; $i <= $page + $adjacents; $i++){
                                                        if ($i == $page){
                                                            echo '<strong>'.$i.'</strong>';
                                                        } else{
                                                            echo '<a href="?'.$searchPag.'page='.$i.'">'.$i.'</a>';
                                                        }
                                                    }

                                                    echo '<span>...</span>';
                                                    echo '<a href="?'.$searchPag.'page='.$second_last.'">'.$second_last.'</a>';
                                                    echo '<a href="?'.$searchPag.'page='.$total.'">'.$total.'</a>';
                                                } else{
                                                    echo '<a href="?'.$searchPag.'page=1">1</a>';
                                                    echo '<a href="?'.$searchPag.'page=2">2</a>';
                                                    echo '<span>...</span>';

                                                    for($i = $total - 6; $i <= $total; $i++){
                                                        if ($i == $page){
                                                            echo '<strong>'.$i.'</strong>';
                                                        } else{
                                                            echo '<a href="?'.$searchPag.'page='.$i.'">'.$i.'</a>';
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if($i > ($page + 1)){
                                            echo '<a href="?'.$searchPag.'page='.($page + 1).'">Next</a>';
                                        }

                                        if($page < $total){
                                            echo '<a href="?'.$searchPag.'page='.$total.'">Last &rsaquo; &rsaquo;</a>';
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