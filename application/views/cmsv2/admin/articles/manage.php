<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 9:17 PM
 * To change this template use File | Settings | File Templates.
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
            <li class="selected"><?=anchor('cms/admin/article/manage','Manage Articles');?></li>
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
        <li><h1>Manage Articles</h1></li>
        <li>All pages are listed below.</li>
        <li>Pick an action</li>
        <li>Edit or Delete</li>
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
                <th></th>
                <th>Header</th>
                <th>Where</th>
                <th>Published</th>
            </tr>
            </thead>
            <tbody>
    <?php
    foreach ($query->result() as $row)
    {
        echo '<tr><td></td><td class="data">'.$row->header.'</td><td class="data">'.$row->place_on_page.'</td><td class="data">'.$row->show.'</td><td class="action-icons">'.anchor('cms/admin/article/update/'.$row->id,'<img src="'.base_url().'images/actions-edit.png" alt="action edit"/>').'<img src="'.base_url().'images/actions-delete.png" alt="action edit" id="'.base_url().'index.php/cms/admin/article/delete/'.$row->id.'" class="delete" title="'.base_url().'index.php/cms/admin/article/manage" /></td></tr>';
    }

    ?>
            </tbody>
        </table>


        </div>


    </div>
</div>