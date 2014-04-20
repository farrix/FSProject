<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/7/11
 * Time: 12:14 AM
 * To change this template use File | Settings | File Templates.
 */
 
?>


       <div id="global-image"><?=$global_image; ?></div>

    <?php echo validation_errors('<div id="error">','</div>'); ?>
    <?php
        if ($this->session->flashdata('success'))
        {
            echo '<div id="success">'.$this->session->flashdata('success').'</div>';
        }

        if ($this->session->flashdata('error'))
        {
            echo '<div id="error">'.$this->session->flashdata('error').'</div>';
        }
    ?>
<div id="registration-content">
    <div id="benefits">
        <h2>Registration Benefits</h2>
           <ul id="registration">
               <li>Free Membership</li>
               <li>Post your work to inspire others.</li>
               <li>Have a portfolio ready to show to possibly new employers.</li>
           </ul>
    </div>

    <div id="register">
        <?php echo form_open('en/register'); ?>
           <ul id="registration_box">
               <li><label>Username</label><input type="username" name="username" /></li>
               <li><label>Password</label><input type="password" name="password" /></li>
               <li><label>Email Address</label><input type="text" name="email" /></li>
               <li id="image"><img src="<?php echo base_url();?>images/code.png" alt="code image" /></li>
               <li><label>Enter Code from Above</label><input type="text" name="code" /></li>
               <li><?php echo anchor('en/login', 'Login');?></li>
               <li><input class="button" type="submit" name="submit" value="Register"  /></li>
           </ul>
           <?php echo form_close(); ?>
    </div>
</div>
