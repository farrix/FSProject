<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 9:22 PM
 * filename: add.php
 */
 
?>

<div id="admin-content">
    <div id="admin-nav-bar">
        <ul>
            <li class="filler"><!-- filler --></li>
            <li><?=anchor('cms/member/admin','Overview');?></li>
            <li>Page & Articles</li>
            <li><?=anchor('cms/admin/pages/manage','Manage Pages');?></li>
            <li><?=anchor('cms/admin/pages/add','Add Page');?></li>
            <li><?=anchor('cms/admin/article/manage','Manage Articles');?></li>
            <li><?=anchor('cms/admin/article/add','Add Article');?></li>
            <li>Networks & Tools</li>
            <?php if(@$query) { $action_update = 'selected';} else { $action_add = 'selected';} ?>
            <li class="<?=@$action_update;?>"><?=anchor('cms/admin/socialnetwork/manage','Manage Social Net ');?></li>
            <li class="<?=@$action_add;?>"><?=anchor('cms/admin/socialnetwork/add','Add Social Net');?></li>
            <li><?=anchor('cms/admin/tools/manage','Manage Project Tools');?></li>
            <li><?=anchor('cms/admin/tools/add','Add Project Tools');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->
        <?php


        if (@$query)
        {
        foreach($query->result() as $social)
        {
            $social_id = $social->id;
            $social_icon = $social->icon;
            $social_name = $social->name;
        }
    }
?>


    <ul id="help">
        <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
    <?php
    if (@$query)
    {
        echo '<li><h1>Edit '.$social_name.' Social Network</h1></li>
              <li>Pick the image you want to associate with the social network</li>
              <li>Type in the name of the network</li></ul>';
    } else {
    ?>  <li><h1>Add a Social Network</h1></li>
        <li>Pick the image you want to associate with the social network</li>
        <li>Type in the name of the network</li>
    </ul>
    <?php } echo validation_errors('<div id="error">','</div>'); ?>
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


        <?php
        if (!@$query)
        {
            echo form_open_multipart('cms/admin/socialnetwork/add');

        } else {
              echo form_open_multipart('cms/admin/social/edit/'.$social_id);
        }
        ?>
        <ul id="form">
<?php
    if (@$query)
    {
       echo '<li><img src="'.$social_icon.'" alt="social media Icon" /></li>';
       $text = 'Update';
       $data_form = array(
           'name' => 'change_image',
           'id' => 'image_change_form',
           'value' => 'true',
           'checked' => FALSE
       );
    } else {

        $text='Add';
}
?>
            <li><label>Social Network Icon</label><input type="file" name="userfile" <?php if (@$query){ echo 'class="upload_form"';} ?>/></li>
            <li><?php if (@$query) { echo form_checkbox($data_form).' Change Default Image'; } ?></li>
            <li><label>Social Network Name</label><input type="text" name="network" value="<?php echo @$social_name; ?>" /></li>

            <li><input type="submit" class="submit button" name="submit" value="<?=@$text;?>" /></li>
        </ul>



        <?php echo form_close(); ?>

        </div>
    </div>
</div>