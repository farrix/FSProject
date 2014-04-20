<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 9:21 PM
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
            <?php if(@$query) { $action_update = 'selected';} else { $action_add = 'selected';} ?>
            <li class="<?=@$action_update;?>"><?=anchor('cms/admin/article/manage','Manage Articles');?></li>
            <li class="<?=@$action_add;?>"><?=anchor('cms/admin/article/add','Add Article');?></li>
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

                if ((@$query) && (@$listpages))
                {
                    echo '<li><h1>Update Article</h1></li>';

                    foreach ($query->result() as $article)
                    {
                        $id = $article->id;
                        $header = $article->header;
                        $article_data = $article->content;
                        $where = $article->place_on_page;
                        $published = $article->show;
                    }
                } else {
                    echo '<li><h1>Add Article</h1></li>';
                }
            ?>


        <li>To add/update contact to a page, Select a page so you know where your content will end up.</li>
        <li>Type in a header usually this data will populate under header one tags. Enter the content
        of the article, this is very large field.</li>
        <li>Placement is where your want your article to go.</li>
        <li>Show if marked true, your article is searchable and will be displayed on the determined page.</li>
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

        <?php

            if ((@$query) && (@$listpages))
            {
                echo form_open('cms/admin/article/update/'.$id);
            } else {

                echo form_open('cms/admin/article/add');

            }
        ?>
        <ul id="form">
            <li><label>Header</label><input type="text" name="header" value="<?php echo @$header; ?>"/></li>
            <li><label>Content</label><textarea name="content"><?php echo @$article_data; ?></textarea></li>
            <li><label>Article Placement</label><select name="where">
                <?php
                    /*
                     * Creating the list of pages;
                     */
                    if (@$listpages)
                    {
                        foreach ($listpages->result() as $page)
                        {
                            if ( $page->id == $where)
                            {
                                echo '<option value="'.$page->id.'" selected="yes">'.$page->title.'</option>';
                            } else {

                                echo '<option value="'.$page->id.'">'.$page->title.'</option>';

                            }
                        }

                    }
                ?>
            </select></li>
            <li><label>Publish Article</label><select name="show"><option>True</option><option>False</option></select></li>
            <li><input type="submit" class="submit button" name="submit" value="<?php if (@$query) { $text = 'Update'; } else { $text='Add'; } echo $text;?> Article" /></li>
        </ul>
        <?php echo form_close(); ?>
    </div>
</div>


