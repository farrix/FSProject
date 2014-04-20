<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
        /*
         * Cms Profile needs only logged in personal making a connection
         * and displaying the data.
         *
         * If person does not have a username, they are sent back to en/index
         * 
         */
        //var_dump($this->session->userdata());
        if ($this->session->userdata('acl'))
        {
//            
            redirect('cms/member/profile', 'location', 301);
        } else {

            $this->session->sess_destroy();
            redirect('en/index', 'location', 301);

        }
    }
    
    public function bio($action = null, $id = null)
    {

        $this->load->model('cms/profile/bio_model', 'bio');
        $this->load->model('cms/profile/login_model', 'users');

        /*
        * Obtaining userId first
        */

        if ((!$this->session->userdata('username')) && ($this->session->userdata('logged_in')) && ($this->session->userdata('acl')))
        {
            /*
             * Double checking user is logged in. 
             */
            $this->session->set_flashdata('error','Not Logged In, Please Sign In.');
            redirect('en/index');
        }

        $userid = $this->users->getUseridByUsername($this->session->userdata('username'));

        if ($userid == 0)
        {
            /*
             * error;
             */
            $this->session->set_flashdata('error','Not Logged In, Please Sign In.');
            redirect('en/index');

        }

        if ($action == 'add')
        {


            $query = $this->bio->getblank($userid);  // checking for blank
            // now checking to see if getblankbio came back with any rows.
            foreach ($query->result() as $row)
            {
                $bio_id = $row->id;
            }


            if ($query->num_rows() > 0)
            {
                /*
                 * Will process that bio instead of creating a new one.
                 */

                $data['bio_data'] = $query;
                $data['social_urls'] = $this->bio->pullSocialUrls($bio_id);
                
                $this->load->model('cms/site/site_model', 'site');
                $data['query'] = $this->site->getSocialNetworks();  // pulling social network information

                $this->load->view('cmsv2/header');
                //$this->load->view('cms/profile2/navigation');
                $this->load->view('cmsv2/profile/biography/add', $data);
                $this->load->view('footer');

            } else {
                // if no rows are found, need to create blank bio;

                $this->bio->addblank($userid);

                redirect('cms/profile/bio/add');
            }
        }

        if (($action == 'update_new') && ($id != null))
        {
            if (is_dir(base_url().'uploads/'.$this->session->userdata('username')) == false)
            {
                mkdir(base_url().'uploads/'.$this->session->userdata('username'), 0755);
            }
            
            $config['upload_path'] =  './uploads/';//.$this->session->userdata('username');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '1000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload())
            {
                $error = $this->upload->display_errors();

                $this->session->set_flashdata('error',$error.'');

                redirect('cms/profile/bio/add');

            } else {
                /*
                 * image was uploaded; proceed to the database;
                 */

                foreach ($this->upload->data() as $item => $value)
                {
                    if ($item == 'file_name')
                    {
                        $filename = $value;
                    }
                }

                $image_url = './uploads/'.$filename;

                $this->bio->addBioBybioId($id, $this->input->post('bio'), $image_url, $this->input->post('publish'));

                $doublecheck = $this->bio->getBlank($userid);

                if ($doublecheck->num_rows() > 0)
                {
                    /*
                     * this is actually one exists. so it tells the user the bio was not updated.
                     */

                    $this->session->set_flashdata('error','Bio was not updated.!');

                    redirect('cms/profile/bio/add');


                } else {

                    $this->session->set_flashdata('success','Bio was successfully added/updated!');

                    redirect('cms/profile/bio/manage');
                }
            }
        }

        if ($action == 'manage')
        {

            $data['query'] = $this->bio->getBioDataByUserid($userid);
            
            $this->load->view('cmsv2/header');
            //$this->load->view('cms/profile2/navigation');
            //$this->load->view('cms/bio/manage', $data);
            $this->load->view('cmsv2/profile/biography/manage', $data);
            //$this->load->view('cms/profile2/footer');
            $this->load->view('footer');
        }

        if (($action == 'update') && ($id != null))
        {
            /*
             * This is will process requests from the manage screen, to edit them.
             */

            $this->form_validation->set_rules('bio','Bio','required');
            $this->form_validation->set_rules('publish','Publish','required');
            
            if ($this->form_validation->run() == TRUE)
            {
                $this->bio->update($id, $this->input->post('bio'), $this->input->post('publish'));

                $this->session->set_flashdata('success','Bio was successfully added/updated!');

                redirect('cms/profile/bio/manage');

            } else {

                $data['bio_data'] = $this->bio->getBioByid($id);

                $data['social_urls'] = $this->bio->pullSocialUrls($id);

                $this->load->model('cms/site/site_model', 'site');
                $data['query'] = $this->site->getSocialNetworks();

                $this->load->view('cmsv2/header');
                //$this->load->view('cms/profile2/navigation');
                $this->load->view('cmsv2/profile/biography/update', $data);
                $this->load->view('footer');
            }




        }

        if (($action == 'delete') && ($id != null))
        {
            $this->load->model('cms/profile/login_model', 'login');
            $query = $this->login->getUseridByUsername($this->session->userdata('username'));

            if ($query != 0)
            {
                $userid = $query;
                
                $this->load->model('cms/profile/bio_model', 'bio');
                $bioData = $this->bio->getBioDataByUserid($userid);

                if ($bioData->num_rows > 0)
                {
                    foreach ($bioData->result() as $bData)
                    {
                        if ($id == $bData->id)
                        {
                            /*
                             * things match, this bio can be deleted.
                             */
                            $this->bio->remove_bio($id);

                            

                        }
                    }
                    $this->session->set_flashdata('success','Bio was deleted!');

                    redirect('cms/profile/bio/manage');
                } else {
                    /*
                     * Username does not have any bios. unable to deleted request denied.
                     */
                    $this->session->set_flashdata('error','Unable to delete, request denied.');

                    redirect('cms/profile/bio/manage');
                }

            } else {
                /*
                 * Username was not found. sending user to logout to delete any hacked cookies.
                 */
                
                redirect('cms/profile/logout');
            }

            
        }
    }

    public function login()
	{
        /*
         * Seem to be having an issue with sessions. Double checking code to make sure its correct.
         * 8/09 11:22
         */

		$this->load->model('cms/profile/login_model', 'login');
        $authenticated = $this->login->authenticate($this->input->post('username'), $this->input->post('password'));

        if ($authenticated != 0)
        {
            // Pull data from profiles, security;
            $access = $this->login->getSecurityLevel($authenticated);

            // start a session.
            //echo $this->session->userdata('session_id');
            $userdata = array(
            					'username' => $this->input->post('username'),
            					'acl' => $access,
            					'logged_in' => 'TRUE'
            );

            $this->session->set_userdata($userdata);  // records user data to a session;

            if (($access == 'member') && ($this->session->userdata('logged_in') == 'TRUE') || ($access == 'administrator') && ($this->session->userdata('logged_in') == 'TRUE')) // user is a member if 2
            {
            	redirect('cms/profile/index', 'location', 301);

            } else {
                // someone is trying to get access failed, added as a safety precaution.;
                $this->session->sess_destroy(); // destroying the newly created session.
                $this->session->set_flashdata('error','You need a member account to do that.');
            	redirect('en/index', 'location', 301);
            }


        } else {
        	// user information does not match database; returns error.
            $this->session->set_flashdata('error','Incorrect username and or password, please try again. Perhaps you need a account?');
            redirect('en/login'); // simple redirection for wrongly entered data. 
        }


    }

    public function logout()
    {
        // works on safari and chrome locally, not firefox.
    	// 8/09 still session bug; I'm throwing it up as a code igniter bug. No other options at this point.

        $this->session->sess_destroy();

    	if ($this->session->userdata('logged_in') == 'TRUE')
    	{
    		$this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('acl');

			redirect('en/index', 'location', 301);

        } else {

    		redirect('en/index', 'location', 301);
    	}

    }

    function project($action, $id = null)
    {
        /*
         * Action is required for this method
         * id is not, since id won't always be used.
         */
        $this->load->helper('file');
        if ($action == 'projectDetail')
        {
            echo 'Internal Use only::WRONG LINK';
        }
        if ($action == 'add')
        {
            /*
             * Checking to see if projectId has been declared. since it has not it will show a form and process
             * the request.
             */

            $this->form_validation->set_rules('overview','Overview','required');
            $this->form_validation->set_rules('additional','Additional', 'required');
            

            if ($this->form_validation->run() == TRUE)
            {
                /*
                 *  form has been submitted, processing request.
                 *  - when user registers, it will create a new folder under uploads with that persons username.
                 */

                $config['upload_path'] =  './uploads/';//.$this->session->userdata('username');
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '3000';
                $config['max_width']  = '1920';
                $config['max_height']  = '1200';

		        $this->load->library('upload', $config);

                if (! $this->upload->do_upload())
                {
                    $error = $this->upload->display_errors();

                    $this->session->set_flashdata('error',$error);

                    redirect('cms/profile/project/add', 'location', 301);

                } else {

                    foreach ($this->upload->data() as $item => $value)
                    {
                        if ($item == 'file_name')
                        {
                            $filename = $value;
                        }
                    }

                    $image_url = './uploads/'.$filename;

                    $overview = $this->input->post('overview');
                    $additional = $this->input->post('additional');
                    $tools = $this->input->post('added_tools');
                    
                    /*
                     * Loading the tools screen.
                     */

                    $this->load->model('cms/site/site_model', 'site');
                    
                    if ($tools != '')
                    {
                        $new_tool_array = array();
                        
                        $each_tool = explode(',', $tools);

                        for ($i=0; $i < count($each_tool); $i++)
                        {
                            $query = $this->site->getToolByName($each_tool[$i]);

                            foreach($query->result() as $row)
                            {
                                //echo $row->id;
                                $new_tool_array[$i] = $row->id;
                            }
                        }
                        
                        $tools = implode(',', $new_tool_array);
                        
                    } else { $tools = '0'; }

                    $this->load->model('cms/profile/login_model', 'login');
                    $this->load->model('cms/profile/portfolio_model', 'port');
                    $this->port->addProject($this->login->getUseridByUsername($this->session->userdata('username')), $image_url, $overview, $additional, $tools);


                    /* new project has been added, lets add it to the rss feed */
                    
                    $this->session->set_flashdata('success','Project and Image was Successful');

                    redirect('cms/profile/project/manage');

                }

            } else {

                /*
                 *  so overview was not set; will display the form instead;
                 */

                /*
                 * Tools new addition.
                 */

                $this->load->model('cms/site/site_model', 'site');

                $data['query'] = $this->site->listTools();

                $this->load->view('cmsv2/header');
                //$this->load->view('cms/profile2/navigation');
                $this->load->view('cmsv2/profile/portfolio/add', $data);
                $this->load->view('footer');
            }
        }

        if ($action == 'manage')
        {
            /*
             * Loading the models will need in this method.
             */
            $this->load->model('cms/profile/login_model', 'user');
            $this->load->model('cms/profile/portfolio_model','project');

            $userId = $this->user->getUseridByUsername($this->session->userdata('username'));  // returns userId or false;
            if ($userId == false)
            {
                $this->session->set_flashdata('error','There is an error with your current session, please logout and log back in.');

                redirect('cms/profile/logout'); // changing it to logout if the user got this far, the  username is  not stored.
            } else {

                $data['query'] = $this->project->getAllProjectsByUserID($userId);
                /*
                 * Pulling icons for the tools display.
                 */

                $this->load->model('cms/site/site_model','site');

                $data['images'] = $this->site->listTools();

                $this->load->view('cmsv2/header');
                //$this->load->view('cms/profile2/navigation');
                $this->load->view('cmsv2/profile/portfolio/manage', $data);
                $this->load->view('footer');

            }
        }

        if (($action == 'edit') && ($id))
        {
            $this->load->model('cms/profile/portfolio_model', 'port');

            $data['project_query'] = $this->port->getProjectDetails($id);
            $this->load->model('cms/site/site_model','site');

            $data['images'] = $this->site->listTools();

            $this->load->model('cms/site/site_model', 'site');

            $data['query'] = $this->site->listTools();
            
            $this->load->view('cmsv2/header');
            $this->load->view('cmsv2/profile/portfolio/add', $data);
            $this->load->view('footer');
        }

        if (($action == 'update') && ($id))
        {
            /*
             * This will just be used to update database and upload a new image if they have
             * selected to upload one.
             */

            $this->form_validation->set_rules('overview','Overview','required');
            $this->form_validation->set_rules('additional','Additional', 'required');


            if ($this->form_validation->run() == TRUE)
            {
                if ($this->input->post('change_image') == TRUE)
                {
                    /*
                     * Processes only if change_image box was selected.
                     */

                    $config['upload_path'] =  './uploads/';//.$this->session->userdata('username');
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	= '3000';
                    $config['max_width']  = '1920';
                    $config['max_height']  = '1200';

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload())
                    {
                        $error = $this->upload->display_errors();

                        $this->session->set_flashdata('error',$error);

                        redirect('cms/profile/project/update/'.$id, 'location', 301);

                    } else {

                        foreach ($this->upload->data() as $item => $value)
                        {
                            if ($item == 'file_name')
                            {
                                $filename = $value;
                            }
                        }

                        $image_url = './uploads/'.$filename;

                    }

                }
                    
                        $overview = $this->input->post('overview');
                        $additional = $this->input->post('additional');
                        $tools = $this->input->post('added_tools');  // is the name of the actual tool.


                        /*
                         * Loading the tools screen.
                         */

                        $this->load->model('cms/site/site_model', 'site');

                        if (!empty($tools))
                        {
                            $new_tool_array = array();

                            $each_tool = explode(',', $tools);

                            for ($i=0; $i < count($each_tool); $i++)
                            {
                                $query = $this->site->getToolByName($each_tool[$i]);

                                foreach($query->result() as $row)
                                {
                                    //echo $row->id;
                                    $new_tool_array[$i] = $row->id;
                                }
                            }
                            
                            $already_used_tools = explode(',', $this->input->post('t_used'));
                            //var_dump($already_used_tools);
                            for ($j=0; $j < count($already_used_tools); $j++ )
                            {
                                
                                $new_tool_array[] = $already_used_tools[$j];

                            }

                            $tools = implode(',',array_unique($new_tool_array)); // this is new tools. or new additions

                            
                        } else { $tools = '0'; }



                        $this->load->model('cms/profile/login_model', 'login');
                        $this->load->model('cms/profile/portfolio_model', 'port');
                        $this->port->update_project($id, $overview, $additional, $tools, @$image_url);
                        $this->session->set_flashdata('success','Project and Image was Successful');

                        redirect('cms/profile/project/manage');

                    }


                } 

        if (($action == 'delete') && ($id))
        {
            $this->load->model('cms/profile/login_model', 'user');
            $userid = $this->user->getUseridByUsername($this->session->userdata('username'));

            if ($userid > 0)
            {
                /*
                 * userid did return a valid userid.
                 */
                $this->load->model('cms/profile/portfolio_model', 'port');
                $query = $this->port->getProjectDetails($id);

                foreach ($query->result() as $project)
                {
                    if ($userid == $project->project_owner)
                    {
                        $this->port->delete_project($project->projectId);
                        
                    }
                }

                $this->session->set_flashdata('success','Project was deleted.');

                redirect('cms/profile/project/manage');
            }
        }
        
    }

    function addSocial()
    {

        $this->load->model('cms/profile/bio_model', 'bio');

        $this->bio->addNetwork($this->input->post('smnid'), $this->input->post('url'), $this->input->post('bioid'));
        
    }

    
    
}

/* End of file cms/profile.php */
/* Location: ./application/controllers/cms/profile.php */