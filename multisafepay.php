<?php
ob_start();
/**
* Plugin Name: multisafepay
* Plugin URI: http://mypluginuri.com/
* Description: A brief description about your plugin.
* Version: 1.0 or whatever version of the plugin (pretty self explanatory)
* Author: Plugin Author's Name
* Author URI: Author's website
* License: A "Slug" license name e.g. GPL12
*/

function include_PaymentTools(){
  include('config/config.php');
  include('controllers/idealController.php');
  $ideal = new idealController();
  $issuers = $ideal->getIssuers();
  return '<p>'.$issuers.'</p>';
}
add_shortcode('include_PaymentTools', 'include_PaymentTools');
$_SESSION['body'] = '<div id="body-wrapper">
      <div id="main-wrapper">
        <div id="container">
          <div class="content-description left-align">
            <h1 class="black">You have selected direct iDEAL to test an iDEAL transaction</h1>
            <br />

            <p>Normally, when you have selected iDEAL as a payment method then you should be able to select the iDEAL issuer during the checkout process. This page simulates that page and would normally be the payment selection or checkout page.</p>
            <br>
            <br />
            <img src="../../wp-content/plugins/multisafepay/assets/images/iDEAL-groot.gif" />
            <p>You have selected iDEAL, please select your issuer and start your transaction</p>
            <form action="../../wp-content/plugins/multisafepay/controllers/idealController.php?task=directTransaction" method="GET">
			bedrag:<br />
            <input type="text" name="amount" />
			[include_PaymentTools]
              <br />
              <br />	
              <input type="submit" value="Start transaction" class="submitbutton"/>
            </form>
            <br/>
          </div>
        </div>
      </div>
    </div>';

function create_multisafepay()
  {
   //post status and options
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'multisafepay',
          'post_status' => 'publish' ,
          'post_title' => 'Multisafepay',
		  'post_content' => $_SESSION['body'],
          'post_type' => 'page',
    );
    //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'mrpage', $newvalue );
  }
register_activation_hook( __FILE__, 'create_multisafepay');


function remove_multisafepay() {//  the id of our page...
  $the_page_id = get_option('mrpage');
    if( $the_page_id ) {
      wp_delete_post( $the_page_id, true );
    }
}
 register_deactivation_hook( __FILE__, 'remove_multisafepay' ); 
?>