<?php

/*
Plugin Name: Testimonials Showcase
Plugin URI: http://www.cmoreira.net/testimonials-showcase
Description: This plugin allows you to create and display testimonials, quotes, reviews or case studies in multiple ways
Author: Carlos Moreira
Version: 1.4.8
Author URI: http://cmoreira.net
Text Domain: ttshowcase
Domain Path: /lang
*/

/* 

	
	Latest version from August 18th 2016

	> Next *possible* updates:
	- lock it to 1 entry per logged author
	- select category via URL for form (so one form could be implemented only)
	- When published review: email 'Your review is published' to user
	- disable touch
	- json-ld for rich snippets?
	- fix pagination code to work with /page/ format and 'paged' parameter
	- 'load more' feature
	- improve script loading
	- reply to reviews
	- extra div closing on average rating?

	v.1.4.8
		- Fixed closing div on average rating shortcode
		- improved rich snippets code

	v.1.4.7
		- Added testimonials custom counter shortcode
		- Form rating title and rating breakdown translation fix 
		- mandatory fields bug fix


	v.1.4.6
		- Added database ID column in administration
		- Ajax form submission option

	v.1.4.5
		- Fixed bug with the 'use categories as products' option

	v.1.4.4
		- Removed custom functions that could cause issues (ttshowcase_manipulate_title)

	v.1.4.3
		- Removed jQuery.noConflict();
	
	v.1.4.2
		- Fixed bug on shortcode generator affecting slider preview

	v.1.4.1
		- Added new pagination code

	v.1.4
		- Live filter option for grid layout (beta)

	v.1.3.9
		- fixed bug on shortcode generator - display cut content inline
		- added 'long testimonial' field to form options

	v.1.3.8
		- fixed bug from custom js field

	v.1.3.7
		- Added other fields to email notification message: email and taxonomies (groups)
		- Added new option for the read more option in shortcode generator: display cut content inline


	v.1.3.6
		- Added imagesLoaded script for masonry support
		- Order form fields in settings
		- Select mandatory fields in settings
		- Improved code to accept more taxonomies

	v.1.3.5
		- Changed saving custom fields process

	v.1.3.4
		- Layers Widget Integration

	v.1.3.3
		- added widget to display saved shortcodes
		- Added custom js field in the settings
		- Honeypot spam prevention technique implemented
		- Akismet filter integration

	v.1.3.2
		- ratings breakdown for average info shortcode
		- fixed bug when displaying half stars and empty stars

	v.1.3.1
		- Fixed font-icon administration bug

	-v1.3
		- Added advanced rich snippets options in shortcode generator

	v.1.2.9
		- Reviewd half-star rating display

	v.1.2.8
		- Previous/Next page labels translation bug fixed

	v.1.2.7
		- rich snippets code bug fix

	v.1.2.6
		- added order by rating
		- default rating for frontend form option / count empty for average layout or not
		- expand content 'read more' option for grid layout
		- visual composer update
		- fontawesome version update

	v.1.2.5
		- Updated Rich Snippets code

	v.1.2.4
		- Improved CSS handling (scoped attribute)

	v.1.2.3
		- Custom email message

	v.1.2.2.1
		- Adaptive Height Slider

	v.1.2.2
		- New shortcode option to choose which content to display
		- New option in advanced settings to render layout on single page

	v.1.2.1
		- New Schema.org fields

	v.1.2
		- mandatory form field in php array
		- new 'force refresh' for form submission
		- updated bxslider version
	
	v.1.1.9
		- Added option to display category on layout via shortcode (will add link automically)
		- Option to show/hide captcha in logged users

	v.1.1.8.1 
		- Fixed bug on captcha

	v.1.1.8
		- Fixed get_the_date() for rich snippets
		- Fontawesome version update
		- Improved image handling (now works with get_avatar())
		- Other small improvements

	v.1.1.7
		- Updated drag&drop code
		- Limit characters for testimonial in admin archive view

	v.1.1.6.3
		- Bug fixes (missing <? 'php' )

	v.1.1.6
		- pre-implementation get_avatar
		- remove_all_filters('posts_orderby') implemented
		- Fixed small shortcode bug (custom read more url)
		- Added Save shortcode options
		- Visual Composer Integration
		- Added confirmation page URL option for form
		- Added option to display empty text entries or not 

	v.1.1.5
		- New option in settings to choose single page template

	v.1.1.4
		- Added new pagination option
		- Added new custom-read-more-label option parameter for the shortcode

	v.1.1.3.3
		- Added read more only on cutout text
		- New Average Rating Shortcode options: Empty ratings text & Singular/Plural text
		- Form: css class added to submit button

	v.1.1.3.2
		- Fixed wp_editor for wp 3.9
		- Added Character limit option to grid layout

	v.1.1.3.1
		- Fixed #wrap id in shortcode generator

	v.1.1.3
		- Fixed bug with slider controls when multiple slider where in same page
		- Added Captcha Verification to form
		- bxslider script updated
		- Removed WP version from enqueued scripts

	v.1.1.2 
		- Added new 'Default URL (only cutout text)' for read more options on slider
		- CSS fix in Admin (star rating class) for new WP version

	v.1.1.1
		- Changed form file to better support translations
		- Added translation function to 'continue reading' default string
		- Fixed quotes in testimonial title issue

	v.1.1:
		- Load Shortcode option implemented
		- Added #ttshowcase anchor to pagination links
		- Shortcode Read More link options
		- Pre-implementation half stars in single testimonials

	v.1.0.4:

		- Display empty stars option
		- Current ID Page filter for categories (useful for product/page reviews linked with pages)
		- Option to display categories on frontend submission form
		- Option to set default publish status for entries submited via frontend form
		- Hover Star Rating option for frontend submission form
		- Category filter in administration
		- Custom Read More link
		- Better Image handling, if no default image exists


	v.1.0.3:

		- Small Frontend submission form improvements (valid email check & page position after submission);
		- Option to display date via shortcode on layouts and date format in settings
		- Block contents - choose which elements to display in different blocks (information block and quote block)
		- Better markup output 
		- Character Limit option for slider

	v.1.0.2

		- Pagination option included	
		- Shortcode option not to render meta data for rich snippets
		- Added option to allow only registred users to submit entries
		- Human Verification option for frontend form
		- Fixed bug when query was empty
		- Added shortcode support inside testiminials content
		- Added [ Current Page Slug ] category filter
		- option to render smiles in testimonial content

	v.1.0.1

		- Bug fix -> custom slug not working
		- Bug fix -> for nl2br in content
		- Added Frontend Image Upload Feature
		- Added parameters in taxonomy shortcode field to display empty categories
		- Added option to customize the 'Star' label in the frontend form
*/ 

