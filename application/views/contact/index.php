<div id="global-image">
    <?=$global_image; ?>
</div>
    <?=validation_errors('<div id="error">','</div>'); ?>

<div id="about-us">
    <div id="questions">
		<h2>Question?</h2>
		<p>Whether you have a project in mind or still have unanswered
questions, our team is waiting to hear from you. Please fill out
each of the fields within the provided form, and well contact
you no later than 1 business day.<br /><br />

Please use the form on the right.</p>
	</div>

	<div id="contact-us-form">
        <h2>Contact Us</h2>
		    <?=form_open('en/contact');?>
                <ul id='contact-message-form'>
                    <li><label>Name</label><input type="text" name="name" value="" /></li>
                    <li><label>Email Address</label><input type="text" name="email" value="" /></li>
                    <li id="subject"><label>Subject</label><input type="text" name="subject" value="" /></li>
                    <li id="message"><label>Message</label><textarea name="message"></textarea></li>
                    <li id="code-image"><img src="<?php echo base_url();?>./images/code.png" alt="Code Message" /></li>
                    <li id="code"><label>Enter code from image above.</label><input type="text" name="code" value="" /></li>
                    <li id="submit-button"><input type="submit" value="Send" class="button" /></li>
                </ul>
        </form>
	</div>
</div>