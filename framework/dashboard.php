<?php

function vc_show_edit_profile()
{
    ob_start();
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID; ?>

	<div class="wrapp_edit_profile_info">
		<h5>Edit Account</h5>
		<form method="POST" action="" class="edit_profile">
			<div class="row">
				<div class="col_50 input_block">
					<label>First Name</label>
					<input type="text" name="firstname" value="<?php echo $current_user->user_firstname; ?>" required="">
				</div>
				<div class="col_50 input_block">
					<label>Last Name</label>
					<input type="text" name="lastname" value="<?php echo $current_user->user_lastname; ?>" required="">
				</div>
			</div>
			<?php /*
            <div class="row">
                <div class="col_100 input_block">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $current_user->user_email; ?>" required="">
                </div>
            </div>*/?>
			<div class="row">
				<div class="col_50 input_block">
					<label>Company Name</label>
					<input type="text" name="company" value="<?php echo get_field('company', 'user_' . $user_id); ?>">
				</div>
				<div class="col_50 input_block">
					<label>Postion</label>
					<input type="text" name="position" value="<?php echo get_field('postion', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_50 input_block">
					<label>Phone</label>
					<input type="tel" name="phone" value="<?php echo get_field('phone', 'user_' . $user_id); ?>">
				</div>
				<div class="col_50 input_block">
					<label>Mobile</label>
					<input type="tel" name="mobile" value="<?php echo get_field('mobile', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Fax</label>
					<input type="tel" name="fax" value="<?php echo get_field('fax', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_50 input_block">
					<label>Country</label>
					<select class="gds-cr" country-data-region-id="gds-cr-one" data-language="en" name="country" country-data-default-value="<?php echo get_field('country', 'user_' . $user_id); ?>"></select>
				</div>
				<div class="col_50 input_block">
					<label>State</label>
					<select id="gds-cr-one" name="state" region-data-default-value="<?php echo get_field('state', 'user_' . $user_id); ?>"></select>
				</div>
			</div>
			<div class="row">
				<div class="col_50 input_block">
					<label>City</label>
					<input type="text" name="city" value="<?php echo get_field('city', 'user_' . $user_id); ?>">
				</div>
				<div class="col_50 input_block">
					<label>Postcode</label>
					<input type="text" name="zipcode" value="<?php echo get_field('zipcode', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Address</label>
					<input type="text" name="address1" value="<?php echo get_field('address', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Newsletter Subscriber</label>
					<select name="newsletter_subscriber">
						<option value="yes" <?php  if (get_field('newsletter_subscriber', 'user_' . $user_id) == "yes") {
        echo 'selected';
    } ?> >Yes</option>
						<option value="no" <?php  if (get_field('newsletter_subscriber', 'user_' . $user_id) == "no") {
        echo 'selected';
    } ?> >No</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<div class="submit-form">
						<i class="icon icon-loading"></i>
						<input type="hidden" name="edit-account" value="<?php echo wp_create_nonce('edit-account'); ?>">
						<input type="submit" name="" value="Submit">
					</div>
					<p class="status"></p>
					<input type="hidden" name="action" value="vc_edit_profile">
				</div>
			</div>
		</form>
	</div>

	<?php
    $content = ob_get_clean();
    return $content;
}

function vc_show_password_change()
{
    ob_start();
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID; ?>
	<div class="wrapp_edit_profile_info">
		<h5>Change Password</h5>
		<form method="POST" action="" class="change_password">
			<div class="row">
				<div class="col_100 input_block">
					<label>New Password</label>
					<div class="relative">
						<input type="password" name="new_password" value="" id="new_password">
						<span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Repeat New Password</label>
					<div class="relative">
						<input type="password" name="new_password2" value="" id="new_password2">
						<span toggle="#new_password2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col_100 input_block">
					<div class="submit-form">
						<i class="icon icon-loading"></i>
						<input type="hidden" name="change-password" value="<?php echo wp_create_nonce('change-password'); ?>">
						<input type="submit" name="" value="Submit">
					</div>
					<p class="status"></p>
					<input type="hidden" name="action" value="vc_change_password">
				</div>
			</div>
		</form>
	</div>

	<?php
    $content = ob_get_clean();
    return $content;
}

function vc_edit_social()
{
    ob_start();
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID; ?>

	<div class="wrapp_edit_profile_social">
		<h5>Social Profile</h5>
		<form method="POST" action="" class="social_profile">
			<div class="row">
				<div class="col_100 input_block">
					<label>Facebook</label>
					<input type="url" name="facebook" value="<?php echo get_field('facebook', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Foursquare</label>
					<input type="url" name="foursquare" value="<?php echo get_field('foursquare', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Instagram</label>
					<input type="url" name="instagram" value="<?php echo get_field('instagram', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>LinkedIn</label>
					<input type="url" name="linkedin" value="<?php echo get_field('linkedin', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Skype</label>
					<input type="text" name="skype" value="<?php echo get_field('skype', 'user_' . $user_id); ?>">
				</div>
			</div>
			<div class="row">
				<div class="col_100 input_block">
					<label>Twitter</label>
					<input type="url" name="twitter" value="<?php echo get_field('twitter', 'user_' . $user_id); ?>">
				</div>
			</div>

			<div class="row">
				<div class="col_100 input_block">
					<div class="submit-form">
						<i class="icon icon-loading"></i>
						<input type="submit" name="" value="Submit">
						<input type="hidden" name="edit-social" value="<?php echo wp_create_nonce('edit-social'); ?>">
					</div>
					<p class="status"></p>
					<input type="hidden" name="action" value="vc_edit_social_user">
				</div>
			</div>

		</form>
	</div>

	<?php
    $content = ob_get_clean();
    return $content;
}

