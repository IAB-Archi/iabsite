<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); ?>
     <input type="hidden" name="current_link" value="<?php 
        global $wp;
        $current_url = home_url(add_query_arg(array(),$wp->request));
        echo  $current_url;  ?>" id="current_link">   
    <?php wp_footer(); ?>
</body>
</html>