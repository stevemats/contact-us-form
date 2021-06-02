<?php
/*
Plugin Name: contact-us
Plugin URI: https://github.com/stevemats/contact-us-form
Description: Simple WordPress Contact Form entirely for the purpose of learning wp.
Version: 1.0
Author: Steve Matindi
Author URI: https://github.com/stevemats/
*/

function contact_html() {
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo 'Your Name (required) <br/>';
    echo '<input type="text" name="ft-name" pattern="[a-zA-Z0-9]+" value="' . ( isset( $_POST["ft-name"] ) ? esc_attr( $_POST["ft-name"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Email (required) <br/>';
    echo '<input type="email" name="ft-email" value="' . ( isset( $_POST["ft-email"] ) ? esc_attr( $_POST["ft-email"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Subject (required) <br/>';
    echo '<input type="text" name="ft-subject" pattern="[a-zA-Z]+" value="' . ( isset( $_POST["ft-subject"] ) ? esc_attr( $_POST["ft-subject"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Message (required) <br/>';
    echo '<textarea rows="10" cols="35" name="ft-message">' . ( isset( $_POST["ft-message"] ) ? esc_attr( $_POST["ft-message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="ft-submit" value="Send"></p>';
    echo '</form>';
}

function deliver_mail() {

    // if the submit button is clicked, send the email
    if ( isset( $_POST['ft-submit'] ) ) {

        // sanitize form values
        $name = sanitize_text_field( $_POST["ft-name"] );
        $email = sanitize_email( $_POST["ft-email"] );
        $subject = sanitize_text_field( $_POST["ft-subject"] );
        $message = esc_textarea( $_POST["ft-message"] );

        // get the blog administrator's email address
        $to = get_option( 'admin_email' );

        $headers = "From: $name <$email>" . "\r\n";

        // If email has been process for sending, display a success message
        if ( wp_mail( $to, $subject, $message, $headers ) ) {
            echo '<div>';
            echo '<p>Thank you for contacting us, someone will be getting intouch with you shortly</p>';
            echo '</div>';
        } else {
            echo 'An unexpected error occurred';
        }
    }
}

function cu_shortcode() {
    ob_start();
    deliver_mail();
    html_form_code();

    return ob_get_clean();
}

add_shortcode( 'contact', 'cu_shortcode' );

?>