// edit social user info
function vc_edit_social_user()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    if (isset($_POST['edit-social']) && wp_verify_nonce($_POST['edit-social'], 'edit-social') == 1) {
        $data = array();
        foreach ($_POST as $key => $value) {
            $social_name = $key;
            if (!empty($social_name) && !empty($value)) {
                // update fields
                update_field($social_name, $value, 'user_'. $user_id);
                $data_social[$social_name]['value'] = $value;
                $data[$social_name] = $value;
            }
        }

        // update profile on mautic
        $contactApi = vc_mautic_connection_contacts();
        $id   = get_field('mautic_user_id', 'user_' . $user_id);
        $createIfNotFound = false;
        $contact = $contactApi->edit($id, $data, $createIfNotFound);
    }



    if (!empty($contact['errors'])) {
        $content = "<span class='success'>Your social profile was updated successfully.</span>";
    } else {
        $content = "<span class='error'>Some problems were found when updating the profile. Please try again later.</span>";
    }
    echo json_encode(array('message' => $content));
    die();
}
add_action('wp_ajax_vc_edit_social_user', 'vc_edit_social_user');
add_action('wp_ajax_nopriv_vc_edit_social_user', 'vc_edit_social_user');

// edit profile user
function vc_edit_profile()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $user_email = $current_user->email;
    $updated = false;

    if (isset($_POST['edit-account']) && wp_verify_nonce($_POST['edit-account'], 'edit-account') == 1) {
        $data = array();
        foreach ($_POST as $key => $value) {
            $social_name = $key;
            if (!empty($social_name) && !empty($value) && $key != "edit-account" && $key != "action") {
                // update fields

                switch ($value) {
                    case 'United States of America':
                    case 'United States Minor Outlying Islands':
                        $value = "United States"; break;
                    case 'Aland Islands': $value = "Åland Islands"; break;
                    case 'United Kingdom of Great Britain and Northern Ireland': $value = "United Kingdom"; break;
                    case 'American Samoa':
                    case 'British Indian Ocean Territory':
                    case 'Christmas Island':
                    case 'Cocos (Keeling) Islands':
                    case 'Cote D\'ivoire':
                    case 'Curacao':
                    case 'Faroe Islands':
                    case 'French Southern Territories':
                    case 'Isle of Man':
                    case 'Korea (the Democratic People\'s Republic of)':
                    case 'Korea (the Republic of)':
                    case 'Eswatini':
                    case 'Norfolk Island':
                    case 'Sint Maarten (Dutch Part)':
                    case 'Timor-Leste':
                            $value = ''; break;
                    case 'Bolivia (Plurinational State of)': $value = 'Bolivia'; break;
                    case 'Brunei Darussalam': $value = 'Brunei'; break;
                    case 'Cabo Verde': $value = "Cape Verde"; break;
                    case 'Czechia': $value = "Czech Republic"; break;
                    case 'Congo':
                    case 'Congo (the Democratic Republic of the)':
                        $value = "Democratic Republic of the Congo"; break;
                    case 'Falkland Islands (Malvinas)': $value = "Falkland Islands"; break;
                    case 'Iran (Islamic Republic of)': $value = "Iran"; break;
                    case 'Lao People\'s Democratic Republic': $value = "Laos"; break;
                    case 'Micronesia (Federated States of)': $value = "Micronesia"; break;
                    case 'Moldova (the Republic of)': $value = "Moldova"; break;
                    case 'Palestine, State of': $value = "Palestine"; break;
                    case 'Reunion': $value = "Réunion"; break;
                    case 'Russian Federation': $value = "Russia"; break;
                    case 'Syrian Arab Republic': $value = "Syria"; break;
                    case 'Taiwan (Province of China)': $value = "Taiwan"; break;
                    case 'Tanzania, United Republic of': $value = "Tanzania"; break;
                    case 'Venezuela (Bolivarian Republic of)': $value = "Venezuela"; break;
                    case 'Viet Nam': $value = "Vietnam"; break;
                    default: break;
                }

                update_field($social_name, $value, 'user_'. $user_id);
                $data_social[$social_name]['value'] = $value;
                $data[$social_name] = $value;
            }
        }

        wp_update_user(array('ID' => $user_id, 'user_email' => esc_attr($user_email), 'user_login' => esc_attr($user_email) )) ;

        $contactApi = vc_mautic_connection_contacts();
        $id   = get_field('mautic_user_id', 'user_' . $user_id);
        $createIfNotFound = false;
        $contact = $contactApi->edit($id, $data, $createIfNotFound);

        // update profile based on company field
        $email_domain 		= explode('@', $user_email);
        $json 				= get_field('mautic_domain_names_full_copy', 'options');
        $json_group 		= get_field('mautic_domain_names_copy', 'options');
        $array_companies 	= json_decode($json, true);
        $array_companies_group = json_decode($json_group, true);

        if (in_array($email_domain[1], $array_companies) == true) {
            // create account on mautic
            $company_name  = vc_search_company_by_domain($array_companies_group, $email_domain[1]);

            if (strcmp($_POST['company'], $company_name) ==  0) {
                // updagrade account on mautic
                $data = array();
                $data['member'] = "yes";
                $data['company'] = $company_name;
                $contact = $contactApi->edit($id, $data, $createIfNotFound);

                update_field('field_5ed7912f53507', $company_name, 'user_' . $user_id);  // company name
                update_field('field_5ee86fdc8dde3', 'yes', 'user_'. $user_id);  // member

                $updated = true;
            }
        } else {
            $data = array();
            $data['member'] = "no";
            $contact = $contactApi->edit($id, $data, $createIfNotFound);
            update_field('field_5ee86fdc8dde3', 'no', 'user_'. $user_id);  // member
        }


        if (empty($contact['errors'])) {
            $content = "<span class='success'>Your profile was updated successfully.</span>";
        } else {
            $content = "<span class='error'>Some problems were found when updating the profile. Please try again later.</span>";
        }
    }


    echo json_encode(array('message' => $content));
    die();
}
add_action('wp_ajax_vc_edit_profile', 'vc_edit_profile');
add_action('wp_ajax_nopriv_vc_edit_profile', 'vc_edit_profile');



