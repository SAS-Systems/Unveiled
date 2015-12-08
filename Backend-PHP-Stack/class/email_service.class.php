<?php

/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 08.12.15
 * Time: 19:20
 */
class EmailService
{

    public static function sendEmailVerification($username, $email, $emailToken)
    {
        global $gvEmailVerificationLink, $gvMailerSMTPserver, $gvMailerUser, $gvMailerPassword, $gvMailerEmail, $gvMailerNameFrom;

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $gvMailerSMTPserver;
        $mail->SMTPAuth = true;
        $mail->Username = $gvMailerUser;
        $mail->Password = $gvMailerPassword;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($gvMailerEmail, $gvMailerNameFrom);
        $mail->addAddress($email);
        $mail->addReplyTo($gvMailerEmail, $gvMailerNameFrom);

        $mail->isHTML(true);

        $mail->Subject = 'Email Verification';
        $mail->Body = 'Hallo ' . $username .
            '</br></br> Bitte bestätige deine Email-Adresse um die Anmeldung abzuschließen. </br>'.
            'Klicke dazu einfach auf den Link: <a href="' . $gvEmailVerificationLink . '?emailtoken=' . $emailToken. '">Bestätigungslink</a> </br></br>'.
            'Viele Grüße</br>Unveiled-Team';
        $mail->AltBody = 'Hallo ' . $username . ' Bitte bestätige deine Email-Adresse um die Anmeldung abzuschließen. Klicke dazu einfach auf den Link: ' . $gvEmailVerificationLink . '?emailtoken=' . $emailToken.
            'Viele Grüße Unveiled-Team';

        if (!$mail->send()) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Message has been sent';
        }
    }

    public static function isValid($email)
    {

        return true;
    }

}