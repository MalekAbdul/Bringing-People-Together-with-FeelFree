<?php
    session_start();
    require_once 'site.php';
    $title = 'Page Not Found';
?>

<!doctype html>
<html lang="en">
    <?php require_once 'site_head.php'; ?>
    <body>
        <section class="pnf">
            <div class="container">
                <div class="pnf-content">
                    <h3>Page Not Found</h3>
                    <small>Our apologies, but we could not find that page. If you entered the URL by hand, double check that it is correct or contact our support.</small>
                </div>
            </div>
        </section>

        <?php require_once 'site_body.php'; ?>
    </body>
</html>

<?php
    echo '<script>
               setTimeout(function(){
                   window.location.href = "'.$site_url.'login";
               }, 30000);
        </script>';
?>