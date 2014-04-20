<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller {

	function index()
	{
        $this->load->view('header');
        $this->load->view('sitemap/index');
        $this->load->view('footer');
    }

}

/* End of file En.php */
/* Location: ./application/controllers/En.php */