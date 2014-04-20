<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class En extends CI_Controller {

	function index()
	{
        $this->load->model('cms/profile/portfolio_model', 'projects');
		$this->load->model('cms/layout/pages_model', 'pages');

        $query = $this->projects->getProjects();

        $data['rotate_banner'] = $query;
        /*
         * Getting the content from the database, will sort it here, then export it to the page.
         */
        $contentDump = $this->pages->retrieveContentByPageId($this->pages->getPageName('Home'));

        $data['content'] = $contentDump->result();
        /*
         * pull 6 images for recent work;
         */

        $data['last_projects'] = $this->projects->getLastProjects(6);


        /*
         * Pulling new Student Material. (bio)
         */
        $this->load->model('cms/profile/bio_model', 'bio');
        $latest_bio = $this->bio->getLastBio();

        if ($latest_bio->num_rows > 0)
        {
            $data['latest_bio'] = $latest_bio;
        }

        $this->load->view('header');
		$this->load->view('welcome_message',$data);
		$this->load->view('footer');
	}
	
	function about()
	{
        $data['global_image'] = $this->show_graphic();
        
        $this->load->model('cms/layout/pages_model', 'pages');
        /*
         * Getting the content from the database, will sort it here, then export it to the page.
         *
         * This has changed from what was thought to be a simple way of doing everything here in the controller
         * vs doing some sorting in the view.  Using direct access Array pulling object, I was able to
         * display the information I needed onto the page with a simple echo array command.
         */
        $contentDump = $this->pages->retrieveContentByPageId($this->pages->getPageName('About Us'));

        $data['content'] = $contentDump->result();
       

		$this->load->view('header');
		$this->load->view('about/index', $data);
		$this->load->view('footer');
	}
	
	function contact()
	{

        $data['global_image'] = $this->show_graphic();

        $this->form_validation->set_rules('code', 'Code', 'callback_check_code');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|xss_clean|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|trim');
        $this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|xss_clean|trim|min_length[10]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('header');
            $this->load->view('contact/index', $data);
            $this->load->view('footer');
        } else {

            /* form validated ok; time to proceed with the email */
            
            $this->load->library('email');

            $this->email->from($this->input->post('email'), $this->input->post('name'));
            $this->email->to('farrix@gmail.com');

            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('message'));

            $this->email->send();

            $this->session->set_flashdata('success','Your email was sent successfully.');
            redirect('en/index');
            
        }

    }

    function check_code($field)
    {
        if ($field != '')
        {
            if (($field == 'MC9367') || ($field == 'mc9367') || ($field == 'mc 9367') || ($field == 'MC 9367'))
            {
                return TRUE;
            } else
            {
                $this->form_validation->set_message('check_code','The %s field is incorrect. Please try again.');
                return FALSE;
            }
        } else {

            $this->form_validation->set_message('check_code','The %s field can not be empty, it is required.');
            return FALSE;
        }
    }
    
	function legal()
	{
        $data['global_image'] = $this->show_graphic();
        $this->load->model('cms/layout/pages_model', 'pages');

        $contentDump = $this->pages->retrieveContentByPageId($this->pages->getPageName('Legal'));

        $data['content'] = $contentDump;

		$this->load->view('header');
		$this->load->view('legal/index', $data);
		$this->load->view('footer');
	}

    function project($action = null, $id = null)
    {
        if (($action == 'detail') && ($id))
        {
            /*
             *  this method is used for pulling project detail data;
             */
            $this->load->model('cms/profile/portfolio_model', 'portfolio');
            $project = $this->portfolio->getProjectDetails($id);


            /*
             * loading site model to get the icon images from pTools.
             */

            $this->load->model('cms/site/site_model', 'site');
            
            foreach($project->result() as $project_info)
            {
                $data['projectId'] = $project_info->projectId;
                $data['image'] = $project_info->project_image_url;
                $data['overview'] = $project_info->project_overview;
                $data['additional'] = $project_info->project_additional_info;
                $tools = $project_info->project_tools;
                /*
                 *  Have to process the project_owner outside to query the bio table
                 */
                
                $tool_array = explode(',', $tools);
                $stack_images = array();
                for($t=0; $t < count($tool_array); $t++)
                {
                    $query = $this->site->listToolsByID($tool_array[$t]);

                    foreach($query->result() as $icon)
                    {
                        /*
                         * Getting icon, will display the icon(s)
                         */

                        
                        $stack_images[$t] = array('path'=>$icon->icon, 'name' => $icon->app_name);
                    }
                }

                $owner = $project_info->project_owner;
            }
            
            $data['image_stack'] = $stack_images;
            $this->load->model('cms/profile/bio_model','bio');
            $bio_info = $this->bio->get($owner);

            foreach($bio_info->result() as $bio)
            {
                $data['bio_image'] = $bio->image;
                $data['userid'] = $owner;
            }
            $this->load->view('header');
            $this->load->view('projects/details', $data);
            $this->load->view('footer');
        }
    }


    function profile($userid = null)
    {
        /*
         * Method is only used when getting more information about the artist author ( bio )
         */
        if ($userid == null)
        {
            redirect('en/index', 'location', 301);
        }
        
        $this->load->model('cms/profile/bio_model', 'bio');
        $this->load->model('cms/profile/portfolio_model', 'port');
        $query = $this->bio->getBioDataByUseridPublished($userid);

        /*
         * getting information about other projects.
         */

        $data['projects'] = $this->port->getAllProjectsByUserID($userid);
        
        foreach($query->result() as $bioData)
        {
            $data['image'] = $bioData->image;
            $data['bio'] = $bioData->bio;
            $bioId = $bioData->id;
        }

        $data['related_social_data'] = $this->bio->pullSocialUrls($bioId);

        $this->load->model('cms/site/site_model', 'site');
        $data['social_media_all'] = $this->site->getSocialNetworks();

        $data['global_image'] = $this->show_graphic();
        $this->load->view('header');
		$this->load->view('profile/about', $data);
		$this->load->view('footer');
    }

    function login()
    {
        $data['global_image'] = $this->show_graphic();
        $this->load->view('header');
        $this->load->view('login/login',$data);
        $this->load->view('footer');
    }

    function register()
    {

        $data['global_image'] = $this->show_graphic();
        $this->load->view('header');

        $this->form_validation->set_rules('username','Username', 'required');
        $this->form_validation->set_rules('password','password', 'required');
        $this->form_validation->set_rules('email','Email Address', 'callback_email_dup_check');
        $this->form_validation->set_rules('code','Number Code', 'callback_captcha_verification');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('register/register', $data);
        } else {
            /*
             * form is validated and is ok to proceed.
             */
            

            $this->load->model('cms/site/site_model', 'site');
            $query = $this->site->addUser($this->input->post('username'), $this->input->post('password'), $this->input->post('email'));

            if ($query == TRUE)
            {
                $this->session->set_flashdata('success','User Account was created successfully.');

                redirect('en/login');

            } else {
                $this->session->set_flashdata('error','Account already exists, or there was another problem creating your account, please try again.');

                redirect('en/register');

            }
        }

        $this->load->view('footer');
    }

    function email_dup_check($email)
    {
        if (!empty($email))
        {
            $this->load->model('cms/profile/login_model', 'user');
            $query = $this->user->check_email_address($email);

            if ($query == TRUE)
            {
                $this->form_validation->set_message('email_dup_check', 'The email address you entered is already in use!');
                return FALSE;

            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('email_dup_check', 'The %s field can not be blank.');
            return FALSE;
        }
    }
    function captcha_verification($code)
    {
        if (!empty($code))
        {
            if ($code == 'MC9367')
            {
                return TRUE;
            } else {
                $this->form_validation->set_message('captcha_verification', 'The %s field does not match code.');
                return FALSE;
            }
        } else {
             $this->form_validation->set_message('captcha_verification', 'The %s field can not be blank.');
            return FALSE;
        }
    }

    private function show_graphic()
    {
        $this->load->model('cms/profile/portfolio_model', 'port');

        $rowcount = $this->port->getProjects();

        if ($rowcount->num_rows() > 0)
        {
            /*
             * Checking to make sure there are portfolios added;
             */

            foreach($rowcount->result() as $id)
            {
                $id_array[] = $id->projectId;
            }

            $query = $this->port->getProjectDetails($id_array[rand(0,count($id_array) - 1)]);

            foreach($query->result() as $global_image)
            {
//                $global_image_array = array(
//                    'image' => $global_image->project_image_url,
//                    'id' => $global_image->projectId
//                );
                $image_properties = array(
                    'src' => base_url().$global_image->project_image_url,
                    'alt' => 'Project Random Image'
                );
                $global_image_array = anchor('en/project/detail/'.$global_image->projectId,img($image_properties)).'';
            }

            return $global_image_array;
            
        } else {
            // TODO: make a default size graphic.
        }
        
    }

    function search()
    {
        $this->form_validation->set_rules('search_field','Search', 'required|trim|min_length[5]');

        if ($this->form_validation->run() == FALSE)
        {
            /*
             * show error: form page.
             */

            $this->load->view('header');
            $this->load->view('search/results');
            $this->load->view('footer');


        } else {

            /* search continues; */
            $str = $this->input->post('search_field');

            $this->load->model('cms/layout/pages_model', 'page');
            $data['pages'] = $this->page->getPages();  // getting pages to get the actual page name.

            $this->load->model('cms/site/search_model', 'search');
            $query1 = $this->search->get_site_content($str);
            $query2 = $this->search->get_bio_content($str);
            $query3 = $this->search->get_portfolio_content($str);

            /* search view */

            // passing search result data to the page.
            $data['first_search'] = $query1;
            $data['second_search'] = $query2;
            $data['third_search'] = $query3;

//            $stacked_array[] = $query1->result();
//            $stacked_array[] = $query2->result();
//            $stacked_array[] = $query3->result();

            

            
            $this->load->view('header');
            $this->load->view('search/results',$data);
            $this->load->view('footer');
        }
    }
}

/* End of file En.php */
/* Location: ./application/controllers/En.php */