<?php
/**
 * Exit if accessed directly
 */
if (! defined('ABSPATH')) {
    exit;
}
if (isset($_POST['mwb_gaq_add_status'])) {
    $status = $_POST['new_status'];
    if (! empty($status)) {
        wp_insert_term($status, 'status', array('slug' => $status));
        echo("<meta http-equiv='refresh' content='1'>");
    }
}
if (isset($_POST['mwb_gaq_add_service'])) {
    $service = $_POST['new_service'];
    if (! empty($service)) {
        wp_insert_term($service, 'service', array('slug' => $service));
        echo("<meta http-equiv='refresh' content='1'>");
    }
}
if (isset($_POST['mwb_gaq_taxonomies_common_settings_save'])) {

    check_admin_referer('gaq_admin_taxo', 'gaq_admin_taxo_nonce');

    $mwb_gaq_taxonomies_setting = array();

    $mwb_gaq_taxonomies_setting['select_for_services'] = ! empty($_POST['select_for_services']) ? sanitize_text_field(wp_unslash($_POST['select_for_services'])) : '';

    $mwb_gaq_taxonomies_setting['select_for_status'] = ! empty($_POST['select_for_status']) ? sanitize_text_field(wp_unslash($_POST['select_for_status'])) : '';

    update_option('mwb_gaq_taxonomies_options', $mwb_gaq_taxonomies_setting); ?>

    <div class="notice notice-success is-dismissible">
        <p><strong><?php esc_html_e('Settings saved', 'GAQ_TEXT_DOMAIN'); ?></strong></p>
    </div>
    <?php
}

$mwb_gaq_taxonomies_option = get_option('mwb_gaq_taxonomies_options', array());

?>
<form action="" method="POST">
<?php wp_nonce_field('gaq_admin_taxo', 'gaq_admin_taxo_nonce'); ?>
    <div class="mwb_gaq_taxonomy_table">
        <table class="form-table mwb_gaq_taxonomy_setting">
            <tbody>
            <tr valign="top">
                    <th scope="row" class="titledesc">
                        <label><?php esc_html_e('Enable Quote Status', 'GAQ_TEXT_DOMAIN'); ?></label>
                    </th>
                    <td>
                        <label class="mwb_gaq_enable_status_taxonomy_plugin_label">
                            <?php
                            $select_for_status = ! empty($mwb_gaq_taxonomies_option['select_for_status']) ? $mwb_gaq_taxonomies_option['select_for_status'] : '';
                            ?>
                            <select class="mwb_gaq_select" name="select_for_status">
                                <option value="yes" <?php selected($select_for_status, 'yes'); ?>><?php esc_html_e('Yes', 'GAQ_TEXT_DOMAIN'); ?></option>
                                <option value="no" <?php selected($select_for_status, 'no'); ?>><?php esc_html_e('No', 'GAQ_TEXT_DOMAIN'); ?></option>
                            </select>
                        </label><br>
                       <!--  <span class="mwb_upsell_global_description"><?php //esc_html_e('To allow quote status', 'GAQ_TEXT_DOMAIN'); ?></span> -->
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="titledesc">
                        <label for="mwb_gaq_enable_taxonomy_plugin"><?php esc_html_e('Enable Service Type', 'GAQ_TEXT_DOMAIN'); ?></label>
                    </th>
                    <td>
                        <label class="mwb_gaq_enable_service_taxonomy_plugin_label">
                            <?php
                            $select_for_services = ! empty($mwb_gaq_taxonomies_option['select_for_services']) ? $mwb_gaq_taxonomies_option['select_for_services'] : '';
                            ?>
                            <select class="mwb_gaq_select" name="select_for_services">
                                <option value="yes" <?php selected($select_for_services, 'yes'); ?>><?php esc_html_e('Yes', 'GAQ_TEXT_DOMAIN'); ?></option>
                                <option value="no" <?php selected($select_for_services, 'no'); ?>><?php esc_html_e('No', 'GAQ_TEXT_DOMAIN'); ?></option>
                            </select>
                        </label><br>
                        <!-- <span class="mwb_upsell_global_description"><?php //esc_html_e('To allow quote services type', 'GAQ_TEXT_DOMAIN'); ?></span> -->
                    </td>
                </tr>
                <tr class="mwb_gaq_status_terms terms">
                    <th class="status_terms_header header"><?php esc_html_e('Status', 'GAQ_TEXT_DOMAIN'); ?></th>
                    <th class="status_terms_sub-heading sub-heading"><?php esc_html_e('Active Terms', 'GAQ_TEXT_DOMAIN'); ?></th>
                    <th class="status_terms_btn btn"><a href="#" id='add_status_terms'>Add Status Terms</a></th>
                    <div class="center hideform" id='mwb_status_add_div'>
                        <i style="float: right;" class="fa fa-times close fa-spin" aria-hidden="true"></i>
                        <form action="" method="POST">
                            <?php esc_html_e('Term Name', 'GAQ_TEXT_DOMAIN'); ?>
                            <br>
                            <br>
                            <input type="text" name="new_status">
                            <br><br>
                            <input type="submit" name="mwb_gaq_add_status" value="Add Status Term">
                        </form>
                    </div>
                </tr>
                <tr class='service_terms terms'>
                    <th class='service_terms_header header'><?php esc_html_e('Service', 'GAQ_TEXT_DOMAIN'); ?></th>
                    <th class="service_terms_sub-heading sub-heading"><?php esc_html_e('Active Terms', 'GAQ_TEXT_DOMAIN'); ?></th>
                    <th class="service_terms_btn btn"><a href="#" id='add_service_terms'>Add Service Terms</a></th>
                    <div class="center hideform" id='mwb_service_add_div'>
                        <i style="float: right;" class="fa fa-times close fa-spin" aria-hidden="true"></i>
                        <form action="" method="POST">
                            <?php esc_html_e('Term Name', 'GAQ_TEXT_DOMAIN'); ?>
                            <br>
                            <br>
                            <input type="text" name="new_service">
                            <br><br>
                            <input type="submit" name="mwb_gaq_add_service" value="Add Service Term">
                        </form>
                    </div>
                </tr>
            <tbody>
        </table>
        <p class="submit">
            <input type="submit" value="<?php esc_html_e('Save Changes', 'GAQ_TEXT_DOMAIN'); ?>" class="button-primary save-button" name="mwb_gaq_taxonomies_common_settings_save" id="mwb_gaq_taxonomies_setting_save">
        </p>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php
