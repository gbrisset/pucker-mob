<?php
/**
   * Helpers
   * Manage Different Functionalities
   * 
   * @package    DatabaseObject
   * @author     Flor Guzman <fguzman@sequelmediainternational.com>
**/

class Helpers extends DatabaseObject{

	
	public  function sendEmail( $data ){
		//	Set the params to be bound
		// multiple recipients
		$to  = 'fguzman@sequelmediainternational.com'; // note the comma

		// subject
		$subject = 'A message from Puckermob Staff';

		// message
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
							<div style="text-align: center;"><h2>PUCKER<span style="color: green;">MOB</span></h2></div>
							<div>
								Hi {BLOGGER_NAME},<br>
							</div>
							<div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
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
			</body>	';

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			$headers .= 'To: Flor <fguzman@sequelmediainternational.com>' . "\r\n";
			$headers .= 'From: Puckermob Staff <mpinedo@sequelmediainternational.com>' . "\r\n";


			// Mail it
			if( mail($to, $subject, $message, $headers) ){
				return array('hasError' => false 'message'=>'Your message was sent successfully');
			}
			return array('hasError' => true, 'message'=>'There was an error sending your email...');

		}
} ?>