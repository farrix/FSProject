<?php

class Bio_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function getBioDataByUserid($userid)
    {
    	/*  Object is to pull the bios information based on the userid provided based on username from login/getUseridByUsername */
       	//$this->db->select('t1.*, t2.*')->from('users_bios as t1, users_smn as t2')->where('t1.userid', $userid)->where('t2.bioid','t1.id');
    	$this->db->select('*')->from('users_bios')->where('userid', $userid)->where('bio !=', 'blank');
    	$query = $this->db->get();
    	
    	return $query;
    }

    function getBioDataByUseridPublished($userid)
    {
    	/*  Object is to pull the bios information based on the userid provided based on username from login/getUseridByUsername */
       	//$this->db->select('t1.*, t2.*')->from('users_bios as t1, users_smn as t2')->where('t1.userid', $userid)->where('t2.bioid','t1.id');

        $this->db->select('*')->from('users_bios')->where('userid', $userid)->where('publish', 'Yes');
    	$query = $this->db->get();

    	return $query;
    }

    function addBioBybioId($bioId, $short_bio, $image_url, $publish)
    {
    	$table_data = array(
            'image' => $image_url,
            'bio' => $short_bio,
            'publish' => $publish
        );

        $this->db->where('id', $bioId);
        $this->db->update('users_bios', $table_data);
        
    }

    function addBlank($userId)
    {
        /*
         * This is for when a user wants to create a new bio for themselves.
         * Creating a blank table for the user to edit.
         */

        $table_data = array(
            'userid' => $userId,
            'image' => '',
            'bio' => 'blank',
            'publish' => 'No'
        );

        $this->db->insert('users_bios', $table_data);
        
    }

    function getBlank($userId)
    {
        /*
         * This method will be used to get a blank bio from user database.
         * - report back the bioId
         */
        $where_array = array('bio' => 'blank', 'userid' => $userId);

        $this->db->select('*')->from('users_bios')->where($where_array)->limit(1);

        $query = $this->db->get();

        return $query;
    }

    function get($userid)
    {
        $where = array(
            'userid' => $userid,
            'publish' => 'Yes'

        );
        $this->db->select('*')->from('users_bios')->where($where);

        $query = $this->db->get();

        return $query;
    }

    function getBioByid($bioId)
    {
        $where = array(
            'id' => $bioId


        );
        $this->db->select('*')->from('users_bios')->where($where);

        $query = $this->db->get();

        return $query;
    }

    function getLastBio()
    {
        $this->db->select('id, userid, image, bio, publish')->from('users_bios')->where('publish', 'Yes')->order_by('id', 'desc')->limit(1);
        $query = $this->db->get();

        return $query;
    }

    function update($bioId, $bio, $publish)
    {
        $data_table = array(
            'id' => $bioId,
            'bio' => $bio,
            'publish' => $publish
        );

        $this->db->where('id' , $bioId);
        $this->db->update('users_bios', $data_table);

    }

    function addNetwork($smnid, $url, $bioid)
    {
        $data_table = array(
            'smnid' => $smnid,
            'url' => $url,
            'bioid' => $bioid
        );

        $this->db->insert('users_social_links', $data_table);

    }

    function pullSocialUrls($bioid)
    {
        $this->db->select('*')->from('users_social_links')->where('bioid', $bioid);

        $query = $this->db->get();

        return $query;
    }

    function remove_bio($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users_bios');
        
    }
}