// Localization
add_action('init', 'ttshowcase_lang_init');
function ttshowcase_lang_init() {
	$path = dirname(plugin_basename( __FILE__ )) . '/lang/';
	$loaded = load_plugin_textdomain( 'ttshowcase', false, $path);
} 


// Include necessary files -  cmshowcase lite framework
require_once dirname( __FILE__ ) . '/includes/utils.php';
require_once dirname( __FILE__ ) . '/includes/cmshowcase-class.php';

// Include necessary files - cmshowcase pro framework
require_once dirname( __FILE__ ) . '/includes/utils-advanced.php'; // functions for the advanced framework
require_once dirname( __FILE__ ) . '/includes/class-shortcodes.php'; // shortcode building and handling
require_once dirname( __FILE__ ) . '/includes/class-layouts.php'; // layout constructor
require_once dirname( __FILE__ ) . '/includes/class-ordering.php'; // drag&drop ordering constructor

//require class to work with Visual Composer
require_once dirname( __FILE__ ) . '/includes/class-visual-composer.php'; // functions for the advanced framework

// Include file with widget info
require_once dirname( __FILE__ ) . '/includes/class-widget.php';
//Widget code for Layers 
require_once dirname(__FILE__) . '/includes/layers-extension.php';

// Include file with options array
require_once dirname( __FILE__ ) . '/options.php';


