<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 1:03 AM
 * views/cmsv2/admin/index.php
 */

?>

<div id="admin-content">
    <div id="admin-nav-bar">
        <ul>
            <li class="filler"><!-- filler --></li>
            <li class="selected"><?=anchor('member/adminlook','Overview');?></li>
            <li>Page & Articles</li>
            <li><?=anchor('cms/admin/pages/manage','Manage Pages');?></li>
            <li><?=anchor('cms/admin/pages/add','Add Page');?></li>
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
        <ul class="info">
            <li>Please make a selection on the left.</li>
        </ul>
        <ul id="help">
            <li><h2>Page and Articles</h2></li>
            <li>Manage Pages - It allows you to have different pages for content. This cms is hard coded for 4 pages
                allowing the content to be displayed on the 4 required pages.</li>
            <li>Add Page - How you would add a Page.</li>
            <li>Manage Articles - Enables the Admin to create and/or update articles/content for the pages</li>
            <li>Add Articles - To create a new Article.</li>
            <li><h2>Networks and Tools</h2></li>
            <li>Manage Social Networks - A place to view already submitted networks and to edit them if need be.
                Deletion of these is not an option.</li>
            <li>Add Social Net - Only way to add a new social network.</li>
            <li>Manage Project Tools - Enables the admin to edit and view project tools listed in the database.</li>
            <li>Add Project Tools - Only way to add new project tools.</li>
        </ul>
    </div>
</div>