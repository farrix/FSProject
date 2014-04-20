<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 9:22 PM
 * filename: manage.php
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
            <li class="selected"><?=anchor('cms/admin/socialnetwork/manage','Manage Social Net ');?></li>
            <li><?=anchor('cms/admin/socialnetwork/add','Add Social Net');?></li>
            <li><?=anchor('cms/admin/tools/manage','Manage Project Tools');?></li>
            <li><?=anchor('cms/admin/tools/add','Add Project Tools');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->


    <ul id="help">
        <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
        <li><h1>Manage Social Network</h1></li>
        <li>All Social Media Networks are Listed</li>
        <li>Pick an action</li>
        <li>Edit a current Social Network.</li>
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


        <table id="datalist">
            <thead>
            <tr>
                <th>Social Network Name</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
    <?php
    if ($query->num_rows() > 0 )
    {
        foreach ($query->result() as $row)
        {
            echo '<tr><td class="data">'.$row->name.'</td><td class="icons">'.img($row->icon).'</td><td class="icons">'.anchor('cms/admin/socialnetwork/edit/'.$row->id,'<img src="'.base_url().'images/actions-edit.png" alt="action edit"/>').'</td></tr>';
        }
    } else {

        echo '<tr><td>Please Add one, none were found.</td><td></td><td></td></tr>';
    }

    ?>
            </tbody>
        </table>


    </div>



    </div>
</div>