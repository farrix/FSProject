<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/1/11
 * Time: 6:22 PM
 * To change this template use File | Settings | File Templates.
 */

class Pages_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getPageId($pagename)
    {
    	/*  Object is to pull the bios information based on the userid provided based on username from login/getUseridByUsername */
       	//$this->db->select('t1.*, t2.*')->from('users_bios as t1, users_smn as t2')->where('t1.userid', $userid)->where('t2.bioid','t1.id');
    	$this->db->select('*')->from('pages')->where('title', $pagename);
    	$query = $this->db->get();

    	return $query;
    }

    function getPages()
    {
        $this->db->select('*')->from('pages');
        $query = $this->db->get();

        return $query;

    }


    function addPages($url, $title)
    {
        $tableData = array(
            'url' => $url,
            'title' => $title
        );

        $this->db->insert('pages', $tableData);

        return TRUE;
    }

    function addContentToPages($header,$content,$whereToPlace,$show)
    {
        /*
         * $id = Content ID
         * $header = Headline of section in <h1>
         * $whereToPlace = as to what page the content is pulled for ( ie, about )
         * $show = can the article be shown.
         */

        $tableData = array(
            'header' => $header,
            'content' => $content,
            'place_on_page' => $whereToPlace,
            'show' => $show
        );

        $this->db->insert('content', $tableData);

        return TRUE;

    }

    function getIdByPage($name)
    {
        $this->db->select('id')->from('pages')->where('title', $name)->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $page)
        {
            return $page->id;
        }
    }

    function retrieveContentByPageId($page)
    {
        /*
         * Function allows the cms to pull the content based on the page it is loading.
         */

        $this->db->select('id,header,content,place_on_page,show')->from('content')->where('place_on_page',$page)->where('show', 'True');
        $query = $this->db->get();

        return $query;

    }

    function getPageName($name)
    {
        $this->db->select('id')->from('pages')->where('title', $name)->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row)
        {
            return $row->id;
        }
    }

    function getPageInfoById($id)
    {
        /*
         * This function is used when retrieving a page information to edit.
         */
        
        $this->db->select('*')->from('pages')->where('id', $id);
        $query = $this->db->get();

        return $query;

    }

    function update($id, $url, $title)
    {
        $update_array = array(
            'url' => $url,
            'title' => $title
        );

        $this->db->update('pages', $update_array, array('id' => $id));

        return TRUE;
        
    }

    function remove($id)
    {
        $this->db->delete('pages', array('id' => $id));

        return TRUE;
    }
}

