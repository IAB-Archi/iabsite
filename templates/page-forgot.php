<?php 
/**
 * Template Name: Forgot Template
 */

defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 

if( is_user_logged_in()) {
	// redirect dashboard
	$dashboard_page = get_field('dashboard_page', 'options');
	header("Location: " . $dashboard_page);
	exit();
} 
get_header(); ?>

<div class="page page-article page-forgot">
    <div class="container">
		<div class="container-small">
           	<div class="title">
			    <h1><?php echo get_the_title(); ?></h1>
			</div>
        </div>
        <div class="container-small">
    		<div class="general-content">
    			<?php  if(!is_user_logged_in()) {  ?>
	        		<?php  if(isset($_GET['key'])) { 
	        					$user_email = decrypt($_GET['key']); // var_dump($user_email );
	        					if(!empty($user_email)) { 
 									$rand = rand(50, 15000); ?>

	        						<div class="reset_password">
		        						<h5>Reset the password for <u><?php echo $user_email; ?></u></h5>
		        						<p class="small">Please pick a password with a minimum of 9 characters</p>
		        						<form method="POST" action="" class="reset_password_form">
		        							<p class="status"></p>
		        							<div class="input_block">
		        								<input type="password" id="password-login-<?php echo  $rand; ?>" name="password" required placeholder="New Password" class="password1" autocomplete="current-password">
		        								<span toggle="#password-login-<?php echo  $rand; ?>" class="fa fa-fw fa-eye field-icon toggle-password"></span>
		        							</div>
		        							<div class="input_block">
		        								<input type="password" id="password-login-<?php echo  $rand; ?>" name="password2" required placeholder="Repeat new password" class="password2" autocomplete="new-password">
		        								<span toggle="#password-login-<?php echo  $rand; ?>" class="fa fa-fw fa-eye field-icon toggle-password"></span>
		        							</div>
		        							<div class="input_block submit-form">
                								<i class="icon icon-loading"></i>
                								<input type="hidden" name="key" value="<?php echo $_GET['key']; ?>" class="hidden_key">
		                						<input type="submit" value="Reset Password" class="button"  />
	                						</div>

		        						</form>
		        					</div>
	        		<?php		} ?>

	        		<?php  } else { ?>

	        			<div class="login wrapp-login forgot-form">
				            <?php echo vc_show_forgot_password(); ?>
				        </div>

	        		<?php  } ?>
        		<?php  } ?>
			</div>
        </div>
    </div> 
</div>

<?php get_footer(); ?>