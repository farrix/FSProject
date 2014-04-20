<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();

        if ($this->session->userdata('acl') != 'administrator')
        {
            $this->session->set_flashdata('error','Access is Denied!');
            redirect('cms/profile', 'location', 301);
        }
	}
	
	public function index()
	{

        // if their security level equals admin levels; they can proceed.
        // do not think the admin views are being used anymore in cms 2.0
        $this->load->view('cmsv2/header');
        $this->load->view('cms/admin/index');
        $this->load->view('footer');

	}

    function Pages($action = null, $id = null)
    {
        $this->load->model('cms/layout/pages_model', 'pages');
        
        if ($action == 'add')
        {
            $this->form_validation->set_rules('name','Page Name', 'required');
            $this->form_validation->set_rules('url','URL', 'required');


            if ($this->form_validation->run() == TRUE)
            {
                //$this->load->model('cms/layout/pages_model', 'pages');
                $pageAdded = $this->pages->addPages($this->input->post('url'), $this->input->post('name'));

                if ($pageAdded == TRUE)
                {
                    $this->session->set_flashdata('success','Page was Added.');
                    redirect('cms/admin/pages/add');
                } 

            } else {

                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/pages/add');
                $this->load->view('footer');

            }

        }

        if ($action == 'manage')
        {
            
            $query = $this->pages->getPages();

            if ($query->num_rows() > 0)
            {
                $data['query'] = $query;

                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/pages/manage', $data);
                $this->load->view('footer');
                
            } else {

                $this->session->set_flashdata('error','Unable to pull page info.');
                redirect('cms/admin/pages/manage', 'location', 301);
            }

        }

        if (($action == "edit") && ($id != null))
        {
            /*
             * If action is something other than null and id != null
             * it is time for edit or another action.
             */

            $query = $this->pages->getPageInfoById($id);

            if ($query->num_rows() > 0)
            {
                $data['edit'] = $query;
//                $this->load->view('cms/profile2/header');
//                $this->load->view('cms/profile2/navigation');
//                $this->load->view('cms/page/add', $data);
//                $this->load->view('cms/profile2/footer');

                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/pages/add', $data);
                $this->load->view('footer');

            } else {
                redirect('cms/admin/pages/add', 'location', 301);
            }
        }

        if (($action == 'update') && ($id))
        {
            $url = $this->input->post('url');
            $title = $this->input->post('name');

            $update_complete = $this->pages->update($id, $url, $title);

            if ($update_complete == TRUE)
            {
                $this->session->set_flashdata('success','Page was updated.');

                redirect('cms/admin/pages/manage', 'location', 301);
            }
        }

        if (($action == 'delete') && ($id))
        {
            $complete = $this->pages->remove($id);

            if ($complete == TRUE)
            {
                $this->session->set_flashdata('success','Page was deleted.');

                redirect('cms/admin/pages/manage', 'location', 301);
            }
        }
    }

    function article($action = null, $id = null, $pages = null)
    {
        /*
         * global model for this method.
         */
        $this->load->model('cms/layout/pages_model', 'pages');
        $this->load->model('cms/layout/article_model', 'articles');
        
        if ($action == 'add')
        {
            /*
             * adding articles.
             */
            /*
             * made a change 12:25 am on 8/10; commented line 164 or abouts.
             */
            $header = $this->input->post('header');
            $content = $this->input->post('content');

            if ($pages == null)
            {
                $whereToPlace = $this->input->post('where');
            } else {
                $whereToPlace = $pages;
            }

            $show = $this->input->post('show');

            if (empty($content))
            {
                /*
                * This should be if content equals nothing to display the form page to add it.
                * view is cms/content/add
                */
                $data['listpages'] = $this->pages->getPages();
                //$data['page'] = $this->pages->getIdByPage($pages);

                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/articles/add' ,$data);
                $this->load->view('footer');

                //$this->load->view('header');

                //$this->load->view('footer');

            } else {


                $contentAdded = $this->pages->addContentToPages($header,$content,$whereToPlace,$show);

                if ($contentAdded == TRUE)
                {
                    $this->session->set_flashdata('success','Article was added successfully.');

                    redirect('cms/admin/article/add', 'location', 301);  
                } else {

                    // TODO complete error.
                }

            }
        }

        if ($action == 'manage')
        {
            $data['query'] = $this->articles->get_articles();

            $this->load->view('cmsv2/header');
            $this->load->view('cmsv2/admin/articles/manage', $data);
            $this->load->view('footer');
        }

        if (($action == 'update') && ($id != null))
        {
            /*
             * Updating articles.
             */

            /*
             * Adding validation:: 8/10 @ 12:14am  Randy
             * also fixed article update bug;
             */
            $this->form_validation->set_rules('header', 'Header','required');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if (($this->form_validation->run() == TRUE) && ($this->session->userdata('acl') == 'administrator'))
            {
                
                $complete = $this->articles->update($this->input->post('header'), $this->input->post('content'), $id, $this->input->post('show'));

                if ($complete == TRUE)
                {
                    $this->session->set_flashdata('success','Article was updated successfully.');

                    redirect('cms/admin/article/manage');
                }
            } else {

                $data['query'] = $this->articles->get_article_by_id($id);

                /*
                 * Need to pull page table for article placement, incase it changes.
                 */

                $data['listpages'] = $this->pages->getPages();
                
                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/articles/add' ,$data);
                $this->load->view('footer');

            }

        }

        if (($action == 'delete') && ($id != null))
        {
            $complete = $this->articles->remove($id);

            if ($complete == TRUE)
            {
                $this->session->set_flashdata('success','Article was deleted successfully.');

                redirect('cms/admin/article/manage');
            }
        }
    }
	
	function socialnetwork($action = null, $id = null)
    {



        if ($action == 'add')
        {

            /*
             * If it is not, then we are either here to add the information to the database
             * or run the form;
             */

            $this->form_validation->set_rules('userfile', 'Icon', '');
            $this->form_validation->set_rules('network', 'Social Network', 'callback_social_network_check');

            if ($this->form_validation->run() == TRUE)
            {
                /*
                 * Will proceed inserting the data into the database.
                 */
                $config['upload_path'] =  './images/social/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '3000';
                $config['max_width']  = '1920';
                $config['max_height']  = '1200';

		        $this->load->library('upload', $config);

                if (! $this->upload->do_upload())
                {
                    $error = $this->upload->display_errors();

                    $this->session->set_flashdata('error',$error);

                    redirect('cms/admin/socialnetwork/add');

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

                    $image_url = base_url().'images/social/'.$filename;

                    $this->load->model('cms/site/site_model', 'site');
                    $complete = $this->site->addSocialNetwork($image_url, $this->input->post('network'));

                    if ($complete == TRUE)
                    {
                        $this->session->set_flashdata('success','Social Network was added!');

                        redirect('cms/admin/socialnetwork/manage');  // removed a full redirect cause chrome says there was too many.
                    }
                }

            } else {

                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/social/add');
                $this->load->view('footer');
            }
        }

        if ($action == 'manage')
        {
            /*
             * Now processing manage for social networks.
             */

            $this->load->model('cms/site/site_model', 'site');
            $data['query'] = $this->site->getSocialNetworks();


            $this->load->view('cmsv2/header');
            $this->load->view('cmsv2/admin/social/manage' ,$data);
            $this->load->view('footer');
        }

        if (($action == 'edit') && ($id))
        {
            $this->load->model('cms/site/site_model', 'site');
            $query = $this->site->getSocialNetworks($id);

            /*
             *  checking to make sure the id is a valid ID
             */

            if($query->num_rows > 0)
            {
                $data['query'] = $query;
                
                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/social/add', $data);
                $this->load->view('footer');

            } else {

                $this->session->set_flashdata('error','The id you are trying to edit does not exists.');

                redirect('cms/admin/socialnetwork/manage');
            }
        }

    }

    function social($action = null, $id = null)
    {
        /*
         * This is just for processing the edited icon.
         * All of the validation checks up to this point were to make sure the data they are editing is
         * correct.
         */

        if (($action == 'edit') && ($id))
        {
            $this->form_validation->set_rules('change_image', 'check_box', '');
            $this->form_validation->set_rules('network', 'Social Network', 'callback_social_network_check');

            if ($this->form_validation->run() == TRUE)
            {
                /*
                 * Checking to make sure if there was a new image being uploaded;
                 * if there is lets update the database after the image has been uploaded.
                 */
                //var_dump($this->input->post());
                if ($this->input->post('change_image') == 'true')
                {
                    $config['upload_path'] =  './images/social/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	= '3000';
                    $config['max_width']  = '1920';
                    $config['max_height']  = '1200';

                    $this->load->library('upload', $config);

                    if (! $this->upload->do_upload())
                    {
                        $error = $this->upload->display_errors();

                        $this->session->set_flashdata('error',$error);

                        redirect('cms/admin/socialnetwork/manage');

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

                        $image_url = base_url().'images/social/'.$filename;
                        $this->load->model('cms/site/site_model', 'site');
                        $complete = $this->site->addSocialNetworkUpdate($image_url, $this->input->post('network'), $id);

                        if ($complete == TRUE)
                        {
                            $this->session->set_flashdata('success','Social Network was updated!');

                            redirect('cms/admin/socialnetwork/manage');  // removed a full redirect cause chrome says there was too many.
                        }

                    }

                } else {

                    $this->load->model('cms/site/site_model', 'site');
                    $complete = $this->site->addSocialNetworkUpdate('none',$this->input->post('network'), $id);

                    if ($complete == TRUE)
                    {
                        $this->session->set_flashdata('success','Social Network was updated!');

                        redirect('cms/admin/socialnetwork/manage');  // removed a full redirect cause chrome says there was too many.
                    }
                }


            } else {

                redirect('cms/admin/socialnetwork/manage');
            }
            
        }
    }

    function social_network_check($name)
    {
        /*
         * Making sure the name has not been taking. also making sure the field is not blank.
         */

        if ($name == '')
        {
            $this->form_validation->set_message('social_network_check','The %s field can not be blank.');
            return FALSE;
        } else {
            $this->load->model('cms/site/site_model', 'site');
            $query = $this->site->checkSocialNetwork($name);

            if ($query->num_rows() > 0)
            {
                /*
                 * returns the same name, request fails.
                 */
                foreach ($query->result() as $row)
                {
                    $check_usage = $this->site->checkUsedSocialNetworks($row->id);  // checking to see if social network is being used.

                    if ($check_usage->num_rows() > 0)
                    {
                        $this->form_validation->set_message('social_network_check', 'In Use or Duplicate found, Please try again later.');
                        $this->session->set_flashdata('error','In Use or Duplicate found, Please try again later.');
                        return FALSE;
                    } else {
                        /*
                         * double checking if the is the same it is entering into the database again.
                         */
                        if ($this->input->post('change_image') == 'true')
                        {
                            return TRUE;
                        }

                        if ($name == $row->name)
                        {
                            
                            $this->form_validation->set_message('social_network_check', 'In Use or Duplicate found, Please try again later.');
                            $this->session->set_flashdata('error','In Use or Duplicate found, Please try again later.');
                            return FALSE;
                        } else {
                            return TRUE;
                        }
                    }
                }

            } else {
                return TRUE;
            }
        }

    }

    function tools($action = null, $id = null)
    {
        $this->load->model('cms/site/site_model', 'site'); 

        if ($action == 'add')
        {
            $this->form_validation->set_rules('appname','Application Name', 'callback_check_appname');



            if ($this->form_validation->run() == FALSE)
            {
                /*
                 * process the form.
                 */
                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/tools/add');
                $this->load->view('footer');

            } else {

                /*
                 * made it this far, the form was processed correctly and should be uploading an image.
                 */

                $config['upload_path'] =  './images/tools/';//.$this->session->userdata('username');
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '3000';
                $config['max_width']  = '1920';
                $config['max_height']  = '1200';

		        $this->load->library('upload', $config);

                if (! $this->upload->do_upload())
                {
                    $error = $this->upload->display_errors();

                    $this->session->set_flashdata('error',$error);

                    redirect('cms/admin/tools/add');

                } else {

                    foreach ($this->upload->data() as $item => $value)
                    {
                        if ($item == 'file_name')
                        {
                            $filename = $value;
                        }
                    }

                    $icon_url = './images/tools/'.$filename;


                    $this->site->addTool($icon_url, $this->input->post('appname'));

                    $this->session->set_flashdata('success','Tool was added Successfully');

                    redirect('cms/admin/tools/manage');  // removed a full redirect cause chrome says there was too many.
                    
                }
            }
        }

        if ($action == 'manage')
        {
            $data['query'] = $this->site->listTools();

            $this->load->view('cmsv2/header');
            $this->load->view('cmsv2/admin/tools/manage', $data);
            $this->load->view('footer');
        }

        if (($action == 'edit') && ($id))
        {

            $this->form_validation->set_rules('appname','Application Name', 'callback_check_appname');



            if ($this->form_validation->run() == FALSE)
            {
                $data['query'] = $this->site->listToolsByID($id);

                $this->load->view('cmsv2/header');
                $this->load->view('cmsv2/admin/tools/add', $data);
                $this->load->view('footer');

            } else {

                if ($this->input->post('change_image') == 'true')
                {
                    $config['upload_path'] =  './images/tools/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	= '3000';
                    $config['max_width']  = '1920';
                    $config['max_height']  = '1200';

                    $this->load->library('upload', $config);

                    if (! $this->upload->do_upload())
                    {
                        $error = $this->upload->display_errors();

                        $this->session->set_flashdata('error',$error);

                        redirect('cms/admin/tools/edit/'.$id);

                    } else {

                        foreach ($this->upload->data() as $item => $value)
                        {
                            if ($item == 'file_name')
                            {
                                $filename = $value;
                            }
                        }

                        $icon_url = './images/tools/'.$filename;



                    }

                } else {

                    $icon_url = 'none';
                }
                /*
                 * everyting should be getting updated, with or without an new image.
                 */
                
                $this->site->updateToolByID($id, $icon_url, $this->input->post('appname'));

                $this->session->set_flashdata('success','Tool was updated Successfully');

                redirect('cms/admin/tools/manage');  // removed a full redirect cause chrome says there was too many.
            }
        }
    }

    function check_appname($input)
    {
        if ($input == '')
        {
            $this->form_validation->set_message('check_appname','The %s field can not be blank.');
            return FALSE;
        } else {
            /* now checking to make sure it is not a duplicate tool. */

            $this->load->model('cms/site/site_model', 'site');
            $query = $this->site->checkToolAppName($input);

            /*
             * Double checking that query came back with something other than nothing.
             */

            if (($query->num_rows() > 0) && ($this->input->post('change_image') != 'true'))
            {
                // app already exists. returns false.
                $this->form_validation->set_message('check_appname','Duplicate Found, Please do not add duplicates.');
                return FALSE;

            } else {
                // no duplicates were found.
                return TRUE;
            }
        }
    }
    
    
}

/* End of file cms/admin.php */
/* Location: ./application/controllers/cms/admin.php */