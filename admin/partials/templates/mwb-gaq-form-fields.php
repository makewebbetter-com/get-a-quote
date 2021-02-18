<?php
?>
<div class="mwb_form_fields">
    <table>
        <tr>
            <th><?php esc_html_e('Form Name', 'GAQ_TEXT_DOMAIN'); ?></th>
            <th><?php esc_html_e('Shortcode', 'GAQ_TEXT_DOMAIN'); ?></th>
            <th><?php esc_html_e('Operation', 'GAQ_TEXT_DOMAIN'); ?></th>
        </tr>
        <tr>
            <td><?php esc_html_e('Contact Form', 'GAQ_TEXT_DOMAIN'); ?></td>
            <td><input type="" id="copytoclipTxt" value="[gaq_form_fields]"/></td>
            <td><a href="?page=gaq-config&tab=form-fields&form_action=edit" class="edit-form"><?php esc_html_e('Edit', 'GAQ_TEXT_DOMAIN'); ?></a></td>
        </tr>
    </table>
</div>
<style>
    input {
    border : none;
    }
    table { 
        border-collapse: collapse; 
    }
    th { 
        background-color:#FA7820; 
        Color:black; 
    }
    th, td { 
        width:150px; 
        text-align:center; 
        border:1px solid black; 
        padding:5px 
    }
</style> 
