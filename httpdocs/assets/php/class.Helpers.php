<?php
/**
   * Helpers
   * Manage Different Functionalities
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class Helpers extends DatabaseObject{
	
	public  function sendEmailToBloggers( $data ){
		$blogger_email = $data['email_add'];
		$email_body = $data['email_msg'];
		$blogger_name = 'Bloggers!';
		$to = '';

		//EMAIL ALL USERS 
		if($blogger_email == "0" ){
			$userObj = new User();
			$users_list = $userObj->all();

			foreach( $users_list as $user){
				$to .= $user->user_email.', ';
			}
		}else{
			$user = new User($blogger_email);
			$to = $blogger_email;
			$blogger_name = $user->contributor->data->contributor_name;
		}
		
		//$to  = 'fguzman@sequelmediainternational.com';

		// SUBJECT
		$subject = 'A message from Puckermob Staff';

		//DETECT THE ENTERS INSERTED IN THE TEXTAREA AND REPLACE WITH <p> tags
		$message = explode(PHP_EOL, $email_body);
		$email_message = '';
		foreach($message as $msg){
			$email_message .= '<p style="font-size: 16px; line-height: 1.5; margin-bottom: 10px;">'.$msg.'</p>';
		}

		// MESSAGE
		$message = '<body alink="#ffffff" bgcolor="#FFFFFF" link="#ffffff" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333333;">
			<table cellpadding="0" cellspacing="0" border="0" width="650" align="center" style="background-color: #157910;">
				<tbody>
				<tr>
					<td style="background-color:#ffffff;padding: 5px 0;margin-bottom: 0;padding-bottom: 0;">
						<img align="right" border="0" src="http://www.puckermob.com/assets/img/internal-mail-image.jpg" style=" width: 100%" />
					</td>
				</tr>
				<tr>
					<td width="200" style="background: #fff;padding: 10px;border: 1px solid green;border-top: none;">
						<div style="text-align: center;">
							<h2>PUCKER<span style="color: green;">MOB</span></h2>
						</div>
						<div>
							<p style="font-size: 18px; line-height: 1.5; font-weight: bold;">Hi '. $blogger_name.'</p>
						</div>
						<div>
							'.$email_message.'
							<br>
						</div>				
					</td>
				</tr>
				<tr style=" background: #ddd;">
					<td width="200" style="background-color:#ffffff;padding: 10px;color: #fff;border: 1px solid green;background: green;">
						<div style="text-align: center;">
							<p style="text-align:right; margin:0" ><a style="color: #ddd; font-size: 12px; cursor: pointer;" href="http://www.puckermob.com/admin" target="blank">LOGIN</a></p>
						</div>	
					</td>
				</tr>
				</tbody>
			</table>
		</body>';

		return $this->sendEmail($blogger_name, $to, $subject, $message );

	}

	public function sendEmail($name, $email, $subject, $message){
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$name.' <'.$email.'>' . "\r\n";
		$headers .= 'From: Puckermob Staff <mpinedo@sequelmediainternational.com>' . "\r\n";


		// Mail it
		if( mail($email, $subject, $message, $headers) ){
			return array('hasError' => false, 'message'=>'Your message was sent successfully');
		}
		return array('hasError' => true, 'message'=>'There was an error sending your email...');

	}
} ?>