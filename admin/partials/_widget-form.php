<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Sacbrant_Wish_Exporter
 * @subpackage Sacbrant_Wish_Exporter/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" id="sacbrantWishForm">
  <?php wp_nonce_field('generate_wish_export','sac-wish-form-submit'); ?>
  <input type="hidden" name="action" value="generate_wish_export">
  <div id="wish-report-errors" class="hidden inline notice notice-error">
    <ul></ul>
  </div>
  <div class="form-group form-group-left">
    <label for="wish-report-from"><?php _e('From', $this->plugin_name); ?></label>
    <input type="text" name="wish-report-from" id="wish-report-from" class="js__wish-datepicker-start">
  </div>
  <div class="form-group form-group-right">
    <label for="wish-resport-to"><?php _e('To', $this->plugin_name); ?></label>
    <input type="text" name="wish-report-to" id="wish-report-to" class="js__wish-datepicker-end">
  </div>
  <div class="clearfix"></div>
  <div class="form-group clearfix form-group-submit">
    <button type="submit" class="button button-primary js__validate-wish-form"><?php _e('Generate Export', $this->plugin_name); ?></button>
  </div>
</form>
