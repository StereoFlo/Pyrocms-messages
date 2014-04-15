<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_m');
        $this->lang->load('messages');
        $this->load->library('form_validation');
        $this->template->title($this->module_details['name'])
        	->append_metadata(js('book.js', 'messages'))
			->append_metadata(css('frontend.style.css', 'messages'));
        if (empty($this->current_user))
        {
            redirect('users/login');
        }
    }
    
    public function index ()
    {
    	$check_block = $this->messages_m->check_block($this->current_user->id);
    	$this->data->contacts = $this->messages_m->get_contacts($this->current_user->id);
    	if ($check_block > 0)
    	{
			$this->template->title($this->module_details['name'])->build('frontend/block', $this->data);
		}
    	else
    	{
	        $smpp_settings = $this->messages_m->get_settings();
	        $smpp_param = array('server' => $smpp_settings[0]->host,
	                            'port' => $smpp_settings[0]->port,
	                            'user' => $smpp_settings[0]->user,
	                            'pass' => $smpp_settings[0]->pass,
	                            'src_number' => $smpp_settings[0]->src_number,
	                            );
	        $this->load->library('smpp', $smpp_param);
			$this->form_validation->set_rules('to', lang('pass'), 'trim|required');
			$this->form_validation->set_rules('message', lang('port'), 'trim|required');
	        if ($this->form_validation->run() == FALSE)
	        {
	            $this->data->user_name = $this->current_user->full_name;
	            $this->template->title($this->module_details['name'])->build('frontend/index', $this->data);
	        }
	        else
	        {
	            if(isset($_GET['action']) && $_GET['action']=='send')
	            {
	                $to = $this->input->post('to');
	                $message = $this->input->post('message');
	                $ip = $this->input->ip_address();
	                $formatted_message = $smpp_settings[0]->template;
	                $formatted_message = str_replace('{from}', $this->current_user->full_name, $formatted_message);
	                $formatted_message = str_replace('{message}', $message, $formatted_message);
			

	                $results = explode(",", $to);
	                $send = NULL;
	                $numarray = array();
	                $get_num = null;
	                if (!empty($results))
	                {
	                    if(count($results) == count(array_unique($results))) {
	                        foreach ($results as $key => $value)
	                        {
	                            $value = trim($value);
	                            if (!is_numeric($value))
	                            {
	                                $get_num = $this->messages_m->get_num($userid, trim($value));
	                                array_push($numarray, $get_num);
	                            }
	                            else {
	                                if ($value != $get_num) array_push($numarray, $value);
	                            }
	                        }
	                    }
	                }
	                foreach ($numarray as $values)
	                {
	                    if (strlen($values) == 10)
	                    {
	                            $send = $this->smpp->send_ru('7'.$values, $formatted_message);
				    if ($send == true)
				    {
					$this->messages_m->add_message(array('to' => '7'.$values, 'message' => $message, 'ip' => $ip, 'from' => $this->current_user->full_name, 'from_id' => $this->current_user->id));
				    }
	                    }
	                }
	                
	                if ($send == TRUE)
	                {
	                    $this->session->set_flashdata('success', lang('messSent'));
	                    redirect('messages');
	                }	
	                else
	                {
	                    $this->session->set_flashdata('error', lang('messNotSent'));
	                    redirect('messages');
	                }
	            }
	        }
		}
    }
    
    public function view ()
    {
        $UserID = $this->current_user->id;
        $pagination = create_pagination('messages/view', $this->messages_m->get_message_by_userid_count($UserID), NULL, 3);
        $this->data->messages = $this->messages_m->get_message_by_userid($UserID, $pagination["per_page"], $pagination["current_page"]);
        $this->template->title($this->module_details['name'])->set('pagination', $pagination['links'])->build('frontend/view', $this->data);
    }

}