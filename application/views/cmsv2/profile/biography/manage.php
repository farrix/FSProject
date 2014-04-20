<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 7:57 PM
 * cmsv2/profile/biography/manage.php
 */
 
?>

<div id="admin-content">
    <div id="admin-nav-bar">
        <ul>
            <li class="filler"><!-- filler --></li>
            <li><?=anchor('cms/member/profile','Overview');?></li>
            <li>Biography</li>
            <li class="selected"><?=anchor('cms/profile/bio/manage','Manage Bio');?></li>
            <li><?=anchor('cms/profile/bio/add','Add Bio');?></li>
            <li>Projects</li>
            <li><?=anchor('cms/profile/project/manage','Manage Portfolio');?></li>
            <li><?=anchor('cms/profile/project/add','Add Project');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content -->

            <ul id="help">
                <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
                <li><h1>Manage Bio</h1></li>
                <li>All bios are listed, if they are published or not.</li>
                <li>Pick an action</li>
                <li>If you want to delete several pages at once, check the box.</li>
                <li>Just click on the edit icon to edit the you want.</li>
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
                        <th>Bio Image</th>
                        <th>Bio</th>
                        <th>Published</th>
                    </tr>
                    </thead>
                    <tbody>
            <?php
            foreach ($query->result() as $row)
            {
                $image_properties = array(
                        'src' => base_url().$row->image,
                        'alt' => 'Bio Image',
                        'title' => word_limiter($row->bio, 10),
                        'class' => 'image'

                    );
                echo '<tr><td></td><td class="data">'.img($image_properties).'</td><td class="data">'.word_limiter($row->bio, 30).'</td><td class="data">'.$row->publish.'</td><td class="action-icons">'.anchor('cms/profile/bio/update/'.$row->id,'<img src="'.base_url().'images/actions-edit.png" alt="action edit" class="action-icon"/>').'<img src="'.base_url().'images/actions-delete.png" alt="action edit" id="'.base_url().'index.php/cms/profile/bio/delete/'.$row->id.'" class="delete" title="'.base_url().'index.php/cms/profile/bio/manage" /></td></tr>';
            }

            ?>
                    </tbody>
                </table>

    </div>
</div>