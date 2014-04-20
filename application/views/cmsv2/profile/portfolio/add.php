<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 8:39 PM
 * cmsv2/profile/portfolio/add
 */
 
?>

<div id="admin-content">
    <div id="admin-nav-bar">
        <ul>
            <li class="filler"><!-- filler --></li>
            <li><?=anchor('cms/member/profile','Overview');?></li>
            <li>Biography</li>
            <li><?=anchor('cms/profile/bio/manage','Manage Bio');?></li>
            <li><?=anchor('cms/profile/bio/add','Add Bio');?></li>
            <li>Projects</li>
            <?php if(@$project_query) { $action_update = 'selected';} else { $action_add = 'selected';} ?>
            <li class="<?=@$action_update;?>"><?=anchor('cms/profile/project/manage','Manage Portfolio');?></li>
            <li class="<?=@$action_add;?>"><?=anchor('cms/profile/project/add','Add Project');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->


        <ul id="help">
        <?php
            if (@$project_query)
            {
                foreach($project_query->result() as $info)
                {
                    $projecId = $info->projectId;
                    $project_image = $info->project_image_url;
                    $project_overview = $info->project_overview;
                    $project_additional = $info->project_additional_info;
                    $project_tools = $info->project_tools;

                }

                echo'<li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
                    <li><h1>Update Project</h1></li>
                    <li>You can change the image if you want, make sure to check the box to enable the field.</li>
                    <li>Update the text, use the textarea ui to edit the content the way you want.</li>
                    <li>Drag n\' Drop any new tool you forgot to add. Or remove any you wish.</li>
                    <li>Hit the update button when done.</li>
                </ul>';
            } else {


        ?>
            <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
            <li><h1>Add Project</h1></li>
            <li>To add a project, fill out the form below.</li>
            <li>Pick the image of the artwork you wish to display</li>
            <li>Document the project overview such as how the piece was created. How you decided the project was finally finished.</li>
            <li>Please add (simply drag n' drop) which tools were used to create such wonderful artwork, to help inspire others.</li>
            <li>The additional info what this is for is tell your viewers how you decided to make the piece.</li>
        </ul>
        <?php } // end of notes.?>

    <?php

        echo validation_errors('<div id="error">','</div>');

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
    if (@$project_query)
    {
       echo '<p><img src="'.base_url().$project_image.'" alt="Project Image" id="project-image-update" /></p>';

       $data_form = array(
           'name' => 'change_image',
           'id' => 'image_change_form',
           'value' => 'true',
           'checked' => FALSE
       );
    }
?>
        <?php $data_form_array = array('id'=> 'form');?>
        <?php if (@$project_query)
    {
        echo form_open_multipart('cms/profile/project/update/'.$projecId, $data_form_array);
   } else {
        echo form_open_multipart('cms/profile/project/add', $data_form_array);

    } ?>
        <ul>
            <li><label>Select a Project</label><input type="file" name="userfile" <?php if (@$project_query){ echo 'class="upload_form"';} ?> /></li>
            <li><?php if (@$project_query) { echo form_checkbox($data_form).' Change Default Image'; } ?></li>
            <li><label>Project Overview</label><textarea name="overview"><?=@$project_overview;?></textarea></li>

            <li><label>Project Additonal</label><textarea name="additional"><?=@$project_additional;?></textarea></li>

            <li><label>Tools Used</label></li>
            <li id="tools"><?php if (@$project_query) { echo '<input type="hidden" name="t_used" value="'.$project_tools.'" />';} ?>
                <div id="tools_added">
                    <?php
                        if (@$project_query)
                        {
                            /*
                             * this will get the current tools list and echo the image to the page.
                             */

                            $tool_used_id = explode(',', $project_tools);

                            for($i=0; $i < count($tool_used_id); $i++)
                            {
                                foreach($images->result() as $tool)
                                {
                                    if ($tool_used_id[$i] == $tool->id)
                                    {

                                        echo '<div class="tool"><img src="'.base_url().$tool->icon.'" alt="'.$tool->app_name.'" title="'.$tool->app_name.'" class="used_tool" /></div>';
                                    } else {

                                        $unused_tools = '<div class="tool_images"><img class="app_icon" src="'.base_url().$tool->icon.'" title="'.$tool->app_name.'" alt="'.$tool->app_name.'" /></div>';
                                    }
                                }
                            }
                        }
                    ?>
                </div><input id="tools_input" type="hidden" name="added_tools" value="" />

            </li>
            <li id="tools_available"><label>Available Tools ( drag n' drop them to the green plus to add )</label></li>
            <li class="icons">
            <?php
                // used on add action.
                if (@$query)
                {
                    foreach($query->result() as $app)
                    {
                        echo '<div class="tool_images"><img class="app_icon" src="'.base_url().$app->icon.'" title="'.$app->app_name.'" alt="'.$app->app_name.'" /></div>';
                    }
                } else {
                    if (@$project_query)
                    {
                        echo $unused_tools;
                    }
                }
            ?>
            </li>
            <li class="divider"><input type="submit" class="button submit" name="submit" value="<?php if (@$project_query) { echo 'Update Project';} else { echo 'Add Project';}?>" /></li>
        </ul>



        <?php echo form_close(); ?>

        </div>

    </div>
</div>