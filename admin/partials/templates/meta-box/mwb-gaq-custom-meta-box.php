<?php
$details = $this->gaq_helper->detailed_post_array(get_the_ID());
// echo '<pre>'; print_r( $details ); echo '</pre>'; die();
/* $country = $this->gaq_country_manager->get_country_list();
if (! empty($details['fqcountry'])) {
    foreach ($country as $value => $key) {
        if ($value === $details['fqcountry']) {
            $details['fqcountry'] = $key;
        }
    }
} */
?>
<form action="<?php plugin_dir_url(__FILE__) . 'class-get-a-quote-admin.php'; ?>" method="POST" enctype="multipart/form-data">
    <table class="form-table">
        <tr>
            <th style=' text-align: Center; font-size: 1.5em;color:cadetblue;
            border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2>
                <div><?php esc_html_e('Attributes', 'GAQ_TEXT_DOMAIN'); ?>
                </div>
            </th>
        </tr>
        <tr>
            <?php if (! empty($details['taxo_service'])) { ?>
                <th>
                <?php
                esc_html_e('Service', 'GAQ_TEXT_DOMAIN');
                ?>
               </th>
                <td><input id="fname" type="text" name="taxo_service" value="<?php echo
                        esc_html(! empty($details['taxo_service']) ? $details['taxo_service'] : ''); ?>" readonly>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('First Name', 'GAQ_TEXT_DOMAIN');
            ?>
            <span class="required">*</span></th>
            <td><input id="fname" type="text" name="firstname" required="required"
                    value="<?php echo esc_html(! empty($details['firstname']) ? $details['firstname'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('City', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="city" type="text" name="Cityname"
                    value="<?php echo esc_html(! empty($details['Cityname']) ? $details['Cityname'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('Zipcode', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="code" type="text" name="Zipcode"
                    value="<?php echo esc_html(! empty($details['Zipcode']) ? $details['Zipcode'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('Email', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="email" type="text" name="Email" value="<?php echo esc_html(! empty($details['Email']) ? $details['Email'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('Country', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="country" type="text" name="Country"
                    value="<?php echo esc_html(! empty($details['Country']) ? $details['Country'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('State', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="State" type="text" name="State"
                    value="<?php echo esc_html(! empty($details['State']) ? $details['State'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <th>
            <?php
            esc_html_e('Phone', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="phone" type="text" name="Phone"
                    value="<?php echo esc_html(! empty($details['Phone']) ? $details['Phone'] : ''); ?>">
            </td>
        </tr>
            <th>
            <?php
            esc_html_e('Additional Details', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>
            <td><input id="add" type="text" name="Additional"
                    value="<?php echo esc_html(! empty($details['Additional']) ? $details['Additional'] : ''); ?>">
            </td>
        </tr>
        <?php if ($details['status'] == 'true'){?>
        <tr>
            <th>
            <?php
            esc_html_e('Attached File', 'GAQ_TEXT_DOMAIN');
            ?>
            </th>

            <td>
                <b><span>
                    <?php $file = ! empty($details['filename']) ? $details['filename'] : '';
                    if (! empty($file)) {
                        echo (sprintf('<a href="%s" target="_blank">%s</a>', esc_html($details['filelink']), esc_html__('Open File', 'GAQ_TEXT_DOMAIN')));
                    } else {
                        esc_html_e('No File Selected', 'GAQ_TEXT_DOMAIN');
                    }

                    ?>
                </span></b>
            </td>
        </tr>
        <?php }?>
    </table>
</form>