//First, we check for the available layouts and we merge the options with the settings array
//this will run a function from the utils-advanced file
$ttshowcase_settings = cmshowcase_build_layout_options($ttshowcase_layouts,$ttshowcase_settings);

// Second, we add the shortcodes functionality	
// We pass the layouts also.
$ttshowcase_sc = new cmshowcase_shortcode('ttshowcase',$ttshowcase_shortcodes,$ttshowcase_layouts);


// Third, we add the layouts to be accessed later
// Might not be needed at the moment the layouts are inside the shortcodes
$ttshowcase_lyts = new cmshowcase_layouts('ttshowcase',$ttshowcase_layouts);

// Fourth, we build the Custom Post Type, after merging all needed arrays
// The paramater inside new cmshowcase will indicate the custom post type id. 
// The same should be used when adding extra functionalities, like shortcodes
$ttshowcase_options['options'] = $ttshowcase_settings;
$ttshowcase = new cmshowcase('ttshowcase',$ttshowcase_options);


//To activate drag & drop ordering in the admin screen
//$ttshowcase_ordering = new cmshowcase_ordering('ttshowcase');
cmshowcase_ordering::get_instance('ttshowcase');

//to run visual composer integration
$ttshowcase_visual_composer = new cmshowcase_VCExtendAddonClass(
	'ttshowcase',
	__('Testimonials','ttshowcase'),
	__('Insert previously saved Testimonials Shortcode','ttshowcase'),
	'show-testimonials'
	);

/*

The Content Below is Custom Made for the Testimonials Showcase and not part of the Showcase Framework

*/

// globals for layout parameters
$tt_showcase_counter = 0;
$tt_colorbox_params = array();
$tt_slider_params = array();
$tt_carousel_params = array();
$tt_colorbox_enqueued = false; // global to say that the colorbox by default if off;

//Callback Function for Shortcode 'show-testimonials'
function ttshowcase_show_testimonials ($atts) {

	if(isset($atts['alias'])) {

		$saved_shortcodes = get_option('ttshowcase_saved_shortcodes',array());

		if(count($saved_shortcodes) > 0) {

			foreach ($saved_shortcodes as $key => $value) {
				
				if(array_key_exists($atts['alias'], $value)) {

					$html = do_shortcode($value[$atts['alias']]);

					return $html;
					

				}
			}


		}


	}


	global $tt_showcase_counter;

	if(isset($atts['counter'])) { $tt_showcase_counter = $atts['counter']; }

	
	

	$html = '<div id="ttshowcase_'.$tt_showcase_counter.'">';

	if(isset($atts['layout'])) {
		
		global $ttshowcase_sc;

		$query = cmshowcase_build_query('ttshowcase',$atts);
		$options = isset($atts['options']) ? cmshowcase_extract_options($atts['options']) : array();
		$preview = isset($atts['preview']) && $atts['preview'] == 'true' ? true : false;
		$html .= $ttshowcase_sc->layouts['ttshowcase'][$atts['layout']]->build_layout($query,$options,$preview);

		if(isset($atts['pagination']) && $atts['pagination'] != 'off') {
			$labels = array();
			$labels['previous'] = cmshowcase_get_option( 'previous', 'ttshowcase_basic_settings', 'Previous Page' );
			$labels['next'] = cmshowcase_get_option( 'next', 'ttshowcase_basic_settings', 'Next Page' );
			$html .= cmshowcase_build_pager('ttshowcase',$query,$labels,$atts['pagination']);
		}
		
	}

	else {

		$html = __("There were no arguments supplied for this shortcode","ttshowcase");
	}
	
	$html .= '</div><!-- Closing Wrap Div for ttshowcase_'.$tt_showcase_counter.' -->';

	$tt_showcase_counter++;
	return $html;

}


//Custom For Form Function

require_once dirname( __FILE__ ) . '/form/form-class.php';
require_once dirname( __FILE__ ) . '/form/form.php';

