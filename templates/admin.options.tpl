<div class="sb-form">

  <p>The Smoothbook Wordpress plugin enables you to easily embed your booking calendar wherever you like into your Wordpress pages and blog posts.</p>

  <p>
  Please note that you will need to create an account with Smoothbook for the plugin to work. You can quickly and easily create a free account with Smoothbook by
  <a target="_blank" href="https://app.smoothbook.co/#/register">clicking here</a>
  </p>

  <p>Please submit the email address of a Smoothbook account owner below so that we can correctly identify your organisation.</p>

  <p>Once you have entered your email address and can see your booking calendar below, you will be able to embed the booking calendar or insert the booking button into any position on any page or post by clicking on the 'Smoothbook' button in the WYSIWYG text editor</p>

  <p>If you have any difficulties at all, please contact us at <a href="mailto:support@smoothbook.co">support@smoothbook.co</a></p>
  
  <div class="left-box">&nbsp;</div>
  <div class="form-box">
    <form id="smoothbook_options" name="smoothbook_options" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
      <p>
        <label>Your Email Address</label></br>
        <input type="email" name="<?php echo SbOptions::EMAIL ?>" value="<?php echo SbOptions::getEmail(); ?>" size="50" maxlength="255"/>
        <br/>

        <?php 

        	$orgName = SbOptions::getOrgName();

        	if($orgName) :		

        ?>

        <label>Your organisation name</label></br>
        <input type="text" value="<?php echo $orgName; ?>" size="50" disabled="disabled"/>
        <br/>

        <?php 

        	endif;
        ?>

        <input type="hidden" name="action" value="smoothbook_update" />
        <?php wp_nonce_field('smoothbook-update_options'); ?>
        <input type="submit" name="Submit" value="Save" class="button-primary" />
        <?php echo !empty(Smoothbook::$message) ? '<span class="sb-options-error"><strong>' . Smoothbook::$message . '</strong></span>' : ''; ?>
      </p>
    </form>
  </div>
</div>
<div style="clear: both;"></div>
