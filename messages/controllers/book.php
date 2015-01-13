<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Book extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_m');
        $this->lang->load('messages');
        $this->load->library('form_validation');
        $this->template->title($this->module_details['name'])
        	->append_metadata(js('book.js', 'messages'))
        	->append_metadata(js('modal.js', 'messages'))
        	->append_metadata(css('modal.css', 'messages'))
			->append_metadata(css('frontend.style.css', 'messages'));
        if (empty($this->current_user))
        {
            redirect('users/login');
        }
    }
    
    public function index ()
    {
    	$this->data->contacts = $this->messages_m->get_contacts($this->current_user->id);
    	$this->template->title($this->module_details['name'])->build('frontend/book', $this->data);
    }
    
    public function save ()
    {
		if (isset($_POST))
		{
			if (isset($_POST['name']) and isset($_POST['phone']))
			{
				$this->messages_m->add_to_book($_POST['name'], $_POST['phone'], $this->current_user->id);
				print 1;
			}
			else
			{
				print "the are not specified name or phone";
			}
		}
		else
		{
			print "we cant to accept get requests";
		}
	}
	public function delete()
	{
		if ($_POST)
		{
			$this->messages_m->delete_contact($_POST['id']);
			print 1;
		}
		else
		{
			print 0;
		}
	}
}