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

global $p_id;
$p_id = '';
if ( isset( $_POST['qsubmit'] ) ) {
    if ( isset( $_POST['gaq_public_form_nonce'] ) ) {
        check_admin_referer( 'gaq_public_form', 'gaq_public_form_nonce' );
        $mwb_gaq_form_fields_option = get_option( 'mwb_gaq_form_fields_options', $this->gaq_helper->enabling_default_value( 'form_fields' ) );

        unset( $_POST['qsubmit'] );

        $mwb_gaq_form_data = array();

        $mwb_gaq_form_data['ffname'] = isset( $_POST['ffname'] ) ? sanitize_text_field( wp_unslash( $_POST['ffname'] ) ) : '';

        $mwb_gaq_form_data['fqlname'] = isset( $_POST['fqlname'] ) ? sanitize_text_field( wp_unslash( $_POST['fqlname'] ) ) : '';

        $mwb_gaq_form_data['fqaddress'] = isset( $_POST['fqaddress'] ) ? sanitize_text_field( wp_unslash( $_POST['fqaddress'] ) ) : '';

        $mwb_gaq_form_data['fqcity'] = isset( $_POST['fqcity'] ) ? sanitize_text_field( wp_unslash( $_POST['fqcity'] ) ) : '';

        $mwb_gaq_form_data['fqzipcode'] = isset( $_POST['fqzipcode'] ) ? sanitize_text_field( wp_unslash( $_POST['fqzipcode'] ) ) : '';

        $mwb_gaq_form_data['fqcountry'] = isset( $_POST['fqcountry'] ) ? sanitize_text_field( wp_unslash( $_POST['fqcountry'] ) ) : '';

        $mwb_gaq_form_data['fqstates'] = isset( $_POST['fqstates'] ) ? sanitize_text_field( wp_unslash( $_POST['fqstates'] ) ) : '';

        $mwb_gaq_form_data['fqemail'] = isset( $_POST['fqemail'] ) ? sanitize_email( wp_unslash( $_POST['fqemail'] ) ) : '';

        $mwb_gaq_form_data['fqphone'] = isset( $_POST['fqphone'] ) ? sanitize_text_field( wp_unslash( $_POST['fqphone'] ) ) : '';

        $mwb_gaq_form_data['fqbudget'] = isset( $_POST['fqbudget'] ) ? sanitize_text_field( wp_unslash( $_POST['fqbudget'] ) ) : '';

        $mwb_gaq_form_data['fqadd'] = isset( $_POST['fqadd'] ) ? sanitize_textarea_field( wp_unslash( $_POST['fqadd'] ) ) : '';

        $mwb_gaq_form_data['taxonomy_for_service'] = isset( $_POST['taxonomy_for_service'] ) ? sanitize_text_field( wp_unslash( $_POST['taxonomy_for_service'] ) ) : '';

        $mwb_gaq_form_data['taxonomy_for_status'] = 'Pending';

        if ( ! empty( $mwb_gaq_form_data['ffname'] ) && ! empty( $mwb_gaq_form_data['taxonomy_for_service'] ) && ! empty( $mwb_gaq_form_data['fqlname'] ) && ! empty( $mwb_gaq_form_data['fqemail'] ) ) {
            $my_post_details = array(
                'post_title'  => $mwb_gaq_form_data['ffname'],
                'post_type'   => 'quotes',
                'post_status' => 'publish',
            );
            wp_insert_post( $my_post_details );
            $p_id = $this->gaq_helper->recent_post_id();
            if ( isset( $_FILES['fqfiles']['name'] ) ) {
                $err        = array();
                $file_name  = isset( $_FILES['fqfiles']['name'] ) ? sanitize_textarea_field( wp_unslash( $_FILES['fqfiles']['name'] ) ) : '';
                $file_tmp   = isset( $_FILES['fqfiles']['tmp_name'] ) ? sanitize_textarea_field( wp_unslash( $_FILES['fqfiles']['tmp_name'] ) ) : '';
                $file_type  = isset( $_FILES['fqfiles']['type'] ) ? sanitize_textarea_field( wp_unslash( $_FILES['fqfiles']['type'] ) ) : '';
                $file_ext   = wp_check_filetype( basename( $file_name ), null );
                $extensions = array( 'png', 'jpeg', 'jpg' );

                if ( ! empty( $file_ext['ext'] ) ) {
                    if ( in_array( $file_ext, $extensions, true ) ) {
                        $err[] = 'extension not allowed, please choose a pdf or docx file.';
                    }
                }
                $log_dir = ABSPATH . 'wp-content/uploads/quote-submission';
                if ( ! is_dir( $log_dir ) ) {

                    mkdir( $log_dir, 0755, true );
                }

                if ( empty( $err ) ) {

                    $mwb_gaq_form_data['fqfilename'] = 'quote_' . $p_id . '.' . $file_ext['ext'];
                    $file_add                        = $log_dir . '/' . $mwb_gaq_form_data['fqfilename'];
                    move_uploaded_file( $file_tmp, $file_add );
                    if ( ! empty( $file_add ) ) {
                        $this->gaq_helper->create_attachment( $p_id, $file_add );
                        esc_html_e( 'Success', 'GAQ_TEXT_DOMAIN' );
                    }
                } else {
                    $err = sprintf( '<div class="notice-fail is-dismissible"><p><strong>%s</strong></p></div>', $err );
                    echo esc_html( $err );
                }
            }
            update_post_meta( $p_id, 'quotes_meta', $mwb_gaq_form_data );
            $this->gaq_helper->set_taxonomy( $p_id );

            if ( is_admin() ) {
                return;
            }
            $email_activator = get_option( 'mwb_gaq_activate_email' );
            if ( 'on' === $email_activator ) {
                $mail = $this->gaq_helper->email_sending( $p_id );
            }
            ?>
            </ul>
            <div class="notice notice-success is-dismissible">
                <p><strong><?php esc_html_e( 'Thank you', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="notice-fail is-dismissible">
            <p><strong><?php esc_html_e( 'Issue in required Fields', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
        </div>
        <?php
    }
}

$mwb_gaq_form_fields_option = get_option( 'mwb_gaq_form_fields_options', $this->gaq_helper->enabling_default_value( 'form_fields' ) );
$mwb_gaq_enable_form        = get_option( 'mwb_gaq_form_enable', 'on' );
if ( 'on' === $mwb_gaq_enable_form ) {
    $recent_id_post = $this->gaq_helper->recent_post_id();
            $fqfile = isset( $mwb_gaq_form_values['fqfile'] ) ? $mwb_gaq_form_values['fqfile'] : '';
    ?>
    <br />
    <form action="" class="active-from" method="POST" enctype="multipart/form-data">
    <?php wp_nonce_field( 'gaq_public_form', 'gaq_public_form_nonce' );?>
        <div class="active-front-form">
        </div>
        <input type="submit" id="form_submit" name="qsubmit" value="Submit">
    </form>

    <?php
}
