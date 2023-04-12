<?php
/*
Plugin Name: contact form by jalil
Plugin URI: http://contactform.jalil.com
Description: WordPress Contact Form by jalil betroji | the most used form 
Version: 1.0.0
Author: jalil betroji
*/

if( !defined('ABSPATH') ){
  die("what do you doing here!");
};


##################### START ADDING BOOTSTRAP CDN #########################

function Bootstrap_CDN_Scripts() {
    // all styles
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');
    }
    add_action( 'wp_enqueue_scripts', 'Bootstrap_CDN_Scripts' );


##################### END ADDING BOOTSTRAP CDN ###########################




########################## START registering activation hook ###############################
################ CREATE wp_contact_form WHEN THE PLUGIN IS ACTIVATED  ######################

function Plugin_Activation_Hook() {

  $sql = "CREATE TABLE `wp_contact_form` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `FirstName` varchar(100) NOT NULL,
    `LastName` varchar(100) NOT NULL,
    `Email` varchar(255) NOT NULL,
    `Subject` varchar(255) NOT NULL,
    `Message` text NOT NULL,
    `Sent_Date` timestamp NOT NULL DEFAULT current_timestamp()
  );
  ";
// include upgrade.php to be able to use dbDelta function to run sql queries
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
  }
  register_activation_hook( __FILE__, 'Plugin_Activation_Hook' );


################ END registering activation hook ######################


#################### START registering Deactivation hook #########################
########### DELETE wp_contact_form WHEN THE PLUGIN IS DESACTIVATED  ##############


  function Plugin_Deactivation_Hook() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
  }

  register_deactivation_hook(__FILE__, 'Plugin_Deactivation_Hook');

################ END registering Deactivation hook #######################


################ START ADDING PLUGIN TO WORDPRESS MENU ###################

    function View_contact_form_submition(){
        $page_title = 'Contact form submition';
        $menu_title = 'Contact form submition';
        $capability = 'manage_options';
        $menu_slug = 'Contact_form_submition';
        $icon_url = 'https://cdn-icons-png.flaticon.com/24/9374/9374940.png';
        function Menu_Page_Callback(){
                include(dirname(__FILE__).'/design/'.'ContactFormSubmition.php');
            
        }

 add_menu_page(  $page_title ,  $menu_title,  $capability,  $menu_slug, 'Menu_Page_Callback' ,  $icon_url,  $position = 2 );
 
    }

    add_action( "admin_menu", 'View_contact_form_submition');


################ END ADDING PLUGIN TO WORDPRESS MENU #####################


##################### START PLUGIN FUNCTIONS #########################


// HTML_FORM function will display the form into desired pages :D
    function Contact_Form_HTML() {

      $form =' <form class="row g-3" method="POST">
  <div class="col-md-6">
    <label for="FirstName" class="form-label">FirstName</label>
    <input type="text" class="form-control" name="FirstName" placeholder="FirstName">
  </div>
  <div class="col-md-6">
    <label for="LastName" class="form-label">LastName</label>
    <input type="text" class="form-control" name="LastName" placeholder="LastName">
  </div>
  <div class="col-12">
    <label for="Email" class="form-label">Email</label>
    <input type="eamil" class="form-control" name="Email" placeholder="Enter your email">
  </div>
  <div class="col-12">
    <label for="Subject" class="form-label">Subject</label>
    <input type="text" class="form-control" name="Subject" placeholder="Subject">
  </div>
  <div class="col-md-12">
    <label for="Message" class="form-label">Message</label>
    <textarea type="text" class="form-control" name="Message" placeholder="Enter your message"></textarea>
  </div>
  <div class="col-12 gap-2 d-grid">
    <button type="submit" name="ContactFormByJalil" class="btn btn-warning">Contact</button>
  </div>
</form> ' ;

echo $form ;

    }

// STORE MAIL FUNCTION will sanitize the inputs and STORE DATA INTO wp_contact_form TABLE
// IF error ============> display error message :)
// IF success ============> display success message :)
    function STORE_MAIL() {
if (isset( $_POST['ContactFormByJalil'])){
        // if the submit button is clicked, send the email
        if ( isset( $_POST['FirstName'] ) && !empty($_POST['FirstName']) 
        && isset( $_POST['LastName'] ) && !empty($_POST['LastName'])
        && isset( $_POST['Email'] ) && !empty($_POST['Email'])
        && isset( $_POST['Subject'] ) && !empty($_POST['Subject'])
        && isset( $_POST['Message'] ) && !empty($_POST['Message'])
    
          ) {
    
            // sanitize form values
           
            $FirstName   = sanitize_text_field( $_POST["FirstName"] );
            $LastName    = sanitize_text_field( $_POST["LastName"] );
            $Email   = sanitize_email( $_POST["Email"] );
            $Subject = sanitize_text_field( $_POST["Subject"] );
            $Message = esc_textarea( $_POST["Message"] );
            // , current_timestamp()
                // insert message into table 
                global $wpdb;
                $sql = "
                INSERT INTO `wp_contact_form` (`id`, `FirstName`, `LastName`, `Email`, `Subject`, `Message`) 
                VALUES (NULL, 
                '$FirstName', 
                '$LastName',
                 '$Email', 
                '$Subject', 
                '$Message'
          )
            ";
                if ($wpdb->query($sql)){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>message sent! </strong> Your message has been recieved thanks for contacting us .
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';

                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>message failed! </strong> Your message has not recieved please try again .
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }

    

           
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>missing input fields </strong> please fill all the required inputs .
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }


    }

##################### END PLUGIN FUNCTIONS #########################

##################### START ADDING shortcode #########################

   function ShortcodeFunctions(){
    ob_start();
    STORE_MAIL();
    Contact_Form_HTML();
    return ob_get_clean();
    }
    add_shortcode( 'Contact_Form_By_Jalil', 'ShortcodeFunctions' );

    ##################### END ADDING shortcode #########################

?>