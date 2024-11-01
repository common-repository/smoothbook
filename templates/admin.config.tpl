<div class="wrap">
  <?php if (empty(SbOptions::getOrgId()) && empty(Smoothbook::$message)): ?>
  <div class="notice notice-success is-dismissible"><p><b>Welcome to the Smoothbook configuration page, please enter your email to continue</b></p></div>
  <?php endif; ?>

  <div id="poststuff" >
    <div class="postbox-container">
      <div class="postbox">
        <h3 class="sb-header">Smoothbook booking calendar configuration</h3>
        <div class="inside">
          <?php echo Smoothbook::adminOptions();?>
        </div>
      </div>
    </div>
  </div>

  <?php if (!empty(SbOptions::getOrgId())): ?>
  <div id="poststuff" >
    <div class="postbox-container">
      <div class="postbox">
        <h3 class="sb-header">Calendar preview</h3>
        <div class="inside">
          <p>
            <?php wp_enqueue_script('smoothbook-calendar', 'https://app.smoothbook.co/lib/calendar-embed.js'); ?>
            <a class="sb-calendar" data-embed="true" href="https://app.smoothbook.co/calendar/<?php echo SbOptions::getOrgId() ?>/#/home"><img src="<?php echo Smoothbook::$imagesUrl?>book-now-button.png" alt="Online appointments by Smoothbook"><a/>
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>
