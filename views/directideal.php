<?php
include('config/config.php');
include('controllers/idealController.php');
$ideal = new idealController();
$issuers = $ideal->getIssuers();
?>

<div id="body-wrapper">
  <div id="main-wrapper">
    <div id="container">
      <div class="content-description left-align">
        <h1 class="black">You have selected direct iDEAL to test an iDEAL transaction</h1>
        <br />

        <p>Normally, when you've selected iDEAL as a payment method then you should be able to select the iDEAL issuer during the checkout process. This page simulates that page and would normally be the payment selection or checkout page.</p>
        <br>
        <br />
        <img src="<?php echo BASE_URL ?>assets/images/iDEAL-groot.gif" />
        <p>You have selected iDEAL, please select your issuer and start your transaction</p>
        <form action="<?php echo BASE_URL ?>controllers/idealController.php?task=directTransaction" method="GET">
          <?php echo $issuers; ?>
          <br />
          <br />	
          <input type="submit" value="Start transaction" class="submitbutton"/>
        </form>
        <br/>

      </div>
      <div class="examples">

        <div style="clear:both;"></div>
      </div>
    </div>
  </div>
</div>