<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 7:57 PM
 * cmsv2/profile/biography/add
 */

?>

<div id="admin-content">
    <div id="admin-nav-bar">
        <ul>
            <li class="filler"><!-- filler --></li>
            <li><?=anchor('cms/member/profile','Overview');?></li>
            <li>Biography</li>
            <li><?=anchor('cms/profile/bio/manage','Manage Bio');?></li>
            <li class="selected"><?=anchor('cms/profile/bio/add','Add Bio');?></li>
            <li>Projects</li>
            <li><?=anchor('cms/profile/project/manage','Manage Portfolio');?></li>
            <li><?=anchor('cms/profile/project/add','Add Project');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->


    <ul id="help">
        <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
        <li><h1>Add Bio</h1></li>
        <li>Just a reminder, this is a bio for other people to read about you.</li>
        <li>Pick your bio image.</li>
        <li>Type in your bio, or paste it from word or another word processor.</li>
        <li>Social Section, click on the image and type in your profile url.</li>
    </ul>
    <?php
        if ($this->session->flashdata('success'))
        {
            echo '<div id="success">'.$this->session->flashdata('success').'</div>';
        }

        if ($this->session->flashdata('error'))
        {
            echo '<div id="error">'.$this->session->flashdata('error').' The webmaster has been emailed, please try this again later.</div>';
        }

        foreach($bio_data->result() as $data)
        {
            $bioId = $data->id;
            $bio = $data->bio;
            $publish = $data->publish;
        }
    ?>


        <?php  $attributes = array ('id' => 'form'); echo form_open_multipart('cms/profile/bio/update_new/'.$bioId, $attributes); ?>
        <ul>
            <li><label>Select Bio Image</label><input type="file" name="userfile" /></li>
            <li><label>Short Bio</label><textarea name="bio"><?php echo $bio; ?></textarea></li>


            <li><label>Social Media</label></li>
            <?php

                foreach(@$query->result() as $networks)
                {
                        $found = '';
                        $image_properties = array(
                            'src' => $networks->icon,
                            'alt' => $networks->name.' image',
                            'title' => $networks->name,
                            'class' => 'icon',
                            'id' => $bioId
                        );


                        foreach ($social_urls->result() as $social)
                        {
                            /*
                             * Checking social networks to only show the ones that have not
                             * been submitted.
                             */
                            if ( $social->smnid == $networks->id)
                            {
                                $found = true;

                            }
                        }

                        if ($found != true)
                        {
                            echo '<li class="social_media_icon">'.img($image_properties).'
                        <form>
                            <input type="hidden" id="smnid" value="'.$networks->id.'" />
                            <input type="hidden" id="bioid" value="'.$bioId.'" />
                            <input type="hidden" id="base_url" value="'.base_url().'" />
                        </form>
                    </li>';

                        }

                    }



            ?>
            <li class="your-social-media-icon"><label>Your Social Media Network</label></li>

                <ul id="social_content">
                    <?php
                        foreach ($social_urls->result() as $socialnetwork)
                        {



                            foreach(@$query->result() as $networks)
                            {
                                $image_properties = array(
                                    'src' => $networks->icon,
                                    'alt' => $networks->name.' image',
                                    'title' => $networks->name,
                                    'class' => $networks->id,
                                    'id' => $bioId
                                );

                                if ($socialnetwork->smnid == $networks->id)
                                {
                                    echo '<li><label>'.img($image_properties).'</label><input type="text" name="'.$socialnetwork->id.'" value="'.$socialnetwork->url.'" /></li>';

                                }

                            }



                        }
                    ?>
                </ul>
       
            <li><label>Publish</label>
                <select name="publish">
                    <option value="<?php echo $publish; ?>" selected><?php echo $publish; ?></option>
                    <option value="Yes">Yes</option>
                     <option value="No">No</option>
                </select>
            </li>
            <li><input type="submit" class="submit button" name="submit" value="Add Bio" /></li>
        </ul>



        <?php echo form_close(); ?>
    


       

    </div>
</div>