function ttshowcase_show_form ($atts) { 

	if(isset($atts['alias'])) {

		$saved_shortcodes = get_option('ttshowcase_saved_shortcodes',array());

		if(count($saved_shortcodes) > 0) {

			foreach ($saved_shortcodes as $key => $value) {
				
				if(array_key_exists($atts['alias'], $value)) {

					$html = do_shortcode($value[$atts['alias']]);

					return $html;
					

				}
			}


		}


	}

	// css
	wp_register_style( 'tt-form-style', plugins_url( '/form/style.css' , __FILE__), array() , '1.0', 'all' );
	wp_enqueue_style( 'tt-form-style' );

	// custom jquery
	//wp_register_script( 'tt-form-validation', plugins_url( '/form/js/jquery.validation.js' , __FILE__), array( 'jquery' ), '1.0', TRUE );
	//wp_enqueue_script( 'tt-form-validation' );
	 
	// validation
	//wp_register_script( 'tt-validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', array( 'jquery' ) );
	//wp_enqueue_script( 'tt-validation' );

	 //for the ajax to work
    //wp_localize_script( 'tt-form-validation', 'ajax_object', array(
      //  'ajax_url' => admin_url( 'admin-ajax.php' )
    //));

	



	$form_html = ttshowcase_build_form($atts);

	return '<div class="tt_form_container">'.$form_html.'</div>';
	

}

//to run the ajax form
add_action( 'wp_ajax_ttshowcase_ajax_form', 'ttshowcase_ajax_form');


//function to display average rating 

require_once dirname( __FILE__ ) . '/layouts/averagebox/layout.php';

function ttshowcase_average_rating($atts) {

	if(isset($atts['alias'])) {

		$saved_shortcodes = get_option('ttshowcase_saved_shortcodes',array());

		if(count($saved_shortcodes) > 0) {

			foreach ($saved_shortcodes as $key => $value) {
				
				if(array_key_exists($atts['alias'], $value)) {

					$html = do_shortcode($value[$atts['alias']]);

					return $html;
					

				}
			}


		}


	}

	$average = new tt_average_box('ttshowcase');
	$query = cmshowcase_build_query('ttshowcase',$atts);
	$options = isset($atts['options']) ? cmshowcase_extract_options($atts['options']) : array();
	$preview = isset($atts['preview']) && $atts['preview'] == 'true' ? true : false;
	$html = $average->build_layout($query,$atts,$preview);

	return $html;

}


//Custom Function for Single Page entry
//Activate the Rich Snippets Code

function ttshowcase_single_page_css() {
	
	wp_deregister_style('ttshowcase_single');
	wp_register_style( 'ttshowcase_single', plugins_url( 'resources/global.css', __FILE__ ), array(), '1.0.0', 'all');
	wp_enqueue_style( 'ttshowcase_single' );
	
}

//Display custom CSS
function ttshowcase_custom_css_single_page () {

	$css = cmshowcase_get_option( 'custom_css', 'ttshowcase_advanced_settings',  '' );
	
	if($css!=''){
		echo '
		<!-- Custom Styles for Testimonials Showcase -->
		<style type="text/css">
		'.$css.'
		</style>';
	}
}

//filter to handle the single page template

function ttshowcase_single_template($template) {

	global $post;


	if( !locate_template('single-ttshowcase.php') && $post->post_type == 'ttshowcase' ){

	$tt_template = cmshowcase_get_option('single_page_template','ttshowcase_basic_settings','post');


		//do we have a default template to choose for testimonials?
		if( $tt_template == 'page' ){
			$post_templates = array('page.php','index.php');
		}
		else{
		    $post_templates = array($tt_template);
		}
		
		if( !empty($post_templates) ){
		    $post_template = locate_template($post_templates,false);
		    if( !empty($post_template) ) $template = $post_template;
		}
			

	}

	return $template;
}


