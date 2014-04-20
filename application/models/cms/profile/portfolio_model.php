<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/3/11
 * Time: 7:34 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Portfolio_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function addProject($userId, $image_url, $overview, $additional, $tools)
    {
        /*
         * The overview & additional_info will be searchable.
         */
        $table_data = array(
            'project_image_url' => $image_url,
            'project_overview' => $overview,
            'project_additional_info' => $additional,
            'project_tools' => $tools,
            'project_owner' => $userId
        );

        $this->db->insert('portfolio', $table_data);
    }

    function getProjectDetails($projectId)
    {
        /*
         *  getProjectDetails is pulling the data from the database based on a single project ID.
         */
        $this->db->select('*')->from('portfolio')->where('projectid', $projectId)->limit(1);

        $query = $this->db->get();

        return $query;
        
    }

    function getProjects()
    {
        $this->db->select('projectId, project_image_url')->from('portfolio');

        $query = $this->db->get();

        return $query;
    }

    function getLastProjects($limit)
    {
        $this->db->select('*')->from('portfolio')->limit($limit);
        $query = $this->db->get();

        return $query;
    }

    function getAllProjectsByUserID($id)
    {
        /*
         * Mainly used for the managing of profolio.
         * returns param $query
         */
        $this->db->select('*')->from('portfolio')->where('project_owner', $id);
        $query = $this->db->get();

        return $query;
    }

    function update_project($id, $overview, $additional, $tools, $image = null)
    {

        if ($image == null)
        {
            // update without image;

            $data_table = array(
                'project_overview' => $overview,
                'project_additional_info' => $additional,
                'project_tools' => $tools
            );
            
        } else {
            // update with image.

            $data_table = array(
                'project_image_url' => $image,
                'project_overview' => $overview,
                'project_additional_info' => $additional,
                'project_tools' => $tools
            );


        }

        $this->db->where('projectId', $id);
        $this->db->update('portfolio', $data_table);

    }


    function delete_project($id)
    {
        $this->db->where('projectId', $id);
        $this->db->delete('portfolio');
    }
}