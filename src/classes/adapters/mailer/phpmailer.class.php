<?php
/**
* @package janitor.shop
*/


require_once("includes/mailer/PHPMailer-5.2.26/PHPMailerAutoload.php");


class JanitorPHPMailer {


	// Mailer settings
	private $mail_host;
	private $mail_port;
	private $mail_username;
	private $mail_password;
	private $mail_smtpauth;
	private $mail_secure;

	/**
	*
	*/
	function __construct($_settings) {

		// Store SMTP connection info
		$this->host = isset($_settings["host"]) ? $_settings["host"] : "";
		$this->username = isset($_settings["username"]) ? $_settings["username"] : "";
		$this->password = isset($_settings["password"]) ? $_settings["password"] : "";
		$this->port = isset($_settings["port"]) ? $_settings["port"] : "";
		$this->secure = isset($_settings["secure"]) ? $_settings["secure"] : "";
		$this->smtpauth = isset($_settings["smtpauth"]) ? $_settings["smtpauth"] : "";	

		$this->mailer             = new PHPMailer();

		// enables SMTP debug information (for testing)
//		$this->mailer->SMTPDebug  = 1;

		$this->mailer->CharSet    = "UTF-8";
		$this->mailer->IsSMTP();


		$this->mailer->SMTPAuth   = $this->smtpauth;
		$this->mailer->SMTPSecure = $this->secure;
		$this->mailer->Host       = $this->host;
		$this->mailer->Port       = $this->port;
		$this->mailer->Username   = $this->username;
		$this->mailer->Password   = $this->password;

	}


	function send($_options) {


		$this->mailer->clearAllRecipients();
		$this->mailer->clearAttachments();
		$this->mailer->clearReplyTos();


		$subject = false;
		$text = false;
		$html = false;

		$from_name = false;
		$from_email = false;
		$recipients = false;

		$attachments = false;


		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "subject"                : $subject                = $_value; break;
					case "text"                   : $text                   = $_value; break;
					case "html"                   : $html                   = $_value; break;

					case "from_name"              : $from_name              = $_value; break;
					case "from_email"             : $from_email             = $_value; break;
					case "recipients"             : $recipients             = $_value; break;

					case "attachments"            : $attachments            = $_value; break;

				}
			}
		}


		$this->mailer->Subject    = $subject;


		$this->mailer->addReplyTo($from_email, $from_name);
		$this->mailer->SetFrom($from_email, $from_name);


		foreach($recipients as $recipient) {
			$this->mailer->AddAddress($recipient);
		}


		if($html) {
			$this->mailer->IsHTML(true);
			$this->mailer->Body = $html;
		}
		else {
			$this->mailer->IsHTML(false);
			$this->mailer->Body = $text;
		}


		// Attachments
		if($attachments) {
			if(is_array($attachments)) {
				foreach($attachments as $attachment) {
					$this->mailer->addAttachment($attachment, basename($attachment));
				}
			}
			else {
				$this->mailer->addAttachment($attachments, basename($attachments));
			}
		}

		return $this->mailer->Send();

	}
	
	
	function sendBulk($_options) {

		$subject = false;
		$text = false;
		$html = false;

		$from_name = false;
		$from_email = false;
		$recipients = false;
		$recipient_values = [];

		$attachments = false;


		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "subject"                : $subject                = $_value; break;
					case "text"                   : $text                   = $_value; break;
					case "html"                   : $html                   = $_value; break;

					case "from_name"              : $from_name              = $_value; break;
					case "from_email"             : $from_email             = $_value; break;
					case "recipients"             : $recipients             = $_value; break;
					case "values"                 : $recipient_values       = $_value; break;

					case "attachments"            : $attachments            = $_value; break;

				}
			}
		}

		print "recipient values:<br>\n";
		print_r($recipient_values);


		foreach($recipients as $recipient) {

			$user_html = $html;
			$user_text = $text;
			$user_subject = $subject;

			if(isset($recipient_values[$recipient])) {

				// Replace values
				foreach($recipient_values[$recipient] as $key => $value) {
					$user_html = preg_replace("/{".$key."}/", $value, $user_html);
					$user_text = preg_replace("/{".$key."}/", $value, $user_text);
					$user_subject = preg_replace("/{".$key."}/", $value, $user_subject);
				}

			}

			$this->send([
//			return $mailer->send([
				"subject" => $user_subject,


				"from_name" => $from_name,
				"from_email" => $from_email,
				"recipients" => [$recipient],

				"attachments" => $attachments,
				
				"html" => $user_html,
				"text" => $user_text,
			]);


		}

		return true;

	}

}