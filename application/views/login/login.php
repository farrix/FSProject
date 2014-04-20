<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/6/11
 * Time: 10:53 PM
 * To change this template use File | Settings | File Templates.
 */
 
?>

    <div id="global-image"><?=$global_image; ?></div>
    <?php
        if ($this->session->flashdata('success'))
        {
            echo '<div id="success">'.$this->session->flashdata('success').'</div>';
        }

        if ($this->session->flashdata('error'))
        {
            echo '<div id="error">'.$this->session->flashdata('error').' The webmaster has been emailed, please try this again later.</div>';
        }
    ?>
    <div id="login">

        <?php echo form_open('cms/profile/login'); ?>
        <ul id="login_box">
            <li><h2>Welcome Back,</h2></li>
            <li><label>Username</label><input type="username" name="username" /></li>
            <li><label>Password</label><input type="password" name="password" /></li>
            <li><?php echo anchor('en/register', 'Register');?></li>
            <li><input class="button" type="submit" name="submit" value="Login"  /></li>
        </ul>
        <?php echo form_close(); ?>

    </div>
