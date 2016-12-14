<?php 


$tt_custom_form_css = '';

function ttshowcase_custom_css_footer() {

		global $tt_custom_form_css;

		$custom_css = cmshowcase_get_option('custom_css','ttshowcase_advanced_settings','');
		$custom_js = cmshowcase_get_option('custom_js','ttshowcase_advanced_settings','');

		$css = '';
		$js = '';

		if($tt_custom_form_css=='') {

			if($custom_css!='') {

				$css .= '<!-- Custom Styles for Testimonials Showcase Forms -->';
				    $css .= '<style type="text/css">';
				    $css .= $custom_css;
				    $css .= '</style>';

			}



			if($custom_js!='') {

				$js .= '<!-- Custom Script for Testimonials Showcase Forms -->';
				    $js .= '<script type="text/javascript">';
				    $js .= $custom_js;
				    $js .= '</script>';

			}

			$css .= $js;

			$tt_custom_form_css = $css;
			echo $css;	

		}
		
	}

//Fix to add the redirect - not so clean, all form processing needs improving
add_action('init','ttshowcase_submit_form');

function ttshowcase_submit_form() {

	/*if(!session_id()) {
    session_start();
    }

   	$_SESSION['ttform_submit'] = false;
	*/

	
	if(isset($_POST['tt_submitted'])) {

		$tt_force_redirect = cmshowcase_get_boolean(cmshowcase_get_option('force_redirect', 'ttshowcase_front_form', 'off'));
		$tt_confirmation_url = cmshowcase_get_option('thankyou_url', 'ttshowcase_front_form', '');

		if($tt_confirmation_url!='' || $tt_force_redirect == true) {

			ob_start();

		}

	} 
	

}


