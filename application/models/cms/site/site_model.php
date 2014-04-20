<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 8/4/11
 * Time: 1:19 AM
 * models/cms/site/site_model.php
 */
 
class Site_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function addSocialNetwork($path, $name)
    {
        $table_data = array(
            'icon' => $path,
            'name' => $name
        );

        $this->db->insert('sMediaNetworks', $table_data);

        return TRUE;
    }


    function getSocialNetworks($id = null)
    {
        if ($id)
        {
            $this->db->select('*')->from('sMediaNetworks')->where('id', $id);
        } else {
            $this->db->select('*')->from('sMediaNetworks');
        }

        $query = $this->db->get();

        return $query;
    }

    function checkUsedSocialNetworks($id)
    {
        $this->db->select('smnid')->from('users_social_links')->where('smnid', $id);
        $query = $this->db->get();

        return $query;
    }

    function addUser($user, $pass, $email)
    {
        $data_table = array(
            'username' => $user,
            'password' => md5($pass)
        );

        $this->db->select('username')->from('users')->where('username', $user)->limit(1);
        $checkingUserAccount = $this->db->get();
        if ($checkingUserAccount->num_rows() == 0)
        {
            $this->db->select('*')->from('users');
            $pullUsers = $this->db->get();

            $query = $this->db->insert('users', $data_table);


            /*
            * it should have inserted a row.
            */

            $this->db->select('userid')->from('users')->where('username', $user)->limit(1);
            $get_userid = $this->db->get();

            foreach($get_userid->result() as $user)
            {
                $userid = $user->userid;
            }

            if ($pullUsers->num_rows() == 0)
            {
                $new_data_table = array(
                    'userid'=> $userid,
                    'email_address' => $email,
                    'security_level' => 1
                );
            } else {

                $new_data_table = array(
                    'userid'=> $userid,
                    'email_address' => $email,
                    'security_level' => 2
                );

            }

            $this->db->insert('users_profiles', $new_data_table);
            return true;

        } else {
            return false;
        }

    }

    function checkSocialNetwork($field)
    {
        $this->db->select('*')->from('sMediaNetworks')->where('name', $field);
        $query = $this->db->get();

        return $query;
    }

    function addSocialNetworkUpdate($image_url, $name, $id)
    {
        if ($image_url == 'none')
        {
            $data_update = array(
                'name' => $name,
                'id' => $id
            );

        } else {

            $data_update = array(
                'icon' => $image_url,
                'name' => $name,
                'id' => $id
            );
        }

        $this->db->where('id', $id);
        $this->db->update('sMediaNetworks', $data_update);

        return TRUE;
    }


    function checkToolAppName($name)
    {
        $this->db->select('*')->from('pTools')->where('app_name', $name)->limit(1);
        $query = $this->db->get();

        return $query;
    }

    function addTool($tool_icon, $app_name)
    {
        $data_table = array(
            'icon' => $tool_icon,
            'app_name' => $app_name
        );

        $this->db->insert('pTools', $data_table);
    }

    function listTools()
    {
        $this->db->select('*')->from('pTools');
        $query = $this->db->get();

        return $query;
    }

    function listToolsByID($id)
    {
        /*
         * Only to return one item row by id of an Edit.
         */
        $this->db->select('*')->from('pTools')->where('id', $id)->limit(1);
        $query = $this->db->get();

        return $query;
    }

    function getToolByName($name)
    {
        $this->db->select('id')->from('pTools')->where('app_name', $name)->limit(1);
        $query = $this->db->get();

        return $query;

    }


    function updateToolByID($id, $icon, $appname)
    {
        if ($icon == 'none')
        {
            /*
             * Icon was not changed.
             */

            $data_table = array(
                'app_name' => $appname
            );

        } else {

            /*
             * icon was changed, needs updated.
             */

            $data_table = array(
                'icon' => $icon,
                'app_name' => $appname
            );

        }

        $this->db->where('id', $id);
        $this->db->update('pTools', $data_table);
    }

}