//Filter to handle content of single page
function ttshowcase_single_page($content) {

	if(is_singular( 'ttshowcase' )) {

		ttshowcase_single_page_css();
		//add custom css function
		add_action('wp_footer', 'ttshowcase_custom_css_single_page');

		$id = get_the_ID();

		//$content = get_post_meta( get_the_ID(), '_aditional_info_short_testimonial', true ).$content; 
		//$content = do_shortcode("[show-testimonials orderby='menu_order' order='ASC' id_filter='".get_the_ID()."' post_status='publish' layout='grid' options='theme:speech,info-position:info-above,text-alignment:left,columns:1,review_title:on,rating:on,date:on,display-image:on,image-size:ttshowcase_small,image-shape:circle,image-effect:none,image-link:on']").$content; 

		$rs_active = cmshowcase_get_option('single_page_active','ttshowcase_rich_snippets','off');
		$single_info = cmshowcase_get_option('single_page_info','ttshowcase_basic_settings','on');
		$single_testimonial = cmshowcase_get_option('single_page_testimonial','ttshowcase_basic_settings','on');

		$single_page_shortcode = cmshowcase_get_option('single_page_shortcode','ttshowcase_advanced_settings','');

		if(trim($single_page_shortcode)!='') {
			$content = do_shortcode("[show-testimonials orderby='menu_order' order='ASC' id_filter='".get_the_ID()."' post_status='publish' layout='grid' options='".$single_page_shortcode."']").$content;
		}

		if($single_testimonial=='on') {

			$testimonial_title = get_post_meta( $id, '_aditional_info_review_title', true );
			$testimonial = get_post_meta( $id, '_aditional_info_short_testimonial', true ); 
			$content = '
			<div class="tt_single_page_testimonial_title">'.$testimonial_title.'</div>
			<div class="tt_single_page_testimonial">'.$testimonial.'</div>'.$content;
		
		}

		if($rs_active=='on') {


			
			$title = get_the_title($id).' '. __('Review','ttshowcase');
			$author = get_the_title($id);
			$itemreviewed = cmshowcase_get_option( 'default_product', 'ttshowcase_rich_snippets', get_bloginfo() );

			$rating = get_post_meta( $id, '_aditional_info_rating', true ); 

			$html = '<div itemscope itemtype="http://schema.org/Review">
						<meta itemprop="name" content="'.$title.'">
						<meta itemprop="datePublished" content="2013-12-03">

						<div itemprop="author" itemscope itemtype="http://schema.org/Person">
							<meta itemprop="name" content="'.$author.'">
						</div>

						<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
							<meta itemprop="name" content="'.$itemreviewed.'">
						</div>

						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
							<meta itemprop="worstRating" content="1">
							<meta itemprop="ratingValue" content="'.$rating.'">
							<meta itemprop="bestRating" content="5">
						</div>

						<div itemprop="reviewBody">
						'.$content.'
						</div>

					</div>
					';

			$content = $html;


		}

		

	}

	//Add a shortcode to all single pages
	//$shortcode = "[show-testimonials orderby='menu_order' order='ASC' post_status='publish' layout='grid' options='theme:speech,info-position:info-above,text-alignment:left,columns:1,review_title:on,rating:on,date:on,display-image:on,image-size:ttshowcase_small,image-shape:circle,image-effect:none,image-link:on']";
	//$content = $content.do_shortcode($shortcode);

	return $content;

}


// To order by menu_order in admin
// Order by menu_order in the ADMIN screen
// This will default the ordering admin to the 'menu_order' - will disable other ordering options

function ttshowcase_admin_order($wp_query)
{
	if (is_post_type_archive( 'ttshowcase' ) && is_admin()) {
		if (!isset($_GET['orderby'])) {
			$wp_query->set( 'orderby', 'menu_order' );
			$wp_query->set( 'order', 'ASC' );
		}
	}
}

//Function to limit the creation of thumbnails only when on this custom post type
//add_filter( 'intermediate_image_sizes', 'ttshowcase_image_sizes', 999 );
function ttshowcase_image_sizes( $image_sizes ){

    $ttshowcase_sizes = array( 'ttshowcase_small', 'ttshowcase_normal' ); 

    if( isset($_REQUEST['post_id']) && 'ttshowcase' != get_post_type( $_REQUEST['post_id'] ) ) {
    	$image_sizes = array_diff($image_sizes, $ttshowcase_sizes);
    }
     
    return $image_sizes;
}

