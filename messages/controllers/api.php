<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_m');
        $smpp_settings = $this->messages_m->get_settings();
        $smpp_param = array('server' => $smpp_settings[0]->host,
                            'port' => $smpp_settings[0]->port,
                            'user' => $smpp_settings[0]->user,
                            'pass' => $smpp_settings[0]->pass,
                            'src_number' => $smpp_settings[0]->src_number,
                            );
        $this->load->library('smpp', $smpp_param);
    }
    
    public function index ()
    {
        $number = isset($_GET['to']) ? $_GET['to'] : NULL;
        $message = isset($_GET['text']) ? $_GET['text'] : NULL;
        if (is_null($number) or is_null($message))
        {
            $this->load->view('api');
        }
        else
        {
            preg_match('/([0-9]{11})/', $number, $match);
            $result = $this->smpp->send_ru($match[1], $message);
            if ($result == true)
            {
                print 1;
            }
            else
            {
                print 0;
            }
        }
    }
}