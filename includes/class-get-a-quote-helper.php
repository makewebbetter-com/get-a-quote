<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin
 * @author     Make Web Better <plugins@makewebbetter.com>
 */
class Get_A_Quote_Helper {

    /**
     * The single instance of the class.
     *
     * @since   1.0.0
     * @var GAQCountryManager   The single instance of the GAQCountryManager
     */
    protected static $instance = null;

    /**
     * Main Get_A_Quote_Helper Instance.
     *
     * Ensures only one instance of Get_A_Quote_Helper is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return Get_A_Quote_Helper - Main instance.
     */
    public static function get_instance() {

        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Enabling_default_value
     * Return default setting values.
     *
     * @param  array $option provides the list of the fields which accepts default values.
     * @since 1.0.0
     * @return array  $result selected options.
     */
    public function enabling_default_value($option) {
        switch ($option) {

            case 'enable':
                $result = 'on';
                break;

            case 'taxonomy':
                $result = array(
                    'select_for_services' => 'yes',
                    'select_for_status'   => 'yes',
                );
                break;

            case 'form_fields':
                $result = array(
                    'select_for_fname_field'      => 'yes',
                    'select_for_lname_field'      => 'yes',
                    'select_for_address_field'    => 'yes',
                    'select_for_city_field'       => 'yes',
                    'select_for_zipcode_field'    => 'yes',
                    'select_for_country_field'    => 'yes',
                    'select_for_states_field'     => 'yes',
                    'select_for_email_field'      => 'yes',
                    'select_for_phone_field'      => 'yes',
                    'select_for_budget_field'     => 'yes',
                    'select_for_additional_field' => 'yes',
                    'select_for_fileup_field'     => 'yes',
                );
                break;
        }
        return $result;
    }

    /**
     * Return helper tip html.
     *
     * @param  string $message provides the message to be displayed in helpertip.
     * @since 1.0.0
     */
    public function helpertip($message = '') {
        if (! empty($message)) {
            echo '<span class="wp-tooltiptext">' . esc_html($message) . '</span>';
        }
    }

    /**
     * Create_attachment
     *
     * @param  string $file_add should be the path to a file in the upload directory.
     * @param  string $p_id he ID of the post this attachment is for.
     * @return void
     */
    public function create_attachment($p_id, $file_add) {

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype(basename($file_add), null);

        // Get the path to the upload directory.
        $upload_dir = wp_upload_dir();

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $upload_dir['url'] . '/' . basename($file_add),
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_add)),
            'post_content'   => '',
            'post_status'    => 'inherit',
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment($attachment, $file_add, $p_id);

        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata($attach_id, $file_add);

        wp_update_attachment_metadata($attach_id, $attach_data);

        set_post_thumbnail($p_id, $attach_id);
    }
    /**
     * Return all quote saved data.
     *
     * @param string $post_id of the post to fetch meta data.
     * @since 1.0.0
     * @return array $post_details Submission data.
     */
    public function detailed_post_array($post_id) {
        $post_details = get_post_meta($post_id, 'quotes_meta', true);
        return $post_details;
    }

    /**
     * Return all quote saved data.
     *
     * @since 1.0.0
     * @return array  $recent_post_id Submission data.
     */
    public function recent_post_id() {
        $recent_posts = get_posts(
            array(
                'fields'    => 'ids',
                'post_type' => 'quotes',
            )
        );
        if (! empty($recent_posts)) {
            $recent_post_id = $recent_posts[0];
            return $recent_post_id;
        }
    }

    /**
     * Set_taxonomy it sets the value of the taxo term.
     *
     * @param  string $id provides the id of the post.
     * @since 1.0.0
     */
    public function set_taxonomy($id)
    {
        $service = $this->detailed_post_array($id);
        if (! empty($service['taxo_service'])) {
            $service_id = term_exists($service['taxo_service']);
            wp_set_object_terms($id, intval($service_id), 'service');
        }
        
        if (! empty($service['status_taxo'])) {
            $status_id = term_exists($service['status_taxo']);
            wp_set_object_terms($id, intval($status_id), 'status');
        }
    }

    /**
     * Get_taxonomy it gets the value of the taxo term.
     *
     * @param  string $taxoname provides the name of the taxonomy.
     * @since 1.0.0
     */
    public function get_taxonomy($taxoname)
    {
        if (isset($_POST['tax_input'])) {
            $term_id = '';
            $tax = $_POST['tax_input'];
            foreach ($tax[$taxoname] as $key => $value) {
                if ($value != 0) {
                    $term_id = $value;
                }
            }
            $term = get_term_by('id', $term_id, $taxoname);
            if( isset( $term->name)){
                return $term->name;
            }
        }
    }

    /**
     * Email_sending
     *
     * @param string $post_id it provides the post id to send the mail.
     * @since 1.0.0
     * @return array  $post_detail Submission data.
     */
    public function email_sending($post_id) {

        $options = get_option('mwb_gaq_email_fields_data');
        $sender  = ! empty($options['sender_email']) ? $options['sender_email'] : get_bloginfo('admin_email');
        $details = $this->detailed_post_array($post_id);
        $message = ! empty($options['emailmess']) ? $options['emailmess'] : 'Thank for using our service we will be get back to you soon. ';
        $headers = 'From: ' . $sender . "\r\n" .
            'Reply-To: ' . $sender . "\r\n";
        $subject = ! empty($options['email_subject']) ? $options['email_subject'] : 'Quotation Submitted';
        $send_to = $details['fqemail'];
        $sent    = wp_mail($send_to, $subject, wp_strip_all_tags($message), wp_strip_all_tags($headers));
        $value   = (1 === 1) ? 'Mail Sent' : 'Mail not Send';
        return $value;
    }

    /**
     * Add default Terms.
     *
     * @param  array  $args provides the agruments array for setting term.
     * @param string $type provides the custom taxonomy name.
     * @since    1.0.0
     */
    public function insert_default_quote_taxonomies($args = array(), $type = 'service') {

        if (! empty($args) && is_array($args)) {
            foreach ($args as $key => $value) {
                try {
                    $_terms =
                    array(
                        'description' => $value['description'],
                    );
                    wp_insert_term($value['label'], $type, $_terms);
                } catch (\Throwable $th) {
                    // Add issues to a logger class later.
                    echo esc_html($th->getMessage());
                }
            }
        }
    }
    // End of class.
}
