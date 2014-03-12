<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_m');
    }
    
    public function index ()
    {
        $this->load->view('api');
    }
}