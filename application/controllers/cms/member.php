<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	function index()
	{

    }

    function profile()
    {
        $this->load->view('cmsv2/header');
        $this->load->view('cmsv2/profile/index');
        $this->load->view('footer');  // overall site footer.
    }

    function admin()
    {
        $this->load->view('cmsv2/header');
        $this->load->view('cmsv2/admin/index');
        $this->load->view('footer');  // overall site footer.
    }

}
/* End of file Member.php */
/* Location: ./application/controllers/cms/Member.php */