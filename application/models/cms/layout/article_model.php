<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/5/11
 * Time: 12:28 AM
 * To change this template use File | Settings | File Templates.
 */

class Article_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_articles()
    {
        $this->db->select('*')->from('content');
        $query = $this->db->get();

        return $query;
    }

    function get_article_by_id($id)
    {
        $this->db->select('*')->from('content')->where('id', $id);
        $query = $this->db->get();

        return $query;
    }

    function update($header,$article,$id,$publish)
    {
        $data = array(
            'header' => $header,
            'content' => $article,
            'show' => $publish
        );

        $this->db->update('content', $data, array('id' => $id));

        return TRUE;
    }

    function remove($id)
    {
        $this->db->delete('content', array('id' => $id));

        return TRUE;
    }
}