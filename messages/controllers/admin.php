<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    protected $section = 'view';
    
    public function __construct()
    {
	parent::__construct();
	$this->load->model('messages_m');
        $this->lang->load('messages');
    }

    public function index ()
    {
        $this->data->count = $this->messages_m->count_messages();
        $pagination = create_pagination('admin/messages/view/index', $this->data->count, NULL, 5);
        $this->data->messages = $this->messages_m->get_messages($pagination["per_page"], $pagination["current_page"]);
        $this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('admin/view', $this->data);
    }
    public function delete ($id = 0)
    {
        $this->messages_m->delete_message($id);
        $this->session->set_flashdata('success', 'Message has been deleted');
        redirect('admin/messages/view/');
    }
    public function user ($id = null)
    {
        if (is_null($id) and !is_numeric($id))
        {
            $this->session->set_flashdata('error', 'user not defined');
            redirect('admin/messages/view/');
        }
        else
        {
            $this->data->count = $this->messages_m->count_messages($id);
            $pagination = create_pagination('admin/messages/view/user/'.$id.'/', $this->data->count, NULL, 6);
            $this->data->messages = $this->messages_m->get_messages($pagination["per_page"], $pagination["current_page"], $id);
            $this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('admin/view', $this->data);
        }
    }
}