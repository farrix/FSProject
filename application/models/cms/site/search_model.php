<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/11/11
 * Time: 12:19 AM
 * models/cms/site/search_model.php
 */

class Search_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_site_content($str)
    {
        // show must be equal = true;

        $this->db->select('*')->from('content')->where('show', 'True')->like('content',$str);
        $query = $this->db->get();

        return $query;
    }

    function get_bio_content($str)
    {
        $this->db->select('*')->from('users_bios')->where('publish', 'Yes')->like('bio', $str);

        $query = $this->db->get();

        return $query;
    }


    function get_portfolio_content($str)
    {
        $this->db->select('*')->from('portfolio')->like('project_overview', $str)->or_like('project_additional_info', $str);

        $query = $this->db->get();

        return $query;
    }
}