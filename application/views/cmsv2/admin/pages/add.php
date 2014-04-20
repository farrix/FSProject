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
            <?php if(@$edit) { $action_update = 'selected';} else { $action_add = 'selected';} ?>
            <li class="<?=@$action_update;?>"><?=anchor('cms/admin/pages/manage','Manage Pages');?></li>
            <li class="<?=@$action_add;?>"><?=anchor('cms/admin/pages/add','Add Page');?></li>
            <li><?=anchor('cms/admin/article/manage','Manage Articles');?></li>
            <li><?=anchor('cms/admin/article/add','Add Article');?></li>
            <li>Networks & Tools</li>
            <li><?=anchor('cms/admin/socialnetwork/manage','Manage Social Net ');?></li>
            <li><?=anchor('cms/admin/socialnetwork/add','Add Social Net');?></li>
            <li><?=anchor('cms/admin/tools/manage','Manage Project Tools');?></li>
            <li><?=anchor('cms/admin/tools/add','Add Project Tools');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->


        <ul id="help">
            <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
            <?php

                if (@$edit)
                {
                    echo '<li><h1>Update Page</h1></li>';
                } else {
                    echo '<li><h1>Add a new page</h1></li>';
                }

            ?>

            <li>To add a page, please type in the url of the controller then function within the controller.</li>
            <li>Type in the title of the page like a page about us would be About Us</li>
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
    ?>

        <ul id="form">
        <?php
            if (@$edit)  // may not be checking the variable correctly.
            {
                foreach ($edit->result() as $page)
                {
                    $url = $page->url;
                    $title = $page->title;
                    $id = $page->id;
                }

                /*
                 *  this seems to error out if $url & $title $id are not used. adding work around now.
                 *  happens because $edit is empty, or array of 0 length.
                 */


                echo form_open('cms/admin/pages/update/'.$id);  // linking to the controller admin/addPage
            } else {
                /*
                 * Had a glitch to where if a page was managed / edited the page name
                 * stayed in the form. This I am hoping will correct that issue / bug.
                 */
                $url = '';
                $title = '';

                echo form_open('cms/admin/pages/add');  // linking to the controller admin/addPage
            }

            echo '<li>'.form_label('Enter URL','url').' '.form_input('url',$url).'</li>';
            echo '<li>'.form_label('Page Name', 'name').' '.form_input('name',$title).'</li>';
            if (@$edit)
            {
                 echo '<li><input type="submit" class="submit button" value="Update Entry" /></li>';
            } else {

                echo '<li><input type="submit" class="submit button" value="Add Page" /></li>';
            }
            echo form_close();
        ?>
        </ul>

    </div>


</div>