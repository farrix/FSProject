<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/19/11
 * Time: 8:40 PM
 * cmsv2/profile/portfolio/manage
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
            <li class="selected"><?=anchor('cms/profile/project/manage','Manage Portfolio');?></li>
            <li><?=anchor('cms/profile/project/add','Add Project');?></li>
        </ul>
    </div>
    <div id="admin-member-content">
        <!-- content goes here -->


    <ul id="help">
        <li class="ui-state-default ui-corner-all close" title="close"><span class="ui-icon ui-icon-close"></span></li>
        <li><h1>Manage Portfolio</h1></li>
        <li>All of your Projects are listed below.</li>
        <li>Pick an action</li>
        <li>Edit a project.</li>
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
                <th>Project Image</th>
                <th>Project Overview</th>
                <th>Project Tools</th>
                <th>Manage Actions</th>
            </tr>
            </thead>
            <tbody>
    <?php
    if ($query->num_rows() > 0 )
    {
        foreach ($query->result() as $row)
        {
            foreach ($images->result() as $img)
            {
                $icon_array = explode(',', $row->project_tools);

                for($i=0; $i < count($icon_array); $i++)
                {
                    if ($img->id == $icon_array[$i])
                    {
                        $image_url[$i] = $img->icon;
                    }
                }
            }
            @$image_set = '';
            if (@$image_set)
            {
                unset($image_set);

            }

            for($j=0; $j < count(@$image_url); $j++)
            {
                $data_image = array(
                    'src' => base_url().$image_url[$j],
                    'alt' => 'Tool Graphic',
                    'class' => 'tool-icon'
                );
                $image_set .=  img($data_image);
            }
            unset($image_url);
            echo '<tr><td class="data"><img src="'.base_url().$row->project_image_url.'" alt="project Image" class="project_image" /></td><td class="data">'.$row->project_overview.'</td><td>'.$image_set.'</td><td class="action-icons">'.anchor('cms/profile/project/edit/'.$row->projectId,'<img src="'.base_url().'images/actions-edit.png" alt="action edit" class="action-icon"/>').'<img src="'.base_url().'images/actions-delete.png" alt="action edit" id="'.base_url().'index.php/cms/profile/project/delete/'.$row->projectId.'" class="delete" title="'.base_url().'index.php/cms/profile/projects/manage" /></td></tr>';

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