<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/public/partials
 */
?>
<?php
$mwb_gaq_form_data['taxonomy_for_service'] = isset($_POST['taxonomy_for_service']) ?
    sanitize_text_field(wp_unslash($_POST['taxonomy_for_service'])) : '';
$mwb_gaq_form_data['taxonomy_for_status'] = 'Pending';
$taxonomies = get_terms(
    array(
        'taxonomy' => 'service',
        'hide_empty' => false,
    )
);
?>
<div class='error_div'>
</div>
<form action="" class="active-from" id='formdata' method="POST" enctype="multipart/form-data">
    <?php
    if (!empty($taxonomies)) {
        $taxonomies = json_decode(json_encode($taxonomies), true);
        if (!isset($taxonomies['errors'])) {
            ?>
            <label class="form_labels"><?php esc_html_e('Type Of Service', 'get-a-quote'); ?></label><br />
            <select class="mwb_gaq_taxonomy_display" name="taxo_service">
            <?php
            foreach ($taxonomies as $values => $key) {?>
                <option value="<?php echo $key['slug']; ?>" <?php selected($key['slug']); ?>> <?php esc_html_e($key["name"], 'get-a-quote'); ?></option>
                <?php
            }
            ?>
            </select>
            <?php
        }
    }
    ?>
    <div class="active-front-form mwb_gaq__form--group">
    </div>
    <button type="submit" name="qsubmit" id="form_submit">Submit</button>
</form>