// edit profile as admin
add_action('profile_update', 'my_profile_update', 10, 2);
function my_profile_update($user_id)
{
    if (current_user_can('edit_user', $user_id)) {
        $user_data = array();
        $user_data['company'] = get_field('company', 'user_'. $user_id);
        $user_data['position'] = get_field('position', 'user_'. $user_id);
        $user_data['phone'] = get_field('phone', 'user_'. $user_id);
        $user_data['mobile'] = get_field('mobile', 'user_'. $user_id);
        $user_data['country'] = get_field('country', 'user_'. $user_id);
        $user_data['state'] = get_field('state', 'user_'. $user_id);
        $user_data['city'] = get_field('city', 'user_'. $user_id);
        $user_data['zipcode'] = get_field('zipcode', 'user_'. $user_id);
        $user_data['address1'] = get_field('address1', 'user_'. $user_id);
        $user_data['facebook'] = get_field('facebook', 'user_'. $user_id);
        $user_data['foursquare'] = get_field('foursquare', 'user_'. $user_id);
        $user_data['instagram'] = get_field('instagram', 'user_'. $user_id);
        $user_data['linkedin'] = get_field('linkedin', 'user_'. $user_id);
        $user_data['skype'] = get_field('skype', 'user_'. $user_id);
        $user_data['twitter'] = get_field('twitter', 'user_'. $user_id);

        $m = get_field('member_account', 'user_'. $user_id);
        if(empty($m)) {
          $user_data['member'] = "no";
        } else {
          $user_data['member'] = "yes";
        }

        $ns = get_field('newsletter_subscriber', 'user_'. $user_id);
        if(empty($ns)) {
          $user_data['newsletter_subscriber'] = "no";
        } else {
          $user_data['newsletter_subscriber'] = "yes";
        }

        $user_info = get_user_by('id', $user_id);

        $user_data['first_name'] = $user_info->first_name ;
        $user_data['last_name'] =  $user_info->last_name;

        $contactApi = vc_mautic_connection_contacts();
        $id   = get_field('mautic_user_id', 'user_' . $user_id);
        $createIfNotFound = false;
        $contact = $contactApi->edit($id, $user_data, $createIfNotFound);
    }
}


// change user password
function vc_change_password()
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    if (isset($_POST['change-password']) && wp_verify_nonce($_POST['change-password'], 'change-password') == 1) {
        if (isset($_POST['new_password']) && strlen($_POST['new_password']) >= 10) {
            if (strcmp($_POST['new_password'], $_POST['new_password2']) == 0) {

                // update the user passwords
                // wp_set_password( $_POST['new_password'], $user_id );
                wp_update_user(array('ID' => $user_id, 'user_pass' => $_POST['new_password']));
                $content = "<span class='success'>The password was successfully updated.</span>";
            } else {
                $content = "<span class='error'>The passwords must be the same.</span>";
            }
        } else {
            $content = "<span class='error'>The password must be longer than 10 characters.</span>";
        }
    }

    echo json_encode(array('message' => $content));
    die();
}
add_action('wp_ajax_vc_change_password', 'vc_change_password');
add_action('wp_ajax_nopriv_vc_change_password', 'vc_change_password');
