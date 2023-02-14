<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendors/PHPMailer-master/src/Exception.php';
require 'vendors/PHPMailer-master/src/PHPMailer.php';
require 'vendors/PHPMailer-master/src/SMTP.php';

//pre-define vars
$errors = array();
$name = '';
$email = '';
$message = '';

//process the contact form if it was submitted
if (isset($_POST['did_submit'])) {
    //sanitize everything
    $name = clean_string($_POST['fname']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = clean_string($_POST['message']);
    
    //validate
    $valid = true;
    //name is blank
    if ($name == '') {
        $valid = false;
        $errors['name'] = 'Name is required.';
    }
    //name is too long
    if(strlen($name) > 50){
        $valid = false;
        $errors['name'] = 'Name is too long.';
    }
    //email is invalid
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $valid = false;
        $errors['email'] = 'Invalid Email.';
    }


    //instantiate the mailer
    $mailer = new PHPMailer(true);

    //if valid, send the message
    if ($valid) {
        $body = "<p>Name: $name </p>";
        $body .= "<p>Email: $email </p>";
        $body .= "<p>Message: $message </p>";

        //configure and send the mail
        try{
            //set up to to, from, and the message body. The body doesn't have to be HTML
            $mailer->Sender = $email;
            $mailer->AddReplyTo($email, $name);
            $mailer->SetFrom($email, $name);
            $mailer->AddAddress(GMAIL_EMAIL);
            $mailer->Subject = 'Psyechedelia Brittania - Customer Service Request';
            $mailer->MsgHTML($body);

            //Set up our connection information
            $mailer->IsSMTP();
            //show report when down
            $mailer->SMTPDebut = DEBUG_MODE;
            $mailer->SMTPAuth = true;
            $mailer->SMTPSecure = 'ssl';
            $mailer->Port = 465;
            $mailer->Host = 'smtp.gmail.com';
            //username to use for smtp authentication - use full email address for gmail
            $mailer->Username = GMAIL_EMAIL;
            //password for gmail account
            $mailer->Password = GMAIL_PASSWORD;

            //All done. send the mail and make sure it worked
            if ($mailer->Send()) {
                $feedback = 'Thank you for your submission. We will be in touch shortly!';
                $feedback_class = 'success';
            } 
        }catch(phpmailerException $e){
            //php mailer exception
            $feedback = 'Sorry, the server could not send your message at this time.';
            $feedback_class = 'error';
            $errors[] = $e-errorMessage();
        }catch(Exception $e){
            $feedback = 'The mail could not send. Try again later';
            $feedback_class = 'error';
            $errors[] = $e->getMessage();
        }//end try catch for mailer
        
    } else {
        //not valid
        $feedback = 'Please fix the following:';
        $feedback_class = 'error';
    }
}