//Funtion to retrieve a message with the ratings of a particular taxonomy
add_shortcode( 'show-testimonials-custom', 'ttshowcase_get_reviews' );
function ttshowcase_get_reviews($atts) {

	 $tsargs = array(
        'post_type' => 'ttshowcase',
        'tax_query' => array(
			array(
				'taxonomy' => 'ttshowcase_groups',
				'field'    => 'slug',
				'terms'    => $atts['slug'],
			),
		),

      );

      //perform the query
      $tts_query = new WP_Query( $tsargs );

      //store the ratings in an array
      $collection = array(

      	'0' => 0,
      	'1' => 0,
      	'2' => 0,
      	'3' => 0,
      	'4' => 0,
      	'5' => 0

      	);

      $total = 0;

      while ( $tts_query->have_posts() ) : $tts_query->the_post();

      	//get rating value;
		$rating = get_post_meta( get_the_ID(), '_aditional_info_rating', true );

		//add it to collection array
		$collection[$rating] = $collection[$rating]+1;


		$total++;


      endwhile;

      $output = '';

      foreach ($collection as $key => $value) {
      		//show only if there were ratings with that value
      		if($value>0) {
      			//build output
      			$output .= 'Rating '.$key.' = '.$value.' times <br>';
      		}
		
      }

	  //add total rating count
      $output .= 'Total ratings:'.$total;

      return $output;

}


/* Want to remove fontawesome? */
//add_filter( 'the_content', 'ttshowcase_remove_fa', 99 );
function ttshowcase_remove_fa($content) {
    wp_dequeue_style( 'tt-font-awesome' );
    return $content;
}


//To manipulate reviewer name output
//add_filter('the_title','ttshowcase_manipulate_title');
/*
function ttshowcase_manipulate_title($content) {
	if(!is_admin() && 'ttshowcase' == get_post_type()) {
		$words = str_word_count ($content, 1);
		$result = "";
		for ($i = 0; $i < count($words); ++$i) { $result .= $words[$i][0].'.'; }
		return $result;
		  
	} else {
		return $content;
	} 
}
*/


//To add a shortcode to a particular single page
/*
add_filter( 'the_content', 'ttshowcase_add_shortcode_custom' );
function ttshowcase_add_shortcode_custom($content) {


	if(is_singular( 'tshowcase' )) {

		$shortcode = "[show-testimonials alias='team-member'][show-testimonials-form alias='team-form']";

		$content = $content.$shortcode; 
	
	}

	return $content; 

}
*/


