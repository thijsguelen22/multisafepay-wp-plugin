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

function multisafepay_function() {
  include('config/config.php');
  include('controllers/idealController.php');
  $ideal = new idealController();
  $issuers = $ideal->getIssuers();
  $out = '<div id="body-wrapper">
      <div id="main-wrapper">
        <div id="container">
          <div class="content-description left-align">
            <br />
            <img src="../../wp-content/plugins/multisafepay/assets/images/iDEAL-groot.gif" />
            <p>Kies het gewenste bedrag en je bank</p>
            <form action="" method="POST">
			bedrag:<br />
            <input type="text" name="amount" placeholder="bedrag in euro'."'".'s"/><br />'.$issuers.'<br />
              <br />	
              <input name="versturen" type="submit" value="Start transaction" class="submitbutton"/>
            </form>
            <br/>
          </div>
        </div>
      </div>
    </div>';
	if(isset($_POST['versturen']) && isset($_POST['amount'])){
		$amount = $_POST['amount'] * 100;
		$issuer = $_POST['issuer'];
		header("Location: ../../wp-content/plugins/multisafepay/controllers/idealController.php?task=directTransaction&issuer=".$issuer."&amount=".$amount);
	} else {
	return $out;
	}
}
add_shortcode('multisafepay', 'multisafepay_function');
$_SESSION['body'] = '[multisafepay]';

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