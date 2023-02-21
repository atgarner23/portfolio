<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//use PHPMailer\PHPMailer\OAuth;
//Alias the League Google OAuth2 provider class
//use League\OAuth2\Client\Provider\Google;


require_once './vendor/autoload.php';
// require 'vendor/PHPMailer-master/src/Exception.php';
// require 'vendor/PHPMailer-master/src/PHPMailer.php';
// require 'vendor/PHPMailer-master/src/SMTP.php';

//pre-define vars
$errors = array();
$name = '';
$email = '';
$message = '';

//process the contact form if it was submitted
if (isset($_POST['did_submit'])) {
    //sanitize everything
    $name = clean_string($_POST['name']);
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
            $mailer->Subject = 'Portfolio Inquiry';
            $mailer->MsgHTML($body);

            //Set up our connection information
            // $mailer->IsSMTP();
            //show report when down
            // $mailer->SMTPDebut = DEBUG_MODE;
            // $mailer->SMTPAuth = true;
            // $mailer->AuthType = 'XOAUTH2';
            // $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            // $mailer->Port = 465;
            // $mailer->Host = 'smtp.gmail.com';

            $mailer->isSMTP();
$mailer->Host = 'smtp.gmail.com';  //gmail SMTP server
$mailer->SMTPAuth = true;
//to view proper logging details for success and error messages
// $mail->SMTPDebug = 1;
$mailer->Host = 'smtp.gmail.com';  //gmail SMTP server
$mailer->Username = GMAIL_EMAIL;   //email
$mailer->Password = GMAIL_PASSWORD ;   //16 character obtained from app password created
$mailer->Port = 465;                    //SMTP port
$mailer->SMTPSecure = "ssl";

            //XOAUTH
            // $email = 'atgarner23@gmail.com';
            // $clientId = '450607044956-voc6k8qnv7l5plj944qsqgr5si5v57md.apps.googleusercontent.com';
            // $clientSecret = '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';
            // $refreshToken = '';
            // $provider = new Google([
            //     'clientId' => $clientId,
            //     'clientSecret' => $clientSecret,
            // ]);

            // $mailer->setOAuth(
            //     new OAuth(
            //         [
            //             'provider' => $provider,
            //             'clientId' => $clientId,
            //             'refreshToken' => $refreshToken,
            //             'userName' => $email,
            //             'clientSecret' => $clientSecret,
            //             'userName' => $email,
            //         ]
            //     )
            //         );
            //username to use for smtp authentication - use full email address for gmail
            //$mailer->Username = GMAIL_EMAIL;
            //password for gmail account
            //$mailer->Password = ;

            //All done. send the mail and make sure it worked
            if ($mailer->Send()) {
                $feedback = 'Thank you for your submission. We will be in touch shortly!';
                $feedback_class = 'alert-success';
            } 
        }catch(phpmailerException $e){
            //php mailer exception
            $feedback = 'Sorry, the server could not send your message at this time.';
            $feedback_class = 'alert-error';
            $errors[] = $e-errorMessage();
        }catch(Exception $e){
            $feedback = 'The mail could not send. Try again later';
            $feedback_class = 'alert-error';
            $errors[] = $e->getMessage();
        }//end try catch for mailer
        
    } else {
        //not valid
        $feedback = 'Please fix the following:';
        $feedback_class = 'alert-error';
    }
}
