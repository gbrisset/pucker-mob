<section id="sidebar-newsletter-cont">
	<h2>Sign Up For Our Newsletter</h2>

	<form id="newsletter-form" name="newsletter-form" action="" method="POST">
		<fieldset id="firstname">
			<label for="fname"><span>*</span></label>
			<input type="text" name="fname" id="fname" placeholder="First Name" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>" />
		</fieldset>

		<fieldset id="lastname">
			<label for="lname">Last Name:</label>
			<input type="text" name="lname" id="lname" placeholder="Last Name" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>" />
		</fieldset>

		<fieldset id="email">
			<label for="emailinput"><span>*</span></label>
			<input type="text" name="emailinput" id="emailinput" placeholder="Email Address" value="<?php if(isset($_POST['emailinput'])) echo $_POST['emailinput']; ?>" />
			<input type="submit" name="newslettersubmit" id="newslettersubmit" value="Go" />
		</fieldset>
	</form>

	<p id="result" <?php if(isset($newsLetterStatus)) echo ($newsLetterStatus) ? 'class="success"' : 'class="error"'; ?>><?php if(isset($newsLetterStatusMsg)) echo $newsLetterStatusMsg; ?></p>
</section>