function ttshowcase_build_form($atts,$post = false) {


	if(!isset($_POST) && $post != false) {
		$_POST = $post;
	}

	//print_r($_POST);

	$tt_image;

	$section = 'ttshowcase_front_form';
	$form_html = '<a name="ttform"></a>';

	

	$tt_label_name = cmshowcase_get_option('name_label', $section, 'Name');

	$tt_label_subtitle = cmshowcase_get_option('subtitle_label', $section, 'Position');
	$tt_label_url = cmshowcase_get_option('url_label', $section, 'URL');
	$tt_label_testimonial = cmshowcase_get_option('testimonial_label', $section, 'Testimonial');
	$tt_label_long_testimonial = cmshowcase_get_option('long_testimonial_label', $section, 'Long Testimonial');;
	$tt_label_rating = cmshowcase_get_option('rating_label', $section, 'Rating');
	$tt_label_email = cmshowcase_get_option('email_label', $section, 'Email');
	$tt_confirmation_text = cmshowcase_get_option('thankyou', $section, 'Thank you for submitting your message!');
	$tt_confirmation_url = cmshowcase_get_option('thankyou_url', $section, '');
	$tt_error_text = cmshowcase_get_option('error', $section, 'The testimonial was not submitted. Check the form for errors.');
	$tt_confirmation_email_on = cmshowcase_get_option('sendemail', $section, 'on');
	$tt_human_verification_logged = cmshowcase_get_option('human_verification_logged', $section, 'on');
	$tt_confirmation_email = cmshowcase_get_option('email_to', $section, get_option( 'admin_email' ));
	$tt_email_subject = cmshowcase_get_option('email_subject', $section, 'New Testimonial for Review');
	$tt_email_body = cmshowcase_get_option('email_message', $section, 'New Testimonial entry from: {title}. <br /> <a href="{admin_url}">Approve or Delete Entry</a>');
	$tt_submit_label = cmshowcase_get_option('submit_label', $section, 'Submit');
	$tt_review_title_label = cmshowcase_get_option('review_title_label', $section, 'Testimonial Title');
	$tt_image_label = cmshowcase_get_option('image_label',$section,'Your Image');
	$tt_star_label_singular = cmshowcase_get_option('star_singular',$section,'Star');
	$tt_star_label_plural = cmshowcase_get_option('star_plural',$section,'Stars');
	$tt_verification_label = cmshowcase_get_option('verification',$section,'Are you Human?');
	$tt_category_label = cmshowcase_get_option('category_label',$section,'Category');
	$tt_post_status = cmshowcase_get_option('status',$section,'pending');
	$tt_boolean_label = cmshowcase_get_option('custom_boolean_label',$section,'Yes or No?');
	$tt_force_redirect = cmshowcase_get_boolean(cmshowcase_get_option('force_redirect', $section, 'off'));
	$tt_ajax = cmshowcase_get_boolean(cmshowcase_get_option('ajax', $section, 'off'));
	$tt_initial_rating = cmshowcase_get_option('default_rating', $section, '5');
	$tt_human_verification_logged = cmshowcase_get_boolean($tt_human_verification_logged);
	$tt_honeypot = cmshowcase_get_boolean(cmshowcase_get_option('honeypot_spam', $section, 'off'));
	$tt_fields_order = cmshowcase_get_option('order', $section, 'name,subtitle,url,image,title,testimonial,longtestimonial,rating,email,yesOrNo,humanVerification');
	$tt_mandatory = cmshowcase_get_option('mandatory', $section, 'name,email,url,subtitle,title,testimonial,rating,image');


	//Akismet Integration
	$tt_akismet = cmshowcase_get_boolean(cmshowcase_get_option('akismet', $section, 'off'));
	
	if(defined('AKISMET_VERSION')) {

		if($tt_akismet) {

			require_once dirname(__FILE__) . '/Akismet.class.php';
			if(null !== get_option('wordpress_api_key')) {
				$akismet = new tt_Akismet(get_site_url(), get_option('wordpress_api_key'));
				if($akismet->isKeyValid()) {
					
					

				 } else {
				 	echo '<!-- Invalid Akismet API Key -->';
				 }
			}
			

		}

	}

	

	if($tt_ajax) {

		wp_deregister_script( 'ttshowcase-submit-validation' );
		wp_register_script( 'ttshowcase-submit-validation', plugins_url( 'js/jquery.validation.js', __FILE__ ),array('jquery'),false,false);
		wp_enqueue_script( 'ttshowcase-submit-validation' );

		wp_localize_script( 'ttshowcase-submit-validation', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );


	}



	$tt_loggedonly_text = cmshowcase_get_option('loggedonly', $section, 'You need to be a registred user to submit entries');

	$custom_css_load = cmshowcase_get_boolean(cmshowcase_get_option('load_css_form','ttshowcase_advanced_settings','off'));
	if($custom_css_load) {
		add_action('wp_footer', 'ttshowcase_custom_css_footer');
	}

	$subtitle_on = isset($atts['subtitle']) && $atts['subtitle'] == 'on' ? true : false;
	$subtitle_url_on = isset($atts['subtitle_url']) && $atts['subtitle_url'] == 'on' ? true : false;
	$rating_on = isset($atts['rating']) ? $atts['rating'] : false;
	$r_title_on = isset($atts['review_title']) && $atts['review_title'] == 'on' ? true : false;
	$email_on = isset($atts['email']) && $atts['email'] == 'on' ? true : false;
	$long_testimonial_on = isset($atts['long_testimonial']) && $atts['long_testimonial'] == 'on' ? true : false;
	$verification = isset($atts['verification']) ? $atts['verification'] : false;
	$logged_on = isset($atts['logged']) && $atts['logged'] == 'on' ? true : false;
	$logged_only = isset($atts['logged_only']) && $atts['logged_only'] == 'on' ? true : false;
	$taxonomy_on = isset($atts['taxonomy']) ? true : false;
	$image_on = isset($atts['image']) && $atts['image'] == 'on' ? true : false;
	$style = isset($atts['style']) ? $atts['style'] : 'tt_simple';
	$category = isset($atts['display_category']) && $atts['display_category'] == 'on' ? true : false;
	$boolean_field = isset($atts['boolean']) ? $atts['boolean'] : false;

	$hasError = false;


	//PROCESS ALL STRINGS TO BE TRANSLATED
	//Process all strings for translation
	$tt_label_name = __($tt_label_name,'ttshowcase');
	$tt_label_subtitle = __($tt_label_subtitle,'ttshowcase');
	$tt_label_url = __($tt_label_url,'ttshowcase');
	$tt_label_testimonial = __($tt_label_testimonial,'ttshowcase');
	$tt_long_label_testimonial = __($tt_label_long_testimonial,'ttshowcase');
	$tt_label_rating = __($tt_label_rating,'ttshowcase');
	$tt_label_email = __($tt_label_email,'ttshowcase');
	$tt_confirmation_text = __($tt_confirmation_text,'ttshowcase');
	$tt_error_text = __($tt_error_text,'ttshowcase');
	$tt_submit_label = __($tt_submit_label,'ttshowcase');
	$tt_review_title_label = __($tt_review_title_label,'ttshowcase');
	$tt_image_label = __($tt_image_label,'ttshowcase');
	$tt_star_label_singular = __($tt_star_label_singular,'ttshowcase');
	$tt_star_label_plural = __($tt_star_label_plural,'ttshowcase');
	$tt_verification_label = __($tt_verification_label,'ttshowcase');
	$tt_category_label = __($tt_category_label,'ttshowcase');
	$tt_loggedonly_text = __($tt_loggedonly_text,'ttshowcase');




	if(isset($_POST['tt_submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		//make field mandatory
		//possible options in array: name, email, url, subtitle, title, testimonial, rating, image
	
		$tt_mandatory = str_replace(' ', '', $tt_mandatory);
		$mandatory = explode(',',$tt_mandatory);

		//$mandatory = array('name', 'email', 'url', 'subtitle', 'title', 'testimonial', 'rating', 'image' );



		//ERROR HANDLING

		//honeypot spam prevention
		if($tt_honeypot) {
			if(isset($_POST['tt_hp_email_mandatory']) && $_POST['tt_hp_email_mandatory'] != '') {
				$hasError = true;
				$tt_error_text .= '<p>'.__(' Not human maybe? Try reloading the page and fill out the form manually','ttshowcase').'</p>';
			}
		}


		if($verification) {

			if((!is_user_logged_in()) || (is_user_logged_in() && $tt_human_verification_logged)) {

				if(!isset($_POST['hverification']) || !isset($_POST['hval']) || md5(strtoupper($_POST['hverification'])) != $_POST['hval']) {
					$hasError = true;
					$verificationerror = __(' Please insert the correct answer','ttshowcase');
				}
			}
		}

		//check if author/title has a value

		if(in_array('name',$mandatory) && isset($_POST['postTitle']) && trim($_POST['postTitle']) === '') {
			$posttitleerror = __(' Please enter a valid name','ttshowcase');
			$hasError = true;
		} 

		else {
			$postTitle = trim($_POST['postTitle']);
		}


		//make testimonials text mandatory
		
		if(in_array('testimonial',$mandatory) && isset($_POST['_aditional_info_short_testimonial']) && trim($_POST['_aditional_info_short_testimonial']) === '') {
			$testimonialerror = __(' Please enter a valid testimonial','ttshowcase');
			$hasError = true;
		} 

		if(in_array('long_testimonial',$mandatory) && isset($_POST['_aditional_info_long_testimonial']) && trim($_POST['_aditional_info_long_testimonial']) === '') {
			$longtestimonialerror = __(' Please enter a valid testimonial','ttshowcase');
			$hasError = true;
		} 


		if(in_array('email',$mandatory) && $email_on && ((trim($_POST['_aditional_info_email']) === '') || !cmshowcase_check_email($_POST['_aditional_info_email']) ) ) {
			$emailerror = __(' Please enter a valid email','ttshowcase');
			$hasError = true;
		}


		//make images mandatory
		
		if($image_on && in_array('image',$mandatory) && !file_exists($_FILES['featured_image']['tmp_name'])) {

			$imageerror = __(' Please include an image','ttshowcase');
			$hasError = true;

		}
		

		//make testimonial title mandatory
		if(in_array('testimonial_title',$mandatory) && isset($_POST['_aditional_info_review_title']) && trim($_POST['_aditional_info_review_title']) === '') {
			$testimonialtitleerror = __(' This field cannot be empty','ttshowcase');
			$hasError = true;
		} 


		//make subtitle mandatory
		if(in_array('subtitle',$mandatory) && isset($_POST['_aditional_info_name']) && trim($_POST['_aditional_info_name']) === '') {
			$aditionalinfoerror = __(' This field cannot be empty','ttshowcase');
			$hasError = true;
		} 


		//make URL mandatory
		if(in_array('url',$mandatory) && isset($_POST['_aditional_info_url']) && trim($_POST['_aditional_info_url']) === '') {
			$urlerror = __(' This field cannot be empty','ttshowcase');
			$hasError = true;
		} 


		//make rating mandatory
		if(in_array('rating',$mandatory) && $rating_on != false && !isset($_POST['_aditional_info_rating']) ) {
			$ratingerror = __(' Please select a rating','ttshowcase');
			$hasError = true;
		}

		//make boolean Yes/No mandatory - yes should be selected
		if(in_array('yes_or_no',$mandatory) && $boolean_field != false && !isset($_POST['_aditional_info_custom_boolean']) ) {
			$booleanerror = __(' Please review this option','ttshowcase');
			$hasError = true;
		}
		


		$post_information = array(
			'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
			'post_type' => 'ttshowcase',
			'post_status' => $tt_post_status,
			//'post_name'  => 
		);

		if(isset($_POST['_aditional_info_long_testimonial'])) {
			$post_information['post_content'] = esc_attr($_POST['_aditional_info_long_testimonial']);
		}

			if(!$hasError) {

				//check if it was already submitted with

				$post_id = wp_insert_post($post_information);

				if($post_id)
				{

					//add featured image
					if($image_on && isset($_FILES)) {

						require_once (ABSPATH.'/wp-admin/includes/media.php');
						require_once (ABSPATH.'/wp-admin/includes/file.php');
						require_once (ABSPATH.'/wp-admin/includes/image.php');
						$attachmentId = media_handle_upload('featured_image', $post_id);
						set_post_thumbnail($post_id, $attachmentId);

						unset($_FILES);
					    if ( is_wp_error($attachmentId) ) {
					        $errors['upload_error'] = $attachmentId;
					        $id = false;
					    }

					    if (isset($errors)) {
					        //image not uploaded
					    } 

					}

					//add category
					if(isset($_POST['tt_taxonomy'])) {

						$cat_entry = trim($_POST['tt_taxonomy']);

						//if is the taxonomy dropdown, the ids will be sent so we need to convert them to intengers
						if(is_numeric($cat_entry)) {

							$cat_entry = intval($cat_entry);

						}

						if($_POST['tt_taxonomy']=='{current_page_slug}') {
							$slug = basename(get_permalink());

							//for taxonomies - still needs to be reviewed
							//$slug = basename("http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]);

							$cat_entry = $slug;
						}

						if($_POST['tt_taxonomy']=='{current_page_id}') {

							//in this case we create the category first, so it's easier to identify
							$new_taxonomy = get_term_by('slug', $_POST['tt_page_id'], 'ttshowcase_groups');

							//if it doesn't exist, we create the entry first
							if(!$new_taxonomy) {

								$new_t_title = get_the_title($_POST['tt_page_id']);
								$new_t_slug = $_POST['tt_page_id'];

								wp_insert_term(
								  $new_t_title, // the term 
								  'ttshowcase_groups', // the taxonomy
								  array(
								    'slug' => $new_t_slug,
								    'description' => get_permalink()
								  )
								);
							}
							

							$cat_entry = $_POST['tt_page_id'];
							
						}

						wp_set_object_terms($post_id,$cat_entry,'ttshowcase_groups');

					}


					//Code to add custom taxonomies

					//first we check if there's any custom taxonomy
					
					global $ttshowcase_options;
					if(count($ttshowcase_options['taxonomies'])>1) {

						foreach ($ttshowcase_options['taxonomies'] as $identifier => $data) {
							
							if($identifier=='groups') {
								continue;
							}

							if(isset($data['force_form']) && $data['force_form'] && taxonomy_exists('ttshowcase_'.$identifier) && isset($_POST['ttshowcase_'.$identifier])) {
								wp_set_object_terms($post_id,intval($_POST['ttshowcase_'.$identifier]),'ttshowcase_'.$identifier);
							}
						}
					}
					

					// Update Custom Meta
					if(isset($_POST['_aditional_info_name'])) {
					update_post_meta($post_id, '_aditional_info_name', esc_attr(strip_tags($_POST['_aditional_info_name'])));
					}
					if(isset($_POST['_aditional_info_url'])) {
					update_post_meta($post_id, '_aditional_info_url', esc_attr(strip_tags($_POST['_aditional_info_url'])));
					}
					if(isset($_POST['_aditional_info_email'])) {
					update_post_meta($post_id, '_aditional_info_email', esc_attr(strip_tags($_POST['_aditional_info_email'])));
					}
					if(isset($_POST['_aditional_info_review_title'])) {
					update_post_meta($post_id, '_aditional_info_review_title', esc_attr(strip_tags($_POST['_aditional_info_review_title'])));
					}
					if(isset($_POST['_aditional_info_short_testimonial'])) {
					update_post_meta($post_id, '_aditional_info_short_testimonial', esc_attr(strip_tags($_POST['_aditional_info_short_testimonial'])));
					}
					if(isset($_POST['_aditional_info_rating'])) {	
					update_post_meta($post_id, '_aditional_info_rating', esc_attr(strip_tags($_POST['_aditional_info_rating'])));
					}
					if(isset($_POST['_aditional_info_custom_boolean'])) {	
					update_post_meta($post_id, '_aditional_info_custom_boolean', esc_attr(strip_tags($_POST['_aditional_info_custom_boolean'])));
					}
					if(!isset($_POST['_aditional_info_custom_boolean'])) {	
					update_post_meta($post_id, '_aditional_info_custom_boolean', 'false');
					}


					//Filter the submission with Akismet before sending notification email
					$send_email = true;

					if(defined('AKISMET_VERSION')) {

						if($tt_akismet) {

							require_once dirname(__FILE__) . '/Akismet.class.php';
							if(null !== get_option('wordpress_api_key')) {
								$akismet = new tt_Akismet(get_site_url(), get_option('wordpress_api_key'));
								if($akismet->isKeyValid()) {

									 $akismet->setCommentAuthor($_POST['postTitle']);

									 if(isset($_POST['_aditional_info_email'])) {
									 $akismet->setCommentAuthorEmail($_POST['_aditional_info_email']);
									 }
									 if(isset($_POST['_aditional_info_url'])) {
									 	$akismet->setCommentAuthorURL($_POST['_aditional_info_url']);
									 }
									 if(isset($_POST['_aditional_info_short_testimonial'])) {
									 	$akismet->setCommentContent($_POST['_aditional_info_short_testimonial']);
									 }
									 $akismet->setPermalink(get_permalink($post_id));
								
									if($akismet->isCommentSpam()) {

										$send_email = false;
										wp_update_post(array(
								        'ID'    =>  $post_id,
								        'post_status'   =>  'trash',
								        'post_title' => '[SPAM?] '.$_POST['postTitle']
								        ));
									}	
								} 
							}
						}
					}



					//Send Email
					if($tt_confirmation_email_on=='on' && $send_email) {

						$url = admin_url( 'post.php?post='.$post_id.'&action=edit');
						$title = $postTitle;
						$text = sanitize_text_field($_POST['_aditional_info_short_testimonial']);
						$rating = isset($_POST['_aditional_info_rating']) ? sanitize_text_field($_POST['_aditional_info_rating']) : '';
						$boolean = isset($_POST['_aditional_info_custom_boolean']) ? sanitize_text_field($_POST['_aditional_info_custom_boolean']) : '';
						$taxonomy = '';
						$email = isset($_POST['_aditional_info_email']) ? sanitize_text_field($_POST['_aditional_info_email']) : '';
						$taxs = get_post_taxonomies( $post_id );
						foreach ($taxs as $key => $value) {

							$tax = get_taxonomy( $value );


							$term_list = wp_get_post_terms($post_id, $value, array("fields" => "names"));
							//print_r($term_list);
							$current = '';
							foreach ($term_list as $tkey => $tvalue) {
								if($current!=$value) {
									$taxonomy .= $tax->labels->name.': '.$tvalue;
									$current = $value;
								} else {
									$taxonomy .= ', '.$tvalue;
								}
								
							}

							$taxonomy .= '<br>';

						}
	
						//template tags
						/*
						{title} - Name of entry author
						{admin_url} - Link to the edit and approval page for this entry
						{text} - Entry submitted text
						{rating} - Rating for this entry
						{boolean} - Yes/No field
						{email} - Email
						{taxonomy} - Categories
						*/

						$template_search = array('{title}','{admin_url}','{text}','{rating}','{boolean}','{taxonomy}','{email}');
						$template_replace = array($title,$url,$text,$rating,$boolean,$taxonomy,$email);

						$message_subject = str_replace($template_search,$template_replace, $tt_email_subject);
						$message_body = str_replace($template_search,$template_replace, $tt_email_body);
						
						$headers[] = 'Content-type: text/html';
						$send_email = wp_mail( $tt_confirmation_email, $message_subject, nl2br($message_body) ,$headers);
					

					}

					if($send_email) {
						//email was sent
					}

					// Redirect

					if($tt_confirmation_url!='') {

						wp_redirect( $tt_confirmation_url ); exit;
						

					} else {


						if($tt_force_redirect) {

							global $wp;
							$current_url = home_url(add_query_arg(array( 'ttform' => 'success#ttform'),$wp->request));
							wp_redirect( $current_url ); exit;


						} else {

							$form_html .= '<div class="ttshowcase_confirmation">'.do_shortcode($tt_confirmation_text).'</div>';

						}
					}
				}
			}

	} 

	if(isset($_GET['ttform'])) {

		$form_html .= '<div class="ttshowcase_confirmation">'.do_shortcode($tt_confirmation_text).'</div>';

	}


	if(!isset($_POST['tt_submitted']) || (isset($_POST['tt_submitted']) && $hasError)) { 

		$html_array = array();
		

		if($logged_on) {

			 if(is_user_logged_in()) {
	        	
	        	$current_user = wp_get_current_user();

	      	} else {

	      		$logged_on = false;

	      	}

		}

		$form_type = '';

		if($image_on) {

			$form_type = 'enctype="multipart/form-data"';

		}

			
		$form_html .= '
			<!-- #primary BEGIN -->
			
			<div class="ttshowcase_form_wrap">';

				
				if($hasError) { 
					$form_html .= '<div class="ttshowcase_form_error">';
					$form_html .= do_shortcode($tt_error_text); 
					$form_html .= '</div>';
				}


			$tt_action = 'action="#ttform" method="POST"';

			if($tt_ajax) {

				$tt_action = 'onsubmit="tt_ajax_form(); return false;"';

			}

					$form_html .= '

					<form '.$tt_action.' id="ttshowcase_form" class="'.$style.'" '.$form_type.'>';


				


				if(!$logged_on) { 

					
					$name_form_html = '';

					$name_form_html .= '<fieldset>

						<label for="postTitle">'.$tt_label_name.'</label>

						<input type="text" name="postTitle" id="postTitle" value="';
						if(isset($_POST['postTitle'])) { $name_form_html .= $_POST['postTitle']; } 
						$name_form_html .= '" class="required" />';

						if ( isset($posttitleerror) && $posttitleerror != '' ) { 
							$name_form_html .= '<span class="error">'.$posttitleerror.'</span>
							    <div class="clearfix"></div>';
						}

					$name_form_html .= '</fieldset>';
					$html_array['name'] = $name_form_html;


				} if($logged_on) { 

					$name_form_html = '';
					$name_form_html .= '

					<fieldset>

					<label for="postTitle">'.$tt_label_name.'</label>

					<input type="text" name="postTitle" id="postTitle" value="'.$current_user->display_name.'" class="required" readonly />

					</fieldset>';

					$html_array['name'] = $name_form_html;


				}

				if($subtitle_on) { 

					$subtitle_form_html = '';
					$subtitle_form_html .= '<fieldset>

						<label for="_aditional_info_name">'.$tt_label_subtitle.'</label>

						<input type="text" name="_aditional_info_name" id="_aditional_info_name" value="';
						
						if(isset($_POST['_aditional_info_name'])) { $subtitle_form_html .=  $_POST['_aditional_info_name']; } 
						
						$subtitle_form_html .= '" />';

						if ( isset($aditionalinfoerror) && $aditionalinfoerror != '' ) { 
							    $subtitle_form_html .= '<span class="error">'.$aditionalinfoerror.'
							    <div class="clearfix"></div>';
						}

						$subtitle_form_html .= '</fieldset>';

						$html_array['subtitle'] = $subtitle_form_html;


					

					/*

					Custom Made Drop Down 

					$form_html .= '<fieldset>

						<label for="_aditional_info_name">'.$tt_label_subtitle.'</label>
						<select class="regular" name="_aditional_info_name" id="_aditional_info_name">';

							
						$tt_curr_selected = isset($_POST['_aditional_info_name']) ? $_POST['_aditional_info_name'] : null;
							

						$form_html .= '<option value="Selling" '. selected($tt_curr_selected, 'Selling' , false).' >Selling</option>';
						$form_html .= '<option value="Purchasing" '. selected($tt_curr_selected, 'Selling' , false).' >Purchasing</option>';
						$form_html .= '<option value="Staging" '. selected($tt_curr_selected, 'Staging' , false).' >Staging</option>';
						
						$form_html .= '</select>

					</fieldset>
					

					';*/

				}

				if($subtitle_url_on) { 

					$url_form_html = '';
					$url_form_html .= '

					<fieldset>

						<label for="_aditional_info_url">'.$tt_label_url.'</label>

						<input type="text" name="_aditional_info_url" id="_aditional_info_url" value="';
						if(isset($_POST['_aditional_info_url'])) { $url_form_html .=  $_POST['_aditional_info_url']; } 
						$url_form_html .= '" />';

						if ( isset($urlerror) && $urlerror != '' ) { 
							    $url_form_html .= '<span class="error">'.$urlerror.'
							    <div class="clearfix"></div>';
						}

					$url_form_html .= '</fieldset>';

					$html_array['url'] = $url_form_html;

				}

				if($image_on) { 

					$image_form_html = '';
					$image_form_html .= '

					<fieldset>

						<label for="featured_image">'.$tt_image_label.'</label>
						<input type="file" name="featured_image" id="featured_image"';
						if(isset($_POST['featured_image'])) $image_form_html .=  ' value="'.$_POST['featured_image'].'"';
						$image_form_html .= '/>';

						if ( isset($imageerror) && $imageerror != '' ) { 
							    $image_form_html .= '<div class="clearfix"></div><span class="error">'.$imageerror.'
							    </span><div class="clearfix"></div>';
						}

					$image_form_html .='</fieldset>';

						$html_array['image'] = $image_form_html;
						//$html_array['image'] = '<fieldset><div style="display:inline-block; width:26%;">Votre Photo</div><label class="fusion-button button-flat button-pill button-small button-default button-41 btn-file">   Parcourir   <input name="featured_image" id="featured_image" type="file" style="display:none;"> </label></fieldset>';

				}


				if($r_title_on) { 

					$title_form_html = '';
					$title_form_html .= '

					<fieldset>

						<label for="_aditional_info_review_title">'.$tt_review_title_label.'</label>
						<input type="text" name="_aditional_info_review_title" id="_aditional_info_review_title" value="';
						if(isset($_POST['_aditional_info_review_title'])) $title_form_html .=  $_POST['_aditional_info_review_title'];
						$title_form_html .= '" />';

						if ( isset($testimonialtitleerror ) && $testimonialtitleerror  != '' ) { 
							    $title_form_html .= '<span class="error">'.$testimonialtitleerror.'
							    </span><div class="clearfix"></div>';
						}

						$title_form_html .= '</fieldset>';
						$html_array['testimonialTitle'] = $title_form_html;
					

				}

				

				if($rating_on == 'on') { 

					$rating_form_html = '';
					$rating_form_html .= '<fieldset>

						<label for="_aditional_info_rating">'.$tt_label_rating.'</label>
						<select class="regular" name="_aditional_info_rating" id="_aditional_info_rating">';

							
							$tt_curr_selected = isset($_POST['_aditional_info_rating']) ? $_POST['_aditional_info_rating'] : $tt_initial_rating;
							

						$rating_form_html .= '<option value="5" '. selected($tt_curr_selected, 5 , false).' >5 '.$tt_star_label_plural.'</option>';
						$rating_form_html .= '<option value="4" '. selected($tt_curr_selected, 4 , false).' >4 '.$tt_star_label_plural.'</option>';
						$rating_form_html .= '<option value="3" '. selected($tt_curr_selected, 3 , false).' >3 '.$tt_star_label_plural.'</option>';
						$rating_form_html .= '<option value="2" '. selected($tt_curr_selected, 2 , false).' >2 '.$tt_star_label_plural.'</option>';
						$rating_form_html .= '<option value="1" '. selected($tt_curr_selected, 1 , false).' >1 '.$tt_star_label_singular.'</option>';
						
						$rating_form_html .= '</select>

					</fieldset>
					

					';

					$html_array['rating'] = $rating_form_html;

				

				}


				if($rating_on == 'hover') {

					$rating_form_html = '';

					wp_register_style( 'tthoverrating', plugins_url( 'hover-rating.css', __FILE__ ) );
					wp_enqueue_style( 'tthoverrating' );
					wp_register_style( 'tt-font-awesome', plugins_url( 'resources/font-awesome/css/font-awesome.min.css', dirname(__FILE__) ) );
					wp_enqueue_style( 'tt-font-awesome' );

					$tt_curr_selected = isset($_POST['_aditional_info_rating']) ? $_POST['_aditional_info_rating'] : $tt_initial_rating;

					$rating_form_html .= '
					<fieldset>
					<label for="_aditional_info_rating">'.$tt_label_rating.'</label>

					
					<div class="tt_rating">
					    <input type="radio" '.checked( $tt_curr_selected, 5, false ).' name="_aditional_info_rating" id="_aditional_info_rating_5" value="5" /><label for="_aditional_info_rating_5" title="5 '.$tt_star_label_plural.'"><i class="fa fa-star"></i></label>
					    <input type="radio" '.checked( $tt_curr_selected, 4, false ).' name="_aditional_info_rating" id="_aditional_info_rating_4" value="4" /><label for="_aditional_info_rating_4" title="4 '.$tt_star_label_plural.'"><i class="fa fa-star"></i></label>
					    <input type="radio" '.checked( $tt_curr_selected, 3, false ).' name="_aditional_info_rating" id="_aditional_info_rating_3" value="3" /><label for="_aditional_info_rating_3" title="3 '.$tt_star_label_plural.'"><i class="fa fa-star"></i></label>
					    <input type="radio" '.checked( $tt_curr_selected, 2, false ).' name="_aditional_info_rating" id="_aditional_info_rating_2" value="2" /><label for="_aditional_info_rating_2" title="2 '.$tt_star_label_plural.'"><i class="fa fa-star"></i></label>
					    <input type="radio" '.checked( $tt_curr_selected, 1, false ).' name="_aditional_info_rating" id="_aditional_info_rating_1" value="1" /><label for="_aditional_info_rating_1" title="1 '.$tt_star_label_singular.'"><i class="fa fa-star"></i></label>
					</div>';

					

					$rating_form_html .= '</fieldset>';

					if ( isset($ratingerror ) && $ratingerror  != '' ) { 
							    $rating_form_html .= '<span class="error">'.$ratingerror.'
							    </span><div class="clearfix"></div>';
						}

					$html_array['rating'] = $rating_form_html;

				}

				$testimonial_form_html = '';
				$testimonial_form_html .= '


				<fieldset>
							
					<label for="_aditional_info_short_testimonial">'.$tt_label_testimonial.'</label>

					<textarea name="_aditional_info_short_testimonial" id="_aditional_info_short_testimonial" rows="8" cols="30">';

						if(isset($_POST['_aditional_info_short_testimonial'])) { 
							if(function_exists('stripslashes')) { 
								$testimonial_form_html .= stripslashes($_POST['_aditional_info_short_testimonial']); 
							} 
							else { 
								$testimonial_form_html .= $_POST['_aditional_info_short_testimonial'];
							} 
						} 
						
						$testimonial_form_html .='</textarea>';

						if ( isset($testimonialerror) && $testimonialerror != '' ) { 
							$testimonial_form_html .= '<span class="error">'.$testimonialerror.'</span>
							    <div class="clearfix"></div>';
						}

				$testimonial_form_html .='</fieldset>';

				$html_array['testimonial'] = $testimonial_form_html;



				if($long_testimonial_on) {

					$long_testimonial_form_html = '';
					$long_testimonial_form_html .= '


				<fieldset>
							
					<label for="_aditional_info_long_testimonial">'.$tt_label_long_testimonial.'</label>

					<textarea name="_aditional_info_long_testimonial" id="_aditional_info_long_testimonial" rows="8" cols="30">';

						if(isset($_POST['_aditional_info_long_testimonial'])) { 
							if(function_exists('stripslashes')) { 
								$long_testimonial_form_html .= stripslashes($_POST['_aditional_info_long_testimonial']); 
							} 
							else { 
								$long_testimonial_form_html .= $_POST['_aditional_info_long_testimonial'];
							} 
						} 
						
						$long_testimonial_form_html .='</textarea>';

						if ( isset($longtestimonialerror) && $longtestimonialerror != '' ) { 
							$long_testimonial_form_html .= '<span class="error">'.$longtestimonialerror.'</span>
							    <div class="clearfix"></div>';
						}

				$long_testimonial_form_html .='</fieldset>';

				$html_array['longTestimonial'] = $long_testimonial_form_html;


				}

				

				if($email_on && !$logged_on) { 

					$email_form_html = '';

					$email_form_html .= '

					<fieldset>

						<label for="_aditional_info_email">'.$tt_label_email.'</label>

						<input type="text" name="_aditional_info_email" id="_aditional_info_email" value="';
						
						if(isset($_POST['_aditional_info_email'])) { $email_form_html .= $_POST['_aditional_info_email']; } 
						$email_form_html .= '" />';

						if ( isset($emailerror) && $emailerror != '' ) { 
							    $email_form_html .= '<span class="error">'.$emailerror.'
							    <div class="clearfix"></div>';
						}

						$email_form_html .= '

					</fieldset>';

					$html_array['email'] = $email_form_html;

				}

				if($email_on && $logged_on) { 

				
					$email_form_html = '';
					$email_form_html .= '
					<fieldset>

						<label for="_aditional_info_email">'.$tt_label_email.'</label>

						<input type="text" name="_aditional_info_email" id="_aditional_info_email" value="'.$current_user->user_email.'" readonly />

					</fieldset>';

					$html_array['email'] = $email_form_html;

				}

				if($tt_honeypot) {
					$form_html .= '<input name="tt_hp_email_mandatory" type="email" id="tt_hp_email_mandatory" value="" />';
				}


				if($boolean_field == 'on') {
					global $ttshowcase_options;
					$bool_opt = $ttshowcase_options['meta_boxes']['aditional_info']['fields']['custom_boolean']['options'];

					$yesno_form_html = '';

					$yesno_form_html .= '<fieldset>

						<label for="_aditional_info_custom_boolean">'.$tt_boolean_label.'</label>
						<select class="regular" name="_aditional_info_custom_boolean" id="_aditional_info_custom_boolean">';

							
						$tt_curr_selected = isset($_POST['_aditional_info_custom_boolean']) ? $_POST['_aditional_info_custom_boolean'] : null;
						
						foreach ($bool_opt as $key => $value) {

								$yesno_form_html .= '<option value="'.$key.'" '. selected($tt_curr_selected, $key , false).' >'.__($value,'ttshowcase').'</option>';
								
							}	

						
						$yesno_form_html .= '</select>';

						if ( isset($booleanerror) && $booleanerror != '' ) { 
							$yesno_form_html .= '<span class="error">'.$booleanerror.'</span>
							    <div class="clearfix"></div>';
						}

					$yesno_form_html .= '</fieldset>
					

					';

					$html_array['yesOrNo'] = $yesno_form_html;

				}

				//boolean checkbox
				if($boolean_field == 'checkbox') {

					global $ttshowcase_options;
					$bool_opt = $ttshowcase_options['meta_boxes']['aditional_info']['fields']['custom_boolean']['options'];

					$yesno_form_html = '';

					$yesno_form_html .= '<fieldset>';

							
						$tt_curr_selected = isset($_POST['_aditional_info_custom_boolean']) ? 'checked' : '';
						
						$yesno_form_html .= '<input type="checkbox" value="true" name="_aditional_info_custom_boolean" id="_aditional_info_custom_boolean" '.$tt_curr_selected.'>';

						
						$yesno_form_html .= '<label style="width:100%;" for="_aditional_info_custom_boolean">'.$tt_boolean_label.'</label>';


						if ( isset($booleanerror) && $booleanerror != '' ) { 
							$yesno_form_html .= '<span class="error">'.$booleanerror.'</span>
							    <div class="clearfix"></div>';
						}

						$yesno_form_html .='</fieldset>';

					$html_array['yesOrNo'] = $yesno_form_html;

				}

				
				if($verification == 'on') {

					if( !is_user_logged_in() || ( is_user_logged_in() && ($tt_human_verification_logged || is_admin() ) ) ) {

						$one = rand(50, 90);
						$two = rand(1, 9);
						$result = md5($one + $two);

						$verification_form_html = '';

						$verification_form_html .= '
						<fieldset>

							<label for="hverification">'.$tt_verification_label.'</label>

							'.$one.' + '.$two.' = <input type="text" style="width:30px;" name="hverification" id="hverification" value="" />
							<input type="hidden" name="hval" id="hval" value="'.$result.'" />';


							if (isset($verificationerror) && $verificationerror != '' ) { 
								$verification_form_html .= '<div class="clearfix"></div><span class="error">'.$verificationerror.'</span>
								    <div class="clearfix"></div>';
						}

						$verification_form_html .= '</fieldset>';

						

						$html_array['humanVerification'] = $verification_form_html;

					}


				 } 

				  if($verification == 'captcha') {

					if( !is_user_logged_in() || ( is_user_logged_in() && ($tt_human_verification_logged || is_admin() ) ) ) {

					 	$one = rand(50, 90);
						$two = rand(1, 9);
						$result = md5($one + $two);

					 	$image_key = tt_create_image($result);
					 	$word = $image_key['word'];
					 	$image_ash = $image_key['image'];

					 	$img_url = "data:image/png;base64,".$image_ash;

					 	$verification_form_html = '';
					 	$verification_form_html .= '

						<fieldset>

							<label for="captcha">'.$tt_verification_label.'</label>

					 	<input type="text" class="tt_cap_input" name="hverification" id="hverification" value="" />
					 	<img class="tt_capimg" src="'.$img_url.'"> 
					 	<input type="hidden" name="hval" id="hval" value="'.$word.'" />
					 	</fieldset>';

					 	if ( isset($verificationerror) && $verificationerror != '' ) { 
								$verification_form_html .= '<span class="error">'.$verificationerror.'</span>
								    <div class="clearfix"></div>';
							}

						$html_array['humanVerification'] = $verification_form_html;

					}

				 }


				

				if($category) {

					$category_form_html = '';
				 	$category_form_html .= '<fieldset>
				 	<label for="tt_taxonomy">'.$tt_category_label.'</label>
				 	';

				 	$args = array(
				 		'echo' => false,
				 		'taxonomy' => 'ttshowcase_groups',
				 		'hide_empty' => false,
				 		'name' => 'tt_taxonomy',
				 		'id' => 'tt_taxonomy',
				 		'orderby' => 'SLUG',
				 		'order' => 'ASC'
				 		);

				 	if($taxonomy_on){
				 		$tax_id = get_term_by('slug', $atts['taxonomy'], 'ttshowcase_groups');
				 		
				 		if($tax_id){
				 			$args['selected'] = $tax_id->term_id;
				 		}
				 		
				 	}


				 	$dropdown = wp_dropdown_categories( $args );

					$category_form_html .= $dropdown;
					$category_form_html .= '</fieldset>';

					$html_array['category'] = $category_form_html;

				}

				//CUSTOM TAXONOMY FETCHING
				global $ttshowcase_options;
				if(count($ttshowcase_options['taxonomies'])>1) {

					$html_array['customTax'] = '';
					$custom_tax_form_html = '';

					foreach ($ttshowcase_options['taxonomies'] as $identifier => $data) {
						
						if($identifier=='groups') {
							continue;
						}

						if(isset($data['force_form']) && $data['force_form'] && taxonomy_exists('ttshowcase_'.$identifier)) {

							$tax = get_taxonomy('ttshowcase_'.$identifier); 

						 	$custom_tax_form_html .= '<fieldset>
						 	<label for="tt_custom_taxonomy">'.$tax->labels->name.'</label>
						 	';

						 	$args = array(
						 		'echo' => false,
						 		'taxonomy' => 'ttshowcase_'.$identifier,
						 		'hide_empty' => false,
						 		'name' => 'ttshowcase_'.$identifier,
						 		'id' => 'ttshowcase_'.$identifier,
						 		'orderby' => 'NAME',
						 		'order' => 'ASC'
						 		);

						 	$dropdown = wp_dropdown_categories( $args );

							$custom_tax_form_html .= $dropdown;
							$custom_tax_form_html .= '</fieldset>';

							

						}

					}

					$html_array['customTax'] .= $custom_tax_form_html;

				}



				//To order the fields

				$field_order = explode(',',$tt_fields_order);
				

				foreach ($field_order as $field_key) {
					if(isset($html_array[$field_key])) {
						$form_html .= $html_array[$field_key];
					}
				}

				//$form_html .= print_r(explode(',',$tt_fields_order));

				/*global $ts_content_order;
				foreach ($ts_content_order as $info) {
					if(isset($info_array[$info])) {
					$html.=$info_array[$info];
					}
				}
				*/


				//$form_html .= '<fieldset>';
				
				$form_html .= wp_nonce_field('post_nonce', 'post_nonce_field',true,false); 

				//get the post id
				$this_post = get_post();
				if(is_object($this_post)) {
					$current_page_id = $this_post->ID;
				} else {
					$current_page_id = 'null';
				}
				

				$form_html .= '<input type="hidden" name="tt_page_id" id="tt_page_id" value="'.$current_page_id.'" />';
				
				if($taxonomy_on && !$category) {
				$form_html .= '<input id="tt_taxonomy" name="tt_taxonomy" type="hidden" value="'.$atts['taxonomy'].'">';
				}
				
				$form_html .= '<input type="hidden" name="tt_atts" id="tt_atts" value="'.base64_encode(json_encode($atts)).'">';
				$form_html .= '<input type="hidden" name="tt_submitted" id="tt_submitted" value="true" />';
				$form_html .= '<button type="submit" class="tt_form_button">'.$tt_submit_label.'</button>';

				//$form_html .= '</fieldset>';

			$form_html .= '</form>';

		$form_html .= '</div><!-- #primary END -->';

		if($logged_only) {

			if ( ! is_user_logged_in() ) { 

				$form_html = $tt_loggedonly_text;

			}

		} 


	} 

	/* Temp fix for swipeTouch issue. Uncomment if needed */

	// $form_html .= '<script>jQuery(document).ready(function(){jQuery("#ttshowcase_form input").click(function(){this.focus()}),jQuery("#ttshowcase_form textarea").click(function(){this.focus()})});</script>';

	/* End Temp Fix */

	return $form_html;

} 


function  tt_create_image($ash)
{
    global $tt_image;
    $tt_image = imagecreatetruecolor(150, 26) or die("Cannot Initialize new GD image stream");

    $background_color = imagecolorallocate($tt_image, 255, 255, 255);
    $text_color = imagecolorallocate($tt_image, 0, 255, 255);
    $line_color = imagecolorallocate($tt_image, 64, 64, 64);
    $pixel_color = imagecolorallocate($tt_image, 150, 150, 200);

    imagefilledrectangle($tt_image, 0, 0, 180, 26, $background_color);

    for ($i = 0; $i < 3; $i++) {
        imageline($tt_image, 0, rand() % 26, 180, rand() % 26, $line_color);
    }

    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($tt_image, rand() % 180, rand() % 26, $pixel_color);
    }


    $letters = 'ABCDEFGHIJKMNPQRTUVWXY346789';
    $len = strlen($letters);
    $letter = $letters[rand(0, $len - 1)];

    $text_color = imagecolorallocate($tt_image, 0, 0, 0);
    $word = "";
    for ($i = 0; $i < 6; $i++) {
        $letter = $letters[rand(0, $len - 1)];
        imagestring($tt_image, 7, 5 + ($i * 26), 10, $letter, $text_color);
        $word .= strtoupper($letter);
    }


    ob_start();
	imagepng($tt_image);
	// Capture the output
	$imagedata = ob_get_contents();
	// Clear the output buffer
	ob_end_clean();
	imagedestroy($tt_image);

    $array_image = array();
    $array_image['image'] = base64_encode($imagedata);
    $array_image['word'] = md5($word);


    return $array_image;

}

// In Development
add_action('wp_ajax_nopriv_ttshowcase_ajax_form', 'ttshowcase_ajax_form_submit');
add_action('wp_ajax_ttshowcase_ajax_form', 'ttshowcase_ajax_form_submit');

function ttshowcase_ajax_form_submit() {

	//Process data submitted

	$atts = isset($_POST['tt_atts']) ? json_decode(base64_decode($_POST['tt_atts']),true) : array();

	echo ttshowcase_build_form($atts,$_POST);

	exit();

}


?>