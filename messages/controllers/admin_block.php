<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_block extends Admin_Controller {

    protected $section = 'block';
    
    public function __construct()
    {
		parent::__construct();
		$this->load->model('messages_m');
        $this->lang->load('messages');
    }

    public function index ()
    {
    	$blocked = $this->messages_m->get_block();
    	$result = array();
    	foreach ($blocked as $key => $value)
    	{
    		$result[$key]['user_id'] = $value->user_id;
			$result[$key]['user_name'] = $this->db->where('user_id', $value->user_id)->get('profiles')->row()->display_name;
			$result[$key]['message_id'] = $value->reason;
			$result[$key]['message_content'] = $this->db->where('id', $value->reason)->get('messages_content')->row()->message;
		}
    	$this->template->title($this->module_details['name'])->set('blocked', $result)->build('admin/block');
   	}
   	
   	public function block ($id = NULL, $message = NULL)
   	{
		if (is_null($id))
		{
	        $this->session->set_flashdata('error', 'user id not specified');
	        redirect('admin/messages/view/');
		}
		else
		{
			$this->messages_m->block_user($id, $message);
			$this->session->set_flashdata('success', 'OK');
			redirect('admin/messages/view/');
		}
	}
	
	public function unblock ($id = NULL)
	{
		if (is_null($id))
		{
	        $this->session->set_flashdata('error', 'user id not specified');
	        redirect('admin/messages/view/');
		}
		else
		{
			$this->messages_m->unblock_user($id);
			$this->session->set_flashdata('success', 'OK');
			redirect('admin/messages/block/');
		}
	}
	
	public function ajax_block ()
	{
		if(isset($_POST))
		{
			$this->messages_m->block_user($_POST['userID'], $_POST['messageID']);
			print 1;
		}
		else
		{
			print 0;
		}
	}
}