<?php

	function SendConfirmationEmail( $mail, $Game )
    {
    	$mailer = new PHPMailer();
		$mailer->AddReplyTo( "noreply@whatwouldmolydeux.com", "MolyJam 2012" );
		$mailer->SetFrom( "noreply@whatwouldmolydeux.com", "MolyJam 2012" );
		$mailer->AddAddress( $mail );
		$mailer->Subject    = "MolyGame 2012 Game Submission";
		
		$text = "Dear MolyJamer,<br />
<br />
Thank you for sharing your project!<br />
<br />
Below is a link to allow you to edit your entry, this link will only work for 24 hours, after which your game will be stored forever in carbonite.<br />
<br />
http://www.whatwouldmolydeux.com/submit.php?EditID=" . $Game->EditID . "<br />
<br />
Sincerely,<br />
<br />
The Molyjam Organizer Collective.<br />";
		$mailer->MsgHTML( $text );
		$mailer->Send();
   	}
?>