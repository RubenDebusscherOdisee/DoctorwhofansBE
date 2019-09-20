<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $mailToReply = $_POST['emailToReply'];
        $message = $_POST['message'];
        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message)OR empty($subject)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
       }
        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "contact@doctorwhofans.be";
        // Set the email subject.
        $subject = $subject;
        // Build the email content.
        //$email_content = "Name: $name\n";
        //$email_content .= "Reply to:\n$mailToReply\n";
        //$email_content .= "Message:\n$message\n";
        $email_content="<!DOCTYPE HTML><html> <head> <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/> <title>Mail</title> <meta name='viewport' content='width=device-width, initial-scale=1.0'/> </head> <body> <table border='0' cellpadding='0' cellspacing='0' width='100%'> <tr> <td> <table align='center' border='0' cellpadding='0' cellspacing='0' width='80%' style='border-c0llapse: collapse;'> <tr> <td align='center' bgcolor='#000090' style='padding: 40px 0 30px 0;'> <img src='https://www.doctorwhofans.be/images/gallifreyan.png' alt='Creating Email Magic' width='20%' style='display: block;'/> </td></tr><tr> <td bgcolor='#ffffff' style='padding: 2% 5% 2% 5%;'> <table border='0' cellpadding='0' cellspacing='0' width='100%'> <tr> <td style='padding: 20px 0 30px 0;'id='subject'> From: $name\n  $mailToReply\n </td></tr><tr> <td style='padding: 20px 0 30px 0;'id='subject'> Subject: \n$subject\n </td></tr><tr> <td id='content'> \n$message\n </td></tr></table> </td></tr><tr> <td bgcolor='#ee4c50' style='padding: 2% 5% 2% 5%;'> <table border='0' cellpadding='0' cellspacing='0' width='100%'> <tr> <td width='75%'> &reg; DoctorWhoFans.be 2019<br/> </td><td align='right'> <table border='0' cellpadding='0' cellspacing='0'> <tr> </tr></table> </td></tr></table> </td></tr></table> </td></tr></table> </body></html>";



        // Build the email headers.
        $email_headers = "From: $mailToReply\r\n";
        $headers .= "Reply-To: $mailToReply\r\n";
        $headers .= "BCC: contact@doctorwhofans.be\r\n";
        $email_headers .= "MIME-Version: 1.0\r\n";
        $email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }
    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
?>