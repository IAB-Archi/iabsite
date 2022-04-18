<?php 
/**
 * Template Name: Member Registration Page Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header();

$main_id = get_the_ID(); ?>

<div class="page page-article">
    <div class="container">
        <?php   echo vc_show_top_slider(); ?>
        <?php   echo vc_show_breadcrumb(); ?>
        
        <div class="container">
            <div class="title">
                <h1><?php echo get_the_title(); ?></h1>
            </div>
        </div>
        <div class="container">
            <article class="long">
                <div class="general-content">
                    <?php if (have_posts()) : while (have_posts()) : the_post();?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>

                   
                    <div class="mb-reg box_form_mautic">
                        <form action="" method="POST" enctype="multipart/form-data" class="regster_members" id="reg_members">
                            <div class="input_block">
                                <input class="reg_members_text" type="text" value="" name="firstname" id="firstname" placeholder="First Name *" required="required">
                            </div>
                            <div class="input_block">
                                <input class="reg_members_text" type="text" value="" name="surname" id="surname" placeholder="Surname *"  required="required">
                            </div>
                            <div class="input_block">
                                <input class="reg_members_text" type="text" value="" name="emailaddress" id="emailaddress" placeholder="Email Address *"  required="required">
                            </div>
                            <?php /*<div class="input_block">
                                <input type="password" value="" name="password" id="password" placeholder="Password *"  required="required">
                            </div>
                            <div class="input_block">
                                <input type="password" value="" name="passwordrepeat" id="passwordrepeat" placeholder="Repeat password *"  required="required">
                            </div> */?>
                            <div class="input_block">
                                <input class="reg_members_text" type="text" value="" name="userprofileposition" id="userprofileposition" placeholder="Position" required="required">
                            </div>

                            <div class="input_block">
                            <?php
                            $companies = array_keys(
                                json_decode(
                                    get_field('mautic_domain_names_copy', 'options'),
                                    true
                                )
                            );
                            sort($companies);

                            $dropdown = array(
                                '<select name="usercompany" id="usercompany" required="required">',
                                '<option value="">Select a Company *</option>'
                            );
                            foreach($companies as $name) {
                                array_push($dropdown, '<option value="' . $name . '">' . $name . '</option>');
                            }
                            array_push($dropdown, '</select>');

                            echo(implode($dropdown));
                            ?>
			    </div>

			    <div class="input_block checkbox" style="font-size: 0.8em">
				Can't see your company listed? Click <a href="https://iabaustralia.com.au/membership-inquiry/">here</a> to submit a membership enquiry.
			    </div>


                            <div class="input_block">
                                <input class="reg_members_text" type="tel" value="" size="20" name="userprofilemobile" id="userprofilemobile" placeholder="Mobile">
                            </div>
                            <div class="input_block checkbox">
                                <input type="checkbox" name="newsletters" id="Newsletters0"  class="rsform-checkbox">
                                <label for="Newsletters0">Subscribe to our Newsletter</label>
                            </div>
                            <div class="input_block submit-form">
                                <i class="icon icon-loading black"></i>
                                <input type="hidden" value="<?php echo wp_create_nonce('submit_form_members'); ?>" name="submit_form_members">
                                <input type="hidden" value="vc_create_member" name="action">
                                <input type="submit" name="form[submit]" id="submit" class="btn btn-primary rsform-submit-button" value="Submit">
                            </div>

                             <p class="status"></p>
                        </form>
                    </div>
             
                </div>
            </article>
        </div>
       
    </div> 
</div>

<?php get_footer(); ?>

<script>
  $(function() {
    var $select = $('#usercompany');
    if ($select) {
        $select.css('color', '#bfbfbf');
        $select.on('change', function(e) {
            const value = e.target.value;
            if (value) {
                $select.css('color', '#999');
            } else {
                $select.css('color', '#bfbfbf');
            }
        })
    }
})

</script>

