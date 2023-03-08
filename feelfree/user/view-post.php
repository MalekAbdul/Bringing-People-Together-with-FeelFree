<?php
    session_start();
    require_once '../site.php';
    $title = 'View post';

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
                                <?php
                                if($fetch['uid'] != $uid){
                                    $donateBtn = "donate?ui=".base64_encode(($fetch['uid'] * 137) + 387)."&pid=".$fetch['pid'];
                                    $donateStyle = '';
                                } else{
                                    $donateBtn = 'javascript:void(0);';
                                    $donateStyle = 'style="color: #ff0000;"';
                                }
                                ?>
                                <a href="<?php echo $donateBtn; ?>" <?php echo $donateStyle; ?>>Donate</a>
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