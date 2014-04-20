<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 1:03 AM
 * views/cmsv2/profile/index.php
 */

?>

<div id="admin-content">
    <div id="admin-nav-bar">
        <ul>
            <li class="filler"><!-- filler --></li>
            <li class="selected"><?=anchor('cms/member/profile','Overview');?></li>
            <li>Biography</li>
            <li><?=anchor('cms/profile/bio/manage','Manage Bio');?></li>
            <li><?=anchor('cms/profile/bio/add','Add Bio');?></li>
            <li>Projects</li>
            <li><?=anchor('cms/profile/project/manage','Manage Portfolio');?></li>
            <li><?=anchor('cms/profile/project/add','Add Project');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->
        <ul class="info">
            <li>Please make a selection on the left.</li>
        </ul>
        <ul id="help">
            <li><h2>Biography</h2></li>
            <li>Manage Bio - Is a place where you can edit all of your bio information. You can deleted it, make it
        unpublished or published.</li>
            <li>Add Bio - Is where you go to add a bio about yourself.</li>
            <li><h2>Projects</h2></li>
            <li>Manage Portfolios - Is a place where you can go to list all of your projects listed in your portfolio.
                you are only allowed to have one portfolio, but you can have unlimited projects.</li>
            <li>Add Project - Is where you can go to add a project to your online portfolio.</li>
        </ul>


        
    </div>
</div>