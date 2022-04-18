<?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); ?>

<div class="page page-article">
    <div class="container">
        <div class="container-small">
        	<article class="long">
        		<div class="general-content">
	        		<?php 	$content_page_404 = get_field('content_page_404', 'options');
	        				if(!empty($content_page_404)) {
	        					echo $content_page_404; 
	        				} ?>
				</div>
        	</article>
        </div>
    </div> 
</div>

<?php get_footer(); ?>