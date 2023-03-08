<?php
    require_once 'site.php';
?>

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- LightBox JS -->
<script src="<?php echo $site_url; ?>js/lightbox.js" type="text/javascript"></script>
<!-- JS -->
<script src="<?php echo $site_url; ?>js/login_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/reg_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/fgtpass_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/cpost_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/epost_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/donate_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/profile_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/eprofile_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/settings_validation.js" type="text/javascript"></script>
<script src="<?php echo $site_url; ?>js/verification_validation.js" type="text/javascript"></script>
<script type="text/javascript">
    /* Top Error */
    $(document).ready(function(){
        $('#cross').click(function(){
            $('#top-error').hide();
        });
    });

    /* Quick View Menu */
    $(document).ready(function(){
        $('.qview').mouseover(function(){
            $('.qview-menu').slideToggle();
        });
    });

    /* "a" tag as a submit button */
    /*
    document.getElementById('acs').onclick = function(){
        document.getElementById('acs-form').submit();
    }
    */
</script>