/* Custom Shortcode to Get Testimonials Approval/Pending Counter */
add_shortcode('show-testimonials-counter','ttshowcase_testimonials_approval_counter');
function ttshowcase_testimonials_approval_counter($atts) {


	$published_label = isset($atts['publish']) ? $atts['publish'] : 'Published';
	$pending_label = isset($atts['pending']) ? $atts['pending'] : 'Pending';
	$trash_label = isset($atts['trash']) ? $atts['trash'] : 'Refused';

	$colors = array();
	$colors[0] = isset($atts['icon-color']) ? $atts['icon-color'] : '#000000';
	$colors[1] = isset($atts['number-color']) ? $atts['number-color'] : '#000000';
	$colors[2] = isset($atts['label-color']) ? $atts['label-color'] : '#000000';

	$tts = wp_count_posts('ttshowcase');

	$published = $tts->publish;
	$pending = $tts->pending;
	$trash = $tts->trash;


	if(isset($atts['taxonomy'])) {

			$published = count( get_posts( array(
		    'post_type' => 'ttshowcase',
		    'post_status' => 'publish',
		    'ttshowcase_groups' => $atts['taxonomy'],
		    'numberposts' => -1
			)));

			$pending = count( get_posts( array(
		    'post_type' => 'ttshowcase',
		    'post_status' => 'pending',
		    'ttshowcase_groups' => $atts['taxonomy'],
		    'numberposts' => -1
			)));

			$trash = count( get_posts( array(
		    'post_type' => 'ttshowcase',
		    'post_status' => 'trash',
		    'ttshowcase_groups' => $atts['taxonomy'],
		    'numberposts' => -1
			)));
	}

	
	$html = '<div id="tt_status_counter">';
	$html .= ttshowcase_status_column('<i class="fa fa-2x fa-thumbs-up"  aria-hidden="true"></i>',$published,$published_label,$colors);
	$html .= ttshowcase_status_column('<i class="fa fa-2x fa-clock-o"  aria-hidden="true"></i>',$pending,$pending_label,$colors);
	$html .= ttshowcase_status_column('<i class="fa fa-2x fa-minus-circle"  aria-hidden="true"></i>',$trash,$trash_label,$colors);

	$html .='</div>';

	//enqueue fontAwesome
	wp_deregister_style( 'tt-font-awesome' );
	wp_register_style( 'tt-font-awesome', plugins_url( '/resources/font-awesome/css/font-awesome.min.css', __FILE__ ),array(),false,'all');
	wp_enqueue_style( 'tt-font-awesome' );	
	//enqueue global styles
	wp_deregister_style( 'tt-global-styles' );
	wp_register_style( 'tt-global-styles', plugins_url( '/resources/global.css', __FILE__ ),array(),false,'all');
	wp_enqueue_style( 'tt-global-styles' );	

	return $html;
  

}

function ttshowcase_status_column($icon,$number,$description,$colors) {

	$html = '<div class="tt_status_column">
				<div class="tt_status_icon" style="color:'.$colors[0].'">'.$icon.'</div>
				<div class="tt_status_counter" style="color:'.$colors[1].'">'.$number.'</div>
				<div class="tt_status_description" style="color:'.$colors[2].'">'.$description.'</div>
			</div>';

	return $html;

}

/*
// func that is going to set our title of our customer magically
function tts_customers_set_title( $data , $postarr ) {

    // We only care if it's our customer
    if( $data[ 'post_type' ] === 'ttshowcase' ) {

        // get the customer name from _POST or from post_meta
        $title = $_POST[ '_aditional_info_review_title' ];

        // if the name is not empty, we want to set the title
        if( $title != '' ) {

            // sanitize the name for the slug
            $data[ 'post_name' ]  = sanitize_title( sanitize_title_with_dashes( $title, '', 'save' ) );
        }
    }
    return $data;
}
add_filter( 'wp_insert_post_data' , 'tts_customers_set_title' , '99', 2 );



//Custom Function to set testimonial title to be page title
add_filter( 'the_title', 'ttshowcase_title_filter','99',2 );
function ttshowcase_title_filter( $title,$id ) {
    global $id, $post;
    if ( $id && $post && get_post_type($id) == 'ttshowcase' ) {
       $review_title = get_post_meta($id,'_aditional_info_review_title',true);
       if($review_title != '') {
       		$title = $review_title;
       } 
    }
    return $title;
}

add_filter( 'pre_get_document_title', 'ttshowcase_get_doc_title', 999, 1 );
function ttshowcase_get_doc_title($title) {

	global $post;

    if ( $post ) {
       $review_title = get_post_meta($post->ID,'_aditional_info_review_title',true);
       if($review_title != '') {
       		if(is_array($title)) { $title['title'] = $review_title; }
       		else { $title = $review_title; }
       		
       } 
    }

	return $title;
}



add_filter( 'the_title', 'ttshowcase_title_filter','99',2 );
function ttshowcase_title_filter( $title,$id ) {
    global $id, $post;
    if ( $id && $post && get_post_type($id) == 'ttshowcase' ) {
       $review_title = get_post_meta($id,'_aditional_info_review_title',true);
       if($review_title != '') {
       		$title = $review_title;
       } 
    }
    return $title;
}
*/
?>