<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rmcmillan
 * Date: 7/28/11
 * Time: 11:07 PM
 * To change this template use File | Settings | File Templates.
 */

class Login_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function authenticate($user, $password)
    {
        /*
         * Seems to be ok;
         * Changed a few things on 8/9 @ 11:14
         *  - Also removing the limit 1, there should be only one match.
         */
        $this->db->select('*')->from('users')->where('username', $user); // only pulling one, the only one that should match.

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $user)
            {
                if ($user->password == md5($password))
                {
                    // verifying the password is correct that was entered.

                    return $user->userid;

                } else {
                	return 0;
                }
            }

        }
    }


    function getSecurityLevel($userid)
    {
    	/*
    	 * Checking over, to make sure code is where it needs to be;
    	 * 8/09 11:17
    	 */
    	$this->db->select('security_level')->from('users_profiles')->where('userid',$userid);
    	$query = $this->db->get();
    	
    	foreach($query->result() as $level)
    	{
    		$sec_level = $level->security_level;  // grabbing security level from users_profiles based on users account. @ RKM 11:17 8/09
    	}

        $this->db->select('name')->from('acl')->where('id', $sec_level);
        $securityAccess = $this->db->get();

        foreach ($securityAccess->result() as $rights)
        {
            return $rights->name;
        }
    	//return $user_level;
    }
    
    function getUseridByUsername($user)
    {
    	$this->db->select('userid')->from('users')->where('username', $user);
        $this->db->distinct();
    	$query = $this->db->get();
    	
    	if ($query->num_rows() > 0)
    	{
    		foreach($query->result() as $member)
    		{
    			$memberid = $member->userid;
    		}
    	
    		return $memberid;
    	} else {
    		return 0;
    	}
    	
    }

    function check_email_address($email)
    {
        $this->db->select('email_address')->from('users_profiles')->where('email_address', $email);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }

    }
    
}
