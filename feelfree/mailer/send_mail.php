<?php
    function send_mail($from, $from_name, $to, $to_name, $subject, $message){
        require_once('PHPMailerAutoload.php');

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mamalek201@gmail.com';
        $mail->Password = 'pjgjpactxwartkol';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($from, $from_name);
        $mail->addAddress($to, $to_name);
        //$mail->addReplyTo($rt, $rt-name);
        //$mail->addCC($cc);
        //$mail->addBCC($bcc);

        //$mail->addAttachment('source', 'name with extension');
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $message;
        
        if(!$mail->send()){
            return false;
        } else{
            return true;
        }
    }