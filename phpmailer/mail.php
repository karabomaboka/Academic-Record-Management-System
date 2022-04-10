<?php
function sendOTP($email,$otp) 
{
		require 'phpmailer/PHPMailerAutoload.php';
		require('phpmailer/class.phpmailer.php');
		require('phpmailer/class.smtp.php');
	
		$message_body = "<br>Hi there!<br/>Your One Time Password for registration is:<br/><strong><h2>". $otp."</h2></strong><br/>Please don't share your otp with anyone. If this wasn’t you, please ignore this message.</strong>";
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Mailer   = "smtp";
		$mail->Host     = "smtp.gmail.com";
		$mail->Port     = 587;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'tls'; // tls or ssl

		$mail->Username = "";  // enter email address from which you want to send otp to user
 		$mail->Password = "";  	// enter password here for the email-id provided
 
		$mail->SMTPDebug = 0;
		$mail->SetFrom("noreply", "Admin@");
		$mail->AddAddress($email); //email of receiver
		
		$mail->IsHTML(true);
		$mail->Subject = "Verify email- OTP";
		$mail->MsgHTML($message_body);
		if(!$mail->Send())
			{
				return 0;
			}
		else
		{
			return 1;
		}	
}
?>