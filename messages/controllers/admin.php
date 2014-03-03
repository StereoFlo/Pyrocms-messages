<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    protected $section = 'messages';
    public function __construct()
    {
	parent::__construct();
	$this->load->library('form_validation');
	$this->load->model('messages_m');
        $this->lang->load('messages');
    }

    public function index()
    {
	$this->form_validation->set_rules('host', lang('host'), 'trim|required');
	$this->form_validation->set_rules('pass', lang('pass'), 'trim|required');
	$this->form_validation->set_rules('port', lang('port'), 'trim|required');
	$this->form_validation->set_rules('user', lang('user'), 'trim|required');
	$this->form_validation->set_rules('src_number', lang('src_number'), 'trim|required');
	$this->form_validation->set_rules('port', 'IP', 'trim|required');       
                
        if ($this->form_validation->run() == FALSE)
        {
            $this->data->messages = $this->messages_m->get_settings();
            $this->template
                ->title($this->module_details['name'])
                ->build('admin/index', $this->data);
        }
        else
        {
	    if(isset($_GET['action']) && $_GET['action']=='save')
                {
		if(isset($_POST['id']) && $_POST['id'] != "")
                {
		    $this->messages_m->update_settings($_POST);
		}
		else
                {
		    $this->messages_m->add_settings($_POST);
		}	
		$this->session->set_flashdata('success', lang('messSuccess'));	
		redirect('admin/messages');
	    }
        }
    }
    public function view ()
    {
        $pagination = create_pagination('admin/messages/view', $this->messages_m->count_messages());
        $this->data->messages = $this->messages_m->get_messages($pagination["per_page"], $pagination["current_page"]);
        $this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('admin/view', $this->data);
    }
    public function delete ($id = 0)
    {
        $this->messages_m->delete_message($id);
        $this->session->set_flashdata('success', 'Message has been deleted');
        redirect('admin/messages/view/');
    }
}